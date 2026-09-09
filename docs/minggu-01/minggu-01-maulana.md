## Catatan Minggu 1 Pemrograman Web

### READ

#### 1. Buka public/index.php. Baca dari atas ke bawah. Tulis dalam 3 kalimat apa yang dilakukan berkas ini.
Jawaban : <br>
`index.php` berfungsi sebagai pintu masuk utama (entry point) bagi semua request yang dikirim browser ke aplikasi Laravel. Berkas ini lebih dulu memeriksa apakah aplikasi sedang berada dalam mode _maintenance_, kemudian memuat seluruh komponen Laravel dan membangun instance aplikasinya melalui `bootstrap/app.php`. Setelah itu, request yang diterima diteruskan ke dalam siklus pemrosesan Laravel, dan response yang dihasilkan dikembalikan ke browser pengguna.

#### 2. Buka `bootstrap/app.php`. Identifikasi bagian mana yang mengurus route, mana yang mengurus middleware, mana yang mengurus exception.
Jawaban : <br>
Pengaturan route berada pada method `withRouting()`, yang berfungsi menunjuk lokasi berkas-berkas route aplikasi (contohnya `routes/web.php` untuk jalur web dan `routes/console.php` untuk perintah artisan).
```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```
Pengaturan middleware terdapat pada method `withMiddleware()`, yang dipakai untuk mendaftarkan middleware — yaitu lapisan penyaring yang memproses request sebelum atau sesudah mencapai controller.
```php
->withMiddleware(function (Middleware $middleware) {
    //
})
```
Pengaturan exception berada pada method `withExceptions()`, yang mengatur bagaimana aplikasi menangani kesalahan (error) yang terjadi.
```php
   ->withExceptions(function (Exceptions $exceptions) {
       //
   })
```

#### 3. Buka `routes/web.php`. Temukan route yang menghasilkan halaman selamat datang. Ubah teksnya, muat ulang browser, pastikan berubah.
Jawaban : <br>
Di dalam folder `routes` terdapat berkas `web.php` yang menentukan alur navigasi ketika pengguna mengakses situs. Saat halaman utama dibuka, sistem mengarahkan pengguna ke tampilan Welcome yang didefinisikan pada `welcome.blade.php` di folder `views`. Perubahan teks saya lakukan langsung pada berkas `welcome.blade.php`, dan setelah browser di-refresh, tampilan langsung menampilkan hasil editannya.

Sebelum di edit :
![alt text](image-1.png)
Sesudah di edit :
![alt text](image.png)
#### 4. Jalankan `php artisan route:list`. Cocokkan keluarannya dengan isi `routes/web.php`.
Jawaban : <br>
Berikut hasil dari perintah `php artisan route:list`,<br>
![alt text](image-2.png))<br>
dan hasil tersebut sesuai dengan isi `routes/web.php`, yang memang hanya memuat satu route saja:
```php
Route::get('/', function () {
    return view('welcome');
});
```

### BREAK
#### Lakukan satu per satu, catat pesan errornya, lalu kembalikan:

| # | Yang dirusak | Prediksi Anda sebelum mencoba | Pesan error sebenarnya |
|---|--------------|-------------------------------|------------------------|
| 1 | Ganti nama `.env` menjadi `.env.bak` | Akan muncul error total karena sistem tidak dapat menemukan berkas bernama persis `.env` |![alt text](photos/ikhsyan_break.1.png) |
| 2 | Kosongkan nilai `APP_KEY` di `.env` | Tampilan aplikasi akan error dan kemungkinan data-data sensitif aplikasi ikut terekspos |![alt text](photos/ikhsyan_break.2.png) |
| 3 | Ubah `DB_DATABASE` menjadi nama yang tidak ada | Aplikasi gagal terhubung ke database dan memunculkan error karena database yang dituju tidak tersedia |![alt text](photos/ikhsyan_break.3.png) |
| 4 | Ubah `APP_DEBUG=false`, lalu ulangi nomor 3 | Pesan error tidak lagi ditampilkan pada halaman aplikasi |![alt text](photos/ikhsyan_break.4.png) |

Jadi, untuk menyembunyikan detail error dari tampilan, pengaturan `APP_DEBUG` memang harus diset ke `false`?