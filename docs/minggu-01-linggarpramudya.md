# Catatan Minggu 1
Nama : Linggar Pramudya\
Nim : 10241039\
Kelas : A

## 1.3 Read → Break → Fix → Build

### READ — Bedah instalasi Anda sendiri (45 menit)

Setelah instalasi selesai dan halaman selamat datang Laravel muncul, kerjakan **tanpa AI**:

1. Buka `public/index.php`. Baca dari atas ke bawah. Tulis dalam 3 kalimat apa yang dilakukan berkas ini.
2. Buka `bootstrap/app.php`. Identifikasi bagian mana yang mengurus route, mana yang mengurus middleware, mana yang mengurus exception.
3. Buka `routes/web.php`. Temukan route yang menghasilkan halaman selamat datang. Ubah teksnya, muat ulang browser, pastikan berubah.
4. Jalankan `php artisan route:list`. Cocokkan keluarannya dengan isi `routes/web.php`.

### Jawaban
1. Menerima Request User
2. Hasil identifikasi
-ini yang mengurus routesnya
   `return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )`

-ini yang mengurus middleware
    `->withMiddleware(function (Middleware $middleware): void {
        //
    })`

-ini yang mengurus exception
    `->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();`

3. ini yang menghasilkan halaman selamat datang
`Route::get('/', function () {
    return view('welcome');
});`
ketika welcomenya diganti itu websitenya langsung error, karena terhubung ke resource, view.

4. `php artisan route:list` dan `route/web.php`
- `route/web.php`
  
        Route::get('/', function () {
            return view('welcome');
        });

- `php artisan route:list`

    PS C:\Users\Linggar\Downloads\proweb\kampuslms-kelompok-05\test> php artisan route:list
  GET|HEAD  / ................................................................................... routes/web.php:5
  GET|HEAD  storage/{path} storage.local › vendor/laravel/framework/src/Illuminate/Filesystem/FilesystemServicePr…
  PUT       storage/{path} storage.local.upload › vendor/laravel/framework/src/Illuminate/Filesystem/FilesystemSe…
  GET|HEAD  up ....... vendor/laravel/framework/src/Illuminate/Foundation/Configuration/ApplicationBuilder.php:219



### BREAK — Rusak dengan sengaja (30 menit)

Lakukan satu per satu, catat pesan errornya, lalu kembalikan:

| # | Yang dirusak | Prediksi Anda sebelum mencoba | Pesan error sebenarnya |
|--|--------------|-------------------------------|------------------------|
| 1 | Ganti nama `.env` menjadi `.env.bak` | Laravel akan error karena `.env` tidak ditemukan |Muncul This site can’t be reached, dan refused to connect  |
| 2 | Kosongkan nilai `APP_KEY` di `.env` |Laravel masih berjalan, tetapi login akan error |Muncul `No application encryption key has been specified.`|
| 3 | Ubah `DB_DATABASE` menjadi nama yang tidak ada |Sistem akan error saat membutuhkan database|Muncul `Database file at path [laravel] does not exist.` |
| 4 | Ubah `APP_DEBUG=false`, lalu ulangi nomor 3 |Detail error akan disembunyikan | Muncul `500 Server Error` |

Nomor 4 adalah yang terpenting. Perhatikan bedanya: dengan `APP_DEBUG=true` Anda melihat seluruh isi konfigurasi dan jejak kode; dengan `false` Anda hanya melihat halaman 500 kosong. **Di server produksi nanti, `APP_DEBUG=true` berarti membocorkan kredensial database Anda kepada siapa pun yang memicu error.** Ini akan diuji di minggu 12.

### FIX — Perbaiki proyek yang cacat (30 menit)

Dosen menyediakan repo `kampuslms-broken`. Pindah ke branch `w01` — isinya proyek Laravel 12 yang tidak mau jalan. Ada **4 masalah**. Temukan dan perbaiki semuanya, lalu kirim Pull Request berisi penjelasan tiap perbaikan.

Petunjuk: masalahnya tersebar di berkas konfigurasi, dependensi, dan satu berkas yang seharusnya tidak ada di dalam repo.

### BUILD — Fondasi proyek kelompok (sisa waktu + tugas terstruktur)

1. Buat repo kelompok di dalam Organization mata kuliah. Nama: `kampuslms-kelompok-XX`.
2. Instal Laravel 12. Pastikan `php artisan serve` atau Herd berjalan.
3. Buat `README.md` berisi: nama proyek, daftar anggota + NIM, cara instalasi, dan tabel pembagian peran.
4. Pastikan `.env.example` lengkap dan `.env` **tidak** ter-commit. Verifikasi dengan `git status`.
5. Setiap anggota membuat minimal satu commit atas nama dan email masing-masing.
6. Aktifkan branch protection pada `main`.
7. Buat satu route baru `/tentang` yang menampilkan view berisi nama kelompok dan anggotanya.

---

## 1.4 Checkpoint Minggu 1

Jawab tanpa membuka catatan. Kalau ada yang tidak bisa dijawab, ulangi bagian READ.

- [ ] Sebutkan urutan berkas yang dilewati sebuah request dari browser sampai HTML kembali.
- [ ] Kenapa hanya folder `public/` yang boleh diakses dari internet? Apa yang terjadi kalau seluruh folder proyek diekspos?
- [ ] Apa beda `.env` dan `.env.example`, dan kenapa hanya satu yang di-commit?
- [ ] Di Laravel 12, di berkas mana middleware didaftarkan? Kenapa jawabannya berbeda dari kebanyakan tutorial di internet?
- [ ] Apa risiko konkret `APP_DEBUG=true` di server produksi?
- [ ] Tunjukkan di `git log` bahwa Anda punya commit atas nama Anda sendiri.
