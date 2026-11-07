<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Pengaturan key/value yang diubah admin. Jangan simpan rahasia di sini (pakai .env).
 */
class AppSetting extends Model
{
    protected $fillable = ['key', 'value', 'updated_by'];

    private const CACHE_PREFIX = 'app_setting:';

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = Cache::rememberForever(self::CACHE_PREFIX . $key, fn () => self::where('key', $key)->value('value') ?? '__null__');

        return $value === '__null__' ? $default : $value;
    }

    /** Simpan nilai dan catat perubahan (siapa, kapan, dari mana) ke app_setting_logs. */
    public static function put(string $key, ?string $value): void
    {
        DB::transaction(function () use ($key, $value) {
            $current = self::where('key', $key)->lockForUpdate()->first();
            $old = $current?->value;

            if ($current && $old === $value) {
                return;
            }

            $user = Auth::user();

            self::updateOrCreate(['key' => $key], ['value' => $value, 'updated_by' => $user?->id]);

            AppSettingLog::create([
                'key'        => $key,
                'old_value'  => $old,
                'new_value'  => $value,
                'user_id'    => $user?->id,
                'user_email' => $user?->email,
                'ip_address' => Request::ip(),
                'user_agent' => mb_substr((string) Request::userAgent(), 0, 255) ?: null,
            ]);
        });

        Cache::forget(self::CACHE_PREFIX . $key);
    }
}
