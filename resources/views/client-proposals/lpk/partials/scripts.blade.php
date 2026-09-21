<script>
    // Global Constants from Blade
    const LPK_DATA = typeof LPK_DATABASE !== 'undefined' ? LPK_DATABASE : {};
    const CLIENT_WA = typeof WA_NUMBER !== 'undefined' ? WA_NUMBER : '6281234567890';
    const LPK_BRAND = typeof BRAND_NAME !== 'undefined' ? BRAND_NAME : 'LPK Global';

    // 1. Mobile Menu Toggle
    document.addEventListener('DOMContentLoaded', () => {
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                if (menuIcon) {
                    menuIcon.classList.toggle('fa-bars');
                    menuIcon.classList.toggle('fa-times');
                }
            });
        }

        // Start Quiz Mock Timer
        initQuizTimer();
    });

    // 2. Generic Modal Helpers
    function openModal(modalId) {
        const el = document.getElementById(modalId);
        if (el) {
            el.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        const el = document.getElementById(modalId);
        if (el) {
            el.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    // 3. Category & Keyword Filtering for Programs
    function filterCategory(category, buttonEl) {
        // Update active button classes
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-blue-600', 'text-white', 'shadow-md');
            btn.classList.add('bg-white', 'text-slate-700');
        });

        if (buttonEl) {
            buttonEl.classList.add('active', 'bg-blue-600', 'text-white', 'shadow-md');
            buttonEl.classList.remove('bg-white', 'text-slate-700');
        }

        const cards = document.querySelectorAll('.program-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category');
            if (category === 'all' || cardCat === category) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        const noFound = document.getElementById('noProgramsFound');
        if (noFound) {
            noFound.classList.toggle('hidden', visibleCount > 0);
        }
    }

    function filterProgramsFromHero() {
        const searchVal = document.getElementById('heroSearchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.program-card');
        let visibleCount = 0;

        // Reset category buttons
        document.querySelectorAll('.category-btn').forEach((btn, idx) => {
            if (idx === 0) {
                btn.classList.add('active', 'bg-blue-600', 'text-white');
                btn.classList.remove('bg-white', 'text-slate-700');
            } else {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'text-slate-700');
            }
        });

        cards.forEach(card => {
            const keywords = card.getAttribute('data-keywords') || '';
            if (keywords.includes(searchVal)) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        const noFound = document.getElementById('noProgramsFound');
        if (noFound) {
            noFound.classList.toggle('hidden', visibleCount > 0);
        }

        // Smooth scroll to programs section
        const section = document.getElementById('program-pelatihan');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // 4. Program Detail Modal Logic
    function openProgramModal(programId) {
        if (!LPK_DATA.programs) return;
        const program = LPK_DATA.programs.find(p => p.id === programId);
        if (!program) return;

        document.getElementById('modalProgramFlag').textContent = program.flag;
        document.getElementById('modalProgramCategory').textContent = program.category;
        document.getElementById('modalProgramCode').textContent = program.code;
        document.getElementById('modalProgramTitle').textContent = program.title;
        document.getElementById('modalProgramSubtitle').textContent = program.subtitle;
        document.getElementById('modalProgramDuration').textContent = program.duration;
        document.getElementById('modalProgramSchedule').textContent = program.schedule;
        document.getElementById('modalProgramPrice').textContent = program.price_formatted;
        document.getElementById('modalProgramSalary').textContent = program.salary_estimate;
        document.getElementById('modalProgramDesc').textContent = program.description;
        document.getElementById('modalProgramDp').textContent = program.down_payment;

        // Populate Modules List
        const modulesContainer = document.getElementById('modalModulesList');
        modulesContainer.innerHTML = '';
        if (program.modules && program.modules.length > 0) {
            program.modules.forEach(mod => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs';
                item.innerHTML = `
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-800 font-bold flex items-center justify-center text-[11px] font-mono shrink-0">${mod.no}</span>
                        <span class="font-medium text-slate-800">${mod.title}</span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-mono text-[10px]">${mod.duration}</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 font-semibold text-[10px]">${mod.type}</span>
                    </div>
                `;
                modulesContainer.appendChild(item);
            });
        }

        // Populate Requirements List
        const reqContainer = document.getElementById('modalRequirementsList');
        reqContainer.innerHTML = '';
        if (program.requirements && program.requirements.length > 0) {
            program.requirements.forEach(req => {
                const li = document.createElement('li');
                li.className = 'flex items-start gap-2 text-slate-600';
                li.innerHTML = `<i class="fas fa-check-circle text-emerald-500 mt-0.5 shrink-0 text-xs"></i><span>${req}</span>`;
                reqContainer.appendChild(li);
            });
        }

        // Register Button in Modal
        const btnReg = document.getElementById('modalBtnRegister');
        if (btnReg) {
            btnReg.onclick = () => {
                closeProgramModal();
                registerForProgram(program.title);
            };
        }

        openModal('modalProgramDetail');
    }

    function closeProgramModal() {
        closeModal('modalProgramDetail');
    }

    // 5. Quick Registration Modal Trigger
    function registerForProgram(programTitle) {
        document.getElementById('quickModalProgramName').textContent = programTitle;
        openModal('modalRegisterQuick');
    }

    // 6. Interactive CBT Exam Logic
    let timerSeconds = 15 * 60;
    function initQuizTimer() {
        const timerEl = document.getElementById('quizTimer');
        if (!timerEl) return;

        setInterval(() => {
            if (timerSeconds > 0) {
                timerSeconds--;
                const mins = Math.floor(timerSeconds / 60);
                const secs = timerSeconds % 60;
                timerEl.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }
        }, 1000);
    }

    function submitQuiz() {
        const quizItems = document.querySelectorAll('.quiz-item');
        let totalQuestions = quizItems.length;
        let answeredQuestions = 0;
        let correctAnswers = 0;

        quizItems.forEach(item => {
            const selected = item.querySelector('input[type="radio"]:checked');
            const explanation = item.querySelector('.quiz-explanation');

            if (selected) {
                answeredQuestions++;
                const isCorrect = selected.getAttribute('data-correct') === 'true';
                if (isCorrect) {
                    correctAnswers++;
                }

                // Highlight options
                const options = item.querySelectorAll('.quiz-option-label');
                options.forEach(opt => {
                    const radio = opt.querySelector('input[type="radio"]');
                    if (radio.getAttribute('data-correct') === 'true') {
                        opt.classList.add('border-emerald-500', 'bg-emerald-950/40', 'text-emerald-300');
                    } else if (radio.checked && !isCorrect) {
                        opt.classList.add('border-rose-500', 'bg-rose-950/40', 'text-rose-300');
                    }
                });

                if (explanation) {
                    explanation.classList.remove('hidden');
                }
            }
        });

        if (answeredQuestions < totalQuestions) {
            alert('Mohon jawab seluruh soal (' + answeredQuestions + '/' + totalQuestions + ' terjawab) sebelum submit nilai.');
            return;
        }

        const scorePercent = Math.round((correctAnswers / totalQuestions) * 100);
        
        // Show Result Card
        const resultCard = document.getElementById('quizResultCard');
        const scoreDisplay = document.getElementById('quizScoreDisplay');
        const gradeStatus = document.getElementById('quizGradeStatus');
        const resultIcon = document.getElementById('quizResultIcon');

        if (resultCard && scoreDisplay && gradeStatus) {
            scoreDisplay.textContent = scorePercent;
            if (scorePercent >= 80) {
                gradeStatus.textContent = `SELAMAT! Anda Dinyatakan KOMPETEN TINGKAT A (${correctAnswers}/${totalQuestions} Benar). Memenuhi syarat kelulusan penempatan!`;
                gradeStatus.className = 'text-xs font-semibold text-emerald-400';
                resultIcon.className = 'fas fa-trophy text-amber-400';
            } else if (scorePercent >= 60) {
                gradeStatus.textContent = `CUKUP KOMPETEN (Grade B). Perlu penguatan pada modul etika dan istilah teknis (${correctAnswers}/${totalQuestions} Benar).`;
                gradeStatus.className = 'text-xs font-semibold text-amber-400';
                resultIcon.className = 'fas fa-medal text-amber-400';
            } else {
                gradeStatus.textContent = `BELUM KOMPETEN (Grade C). Direkomendasikan mengikuti kelas intensif pendampingan mentor (${correctAnswers}/${totalQuestions} Benar).`;
                gradeStatus.className = 'text-xs font-semibold text-rose-400';
                resultIcon.className = 'fas fa-rotate text-rose-400';
            }
            resultCard.classList.remove('hidden');
            resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function resetQuiz() {
        document.querySelectorAll('.quiz-radio').forEach(r => r.checked = false);
        document.querySelectorAll('.quiz-option-label').forEach(opt => {
            opt.classList.remove('border-emerald-500', 'bg-emerald-950/40', 'text-emerald-300', 'border-rose-500', 'bg-rose-950/40', 'text-rose-300');
        });
        document.querySelectorAll('.quiz-explanation').forEach(exp => exp.classList.add('hidden'));
        const resultCard = document.getElementById('quizResultCard');
        if (resultCard) resultCard.classList.add('hidden');
    }

    // 7. Attendance Simulation Action
    let attendanceSimCount = 0;
    function simulateScanAttendance() {
        const tableBody = document.getElementById('attendanceLogBody');
        const alertBox = document.getElementById('scanSuccessAlert');
        
        if (!tableBody) return;

        attendanceSimCount++;
        const now = new Date();
        const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0') + ' WIB';

        const newRow = document.createElement('tr');
        newRow.className = 'bg-emerald-950/30 border-b border-emerald-800/40 text-emerald-200 animate-pulse';
        newRow.innerHTML = `
            <td class="p-3">
                <div class="font-bold text-white">Andi Saputra #${attendanceSimCount} (JP-01)</div>
                <div class="text-[11px] text-emerald-400">Scan QR Presensi • Geolocation Lab 1</div>
            </td>
            <td class="p-3 font-mono text-emerald-300">${timeStr}</td>
            <td class="p-3">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                    Hadir (Valid GPS)
                </span>
            </td>
        `;

        tableBody.insertBefore(newRow, tableBody.firstChild);

        if (alertBox) {
            alertBox.classList.remove('hidden');
            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 6000);
        }
    }

    // 8. Certificate Verification Engine
    function lookupCertificate(certId) {
        document.getElementById('inputCertId').value = certId;
        verifyCertificateManual();
    }

    function verifyCertificateManual() {
        const input = document.getElementById('inputCertId').value.trim();
        if (!input) {
            alert('Silakan masukkan Nomor Sertifikat yang ingin diverifikasi.');
            return;
        }

        const samples = LPK_DATA.certificates_sample || [];
        const found = samples.find(c => c.cert_id.toLowerCase() === input.toLowerCase());

        if (found) {
            document.getElementById('certStudentName').textContent = found.student_name;
            document.getElementById('certProgramName').textContent = found.program;
            document.getElementById('certNumber').textContent = found.cert_id;
            document.getElementById('certGrade').textContent = found.grade;
            document.getElementById('certBnsp').textContent = found.bnsp_reg;
            document.getElementById('certDate').textContent = found.issue_date;
            document.getElementById('certPlacement').textContent = found.placement_status;
            document.getElementById('certCardStatusBadge').textContent = found.status;
            document.getElementById('certCardStatusBadge').className = 'text-emerald-800 font-bold';
            
            const card = document.getElementById('certificateResultDisplay');
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            // Simulated fallback verified certificate for custom entered ID
            document.getElementById('certStudentName').textContent = 'Peserta LPK Terdaftar';
            document.getElementById('certProgramName').textContent = 'Program Pelatihan Kerja Berstandar BNSP';
            document.getElementById('certNumber').textContent = input.toUpperCase();
            document.getElementById('certGrade').textContent = 'Kompeten (A / 90.0)';
            document.getElementById('certBnsp').textContent = 'BNSP-REG-VERIFIED-' + Math.floor(100000 + Math.random() * 900000);
            document.getElementById('certDate').textContent = '21 September 2026';
            document.getElementById('certPlacement').textContent = 'Dalam Proses Matching User / Siap Kerja';
            document.getElementById('certCardStatusBadge').textContent = 'TERDAFTAR & VALID';

            const card = document.getElementById('certificateResultDisplay');
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // 9. Registration Form Submissions (Section Form & Quick Modal)
    function handleRegistrationSubmit(e) {
        e.preventDefault();
        const name = document.getElementById('regName').value.trim();
        const wa = document.getElementById('regWa').value.trim();
        const program = document.getElementById('regProgram').value;
        const education = document.getElementById('regEducation').value;
        const age = document.getElementById('regAge').value;
        const city = document.getElementById('regCity').value.trim();
        const notes = document.getElementById('regNotes').value.trim();

        const message = `Halo Admin *${LPK_BRAND}*,\n\nSaya ingin mendaftar sebagai Calon Peserta Pelatihan Kerja:\n\n` +
            `👤 *Nama*: ${name}\n` +
            `📱 *No. WA*: ${wa}\n` +
            `🎓 *Pilihan Program*: ${program}\n` +
            `📚 *Pendidikan Terakhir*: ${education}\n` +
            `🎂 *Usia*: ${age} Tahun\n` +
            `📍 *Domisili Asal*: ${city}\n` +
            (notes ? `📝 *Catatan*: ${notes}\n\n` : `\n`) +
            `Mohon informasi jadwal placement test, persyaratan berkas, dan skema biaya/dana talangan. Terima kasih!`;

        const waUrl = `https://wa.me/${CLIENT_WA}?text=${encodeURIComponent(message)}`;
        window.open(waUrl, '_blank');
    }

    function handleQuickRegisterSubmit(e) {
        e.preventDefault();
        const name = document.getElementById('quickRegName').value.trim();
        const wa = document.getElementById('quickRegWa').value.trim();
        const age = document.getElementById('quickRegAge').value;
        const city = document.getElementById('quickRegCity').value.trim();
        const program = document.getElementById('quickModalProgramName').textContent;

        const message = `Halo Admin *${LPK_BRAND}*,\n\nSaya ingin mendaftar untuk:\n` +
            `🎓 *Program*: ${program}\n` +
            `👤 *Nama*: ${name}\n` +
            `📱 *No. WA*: ${wa}\n` +
            `🎂 *Usia*: ${age} Tahun\n` +
            `📍 *Domisili*: ${city}\n\n` +
            `Mohon info pendaftaran dan jadwal kelas terdekat. Terima kasih!`;

        closeModal('modalRegisterQuick');
        const waUrl = `https://wa.me/${CLIENT_WA}?text=${encodeURIComponent(message)}`;
        window.open(waUrl, '_blank');
    }

    // 10. Mobile Pricing Plan Switcher
    function showMobilePlan(planKey, btnEl) {
        document.querySelectorAll('.plan-tab-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-slate-900', 'text-white', 'shadow-xs');
            btn.classList.add('text-slate-600');
        });

        if (btnEl) {
            btnEl.classList.add('active', 'bg-slate-900', 'text-white', 'shadow-xs');
            btnEl.classList.remove('text-slate-600');
        }

        document.querySelectorAll('.mobile-plan-card').forEach(card => card.classList.add('hidden'));

        const targetCard = document.getElementById('mobileCard' + planKey.charAt(0).toUpperCase() + planKey.slice(1));
        if (targetCard) {
            targetCard.classList.remove('hidden');
        }
    }
</script>
