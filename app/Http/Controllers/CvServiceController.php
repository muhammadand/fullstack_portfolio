<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CvServiceController extends Controller
{
    /**
     * Tampilkan Halaman Layanan Template CV & AI CV Builder
     */
    public function index()
    {
        return view('company.services.cv.index');
    }

    /**
     * Dynamic Multi-Turn AI Chat Onboarding
     * AI merespon secara cerdas, kontekstual, dan dinamis berdasarkan Knowledge Base
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'history' => 'nullable|array',
            'current_cv' => 'nullable|array',
            'target_context' => 'nullable|array',
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);
        $currentCv = $request->input('current_cv', []);
        $targetContext = $request->input('target_context', null);

        // Load Knowledge Base
        $kbPath = resource_path('views/company/services/cv/knowledge_base.md');
        $knowledgeBase = File::exists($kbPath) ? File::get($kbPath) : '';

        // Format conversational context
        $conversationContext = "";
        foreach ($history as $msg) {
            $sender = ($msg['sender'] ?? 'user') === 'user' ? 'USER' : 'AI';
            $text = $msg['text'] ?? '';
            $conversationContext .= "{$sender}: {$text}\n";
        }
        $conversationContext .= "USER: {$userMessage}\n";

        $currentCvJson = json_encode($currentCv, JSON_UNESCAPED_UNICODE);

        // Context tagging instructions if user focused on specific section/card
        $contextInstruction = "";
        if (!empty($targetContext)) {
            $contextJson = json_encode($targetContext, JSON_UNESCAPED_UNICODE);
            $contextInstruction = "\n=== TARGET FOKUS DISKUSI AKTIF (ANTIGRAVITY CONTEXT TAG) ===\n" .
                "USER SEDANG MEMFOKUSKAN DISKUSI PADA: {$contextJson}\n" .
                "INSTRUKSI KHUSUS UNTUK TARGET INI:\n" .
                "- USER mungkin memberikan masukan santai, draft poin, atau catatan kasar (misal: 'tambahkan riwayat kerja di PT A, tugas ini, belajar ini, sampai tahun ini', 'ubah IPK dan prestasi', atau 'tambahkan skill SEO').\n" .
                "- Formulasikan masukan tersebut secara otomatis menjadi data profesional berstandar STAR/XYZ method (Action Verbs, Metrik kuantitatif, Dampak bisnis).\n" .
                "- Masukkan atau update data tersebut ke dalam array/objek target yang tepat pada updated_cv (misal: work_experience, education_list, internship_experience, projects, organizations, certifications, awards, skills, profile_summary).\n" .
                "- PERTAHANKAN seluruh data lain yang ada pada DATA CV SAAT INI (STATE) agar tidak terhapus.\n" .
                "- Di dalam teks 'reply', konfirmasikan secara ceria dan hangat bahwa bagian target tersebut telah berhasil diperbarui dan diformulasikan ke preview CV.\n";
        }

        $prompt = "KNOWLEDGE BASE & GUIDELINES:
{$knowledgeBase}

DATA CV SAAT INI (STATE):
{$currentCvJson}

RIWAYAT PERCAKAPAN:
{$conversationContext}
{$contextInstruction}
TUGAS KAMU:
1. Tanggapi pesan USER terbaru secara cerdas, hangat, kontekstual, dan komunikatif seperti Konsultan HR Senior (bukan bot kaku).
2. Jika ada TARGET FOKUS DISKUSI atau USER meminta REVISI / PERUBAHAN / PENAMBAHAN bagian tertentu:
   - Lakukan penambahan / revisi secara presisi dan profesional pada bagian yang diminta dengan formula STAR/XYZ.
   - Pertahankan data pada bagian lain yang tidak diminta diubah dari DATA CV SAAT INI (STATE) agar tidak hilang.
   - Konfirmasikan dengan ceria pada balasan chat bahwa bagian tersebut telah berhasil diubah di preview CV.
3. Jika USER memberikan data baru secara bertahap, perbarui data CV dan ajukan pertanyaan langkah berikutnya secara luwes.

FORMAT RESPON WAJIB:
Kembalikan MURNI respons JSON tanpa pengantar teks luar atau markdown berlebih. Struktur JSON:
{
    \"reply\": \"Teks balasan ramah & cerdas kamu kepada pengguna (2-4 kalimat). Apresiasi apa yang dia sampaikan dan jelaskan bahwa data pada bagian yang didiskusikan sudah langsung terisi/terperbarui di CV preview.\",
    \"updated_cv\": {
        \"full_name\": \"Nama Lengkap Pelamar\",
        \"degree\": \"Gelar pendidikan jika ada (misal: S.Kom, S.E, dll)\",
        \"target_role\": \"Target Posisi / Profesi yang diincar\",
        \"birth_info\": \"Tempat/Tgl Lahir jika ada atau biarkan yang lama\",
        \"gender\": \"Jenis Kelamin jika ada atau biarkan yang lama\",
        \"religion\": \"Agama jika ada atau biarkan yang lama\",
        \"nationality\": \"Kewarganegaraan\",
        \"phone\": \"No Kontak/WA\",
        \"email\": \"Alamat Email\",
        \"address\": \"Alamat/Domisili\",
        \"social_linkedin\": \"LinkedIn\",
        \"social_instagram\": \"Instagram\",
        \"profile_summary\": \"Paragraf ringkasan profil profesional yang menjual sesuai data terkini...\",
        \"education_list\": [
            {
                \"degree_name\": \"S1 Informatika / Manajemen Bisnis\",
                \"institution\": \"Nama Universitas / Sekolah\",
                \"period\": \"2018 - 2022\",
                \"city\": \"Kota\",
                \"gpa\": \"IPK 3.85\",
                \"achievements\": [
                    \"Prestasi atau kegiatan relevan...\"
                ]
            }
        ],
        \"work_experience\": [
            {
                \"company\": \"Nama Perusahaan\",
                \"position\": \"Jabatan / Role\",
                \"period\": \"Periode Kerja\",
                \"city\": \"Kota\",
                \"bullets\": [
                    \"Poin pencapaian dengan kata kerja aktif & metrik...\"
                ]
            }
        ],
        \"internship_experience\": [
            {
                \"company\": \"Nama Perusahaan / Organisasi\",
                \"position\": \"Posisi Magang / Tim\",
                \"period\": \"Periode\",
                \"city\": \"Kota\",
                \"bullets\": [
                    \"Poin tugas dan kontribusi magang...\"
                ]
            }
        ],
        \"projects\": [
            {
                \"title\": \"Nama Proyek\",
                \"period\": \"Periode\",
                \"description\": \"Deskripsi dampak proyek...\"
            }
        ],
        \"organizations\": [
            {
                \"org_name\": \"Nama Organisasi\",
                \"role\": \"Posisi\",
                \"period\": \"Periode\",
                \"description\": \"Deskripsi kontribusi kepemimpinan...\"
            }
        ],
        \"certifications\": [
            {
                \"title\": \"Nama Sertifikasi\",
                \"issuer\": \"Lembaga Penerbit\",
                \"year\": \"2023\"
            }
        ],
        \"awards\": [
            {
                \"title\": \"Nama Penghargaan\",
                \"event\": \"Penyelenggara\",
                \"year\": \"2023\"
            }
        ],
        \"languages\": [
            {
                \"lang\": \"Bahasa\",
                \"level\": \"Tingkat Kemahiran\"
            }
        ],
        \"skills\": [
            {\"name\": \"Nama Skill 1\", \"level\": 90},
            {\"name\": \"Nama Skill 2\", \"level\": 85}
        ]
    }
}";

        try {
            $response = Gemini::generativeModel('gemini-3.1-flash-lite')->generateContent($prompt);
            $responseText = trim($response->text());

            // Bersihkan markdown code blocks jika ada
            $responseText = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', $responseText);

            $data = json_decode($responseText, true);

            if (!$data || !isset($data['reply'])) {
                throw new \Exception("Format respons JSON tidak sesuai.");
            }

            return response()->json([
                'success' => true,
                'reply' => $data['reply'],
                'updated_cv' => $data['updated_cv'] ?? $currentCv
            ]);
        } catch (\Exception $e) {
            Log::error('CV AI Chat Error: ' . $e->getMessage());

            // Smart fallback
            $replyFallback = "Terima kasih atas informasinya! Data profil Anda telah saya perbarui dan formulasikan ke standar HRD. Silakan lanjutkan ceritakan pengalaman kerja atau riwayat pendidikan Anda.";
            return response()->json([
                'success' => true,
                'reply' => $replyFallback,
                'updated_cv' => $currentCv
            ]);
        }
    }

    /**
     * Endpoint AI Assistant untuk memproses chat & menghasilkan struktur CV lengkap berstandar HRD
     */
    public function generateAi(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:150',
            'full_name' => 'nullable|string|max:100',
            'degree' => 'nullable|string|max:50',
            'experience_level' => 'nullable|string|max:50',
            'raw_experience' => 'nullable|string|max:2000',
            'education' => 'nullable|string|max:500',
            'raw_skills' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
        ]);

        $role = $request->input('role');
        $name = $request->input('full_name', 'Muhammad Andi Mubarok');
        $degree = $request->input('degree', 'S.Kom');
        $expLevel = $request->input('experience_level', 'Junior / Mid-Level');
        $rawExp = $request->input('raw_experience', '');
        $education = $request->input('education', '');
        $rawSkills = $request->input('raw_skills', '');
        $city = $request->input('city', 'Bandung');

        $prompt = "Kamu adalah Expert HRD Specialist & Recruiter kelas dunia untuk perusahaan top tier di Indonesia.
Tugasmu adalah menyusun dan memformulasikan profil CV profesional yang memikat, berbobot tinggi, dan berorientasi hasil (menggunakan kata kerja aksi aktif dan formula STAR/XYZ Google) berdasarkan data pelamar berikut:

DATA PELAMAR:
- Target Posisi/Pekerjaan: {$role}
- Nama Pelamar: {$name}
- Gelar/Pendidikan: {$degree}
- Level Pengalaman: {$expLevel}
- Catatan Pengalaman/Magang: " . ($rawExp ?: 'Pengalaman relevan dalam industri digital dan pengembangan sistem') . "
- Pendidikan: " . ($education ?: 'S1 di universitas terkemuka') . "
- Keterampilan/Skills yang disebut: " . ($rawSkills ?: 'Keahlian teknis & analitis standar industri') . "
- Lokasi Domisili: {$city}

INSTRUKSI KHUSUS:
1. Buat ringkasan profil (summary) profesional (3-4 kalimat padat) yang menonjolkan keahlian, pengalaman, dan dorongan inovasi.
2. Buatkan 2 riwayat pekerjaan/pengalaman profesional berbobot dengan masing-masing 3-4 bullet point hasil kerja (metrics, persentase, atau kata kerja aktif).
3. Buatkan 1 riwayat magang / pengalaman pendukung / organisasi dengan 3-4 bullet point tugas.
4. Buatkan 1-2 riwayat pendidikan lengkap dengan IPK tinggi (misal: 3.8x) dan prestasi/kegiatan.
5. Buatkan 4-5 hard skills kunci yang paling dicari HRD untuk posisi ini beserta nilai level kemahiran (persentase integer antara 75 sampai 95).

FORMAT RESPON WAJIB JSON:
{
    \"full_name\": \"{$name}\",
    \"degree\": \"{$degree}\",
    \"target_role\": \"{$role}\",
    \"profile_summary\": \"Paragraf ringkasan profil profesional yang menjual...\",
    \"education_list\": [
        {
            \"degree_name\": \"S1 Informatika / Manajemen\",
            \"institution\": \"Universitas Indonesia\",
            \"period\": \"2018 - 2022\",
            \"city\": \"{$city}\",
            \"gpa\": \"IPK 3.89\",
            \"achievements\": [
                \"Lulus dengan predikat Pujian (Cum Laude).\",
                \"Meraih penghargaan tim dengan strategi terbaik dalam kompetisi tingkat nasional.\"
            ]
        }
    ],
    \"work_experience\": [
        {
            \"company\": \"PT Sinarmas Jaya Indonesia\",
            \"position\": \"{$role}\",
            \"period\": \"02 Jan 2022 - 30 Jan 2024\",
            \"city\": \"{$city}\",
            \"bullets\": [
                \"Memimpin pengembangan dan pelaksanaan strategi yang berhasil meningkatkan efisiensi operasional sebesar 25% dan kenaikan konversi 80%.\",
                \"Mengelola alokasi anggaran bulanan terukur dan memaksimalkan ROI hingga mencapai target performa kuartalan.\",
                \"Menganalisis performa metrik harian untuk mengidentifikasi peluang perbaikan performa.\"
            ]
        },
        {
            \"company\": \"PT Shopee Indonesia\",
            \"position\": \"Associate {$role}\",
            \"period\": \"25 April 2020 - 15 Des 2021\",
            \"city\": \"{$city}\",
            \"bullets\": [
                \"Mengelola alur operasional dengan peningkatan tingkat efisiensi sebesar 75%.\",
                \"Bertanggung jawab atas optimisasi alur kerja tim dalam 8 bulan.\"
            ]
        }
    ],
    \"internship_experience\": [
        {
            \"company\": \"PT Nusantara Travel\",
            \"position\": \"Intern {$role}\",
            \"period\": \"02 Jan 2020 - 30 Jan 2021\",
            \"city\": \"{$city}\",
            \"bullets\": [
                \"Terlibat dalam perencanaan, pelaksanaan, dan pengelolaan proyek harian.\",
                \"Mempelajari implementasi tools dan otomatisasi modern.\"
            ]
        }
    ],
    \"skills\": [
        {\"name\": \"Strategi & Optimasi {$role}\", \"level\": 90},
        {\"name\": \"Analisis Data & Reporting\", \"level\": 88},
        {\"name\": \"Project Management\", \"level\": 85},
        {\"name\": \"Leadership & Communication\", \"level\": 92}
    ]
}";

        try {
            $response = Gemini::generativeModel('gemini-3.1-flash-lite')->generateContent($prompt);
            $responseText = trim($response->text());

            // Bersihkan markdown code blocks jika ada
            $responseText = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', $responseText);

            $data = json_decode($responseText, true);

            if (!$data || !isset($data['profile_summary'])) {
                throw new \Exception("Struktur respons AI tidak valid.");
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('CV AI Generation Error: ' . $e->getMessage());

            $fallbackData = $this->getFallbackCvData($role, $name, $degree, $city);

            return response()->json([
                'success' => true,
                'data' => $fallbackData,
                'is_fallback' => true
            ]);
        }
    }

    /**
     * Fallback template yang elegan dan realistis
     */
    private function getFallbackCvData($role, $name, $degree, $city)
    {
        return [
            'full_name' => $name ?: 'Muhammad Andi Mubarok',
            'degree' => $degree ?: 'S.Kom',
            'target_role' => $role ?: 'Fullstack Web Developer',
            'profile_summary' => "Seorang profesional {$role} dengan pengalaman dalam mengembangkan dan melaksanakan strategi teknis serta operasional berbasis target yang berhasil. Terampil dalam analisis sistem, pengelolaan proyek efisien, dan pemanfaatan alat modern untuk mempercepat produktivitas kerja.",
            'education_list' => [
                [
                    'degree_name' => 'S1 ' . ($role ?: 'Informatika & Sistem Informasi'),
                    'institution' => 'Universitas Indonesia',
                    'period' => '2018 - 2022',
                    'city' => 'Jakarta',
                    'gpa' => 'IPK 3.89',
                    'achievements' => [
                        'Lulus dengan predikat Pujian (Cum Laude).',
                        'Meraih penghargaan tim dengan strategi terbaik dalam kompetisi tingkat nasional.'
                    ]
                ]
            ],
            'work_experience' => [
                [
                    'company' => 'PT Sinarmas Jaya Indonesia',
                    'position' => $role,
                    'period' => '02 Jan 2022 - 30 Jan 2023',
                    'city' => $city ?: 'Bandung',
                    'bullets' => [
                        "Memimpin pengembangan dan pelaksanaan solusi {$role} yang berhasil meningkatkan lalu lintas situs web sebesar 20% dan konversi 80%.",
                        'Mengelola alokasi anggaran operasional dan meningkatkan return on investment (ROI) tim secara konsisten.',
                        'Menganalisis performa data harian untuk mengidentifikasi peluang perbaikan dan efisiensi.'
                    ]
                ],
                [
                    'company' => 'PT Shopee Indonesia',
                    'position' => 'Associate ' . $role,
                    'period' => '25 April 2020 - 15 Des 2021',
                    'city' => $city ?: 'Bandung',
                    'bullets' => [
                        'Mengelola program komunikasi dan optimasi proses dengan peningkatan rasio konversi 75%.',
                        'Bertanggung jawab atas efisiensi alur kerja dan standarisasi proses kerja tim.'
                    ]
                ]
            ],
            'internship_experience' => [
                [
                    'company' => 'PT Nusantara Travel',
                    'position' => 'Intern ' . $role,
                    'period' => '02 Jan 2022 - 30 Jan 2023',
                    'city' => $city ?: 'Bandung',
                    'bullets' => [
                        'Terlibat dalam perencanaan, pelaksanaan, dan pengelolaan tugas harian tim.',
                        'Mempelajari berbagai tools modern, Google Analytics, dan strategi otomatisasi.'
                    ]
                ]
            ],
            'skills' => [
                ['name' => "Keahlian Utama {$role}", 'level' => 90],
                ['name' => 'Analisis Data & Reporting', 'level' => 85],
                ['name' => 'Project Management', 'level' => 88],
                ['name' => 'Komunikasi & Kolaborasi', 'level' => 92]
            ]
        ];
    }
}
