<x-layout title="Detail Mata Kuliah">

    {{-- Breadcrumb untuk navigasi --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm">
            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">
                Dashboard
            </a>
            <span class="text-slate-400">/</span>
            <a href="{{ route('mata-kuliah.index') }}" class="text-indigo-600 hover:underline">
                Mata Kuliah
            </a>
            <span class="text-slate-400">/</span>
            <span class="text-slate-600">{{ $course['name'] }}</span>
        </div>
    </div>

    {{-- Header dengan informasi utama --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <p class="text-sm font-semibold text-indigo-600 mb-2">
                    DETAIL MATA KULIAH
                </p>
                
                <h1 class="text-4xl font-bold text-slate-900 mb-2">
                    {{ $course['name'] }}
                </h1>

                <p class="text-slate-600">
                    Kode: <span class="font-semibold">{{ $course['code'] }}</span>
                </p>
            </div>

            <a 
                href="{{ route('mata-kuliah.index') }}"
                class="inline-flex items-center px-6 py-3 rounded-xl bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300 transition"
            >
                <span class="material-symbols-outlined mr-2">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    {{-- Grid informasi mata kuliah --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">
                Kode Mata Kuliah
            </p>
            <p class="text-2xl font-bold text-indigo-600 mt-3">
                {{ $course['code'] }}
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">
                SKS (Satuan Kredit Semester)
            </p>
            <p class="text-2xl font-bold text-slate-900 mt-3">
                {{ $course['sks'] }} SKS
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">
                Semester
            </p>
            <p class="text-2xl font-bold text-slate-900 mt-3">
                {{ $course['semester'] }}
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">
                Status
            </p>
            <div class="mt-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold">
                    ● Aktif
                </span>
            </div>
        </div>

    </div>

    {{-- Informasi Dosen --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm mb-8">

        <div class="mb-6">
            <h2 class="text-xl font-bold text-slate-900">
                Informasi Dosen Pengampu
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Dosen yang mengajar mata kuliah ini.
            </p>
        </div>

        <div class="flex items-center gap-4 p-5 rounded-xl bg-indigo-50 border border-indigo-200">
            <div class="w-14 h-14 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-lg">
                {{ strtoupper(substr(explode(' ', $course['dosen'])[0], 0, 1)) }}
            </div>

            <div>
                <p class="font-semibold text-slate-900">
                    {{ $course['dosen'] }}
                </p>
                <p class="text-sm text-slate-600 mt-1">
                    Pengampu Mata Kuliah
                </p>
            </div>
        </div>

    </div>

    {{-- Detail Tambahan --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">

        <h2 class="text-xl font-bold text-slate-900 mb-4">
            Informasi Tambahan
        </h2>

        <div class="space-y-4">

            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined text-indigo-600 mt-1">
                    info
                </span>
                <div>
                    <p class="font-semibold text-slate-900">
                        Tujuan Pembelajaran
                    </p>
                    <p class="text-sm text-slate-600 mt-1">
                        Mata kuliah ini dirancang untuk memberikan pemahaman mendalam tentang {{ strtolower($course['name']) }} kepada mahasiswa.
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined text-indigo-600 mt-1">
                    school
                </span>
                <div>
                    <p class="font-semibold text-slate-900">
                        Prasyarat
                    </p>
                    <p class="text-sm text-slate-600 mt-1">
                        Tidak ada prasyarat khusus. Namun direkomendasikan memiliki pengetahuan dasar yang relevan.
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <span class="material-symbols-outlined text-indigo-600 mt-1">
                    assignment
                </span>
                <div>
                    <p class="font-semibold text-slate-900">
                        Metode Penilaian
                    </p>
                    <p class="text-sm text-slate-600 mt-1">
                        Kehadiran (20%), Tugas & Kuis (30%), UTS (25%), UAS (25%)
                    </p>
                </div>
            </div>

        </div>

    </div>

</x-layout>