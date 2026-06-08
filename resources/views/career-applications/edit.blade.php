@extends('layouts.admin.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('career-applications.index') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 md:p-8">
        <h2 class="text-2xl font-semibold text-slate-800 mb-6 border-b border-slate-100 pb-4">Edit Data Pelamar: <span class="text-blue-600">{{ $careerApplication->full_name }}</span></h2>

        <form action="{{ route('career-applications.update', $careerApplication->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Career Selection -->
            <div>
                <label for="career_id" class="block text-sm font-medium text-slate-700 mb-2">Posisi yang Dilamar <span class="text-red-500">*</span></label>
                <select name="career_id" id="career_id" class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    <option value="">Pilih Posisi Karir</option>
                    @foreach($careers as $career)
                    <option value="{{ $career->id }}" {{ old('career_id', $careerApplication->career_id) == $career->id ? 'selected' : '' }}>
                        {{ $career->title }}
                    </option>
                    @endforeach
                </select>
                @error('career_id')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Full Name -->
            <div>
                <label for="full_name" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $careerApplication->full_name) }}" class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                @error('full_name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $careerApplication->email) }}" class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                    @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">No. HP / WhatsApp</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $careerApplication->phone) }}" class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm">
                    @error('phone')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Portfolio URL -->
                <div>
                    <label for="portfolio_url" class="block text-sm font-medium text-slate-700 mb-2">Link Portofolio (URL)</label>
                    <input type="url" name="portfolio_url" id="portfolio_url" value="{{ old('portfolio_url', $careerApplication->portfolio_url) }}" class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="https://...">
                    @error('portfolio_url')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- LinkedIn URL -->
                <div>
                    <label for="linkedin_url" class="block text-sm font-medium text-slate-700 mb-2">Link LinkedIn (URL)</label>
                    <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $careerApplication->linkedin_url) }}" class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="https://linkedin.com/in/...">
                    @error('linkedin_url')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Resume Upload -->
            <div>
                <label for="resume" class="block text-sm font-medium text-slate-700 mb-2">Upload CV / Resume (PDF/DOC/DOCX)</label>
                @if($careerApplication->resume)
                <div class="mb-3 text-sm flex items-center gap-2">
                    <span class="text-slate-500">Resume Saat Ini:</span>
                    <a href="{{ asset('storage/' . $careerApplication->resume) }}" target="_blank" class="text-blue-600 hover:underline font-medium inline-flex items-center gap-1">
                        <i class="fa-solid fa-file-pdf text-red-500"></i> Lihat Resume
                    </a>
                </div>
                @endif
                <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg">
                <p class="mt-2 text-[11px] text-slate-500 italic">* Kosongkan jika tidak ingin mengubah resume.</p>
                @error('resume')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cover Letter -->
            <div>
                <label for="cover_letter" class="block text-sm font-medium text-slate-700 mb-2">Cover Letter / Pesan Tambahan</label>
                <textarea name="cover_letter" id="cover_letter" rows="5" class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('cover_letter', $careerApplication->cover_letter) }}</textarea>
                @error('cover_letter')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('career-applications.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-yellow-500 text-white rounded-lg text-sm font-medium hover:bg-yellow-600 transition">Update Lamaran</button>
            </div>
        </form>
    </div>
</div>
@endsection
