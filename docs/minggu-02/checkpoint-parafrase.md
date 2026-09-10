# Pemeriksaan Hasil Belajar Minggu Kedua - KampusLMS

**Kelompok 05** | Muchammad Maulana, Linggar Pramudya, Muhammad Daffa, Melodiva Rosananda

---

## 1. Risiko Keamanan Menghapus Resource via Method GET

### Deskripsi Masalah
HTTP GET dirancang sebagai method untuk memperoleh/membaca informasi, bukan untuk mengubah atau menghapus data. Penggunaan GET dalam operasi penghapusan membawa risiko keamanan yang serius karena:

**Alasan-alasan Risiko:**
- Alamat URL terlihat di address bar peramban
- Browser menyimpan riwayat URL yang dikunjungi
- User bisa tanpa sengaja membagikan URL yang berisiko
- Program otomatis/crawler bisa memicu aksi penghapusan tidak disengaja
- Serangan CSRF dapat dilakukan dengan lebih mudah

### Ilustrasi Kasus Nyata di Sistem KampusLMS

**Contoh Implementasi yang Risiko (GET untuk Delete):**
```
GET /mata-kuliah/1/delete
```

**Skenario Serangan Praktis:**
1. Penyerang mengirimkan email berisi tautan: `http://kampuslms.com/mata-kuliah/1/delete`
2. Email berisi kalimat menipu: *"Klik tautan ini untuk melihat daftar nilai akhir"*
3. Admin tanpa curiga mengklik link tersebut
4. **Hasilnya: Data mata kuliah bernama Pemrograman Web terhapus dari sistem!**

**Kode yang Tidak Aman:**
```php
// ❌ TIDAK DIREKOMENDASIKAN
Route::get('/mata-kuliah/{id}/delete', [CourseController::class, 'destroy']);
```

**Metode Implementasi yang Aman:**
```php
// ✅ CARA YANG BENAR
Route::post('/mata-kuliah/{id}/delete', [CourseController::class, 'destroy']);
Route::delete('/mata-kuliah/{id}', [CourseController::class, 'destroy']);
```

**Template Form yang Mengimplementasikan Keamanan:**
```blade
<form action="{{ route('mata-kuliah.destroy', $course->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Hapus Data</button>
</form>
```

**Penjelasan Mekanisme Keamanan:**
- `@csrf` - Menghasilkan token untuk mencegah serangan lintas situs
- `@method('DELETE')` - Mengubah method POST menjadi DELETE di level HTTP
- Pengiriman form menghasilkan permintaan POST, bukan GET biasa
- Penyerang tidak bisa memicu tindakan lewat URL sederhana

---

## 2. Dampak Urutan Route: Penempatan Generic vs Specific Pattern

### Konsep Dasar
Laravel menggunakan **First Match Routing** - rute pertama yang sesuai dengan pola URL akan dijalankan, route berikutnya tidak akan dipertimbangkan.

### Demonstrasi Masalah Urutan Tidak Tepat

**Implementasi Rute yang Bermasalah:**
```php
// routes/web.php
Route::get('/mata-kuliah/{id}', [CourseController::class, 'show'])->name('mata-kuliah.show');

Route::get('/mata-kuliah/create', [CourseController::class, 'create'])->name('mata-kuliah.create');
```

**Apa yang Terjadi?**
Ketika user mengakses `/mata-kuliah/create`:
1. Matcher rute memeriksa: `/mata-kuliah/{id}` - **COCOK!** (dianggap `{id} = "create"`)
2. Method `show()` dijalankan dengan parameter `id = "create"`
3. Sistem menampilkan error 404 - tidak ada mata kuliah dengan id bernama "create"
4. Rute `/mata-kuliah/create` yang seharusnya dijalankan **diabaikan**

**Konfigurasi Rute yang Benar di Project:**
```php
// ✅ URUTAN YANG TEPAT di web.php kami
Route::get('/mata-kuliah', [CourseController::class, 'index']) 
    ->name('mata-kuliah.index'); 

Route::get('/mata-kuliah/create', [CourseController::class, 'create']) 
    ->name('mata-kuliah.create'); 

// PERHATIAN: Rute dengan path spesifik (/create) HARUS SEBELUM rute umum (/{id})
Route::get('/mata-kuliah/{id}', [CourseController::class, 'show']) 
    ->name('mata-kuliah.show');
```

**Urutan Prioritas yang Tepat:**
```
1. Rute dengan path spesifik lebih dahulu (/mata-kuliah/create)
2. Rute dengan parameter generic di akhir (/mata-kuliah/{id})
3. ALASAN: Kalau dibalik, parameter {id} akan menangkap "create" lebih dulu
```

**Output Saat Cek Daftar Rute:**
```bash
php artisan route:list --path=mata-kuliah

+--------+------------------------+------------------------------------------+
| Method | URI                    | Name                                     |
+--------+------------------------+------------------------------------------+
| GET    | /mata-kuliah           | mata-kuliah.index                        |
| GET    | /mata-kuliah/{id}      | mata-kuliah.show                         |
+--------+------------------------+------------------------------------------+
```

---

## 3. Penggunaan Helper `route()` - Lokasi Implementasi dan Keuntungannya

### Demonstrasi Implementasi di Sistem KampusLMS

**Lokasi 1: Menu Navigasi Utama** (`resources/views/components/layout.blade.php`)
```blade
<a href="{{ route('dashboard') }}" 
   class="flex items-center gap-3...">
    <span class="material-symbols-outlined">dashboard</span>
    Dashboard
</a>

<a href="{{ route('mata-kuliah.index') }}" 
   class="flex items-center gap-3...">
    <span class="material-symbols-outlined">menu_book</span>
    Mata Kuliah
</a>

<a href="{{ route('tentang') }}" 
   class="flex items-center gap-3...">
    <span class="material-symbols-outlined">info</span>
    Tentang
</a>
```

**Lokasi 2: Tombol Aksi di Tabel** (`resources/views/courses/index.blade.php`)
```blade
<a href="{{ route('mata-kuliah.show', $course['id']) }}"
   class="inline-flex items-center px-4 py-2...">
    Lihat Detail
</a>
```

**Lokasi 3: Navigasi Riwayat** (`resources/views/courses/show.blade.php`)
```blade
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
```

### Analisis Perbandingan: Menggunakan `route()` vs Hardcode URL

| Kriteria | Menggunakan `route()` | Hardcode URL Manual |
|----------|----------------------|-------------------|
| **Pemeliharaan URL** | Modifikasi hanya di routes file | Perlu ubah di puluhan tempat |
| **Deteksi Error** | Laravel memberikan peringatan jika route tidak ada | Error terjadi diam-diam, link rusak |
| **Manajemen Parameter** | Otomatis menghasilkan URL dengan parameter yang tepat | Penggabungan string manual, mudah salah ketik |
| **Proses Refactoring** | Aman dan efisien | Risiko tinggi, mudah ada yang terlewat |

### Ilustrasi Masalah dengan Hardcode

**Contoh Kode yang Tidak Baik:**
```blade
<!-- Jika pola URL berubah, semua link harus diubah manual -->
<a href="/mata-kuliah/{{ $course['id'] }}">Lihat Detail</a>
<a href="/mata-kuliah">Kembali</a>
<a href="/dashboard">Halaman Utama</a>
<!-- Kesalahan pengetikan bisa terjadi tanpa terdeteksi -->
<a href="/mata-kkuliah">❌ Terputus!</a>
```

**Contoh Kode yang Baik:**
```blade
<!-- Jika pola URL berubah di routes, semua link otomatis update -->
<a href="{{ route('mata-kuliah.show', $course['id']) }}">Lihat Detail</a>
<a href="{{ route('mata-kuliah.index') }}">Kembali</a>
<a href="{{ route('dashboard') }}">Halaman Utama</a>
<!-- Laravel langsung error jika nama route tidak sesuai -->
<a href="{{ route('tidak-ada') }}">❌ Route [tidak-ada] not defined</a>
```

**Keuntungan Utama Menggunakan `route()`:**
1. **Prinsip DRY** - Tentukan sekali, gunakan di mana saja
2. **Validasi Tipe** - Laravel melakukan verifikasi route ada atau tidak
3. **Fleksibilitas URL** - Pola URL bisa berubah tanpa update setiap link
4. **Efisiensi Kode** - Satu lokasi untuk perubahan semua alamat URL

---

## 4. Perbandingan Syntax Template: `{{ }}` dan `{!! !!}` serta Demonstrasi XSS

### Penjelasan Perbedaan

| Notasi | Fungsi | Level Keamanan |
|--------|--------|-----------------|
| `{{ }}` | **Escape & Sanitasi HTML** - Mengonversi `<`, `>`, dll menjadi entity HTML | ✅ AMAN |
| `{!! !!}` | **Output Langsung Tanpa Filter** - Menampilkan apa adanya tanpa sanitasi | ❌ RENTAN |

### Percobaan Praktis XSS di Sistem Kami

**Persiapan: Input yang Berbahaya**
```php
// Di controller atau dari form
$inputUser = '<script>alert("Sistem Terganggu!");</script>';
$namaDosenRisiko = '<img src=x onerror="alert(\'XSS Ditemukan\')">';
```

**Skenario 1: TIDAK AMAN - Menggunakan `{!! !!}`**

Di `courses/show.blade.php`:
```blade
<p>Nama Pengajar: {!! $namaDosenRisiko !!}</p>
```

**Hasil Render di Browser:**
```html
<p>Nama Pengajar: <img src=x onerror="alert('XSS Ditemukan')"></p>
```

**Dampak:** Kode JavaScript dieksekusi! Popup alert muncul - **Celah Keamanan Terbuka!** ❌

**Skenario 2: AMAN - Menggunakan `{{ }}`**

Di `courses/show.blade.php`:
```blade
<p>Nama Pengajar: {{ $namaDosenRisiko }}</p>
```

**Hasil Render di Browser:**
```html
<p>Nama Pengajar: &lt;img src=x onerror="alert(&#039;XSS Ditemukan&#039;)"&gt;</p>
```

**Dampak:** Ditampilkan hanya sebagai teks normal, script tidak dijalankan - **AMAN!** ✅

### Kapan Boleh Menggunakan `{!! !!}`?

Hanya gunakan ketika konten **sudah pasti aman dan terpercaya** (bukan dari input user):

**Penggunaan yang Diterima dengan `{!! !!}`:**
```blade
<!-- Dari database internal yang sudah validated -->
{!! $course->description !!}

<!-- Dari berkas lokal yang dikontrol sendiri -->
{!! file_get_contents('panduan.html') !!}

<!-- Dari pustaka pihak ketiga yang terpercaya -->
{!! Markdown::parse($content) !!}
```

**Penggunaan yang DILARANG dengan `{!! !!}`:**
```blade
<!-- Data dari form user -->
{!! $request->get('nama') !!}

<!-- Parameter dari URL -->
{!! $request->query('pencarian') !!}

<!-- Dari API eksternal tanpa verifikasi -->
{!! $externalAPI->getContent() !!}
```

---

## 5. Peran `@vite` - Perbedaan Mode Development vs Production

### Fungsi Utama `@vite`

`@vite()` adalah instruksi Blade yang:
1. **Mode Pengembangan** - Menambahkan live reload, peta sumber kode, aset tidak dikompres
2. **Mode Produksi** - Memuat aset yang sudah dikompres dan dioptimasi dari folder `/public/build/`

### Tempat Penggunaan di Project

**Berkas Layout Utama** (`resources/views/components/layout.blade.php`):
```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EduKampus' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    ...
</head>
```

### Penjelasan Perbedaan: `npm run dev` vs `npm run build`

#### Mode `npm run dev` - Untuk Pengembangan

**Command Eksekusi:**
```bash
npm run dev
```

**Proses yang Terjadi:**
```
✅ Aset TIDAK dikompres (mudah dibaca saat debugging)
✅ Peta kode sumber tersedia (facilitate pengalaman debug)
✅ Live reload diaktifkan (update otomatis saat file berubah)
✅ Ukuran file lebih besar (~500KB+ untuk CSS/JS)
✅ Proses terus berjalan - monitoring perubahan file
✅ Aset disimpan di memory, bukan folder public/build
```

**Tujuan Penggunaan:** Fase development dan testing aplikasi

**Terminal Harus Tetap Aktif:**
```bash
# Terminal 1 - npm dev (biarkan running)
npm run dev
# Output:
# VITE v5.0.0  ready in 234 ms
# ➜  Local:   http://localhost:5173/
# ➜  press h to show help

# Terminal 2 - Laravel dev server
php artisan serve
# Setiap kali file tersimpan, browser akan refresh secara otomatis!
```

#### Mode `npm run build` - Untuk Distribusi Produksi

**Command Eksekusi:**
```bash
npm run build
```

**Proses yang Terjadi:**
```
✅ Aset dikompres minimal (kurangi ukuran 30-50%)
✅ Penghapusan kode yang tidak digunakan (tree shaking)
✅ Gabung & optimasi CSS/JS
✅ Output disimpan di folder public/build/ dengan nama hash unik
✅ Pembuatan manifest.json untuk pemetaan aset
✅ Peta sumber kode opsional (untuk analisis produksi)
```

**Tujuan Penggunaan:** Deployment ke server produksi/live

**Output yang Dihasilkan:**
```
vite v5.0.0 building for production...
✓ 42 modules transformed.
dist/index.html                   0.46 kB │ gzip:  0.32 kB
dist/assets/index-C3iwMIly.js   126.00 kB │ gzip: 41.29 kB
dist/assets/index-xEsJRC0Z.css  352.00 kB │ gzip: 43.12 kB

✓ build complete in 2.81s
```

**Struktur Folder yang Dibuat:**
```
public/build/
├── manifest.json (petaan nama aset)
├── assets/
│   ├── app-a1b2c3d4.css (nama dengan hash)
│   ├── app-e5f6g7h8.js (nama dengan hash)
│   └── bootstrap-i9j0k1l2.js
└── .htaccess
```

### Tabel Ringkas Perbedaan

| Aspek | `npm run dev` | `npm run build` |
|-------|---------------|-----------------|
| **Ukuran Output** | 500KB+ (tanpa kompres) | 50-100KB (terkompresi) |
| **Kecepatan Build** | Cepat, slow di browser | Slow build, fast di browser |
| **Pengalaman Debug** | Mudah dengan peta sumber | Sulit, kode terkompresi |
| **Auto Reload** | ✅ Ada | ❌ Tidak ada |
| **Konteks Penggunaan** | Development/testing | Production/live |
| **Saat Dijalankan** | `npm run dev` aktif | Setelah `npm run build` |

### Troubleshooting Error Manifest

**Error yang Muncul Jika Tidak Di-build:**
```
Vite manifest not found at: 
/public/build/manifest.json
```

**Solusi Penyelesaian:**
```bash
# Jika untuk produksi
npm run build

# Jika masih development
npm run dev
# Biarkan berjalan, kemudian terminal lain jalankan:
php artisan serve
```

---

## 6. Keamanan Data Input dari Pengguna: Mengapa Tidak Boleh Dipercaya

### Konsep Dasar Keamanan Input

Data yang berasal dari `$_POST`, `$_GET`, `$_FILES`, dan header HTTP adalah **eksternal input** yang bisa dimodifikasi oleh pihak yang tidak bertanggung jawab. Tidak ada jaminan data valid atau aman digunakan secara langsung.

### Studi Kasus di Sistem KampusLMS

**Contoh Attack Pertama: Manipulasi Nilai Form**

**Form Awal yang Ditampilkan:**
```html
<form action="/mata-kuliah" method="POST">
    <input type="text" name="name" maxlength="50">
    <input type="number" name="sks" min="1" max="4">
    <button type="submit">Tambah</button>
</form>
```

**Teknik Manipulasi Menggunakan Developer Tools:**
```javascript
// Di Console Browser
// Menghilangkan batasan panjang teks
document.querySelector('input[name="sks"]').max = '999';
document.querySelector('input[name="name"]').maxlength = '99999';

// Atau alternatif: submit dengan command line curl
curl -X POST http://localhost:8000/mata-kuliah \
  -d "name=<script>alert('Rusak')</script>" \
  -d "sks=99999"
```

**Tipe Serangan yang Memungkinkan:**
```
✗ Masukkan nilai SKS melampaui batas (99999 atau nilai negatif)
✗ Sisipkan perintah JavaScript berbahaya di field nama
✗ Eksekusi SQL injection melalui kolom deskripsi
✗ Melewati mekanisme validasi sisi klien (client-side)
✗ Manipulasi hidden fields yang seharusnya tidak berubah
✗ Upload berkas berbahaya atau terinfeksi
```

### Implementasi Keamanan di Kode Aplikasi

**Implementasi BURUK - Mempercayai Input Tanpa Kontrol:**
```php
// routes/web.php
Route::post('/mata-kuliah', function (Request $request) {
    // Langsung mengambil dan mempercayai data input!
    $name = $request->get('name'); // ❌ SANGAT RISIKO
    $sks = $request->get('sks');   // ❌ SANGAT RISIKO
    
    // Langsung menyimpan ke database tanpa pemeriksaan
    Course::create([
        'name' => $name,
        'sks' => $sks,
    ]);
    
    return "Mata kuliah berhasil ditambah";
});
```

**Masalah yang Terjadi:**
- XSS attack melalui field nama
- SKS bisa bernilai negatif atau sangat besar
- Celah SQL Injection tersedia terbuka
- Upload malware bisa terjadi

**Implementasi BAIK - Validasi Sebelum Menggunakan:**
```php
// app/Http/Controllers/CourseController.php
public function store(Request $request)
{
    // 1. LANGKAH VALIDASI DATA INPUT
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'sks' => 'required|integer|min:1|max:6',
        'semester' => 'required|integer|min:1|max:8',
        'dosen' => 'required|string|max:150',
        'description' => 'nullable|string|max:1000',
    ]);
    
    // 2. LANGKAH SANITASI DATA (jika diperlukan)
    $validated['name'] = strip_tags($validated['name']);
    $validated['description'] = Str::limit($validated['description'], 1000);
    
    // 3. BARU SIMPAN KE DATABASE
    Course::create($validated);
    
    return redirect()->route('mata-kuliah.index')
                    ->with('success', 'Mata kuliah berhasil ditambah');
}
```

**Penjelasan Aturan Validasi:**
```php
'name' => 'required|string|max:100'
// ├─ required: Field harus diisi
// ├─ string: Harus bertipe text
// └─ max:100: Maksimal 100 karakter

'sks' => 'required|integer|min:1|max:6'
// ├─ required: Field harus diisi
// ├─ integer: Harus angka bulat
// ├─ min:1: Nilai minimum 1 SKS
// └─ max:6: Nilai maksimum 6 SKS

'description' => 'nullable|string|max:1000'
// ├─ nullable: Boleh dikosongkan
// ├─ string: Kalau ada, harus text
// └─ max:1000: Maksimal 1000 karakter
```

### Tabel Serangan yang Dapat Dicegah

| Jenis Serangan | Pencegahan dengan Validasi |
|----------------|---------------------------|
| XSS (`<script>alert('hack')</script>`) | `string` + `strip_tags()` |
| SQL Injection | Query builder Laravel dengan parameter binding |
| Nilai negatif (-5) | `min:1` validation rule |
| Nilai terlalu besar (999) | `max:6` validation rule |
| Upload berkas berbahaya | File validation rules |
| Serangan CSRF | `@csrf` token di form |

### Praktik Terbaik Keamanan Input

```php
// ✅ APPROACH: Whitelist (Tentukan apa yang BOLEH)
$validated = $request->validate([
    'email' => 'required|email',
    'age' => 'required|integer|between:18,100',
    'file' => 'required|file|mimes:pdf,doc|max:5120',
]);

// ❌ JANGAN: Blacklist (Tentukan apa yang TIDAK BOLEH)
// - Tidak mungkin mencakup semua kemungkinan serangan
// - Penyerang selalu menemukan cara baru

// ✅ APPROACH: Escape saat output
{{ $name }}  // ✅ Otomatis escape HTML
{!! $name !!} // ❌ Gunakan hanya untuk konten terpercaya

// ✅ APPROACH: Gunakan fitur keamanan Laravel
@csrf          // Token CSRF protection
@method('DELETE')  // Method spoofing
$request->validate()  // Input validation
$bcrypt()      // Password hashing
```

---

## Ringkasan Poin-Poin Utama

| Topik | Poin Kunci |
|-------|-----------|
| **DELETE via GET** | Gunakan POST/DELETE, wajib ada CSRF token |
| **Urutan Route** | Path spesifik dulu, generic terakhir, /create sebelum /{id} |
| **route() Helper** | Tentukan sekali, pakai di mana saja, mudah maintenance |
| **{{ }} vs {!! !!}** | Escape HTML default, raw hanya konten terpercaya |
| **@vite & npm** | Dev: unminified + hot reload, Build: minified + optimized |
| **Validasi Input** | Selalu validasi & sanitasi, jangan pernah percaya user input |

---

## Referensi Pembelajaran

- [Dokumentasi Laravel Routing](https://laravel.com/docs/routing)
- [Panduan Validasi Laravel](https://laravel.com/docs/validation)
- [Keamanan Laravel - CSRF Protection](https://laravel.com/docs/csrf)
- [Vite - Frontend Build Tool](https://vitejs.dev/)
- [OWASP Resources - XSS Prevention](https://owasp.org/www-community/attacks/xss/)
