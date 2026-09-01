<script>
    // 7-Day Sprint Calendar Data
    const sprintDays = {
        1: {
            badge: 'Hari 1: Senin',
            title: 'Riset 10 Bisnis Lokal di Google Maps',
            target: 'Target: 10 Kontak WA',
            desc: 'Buka Google Maps atau Instagram di area kota Anda. Cari 10 bisnis lokal (contoh: Cafe, Salon, Rental Mobil, Klinik, Bakery) yang belum memiliki link website di profil mereka. Simpan nama bisnis dan nomor WhatsApp pemilik usaha.',
            actionHtml: `<button onclick="switchTab('categories')" class="flex-1 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5"><i class="fa-solid fa-layer-group text-xs"></i> Lihat Referensi Kategori</button>`
        },
        2: {
            badge: 'Hari 2: Selasa',
            title: 'Generate Live Proposal Klien & Kirim WA',
            target: 'Target: 10 Proposal Terkirim',
            desc: 'Buka menu Katalog Proposal di Dashboard. Masukkan 10 nama bisnis yang telah diriset kemarin untuk membuat link landing page mockup live atas nama bisnis mereka. Kirimkan pesan pengenalan via WhatsApp.',
            actionHtml: `<a href="{{ route('affiliate.proposals') }}" wire:navigate class="flex-1 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5"><i class="fa-solid fa-folder-plus text-xs"></i> Buka Katalog Proposal</a>`
        },
        3: {
            badge: 'Hari 3: Rabu',
            title: 'Publikasi Story WA & Status Media Sosial',
            target: 'Target: 3 Postingan / Story',
            desc: 'Gunakan AI Social Studio untuk meracik copy status WhatsApp Story, Facebook, atau Telegram. Pasang juga poster dari Marketing Kit agar prospek melihat Anda aktif sebagai konsultan agensi digital.',
            actionHtml: `<button onclick="switchTab('ai-studio')" class="flex-1 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5"><i class="fa-solid fa-wand-magic-sparkles text-xs"></i> Buka AI Social Studio</button>`
        },
        4: {
            badge: 'Hari 4: Kamis',
            title: 'Follow-Up Prospek & Tunjukkan Case Study',
            target: 'Target: 5 Respon / Obrolan Aktif',
            desc: 'Follow-up prospek yang sudah melihat proposal Anda. Tanyakan kesan mereka terhadap desain mockup yang dibuat, lalu kirimkan Case Study & Portofolio Scalify sebagai bukti hasil nyata peningkatan omset klien kami.',
            actionHtml: `<button onclick="switchTab('case-study')" class="flex-1 py-2 bg-purple-600 hover:bg-purple-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5"><i class="fa-solid fa-briefcase text-xs"></i> Salin Case Study Klien</button>`
        },
        5: {
            badge: 'Hari 5: Jumat',
            title: 'Tangani Keberatan & Negosiasi Closing',
            target: 'Target: 1-2 Calon Deal',
            desc: 'Jika klien merasa ragu terkait biaya atau fungsi website, gunakan fitur Penakluk Penolakan AI untuk merumuskan balasan negosiasi yang cerdas, ramah, dan meyakinkan hingga klien siap mengambil keputusan.',
            actionHtml: `<button onclick="switchTab('objection')" class="flex-1 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5"><i class="fa-solid fa-shield-halved text-xs"></i> Buka Penakluk Penolakan</button>`
        },
        6: {
            badge: 'Hari 6-7: Weekend',
            title: 'Finalisasi Project Deal & Klaim Komisi',
            target: 'Target: Min. 1 Project Deal',
            desc: 'Pastikan klien menyetujui paket website. Informasikan tim Scalify untuk mulai produksi. Begitu project deal dan diverifikasi, komisi 10% (Rp 200.000 - Rp 500.000) langsung masuk ke saldo dompet Anda!',
            actionHtml: `<a href="{{ route('affiliate.history') }}" wire:navigate class="flex-1 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-1.5"><i class="fa-solid fa-wallet text-xs"></i> Cek Riwayat & Saldo Komisi</a>`
        }
    };

    let currentSprintDay = 1;

    function selectSprintDay(day) {
        currentSprintDay = day;
        document.querySelectorAll('.day-tab-btn').forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.getElementById('day-btn-' + day);
        if (activeBtn) activeBtn.classList.add('active');

        const data = sprintDays[day];
        if (!data) return;

        document.getElementById('sprint-day-badge').innerText = data.badge;
        document.getElementById('sprint-day-title').innerText = data.title;
        document.getElementById('sprint-day-target').innerText = data.target;
        document.getElementById('sprint-day-desc').innerText = data.desc;
        document.getElementById('sprint-action-box').innerHTML = data.actionHtml;

        // Update task checkbox
        const isDone = localStorage.getItem('sprint_day_' + day) === 'true';
        const checkbox = document.getElementById('task-check-1');
        if (checkbox) {
            checkbox.checked = isDone;
            checkbox.setAttribute('onchange', `toggleTaskDone(${day})`);
        }
        const label = document.getElementById('task-label-1');
        if (label) {
            label.innerText = isDone ? 'Aksi hari ini selesai (Tersimpan)' : 'Tandai aksi hari ini selesai';
        }
    }

    function toggleTaskDone(day) {
        const checkbox = document.getElementById('task-check-1');
        if (!checkbox) return;
        localStorage.setItem('sprint_day_' + day, checkbox.checked);
        const label = document.getElementById('task-label-1');
        if (label) {
            label.innerText = checkbox.checked ? 'Aksi hari ini selesai (Tersimpan)' : 'Tandai aksi hari ini selesai';
        }
        updateSprintProgress();
        if (checkbox.checked) {
            showToast('Bagus! Aksi Hari ' + day + ' berhasil diselesaikan.', 'success');
        }
    }

    function updateSprintProgress() {
        let completed = 0;
        for (let i = 1; i <= 6; i++) {
            const isDone = localStorage.getItem('sprint_day_' + i) === 'true';
            const icon = document.getElementById('check-icon-' + i);
            if (icon) {
                if (isDone) {
                    icon.classList.remove('hidden');
                    completed++;
                } else {
                    icon.classList.add('hidden');
                }
            }
        }
        const badge = document.getElementById('sprint-progress-badge');
        if (badge) {
            badge.innerText = `${completed}/6 Selesai`;
            if (completed >= 6) {
                badge.className = 'px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30';
            }
        }
    }

    // Initialize sprint status on load & livewire navigation
    function initGuideView() {
        updateSprintProgress();
        selectSprintDay(1);
    }

    document.addEventListener('DOMContentLoaded', initGuideView);
    document.addEventListener('livewire:navigated', initGuideView);

    // Tab Switcher Logic (Instant 0 Latency)
    function switchTab(tabId) {
        document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        const targetPane = document.getElementById('tab-content-' + tabId);
        const targetBtn = document.getElementById('tab-btn-' + tabId);

        if (targetPane) targetPane.classList.remove('hidden');
        if (targetBtn) targetBtn.classList.add('active');

        // Scroll tab button into view smoothly
        if (targetBtn) {
            targetBtn.scrollIntoView({
                behavior: 'smooth',
                inline: 'center',
                block: 'nearest'
            });
        }
    }

    // Toggle custom objection input
    function toggleCustomObjection() {
        const type = document.getElementById('obj_type').value;
        const box = document.getElementById('custom-obj-box');
        if (type === 'custom') {
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }

    // Quick topic setter
    function setQuickTopic(topic) {
        const input = document.getElementById('ai_custom_topic');
        input.value = topic;
        input.focus();
        showToast('Tema dipilih: ' + topic, 'success');
    }

    // AI Social Post Generator
    async function generateAiSocialPost() {
        const btn = document.getElementById('btn-generate-ai');
        const btnText = document.getElementById('btn-ai-text');
        const outputContainer = document.getElementById('ai-output-container');
        const outputText = document.getElementById('ai-generated-text');

        const platformEl = document.querySelector('input[name="ai_platform"]:checked');
        const platform = platformEl ? platformEl.value : 'wa_story';
        const persona = document.getElementById('ai_persona').value;
        const category = document.getElementById('ai_category').value;
        const custom_topic = document.getElementById('ai_custom_topic').value;

        btn.disabled = true;
        btnText.innerText = 'Meracik Teks AI...';

        try {
            const response = await fetch("{{ route('affiliate.ai_social_post') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    platform,
                    persona,
                    category,
                    custom_topic
                })
            });

            const data = await response.json();

            if (data.success) {
                outputText.value = data.content;
                outputContainer.classList.remove('hidden');
                outputContainer.scrollIntoView({
                    behavior: 'smooth'
                });

                // Update Multi-Channel Share Links
                const refUrl = "{{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}";
                const encodedContent = encodeURIComponent(data.content);
                const encodedUrl = encodeURIComponent(refUrl);

                // WhatsApp
                const btnWa = document.getElementById('btn-share-wa');
                if (btnWa) btnWa.href = `https://api.whatsapp.com/send?text=${encodedContent}`;
                // Facebook
                const btnFb = document.getElementById('btn-share-fb');
                if (btnFb) btnFb.href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}&quote=${encodedContent}`;
                // Telegram
                const btnTg = document.getElementById('btn-share-tg');
                if (btnTg) btnTg.href = `https://t.me/share/url?url=${encodedUrl}&text=${encodedContent}`;
                // Twitter / X
                const btnTw = document.getElementById('btn-share-tw');
                if (btnTw) btnTw.href = `https://twitter.com/intent/tweet?text=${encodedContent}`;

                showToast('Konten berhasil dibuat AI!', 'success');
            } else {
                showToast(data.message || 'Gagal generate AI', 'error');
            }
        } catch (e) {
            showToast('Terjadi kesalahan koneksi', 'error');
        } finally {
            btn.disabled = false;
            btnText.innerText = 'Generate Konten AI';
        }
    }

    function copyGeneratedAiText() {
        const text = document.getElementById('ai-generated-text');
        text.select();
        text.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(text.value);
        showToast('Teks postingan berhasil disalin!', 'success');
    }

    // AI Objection Crusher
    async function generateAiObjectionResponse() {
        const btn = document.getElementById('btn-generate-obj');
        const btnText = document.getElementById('btn-obj-text');
        const outputContainer = document.getElementById('obj-output-container');
        const outputText = document.getElementById('obj-generated-text');

        const objection_type = document.getElementById('obj_type').value;
        const custom_objection = document.getElementById('obj_custom_text').value;
        const business_type = document.getElementById('obj_business_type').value;

        btn.disabled = true;
        btnText.innerText = 'Menyusun Balasan...';

        try {
            const response = await fetch("{{ route('affiliate.ai_handle_objection') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    objection_type,
                    custom_objection,
                    business_type
                })
            });

            const data = await response.json();

            if (data.success) {
                outputText.value = data.response_text;
                outputContainer.classList.remove('hidden');
                outputContainer.scrollIntoView({
                    behavior: 'smooth'
                });
                showToast('Script balasan siap disalin!', 'success');
            } else {
                showToast(data.message || 'Gagal memproses AI', 'error');
            }
        } catch (e) {
            showToast('Terjadi kesalahan koneksi', 'error');
        } finally {
            btn.disabled = false;
            btnText.innerText = 'Susun Balasan Persuasif';
        }
    }

    function copyGeneratedObjText() {
        const text = document.getElementById('obj-generated-text');
        text.select();
        text.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(text.value);
        showToast('Balasan WhatsApp berhasil disalin!', 'success');
    }

    // Copy Helper
    function copyTextById(elementId, successMessage = 'Teks berhasil disalin!') {
        const el = document.getElementById(elementId);
        if (el) {
            navigator.clipboard.writeText(el.innerText);
            showToast(successMessage, 'success');
        }
    }

    function copyCaseStudy(title, client, result, url) {
        const text = `Studi Kasus: ${title}\nKlien: ${client}\nHasil: ${result}\nLive Demo: ${url}`;
        navigator.clipboard.writeText(text);
        showToast('Ringkasan Case Study disalin!', 'success');
    }

    // HTML5 Canvas Banner Generator (1080x1080 High-Res)
    function downloadBannerCanvas(title, subtitle, filename) {
        const canvas = document.getElementById('bannerCanvas');
        const ctx = canvas.getContext('2d');

        // Background Gradient
        const grad = ctx.createLinearGradient(0, 0, 1080, 1080);
        grad.addColorStop(0, '#0B1120');
        grad.addColorStop(0.5, '#0F172A');
        grad.addColorStop(1, '#1E1B4B');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 1080, 1080);

        // Glow circle
        const glow = ctx.createRadialGradient(850, 200, 50, 850, 200, 450);
        glow.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        glow.addColorStop(1, 'transparent');
        ctx.fillStyle = glow;
        ctx.beginPath();
        ctx.arc(850, 200, 450, 0, Math.PI * 2);
        ctx.fill();

        // Border card
        ctx.strokeStyle = 'rgba(255, 255, 255, 0.12)';
        ctx.lineWidth = 4;
        ctx.strokeRect(60, 60, 960, 960);

        // Header Pill
        ctx.fillStyle = 'rgba(37, 99, 235, 0.25)';
        ctx.fillRect(100, 110, 380, 60);
        ctx.fillStyle = '#60A5FA';
        ctx.font = 'bold 26px Inter, sans-serif';
        ctx.fillText('SCALIFY INTELLIGENCE', 130, 150);

        // Main Title
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 52px Inter, sans-serif';
        wrapText(ctx, title, 100, 320, 880, 68);

        // Subtitle
        ctx.fillStyle = '#94A3B8';
        ctx.font = '30px Inter, sans-serif';
        wrapText(ctx, subtitle, 100, 520, 880, 46);

        // Feature Highlights
        ctx.fillStyle = '#38BDF8';
        ctx.font = 'bold 28px Inter, sans-serif';
        ctx.fillText('✓ Desain Premium & Mobile Responsive 2026', 100, 680);
        ctx.fillText('✓ Integrasi WhatsApp & Automasi Chat AI', 100, 740);
        ctx.fillText('✓ Garansi Maintenance & Domain Gratis', 100, 800);

        // Footer Card
        ctx.fillStyle = 'rgba(255, 255, 255, 0.05)';
        ctx.fillRect(100, 860, 880, 110);
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 26px Inter, sans-serif';
        ctx.fillText('Konsultasi & Layanan: Scalify Partner', 130, 925);
        ctx.fillStyle = '#60A5FA';
        ctx.font = 'bold 24px monospace';
        ctx.fillText('ID: {{ $affiliate->affiliate_code }}', 780, 925);

        // Trigger Download
        const link = document.createElement('a');
        link.download = filename;
        link.href = canvas.toDataURL('image/png');
        link.click();
        showToast('Poster HD berhasil diunduh!', 'success');
    }

    function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
        const words = text.split(' ');
        let line = '';

        for (let n = 0; n < words.length; n++) {
            const testLine = line + words[n] + ' ';
            const metrics = ctx.measureText(testLine);
            const testWidth = metrics.width;
            if (testWidth > maxWidth && n > 0) {
                ctx.fillText(line, x, y);
                line = words[n] + ' ';
                y += lineHeight;
            } else {
                line = testLine;
            }
        }
        ctx.fillText(line, x, y);
    }
</script>
