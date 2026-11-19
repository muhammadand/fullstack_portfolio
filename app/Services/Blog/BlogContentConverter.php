<?php

namespace App\Services\Blog;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Ubah konten artikel dari luar menjadi HTML yang siap tampil & bisa diedit di editor Quill (WYSIWYG).
 *
 *   - String HTML       -> langsung dibersihkan (tanpa AI, hemat biaya).
 *   - JSON / teks biasa -> dikonversi AI (Gemini) ke HTML, lalu dibersihkan.
 *   - AI gagal/kosong   -> konversi sederhana tanpa AI (fallback), lalu dibersihkan.
 *
 * Hasil akhir SELALU lewat HtmlSanitizer karena endpoint-nya publik.
 */
class BlogContentConverter
{
    public const MODEL = 'gemini-3.1-flash-lite';

    public const SOURCE_HTML = 'html';
    public const SOURCE_AI = 'ai';
    public const SOURCE_FALLBACK = 'fallback';

    public function __construct(private HtmlSanitizer $sanitizer)
    {
    }

    /**
     * @return array{html: string, source: string}
     */
    public function convert(string|array $content, string $title = ''): array
    {
        if (is_string($content) && $this->looksLikeHtml($content)) {
            return ['html' => $this->sanitizer->clean($content), 'source' => self::SOURCE_HTML];
        }

        $html = $this->sanitizer->clean($this->convertWithAi($content, $title));
        if ($this->hasText($html)) {
            return ['html' => $html, 'source' => self::SOURCE_AI];
        }

        return ['html' => $this->sanitizer->clean($this->fallback($content)), 'source' => self::SOURCE_FALLBACK];
    }

    public function looksLikeHtml(string $content): bool
    {
        return (bool) preg_match('#<(p|h[1-6]|ul|ol|li|br|strong|em|blockquote|a|img|div|span)\b[^>]*>#i', $content);
    }

    private function convertWithAi(string|array $content, string $title): string
    {
        $raw = is_array($content)
            ? json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            : $content;

        $prompt = <<<PROMPT
Kamu adalah konverter konten artikel blog. Ubah DATA di bawah menjadi isi artikel HTML untuk editor WYSIWYG (Quill).

Aturan:
- Pertahankan isi, fakta, angka, dan urutan dari DATA. Jangan menambah informasi baru, jangan meringkas.
- Bahasa mengikuti DATA (jangan diterjemahkan).
- Hanya gunakan tag: <h2>, <h3>, <p>, <strong>, <em>, <ul>, <ol>, <li>, <blockquote>, <a href>, <img src alt>, <br>.
- Jangan sertakan judul artikel sebagai heading (judul: "{$title}"). Jangan pakai <h1>, <html>, <body>, <div>, <style>, atau atribut style/class.
- Key JSON yang berupa metadata teknis (id, timestamp, url sumber tanpa konteks) tidak perlu ditampilkan.
- Paragraf pendek agar nyaman dibaca di HP.
- Balas HANYA dengan HTML, tanpa penjelasan dan tanpa blok ```.

DATA:
{$raw}
PROMPT;

        try {
            $text = Gemini::generativeModel(self::MODEL)->generateContent($prompt)->text();

            return trim(preg_replace('/^```(?:html)?\s*|\s*```$/i', '', trim((string) $text)));
        } catch (\Throwable $e) {
            Log::warning('Blog API: konversi AI gagal, pakai fallback.', ['error' => $e->getMessage()]);

            return '';
        }
    }

    /** Konversi tanpa AI: struktur JSON umum -> HTML sederhana. */
    private function fallback(string|array $content): string
    {
        if (is_string($content)) {
            return $this->paragraphs($content);
        }

        return $this->renderNode($content, 0);
    }

    private function renderNode(mixed $node, int $depth): string
    {
        if (is_scalar($node)) {
            return $this->paragraphs((string) $node);
        }
        if (!is_array($node) || $depth > 8) {
            return '';
        }

        // Blok bertipe: {"type": "heading|paragraph|list|quote|image", ...}
        if (isset($node['type']) && is_string($node['type'])) {
            return $this->renderBlock($node, $depth);
        }

        // Daftar: item string -> <ul>, item objek -> dirender berurutan.
        if (array_is_list($node)) {
            if ($node !== [] && collect($node)->every(fn ($v) => is_scalar($v))) {
                return '<ul>' . collect($node)->map(fn ($v) => '<li>' . e((string) $v) . '</li>')->implode('') . '</ul>';
            }

            return collect($node)->map(fn ($v) => $this->renderNode($v, $depth + 1))->implode('');
        }

        // Objek bebas: key -> heading, value -> isi.
        $html = '';
        foreach ($node as $key => $value) {
            $key = (string) $key;
            if (in_array(strtolower($key), ['id', 'uuid', 'created_at', 'updated_at', 'timestamp'], true)) {
                continue;
            }
            if (in_array(strtolower($key), ['heading', 'title', 'judul', 'subtitle'], true) && is_scalar($value)) {
                $html .= '<h2>' . e((string) $value) . '</h2>';
                continue;
            }
            if (in_array(strtolower($key), ['text', 'content', 'body', 'paragraph', 'isi', 'konten'], true)) {
                $html .= $this->renderNode($value, $depth + 1);
                continue;
            }
            $html .= '<h3>' . e(Str::headline($key)) . '</h3>' . $this->renderNode($value, $depth + 1);
        }

        return $html;
    }

    private function renderBlock(array $block, int $depth): string
    {
        $text = $block['text'] ?? $block['content'] ?? $block['value'] ?? '';
        $text = is_scalar($text) ? (string) $text : '';

        return match (strtolower($block['type'])) {
            'heading', 'header', 'title', 'subheading' => (((int) ($block['level'] ?? 2)) >= 3 ? '<h3>' : '<h2>')
                . e($text) . (((int) ($block['level'] ?? 2)) >= 3 ? '</h3>' : '</h2>'),
            'list', 'bullets', 'ordered_list' => $this->renderList($block),
            'quote', 'blockquote' => '<blockquote>' . e($text) . '</blockquote>',
            'image', 'img' => isset($block['src']) || isset($block['url'])
                ? '<img src="' . e($block['src'] ?? $block['url']) . '" alt="' . e($block['alt'] ?? $block['caption'] ?? '') . '">'
                : '',
            default => $text !== '' ? $this->paragraphs($text) : $this->renderNode(array_diff_key($block, ['type' => 1]), $depth + 1),
        };
    }

    private function renderList(array $block): string
    {
        $items = $block['items'] ?? $block['list'] ?? [];
        if (!is_array($items) || $items === []) {
            return '';
        }

        $tag = (($block['ordered'] ?? false) || strtolower($block['type']) === 'ordered_list' || ($block['style'] ?? '') === 'ordered') ? 'ol' : 'ul';
        $lis = collect($items)
            ->map(fn ($i) => is_scalar($i) ? (string) $i : (string) ($i['text'] ?? $i['content'] ?? ''))
            ->filter(fn ($i) => trim($i) !== '')
            ->map(fn ($i) => '<li>' . e($i) . '</li>')
            ->implode('');

        return $lis === '' ? '' : "<{$tag}>{$lis}</{$tag}>";
    }

    /** Teks biasa: pisah per baris kosong -> <p>, baris "- x" -> list. */
    private function paragraphs(string $text): string
    {
        $blocks = preg_split("/\R{2,}/", trim($text));

        return collect($blocks)->map(function ($block) {
            $lines = preg_split('/\R/', trim($block));
            if (count($lines) > 1 && collect($lines)->every(fn ($l) => preg_match('/^\s*[-*•]\s+/', $l))) {
                return '<ul>' . collect($lines)->map(fn ($l) => '<li>' . e(preg_replace('/^\s*[-*•]\s+/', '', $l)) . '</li>')->implode('') . '</ul>';
            }
            if (preg_match('/^#{1,3}\s+(.+)$/', $block, $m) && count($lines) === 1) {
                return '<h2>' . e($m[1]) . '</h2>';
            }

            return $block === '' ? '' : '<p>' . nl2br(e($block), false) . '</p>';
        })->implode('');
    }

    private function hasText(string $html): bool
    {
        return trim(html_entity_decode(strip_tags($html))) !== '';
    }
}
