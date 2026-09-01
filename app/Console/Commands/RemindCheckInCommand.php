<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Affiliate;
use App\Notifications\CheckInReminderNotification;

class RemindCheckInCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'affiliate:remind-checkin {--force : Send reminder to all subscribed affiliates regardless of check-in status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send push notification to affiliates who have not checked in today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->format('Y-m-d');
        $force = $this->option('force');

        $query = Affiliate::where('status', 'approved');

        if (!$force) {
            $query->where(function ($q) use ($today) {
                $q->whereNull('last_claim_date')
                    ->orWhere('last_claim_date', '!=', $today);
            });
        }

        $affiliates = $query->get();
        $count = 0;
        $failed = 0;

        foreach ($affiliates as $affiliate) {
            // Only notify if they have a push subscription
            if ($affiliate->pushSubscriptions()->exists()) {
                try {
                    $affiliate->notify(new CheckInReminderNotification());
                    $count++;
                } catch (\Throwable $e) {
                    $failed++;
                    \Illuminate\Support\Facades\Log::warning("Gagal kirim push ke Affiliate #{$affiliate->id}: " . $e->getMessage());
                }
            }
        }

        $resultMsg = "Sent check-in reminders to {$count} affiliates" . ($failed > 0 ? " ({$failed} failed)" : "") . ".";
        $this->info($resultMsg);
    }
}
