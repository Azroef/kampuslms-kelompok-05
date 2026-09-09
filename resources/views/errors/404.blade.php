<x-layout title="404 - Halaman Tidak Ditemukan">

    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="text-center">

            <div class="text-8xl font-bold text-indigo-600">
                404
            </div>

            <h1 class="mt-4 text-3xl font-bold text-slate-800">
                halamannya kagak ada ges
            </h1>

            <p class="mt-3 text-slate-500">
                cek lagi aja coba
            </p>

            <div class="mt-8">
                <a
                    href="{{ route('mata-kuliah.index') }}"
                    class="inline-flex items-center rounded-xl bg-indigo-600 px-6 py-3
                           font-semibold text-white transition hover:bg-indigo-700"
                >
                    Kembali ke Mata Kuliah
                </a>
            </div>

        </div>
    </div>

</x-layout>