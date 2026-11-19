<?php

namespace App\Services\Blog;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Pembersih HTML berbasis whitelist untuk konten blog yang masuk dari luar (API publik / hasil AI).
 * Konten blog ditampilkan dengan {!! !!}, jadi semua yang tidak dikenal dibuang:
 *   - tag berbahaya (script, iframe, form, ...) dihapus beserta isinya
 *   - tag lain yang tidak diizinkan di-"unwrap" (teksnya tetap ada)
 *   - atribut hanya yang diizinkan; href/src hanya http(s)/mailto, tidak ada on*= / javascript:
 * Tag yang diizinkan mengikuti apa yang bisa dibaca & diedit editor Quill di admin.
 */
class HtmlSanitizer
{
    /** tag => atribut yang boleh */
    private const ALLOWED = [
        'p' => ['class'], 'br' => [], 'hr' => [],
        'h2' => ['class'], 'h3' => ['class'], 'h4' => ['class'],
        'strong' => [], 'b' => [], 'em' => [], 'i' => [], 'u' => [], 's' => [],
        'blockquote' => [], 'pre' => ['class'], 'code' => [],
        'ul' => [], 'ol' => [], 'li' => ['class'],
        'a' => ['href'], 'img' => ['src', 'alt'],
    ];

    /** Dibuang bersama seluruh isinya. */
    private const DROP = [
        'script', 'style', 'iframe', 'frame', 'frameset', 'object', 'embed', 'applet', 'form', 'input',
        'button', 'textarea', 'select', 'option', 'svg', 'math', 'link', 'meta', 'base', 'noscript',
        'template', 'head', 'title', 'audio', 'video', 'source', 'canvas',
    ];

    /** Heading level atas diturunkan: <h1> milik judul halaman. */
    private const RENAME = ['h1' => 'h2', 'h5' => 'h4', 'h6' => 'h4'];

    public function clean(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        $doc = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $doc->loadHTML(
            '<?xml encoding="UTF-8"?><div id="__root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $doc->getElementById('__root');
        if (!$root) {
            return '';
        }

        $this->cleanChildren($root);

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }

        // Paragraf kosong sisa pembersihan tidak berguna.
        return trim(preg_replace('#<p>(\s|&nbsp;|<br>)*</p>#i', '', $out));
    }

    private function cleanChildren(DOMNode $parent): void
    {
        // Salin dulu: childNodes berubah selama node diganti/dihapus.
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if ($node->nodeType === XML_TEXT_NODE) {
                continue;
            }

            if (!$node instanceof DOMElement) {
                $parent->removeChild($node); // komentar, CDATA, processing instruction
                continue;
            }

            $tag = strtolower($node->nodeName);

            if (in_array($tag, self::DROP, true)) {
                $parent->removeChild($node);
                continue;
            }

            if (isset(self::RENAME[$tag])) {
                $node = $this->rename($node, self::RENAME[$tag]);
                $tag = self::RENAME[$tag];
            }

            if (!isset(self::ALLOWED[$tag])) {
                $this->cleanChildren($node);
                $this->unwrap($node);
                continue;
            }

            $this->cleanAttributes($node, $tag);

            if ($tag === 'img' && !$node->hasAttribute('src')) {
                $parent->removeChild($node);
                continue;
            }

            $this->cleanChildren($node);
        }
    }

    private function cleanAttributes(DOMElement $node, string $tag): void
    {
        foreach (iterator_to_array($node->attributes) as $attr) {
            $name = strtolower($attr->nodeName);
            $value = trim($attr->nodeValue);
            $keep = in_array($name, self::ALLOWED[$tag], true);

            if ($keep && in_array($name, ['href', 'src'], true)) {
                $keep = $this->isSafeUrl($value, $name === 'href');
            }
            if ($keep && $name === 'class') {
                // Hanya kelas format Quill (ql-align-center, ql-indent-1, ...).
                $value = implode(' ', array_filter(preg_split('/\s+/', $value), fn ($c) => preg_match('/^ql-[a-z0-9-]+$/', $c)));
                $keep = $value !== '';
            }

            $node->removeAttribute($attr->nodeName);
            if ($keep) {
                $node->setAttribute($name, $value);
            }
        }

        if ($tag === 'a' && $node->hasAttribute('href')) {
            $node->setAttribute('target', '_blank');
            $node->setAttribute('rel', 'nofollow noopener noreferrer');
        }
    }

    private function isSafeUrl(string $url, bool $allowMailto): bool
    {
        // Buang karakter kontrol/spasi yang bisa dipakai menyamarkan "java\tscript:".
        $normalized = strtolower(preg_replace('/[\x00-\x20]+/', '', $url));

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return filter_var($url, FILTER_VALIDATE_URL) !== false;
        }

        return $allowMailto && str_starts_with($normalized, 'mailto:');
    }

    private function rename(DOMElement $node, string $tag): DOMElement
    {
        $new = $node->ownerDocument->createElement($tag);
        while ($node->firstChild) {
            $new->appendChild($node->firstChild);
        }
        $node->parentNode->replaceChild($new, $node);

        return $new;
    }

    private function unwrap(DOMElement $node): void
    {
        $parent = $node->parentNode;
        while ($node->firstChild) {
            $parent->insertBefore($node->firstChild, $node);
        }
        $parent->removeChild($node);
    }
}
