<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Checkout partner ditolak dengan alasan yang aman ditampilkan ke user (saldo kurang, produk gangguan, dll.).
 */
class PartnerOrderException extends RuntimeException
{
}
