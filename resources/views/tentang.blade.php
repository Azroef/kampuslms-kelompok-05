<x-layout title="Tentang">

    <div class="w-full">

        {{-- Header Section --}}
        <div class="mb-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <p class="text-sm font-semibold text-indigo-600 mb-2 uppercase tracking-wider">
                        PROFIL KELOMPOK
                    </p>

                    <h1 class="text-4xl font-bold text-slate-900 mb-3">
                        Kelompok 05
                    </h1>

                    <p class="text-lg text-slate-600 max-w-2xl">
                        Tim pengembang KampusLMS yang berdedikasi untuk membangun platform akademik modern dan user-friendly.
                    </p>
                </div>

                <div class="flex items-center justify-center w-24 h-24 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg">
                    <span class="material-symbols-outlined text-white text-5xl">
                        groups
                    </span>
                </div>
            </div>
        </div>

        {{-- Team Members Section --}}
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">
                Anggota Kelompok
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Member 1 --}}
                <div class="group">
                    <div class="relative bg-white rounded-2xl border-2 border-indigo-200 p-6 shadow-sm hover:shadow-lg hover:border-indigo-400 transition-all duration-300 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-indigo-50 to-transparent rounded-bl-3xl"></div>

                        <div class="relative z-10 flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                                M
                            </div>

                            <div>
                                <h3 class="font-bold text-lg text-slate-900">
                                    Muchammad Maulana
                                </h3>
                                <p class="text-sm text-indigo-600 font-semibold">
                                    Backend Developer
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Member 2 --}}
                <div class="group">
                    <div class="relative bg-white rounded-2xl border-2 border-purple-200 p-6 shadow-sm hover:shadow-lg hover:border-purple-400 transition-all duration-300 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-purple-50 to-transparent rounded-bl-3xl"></div>

                        <div class="relative z-10 flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                                L
                            </div>

                            <div>
                                <h3 class="font-bold text-lg text-slate-900">
                                    Linggar Pramudya
                                </h3>
                                <p class="text-sm text-purple-600 font-semibold">
                                    Frontend Developer
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Member 3 --}}
                <div class="group">
                    <div class="relative bg-white rounded-2xl border-2 border-emerald-200 p-6 shadow-sm hover:shadow-lg hover:border-emerald-400 transition-all duration-300 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-emerald-50 to-transparent rounded-bl-3xl"></div>

                        <div class="relative z-10 flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                                D
                            </div>

                            <div>
                                <h3 class="font-bold text-lg text-slate-900">
                                    Muhammad Daffa
                                </h3>
                                <p class="text-sm text-emerald-600 font-semibold">
                                    Database Engineer
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Member 4 --}}
                <div class="group">
                    <div class="relative bg-white rounded-2xl border-2 border-rose-200 p-6 shadow-sm hover:shadow-lg hover:border-rose-400 transition-all duration-300 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-rose-50 to-transparent rounded-bl-3xl"></div>

                        <div class="relative z-10 flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-rose-500 to-orange-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                                M
                            </div>

                            <div>
                                <h3 class="font-bold text-lg text-slate-900">
                                    Melodiva Rosananda
                                </h3>
                                <p class="text-sm text-rose-600 font-semibold">
                                    UI/UX Designer
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Project Info Section --}}
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 md:p-12 text-white shadow-xl">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="text-center md:text-left">
                    <div class="text-5xl font-bold text-indigo-400 mb-2">
                        4
                    </div>
                    <p class="text-slate-300 font-semibold">
                        Anggota Tim
                    </p>
                </div>

                <div class="text-center md:text-left">
                    <div class="text-5xl font-bold text-purple-400 mb-2">
                        100%
                    </div>
                    <p class="text-slate-300 font-semibold">
                        Dedikasi
                    </p>
                </div>

                <div class="text-center md:text-left">
                    <div class="text-5xl font-bold text-pink-400 mb-2">
                        ∞
                    </div>
                    <p class="text-slate-300 font-semibold">
                        Inovasi
                    </p>
                </div>

            </div>

            <div class="mt-10 pt-10 border-t border-slate-700">
                <p class="text-slate-300 text-center md:text-left">
                    🚀 KampusLMS - Platform Akademik Modern untuk Era Digital
                </p>
            </div>

        </div>

    </div>

</x-layout>