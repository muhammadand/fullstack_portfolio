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
    protected $signature = 'affiliate:remind-checkin';

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
        
        $affiliates = Affiliate::where('status', 'approved')
            ->where(function($query) use ($today) {
                $query->whereNull('last_claim_date')
                      ->orWhere('last_claim_date', '!=', $today);
            })
            ->get();
            
        $count = 0;
        
        foreach ($affiliates as $affiliate) {
            // Only notify if they have a push subscription
            if ($affiliate->pushSubscriptions()->exists()) {
                $affiliate->notify(new CheckInReminderNotification());
                $count++;
            }
        }
        
        $this->info("Sent check-in reminders to {$count} affiliates.");
    }
}
