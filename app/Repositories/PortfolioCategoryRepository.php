<?php

namespace App\Repositories;

use App\Models\PortfolioCategory;

class PortfolioCategoryRepository extends BaseRepository
{
    public function __construct(PortfolioCategory $model)
    {
        parent::__construct($model);
    }

    // Tambahan filter khusus (jika dibutuhkan nanti)
    public function filterActive($query)
    {
        return $query->where('is_active', 1);
    }
}
