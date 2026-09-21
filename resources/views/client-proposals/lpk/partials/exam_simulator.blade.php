<!-- Exam Simulator Section (Clean & Minimal) -->
<section id="simulasi-ujian" class="py-20 bg-slate-900 text-white relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Simulasi Ujian CBT
            </h2>
            <p class="mt-2 text-slate-400 text-xs sm:text-sm">
                Sistem ujian online terintegrasi: timer otomatis, pengacakan soal, dan penilaian instan.
            </p>
        </div>

        <!-- CBT Container -->
        <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-xl">

            <!-- Top Bar -->
            <div class="flex items-center justify-between border-b border-slate-700 pb-4 mb-6 text-xs">
                <div>
                    <h4 class="font-bold text-white text-sm">Mini Placement Test</h4>
                    <span class="text-slate-400">3 Soal Contoh • 100 Poin</span>
                </div>
                <div class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 font-mono text-slate-300">
                    Sisa Waktu: <span id="quizTimer" class="font-bold text-amber-400">14:45</span>
                </div>
            </div>

            <!-- Questions -->
            <div id="quizContainer" class="space-y-6">
                @foreach($lpkDatabase['quiz_data'] ?? [] as $index => $q)
                <div class="quiz-item bg-slate-900/50 rounded-xl p-5 border border-slate-700/60" data-question-id="{{ $q['id'] }}">

                    <div class="flex items-center justify-between text-xs text-slate-400 mb-2">
                        <span class="font-semibold text-blue-400">Soal #{{ $index + 1 }} • {{ $q['category'] }}</span>
                        <span>33.3 Pts</span>
                    </div>

                    <p class="text-xs sm:text-sm font-medium text-white mb-4 leading-relaxed">
                        {{ $q['question'] }}
                    </p>

                    <!-- Options -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach($q['options'] as $opt)
                        <label class="quiz-option-label flex items-center gap-3 p-3 rounded-xl border border-slate-700 bg-slate-800/40 hover:bg-slate-800 cursor-pointer transition-colors text-xs">
                            <input type="radio" name="question_{{ $q['id'] }}" value="{{ $opt['key'] }}" data-correct="{{ isset($opt['correct']) && $opt['correct'] ? 'true' : 'false' }}" class="quiz-radio w-3.5 h-3.5 text-blue-600 bg-slate-700 border-slate-600">
                            <span class="font-bold text-slate-400 font-mono">{{ $opt['key'] }}.</span>
                            <span class="text-slate-200">{{ $opt['text'] }}</span>
                        </label>
                        @endforeach
                    </div>

                    <!-- Explanation -->
                    <div class="quiz-explanation hidden mt-3 p-3 rounded-lg bg-slate-800 border border-slate-700 text-xs text-slate-300">
                        <strong class="text-amber-400 block mb-0.5">Pembahasan:</strong>
                        <p>{{ $q['explanation'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Actions -->
            <div class="mt-6 pt-5 border-t border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <span class="text-slate-400">Pilih jawaban lalu klik submit untuk melihat skor.</span>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="button" onclick="resetQuiz()" class="px-3.5 py-2 rounded-lg border border-slate-700 text-slate-300 hover:bg-slate-700 transition">
                        Reset
                    </button>
                    <button type="button" onclick="submitQuiz()" class="flex-1 sm:flex-none px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                        Submit Jawaban
                    </button>
                </div>
            </div>

            <!-- Result Card -->
            <div id="quizResultCard" class="hidden mt-5 p-5 rounded-xl bg-slate-900 border border-blue-500/30 text-center space-y-2">
                <h4 class="font-heading font-bold text-xl text-white">
                    Skor: <span id="quizScoreDisplay" class="text-amber-400">0</span> / 100
                </h4>
                <p id="quizGradeStatus" class="text-xs font-semibold"></p>
                <div class="pt-2">
                    <a href="#pendaftaran-peserta" class="inline-block px-4 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition">
                        Daftar Program Penuh
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>
