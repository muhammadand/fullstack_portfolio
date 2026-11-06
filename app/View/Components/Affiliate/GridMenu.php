<?php

namespace App\View\Components\Affiliate;

use App\Support\AffiliateMenu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Grid shortcut menu di dashboard affiliate (7 shortcut + tombol "Semua Menu").
 * Daftar lengkap ada di halaman affiliate.menu.
 */
class GridMenu extends Component
{
    public array $shortcuts;

    public function __construct(
        public int $totalProjects = 0,
        public int $totalClicks = 0,
    ) {
        $this->shortcuts = AffiliateMenu::shortcuts();
    }

    public function render(): View|Closure|string
    {
        return view('components.affiliate.grid-menu');
    }
}
