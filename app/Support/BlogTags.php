<?php

namespace App\Support;

use App\Models\Blog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Tag (tagar) artikel blog sebagai halaman topik: /s/blogs/tag/{slug}.
 *
 * Tag disimpan di kolom JSON blogs.tags. Indeks tag (slug -> nama, jumlah artikel, id artikel) dihitung
 * dari artikel yang sudah terbit lalu di-cache; cache dibuang otomatis saat artikel disimpan/dihapus.
 * Halaman tag dengan artikel < MIN_INDEXABLE diberi noindex & tidak masuk sitemap (hindari "thin content").
 */
class BlogTags
{
    public const MIN_INDEXABLE = 2;
    private const CACHE_KEY = 'blog_tags_index_v1';

    /** "AI, #umkm , ai" / ["AI", "UMKM"] -> ["AI", "umkm"] (unik tanpa beda huruf besar/kecil). */
    public static function normalize(mixed $tags): array
    {
        $list = is_array($tags) ? $tags : (is_string($tags) ? [$tags] : []);

        return collect($list)
            ->filter(fn ($t) => is_scalar($t))
            ->flatMap(fn ($t) => explode(',', (string) $t))
            ->map(fn ($t) => Str::limit(trim(preg_replace('/\s+/', ' ', ltrim(trim($t), '#'))), 50, ''))
            ->filter(fn ($t) => $t !== '' && static::slug($t) !== '')
            ->unique(fn ($t) => static::slug($t))
            ->values()
            ->all();
    }

    public static function slug(string $tag): string
    {
        return Str::slug(ltrim(trim($tag), '#'));
    }

    public static function url(string $tag): string
    {
        return route('blogs.tag', static::slug($tag));
    }

    /**
     * @return Collection<string, array{name: string, slug: string, count: int, blog_ids: int[], updated_at: ?string}>
     *         diurutkan dari tag dengan artikel terbanyak
     */
    public static function index(): Collection
    {
        $data = Cache::rememberForever(self::CACHE_KEY, function () {
            $tags = [];
            $byBlog = [];

            Blog::published()->where('published_at', '<=', now())
                ->get(['id', 'tags', 'updated_at'])
                ->each(function (Blog $blog) use (&$tags, &$byBlog) {
                    foreach (static::normalize($blog->tags) as $name) {
                        $slug = static::slug($name);
                        $tags[$slug] ??= ['slug' => $slug, 'names' => [], 'blog_ids' => [], 'updated_at' => null];
                        $tags[$slug]['names'][$name] = ($tags[$slug]['names'][$name] ?? 0) + 1;
                        $tags[$slug]['blog_ids'][] = $blog->id;
                        $updated = $blog->updated_at?->toIso8601String();
                        if ($updated && $updated > ($tags[$slug]['updated_at'] ?? '')) {
                            $tags[$slug]['updated_at'] = $updated;
                        }
                        $byBlog[$blog->id][] = $slug;
                    }
                });

            foreach ($tags as &$tag) {
                arsort($tag['names']);                 // ejaan yang paling sering dipakai jadi nama tampilan
                $tag['name'] = (string) array_key_first($tag['names']);
                $tag['count'] = count($tag['blog_ids']);
                unset($tag['names']);
            }
            unset($tag);

            uasort($tags, fn ($a, $b) => [$b['count'], $a['name']] <=> [$a['count'], $b['name']]);

            return ['tags' => $tags, 'by_blog' => $byBlog];
        });

        return collect($data['tags']);
    }

    public static function find(string $slug): ?array
    {
        return static::index()->get($slug);
    }

    /** Tag dengan artikel terbanyak, untuk blok "Topik Populer". */
    public static function popular(int $limit = 12, int $minCount = self::MIN_INDEXABLE): Collection
    {
        return static::index()->filter(fn ($t) => $t['count'] >= $minCount)->take($limit)->values();
    }

    /** Tag yang paling sering muncul bersama tag ini (untuk "Topik terkait"). */
    public static function relatedTo(string $slug, int $limit = 10): Collection
    {
        $tag = static::find($slug);
        if (!$tag) {
            return collect();
        }

        $byBlog = Cache::get(self::CACHE_KEY)['by_blog'] ?? [];
        $counts = [];
        foreach ($tag['blog_ids'] as $id) {
            foreach ($byBlog[$id] ?? [] as $other) {
                if ($other !== $slug) {
                    $counts[$other] = ($counts[$other] ?? 0) + 1;
                }
            }
        }
        arsort($counts);

        return collect(array_keys($counts))->map(fn ($s) => static::find($s))->filter()->take($limit)->values();
    }

    public static function isIndexable(array $tag): bool
    {
        return $tag['count'] >= self::MIN_INDEXABLE;
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
