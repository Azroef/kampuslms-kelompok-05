### READ — Telusuri satu request penuh (30 menit)

Ambil route `/tentang` yang Anda buat minggu lalu. Tanpa AI, tulis di catatan Anda:

1. Baris mana di `routes/web.php` yang menangkapnya?
2. Kalau ditangani controller, berkas dan method mana?
3. View mana yang dikembalikan? Di path apa persisnya?
4. Layout apa yang membungkusnya?
5. Jalankan `php artisan route:list --path=tentang`. Cocok dengan analisis Anda?

Jawaban

1. Ada di baris:
```php
Route::get('/tentang', function () { 
    return view('tentang'); 
})->name('tentang');
```
2. Saat ini rute `/tentang` langsung ditangani di route. Jika dialihkan ke controller, perlu dibuat berkas class controller baru di dalam folder `controller` beserta method pemanggilnya.

3. View yang dikembalikan yaitu `tentang.blade.php` yang berada di `resources/views/tentang.blade.php`

4. Awalnya masih berbentuk HTML polos, tidak ada layout, setelah dirapikan jadi dibungkus `<x-layout>` yang ada di `resources/views/components/layout.blade.php`

5. 