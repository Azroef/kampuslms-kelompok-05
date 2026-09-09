**Nama : Melodiva Rosananda**  
**NIM : 10241041**

 
### READ — Bedah instalasi Anda sendiri (45 menit)

Setelah instalasi selesai dan halaman selamat datang Laravel muncul, kerjakan **tanpa AI**:

1. Buka `public/index.php`. Baca dari atas ke bawah. Tulis dalam 3 kalimat apa yang dilakukan berkas ini.
2. Buka `bootstrap/app.php`. Identifikasi bagian mana yang mengurus route, mana yang mengurus middleware, mana yang mengurus exception.
3. Buka `routes/web.php`. Temukan route yang menghasilkan halaman selamat datang. Ubah teksnya, muat ulang browser, pastikan berubah.
4. Jalankan `php artisan route:list`. Cocokkan keluarannya dengan isi `routes/web.php`.

## Jawaban  
1. `public/index.php` menjadi gerbang masuk dalam menerima http request dari browser. `Kemudian public/index.php` memanggil file autoloader.php yang berada di folder vendor untuk mengaktifkan fungsi composer. Kemudian http tersebut dikirimkan menuju `bootstrap/app.php`.  
2. Pada `bootstrap/app.php`, bagian yang mengurus route berada pada baris 7-12. Bagian yang mengurus middleware berada pada baris 13-15. Dan bagian yang mengurus exceptions berada pada baris 16-17. 
3. Pada `routes/web.php`, bagian yang menghasilkan halaman selamat datang yaitu pada baris 5-7. Fungsi tersebut mengembalikan nilai "welcome" ke fungsi view.
4. Pada laman routes/web/php, Get (/) mengambil route yang telah disediakan oleh laravel untuk mengatur alur pemrosesan dari index.php menuju middleware sampai ke web.php sehingga browser dapat menerima tampilan ataua output dari pemrosesan tersebut.