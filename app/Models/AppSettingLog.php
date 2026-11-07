<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Jejak audit perubahan AppSetting. Append-only: tidak bisa diubah atau dihapus lewat model. */
class AppSettingLog extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['key', 'old_value', 'new_value', 'user_id', 'user_email', 'ip_address', 'user_agent'];

    protected $casts = ['created_at' => 'datetime'];

    protected static function booted(): void
    {
        static::updating(fn () => throw new \LogicException('AppSettingLog bersifat append-only.'));
        static::deleting(fn () => throw new \LogicException('AppSettingLog bersifat append-only.'));
    }
}
