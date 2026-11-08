<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    public const SOURCE_TRAVEL = 'travel';
    public const SOURCE_TOPUP = 'topup';
    public const SOURCE_GOOGLE_CARD = 'google_card';

    /** Label & warna badge (komponen x-admin.badge) per sumber customer. */
    public const SOURCE_META = [
        self::SOURCE_TOPUP       => ['Top Up Game', 'blue'],
        self::SOURCE_TRAVEL      => ['Travel & Shuttle', 'orange'],
        self::SOURCE_GOOGLE_CARD => ['Google Review Card', 'green'],
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'source',
        'points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'points'   => 'integer',
        'balance'  => 'decimal:2',
    ];

    /**
     * Get the bookings for the customer.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the digital product / topup orders for the customer.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /** Mutasi saldo (refund & penarikan). */
    public function balanceMutations(): HasMany
    {
        return $this->hasMany(CustomerBalanceMutation::class);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(CustomerWithdrawal::class);
    }

    /** Batasi query ke satu sumber customer. */
    public function scopeFromSource($query, string $source)
    {
        return $query->where('source', $source);
    }

    /**
     * Varian penulisan no. HP Indonesia yang dianggap sama: 0812..., 62812..., 812...
     *
     * @return array<int, string>
     */
    public static function phoneVariants(string $phone): array
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);

        if ($digits === '') {
            return [];
        }

        $national = match (true) {
            str_starts_with($digits, '62') => substr($digits, 2),
            str_starts_with($digits, '0')  => substr($digits, 1),
            default                        => $digits,
        };

        return array_values(array_unique([$digits, '0' . $national, '62' . $national]));
    }

    /**
     * Cari customer berdasarkan (source + no. HP). Customer dari sumber lain tidak pernah ikut terpilih.
     */
    public static function findByPhone(string $phone, string $source): ?self
    {
        $variants = static::phoneVariants($phone);

        return $variants === [] ? null : static::fromSource($source)->whereIn('phone', $variants)->first();
    }

    /**
     * Cari atau buat customer untuk sebuah sumber, validasi kuncinya (source + phone).
     * Nama customer yang sudah ada diperbarui bila berbeda. Return [Customer, apakahBaru].
     *
     * @return array{0: self, 1: bool}
     */
    public static function findOrCreateByPhone(string $phone, string $source, string $name, int $welcomePoints = 0): array
    {
        $customer = static::findByPhone($phone, $source);

        if ($customer) {
            if ($name !== '' && $customer->name !== $name) {
                $customer->update(['name' => $name]);
            }

            return [$customer, false];
        }

        return [static::create([
            'name'   => $name,
            'phone'  => preg_replace('/[^0-9]/', '', $phone),
            'source' => $source,
            'points' => $welcomePoints,
        ]), true];
    }
}
