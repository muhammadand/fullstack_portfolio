<?php

namespace App\View\Components\Affiliate;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CheckInCard extends Component
{
    public $affiliate;
    public $hasClaimedToday;
    public $streak;
    public $fireColor;
    public $fireBg;
    public $fireGlow;
    public $fireLevel;

    public function __construct($affiliate)
    {
        $this->affiliate = $affiliate;
        
        $today = now()->format('Y-m-d');
        $this->hasClaimedToday = $this->affiliate->last_claim_date === $today;
        
        $this->streak = $this->affiliate->current_streak;
        
        $yesterday = now()->subDay()->format('Y-m-d');
        if ($this->affiliate->last_claim_date !== $today && $this->affiliate->last_claim_date !== $yesterday) {
            $this->streak = 0;
        }

        $this->fireColor = 'text-slate-600';
        $this->fireBg = 'bg-slate-800';
        $this->fireGlow = '';
        $this->fireLevel = 0;

        if ($this->streak > 0) {
            if ($this->streak < 30) {
                $this->fireColor = 'text-orange-500';
                $this->fireBg = 'bg-orange-500/20';
                $this->fireGlow = 'drop-shadow-[0_0_8px_rgba(249,115,22,0.8)] animate-pulse';
                $this->fireLevel = 1;
            } elseif ($this->streak < 60) {
                $this->fireColor = 'text-cyan-400';
                $this->fireBg = 'bg-cyan-500/20';
                $this->fireGlow = 'drop-shadow-[0_0_12px_rgba(34,211,238,0.9)] animate-pulse';
                $this->fireLevel = 2;
            } else {
                $this->fireColor = 'text-yellow-400';
                $this->fireBg = 'bg-yellow-500/20';
                $this->fireGlow = 'drop-shadow-[0_0_15px_rgba(250,204,21,1)] animate-pulse';
                $this->fireLevel = 3;
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.affiliate.check-in-card');
    }
}
