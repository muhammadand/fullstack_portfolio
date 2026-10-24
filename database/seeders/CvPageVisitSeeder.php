<?php

namespace Database\Seeders;

use App\Models\CvPageVisit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CvPageVisitSeeder extends Seeder
{
    /**
     * Seed realistic visitor traffic for CV Service over the last 30 days.
     */
    public function run(): void
    {
        // Bersihkan kunjungan lama yang kosong jika perlu, atau tambahkan data realistik 30 hari ke belakang
        CvPageVisit::truncate();

        $referers = [
            'https://www.google.com/search?q=template+cv+ats+gratis',
            'https://www.instagram.com/',
            'https://api.whatsapp.com/',
            'https://t.co/',
            'https://www.linkedin.com/',
            'https://www.tiktok.com/',
            null, // Direct traffic
        ];

        $userAgents = [
            'desktop' => [
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/122.0',
            ],
            'mobile' => [
                'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Mobile/15E148 Safari/604.1',
                'Mozilla/5.0 (Linux; Android 14; SM-S918B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.6099.230 Mobile Safari/537.36',
                'Mozilla/5.0 (Linux; Android 13; Redmi Note 12) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Mobile Safari/537.36',
            ],
            'tablet' => [
                'Mozilla/5.0 (iPad; CPU OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
                'Mozilla/5.0 (Linux; Android 13; SM-X900) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ]
        ];

        $now = Carbon::now();
        $records = [];

        // Generate data untuk 30 hari ke belakang (mulai dari 29 hari lalu sampai hari ini)
        for ($i = 29; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dateStr = $date->toDateString();

            // Pola traffic alami: hari kerja lebih ramai (15-40 kunjungan), akhir pekan sedikit santai (10-25)
            $isWeekend = in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]);
            $baseVisits = $isWeekend ? rand(12, 28) : rand(22, 48);

            // Tambahkan lonjakan traffic bertahap (tren naik mendekati hari ini)
            $growthFactor = (30 - $i) * 0.4;
            $totalForDay = (int) round($baseVisits + $growthFactor);

            for ($v = 0; $v < $totalForDay; $v++) {
                // Distribusi device: Mobile 60%, Desktop 32%, Tablet 8%
                $randDev = rand(1, 100);
                if ($randDev <= 60) {
                    $device = 'mobile';
                } elseif ($randDev <= 92) {
                    $device = 'desktop';
                } else {
                    $device = 'tablet';
                }

                $uaList = $userAgents[$device];
                $ua = $uaList[array_rand($uaList)];
                $referer = $referers[array_rand($referers)];

                // Acak IP unik realistis
                $ip = rand(103, 180) . '.' . rand(10, 250) . '.' . rand(1, 254) . '.' . rand(1, 254);

                $hour = rand(7, 23);
                $minute = rand(0, 59);
                $timestamp = $date->copy()->setTime($hour, $minute, rand(0, 59));

                $records[] = [
                    'visited_at'  => $dateStr,
                    'ip_address'  => $ip,
                    'user_agent'  => $ua,
                    'device_type' => $device,
                    'referer'     => $referer,
                    'created_at'  => $timestamp,
                    'updated_at'  => $timestamp,
                ];
            }
        }

        // Chunk insert untuk efisiensi tinggi
        foreach (array_chunk($records, 150) as $chunk) {
            CvPageVisit::insert($chunk);
        }
    }
}
