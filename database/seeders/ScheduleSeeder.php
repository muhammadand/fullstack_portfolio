<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::all();

        if ($routes->isEmpty()) {
            $this->call(RouteSeeder::class);
            $routes = Route::all();
        }

        // Jam-jam keberangkatan harian
        $timeSlots = [
            ['time' => '06:00:00', 'service' => Schedule::SERVICE_TYPE_REGULER, 'status' => Schedule::STATUS_CONFIRMED],
            ['time' => '09:00:00', 'service' => Schedule::SERVICE_TYPE_REGULER, 'status' => Schedule::STATUS_WAITING_QUOTA],
            ['time' => '13:00:00', 'service' => Schedule::SERVICE_TYPE_PREMIUM_SOPIR, 'status' => Schedule::STATUS_CONFIRMED],
            ['time' => '16:00:00', 'service' => Schedule::SERVICE_TYPE_REGULER, 'status' => Schedule::STATUS_WAITING_QUOTA],
            ['time' => '19:30:00', 'service' => Schedule::SERVICE_TYPE_PREMIUM_SOPIR, 'status' => Schedule::STATUS_WAITING_QUOTA],
        ];

        // Buat jadwal untuk 4 hari ke depan (hari ini s/d H+3)
        for ($day = 0; $day < 4; $day++) {
            $date = Carbon::today()->addDays($day)->toDateString();

            foreach ($routes as $route) {
                foreach ($timeSlots as $slot) {
                    Schedule::updateOrCreate(
                        [
                            'route_id' => $route->id,
                            'departure_date' => $date,
                            'departure_time' => $slot['time'],
                        ],
                        [
                            'service_type' => $slot['service'],
                            'min_quota' => 4,
                            'status' => $slot['status'],
                        ]
                    );
                }
            }
        }
    }
}
