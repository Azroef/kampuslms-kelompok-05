# Checkpoint Minggu 2 - KampusLMS

**Kelompok 05** | Muchammad Maulana, Linggar Pramudya, Muhammad Daffa, Melodiva Rosananda

---

## 1. Kenapa Menghapus Data Lewat `GET` Berbahaya?

### Penjelasan
HTTP `GET` adalah method yang dirancang untuk **mengambil/membaca data**, BUKAN memodifikasi. Menggunakan GET untuk menghapus data sangat berbahaya karena:

**Alasan Bahaya:**
- URL GET terlihat di address bar browser
- Browser menyimpan history URL
- User bisa accidentally share URL yang menghapus data
- Bot/crawler bisa trigger penghapusan data
- CSRF attack lebih mudah dilakukan

### Skenario Konkret di KampusLMS

**❌ BERBAHAYA (GET untuk delete):**
```
GET /mata-kuliah/1/delete
```

**Skenario Attack:**
1. Admin membuka email dengan link: `http://kampuslms.com/mata-kuliah/1/delete`
2. Email berisi: *"Klik disini untuk lihat hasil UAS"*
3. **Tanpa disadari, data mata kuliah Pemrograman Web terhapus!**

**Bukti Bahaya:**
```php
// ❌ JANGAN - Sangat Berbahaya!
Route::get('/mata-kuliah/{id}/delete', [CourseController::class, 'destroy']);
```

**✅ AMAN (POST untuk delete):**
```php
// ✅ BENAR - Gunakan POST atau DELETE
Route::post('/mata-kuliah/{id}/delete', [CourseController::class, 'destroy']);
Route::delete('/mata-kuliah/{id}', [CourseController::class, 'destroy']);
```

**Form yang Benar:**
```blade
<form action="{{ route('mata-kuliah.destroy', $course->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Hapus</button>
</form>
```

**Penjelasan:**
- `@csrf` - Token CSRF mencegah serangan dari domain lain
- `@method('DELETE')` - Override POST ke DELETE method
- Form submission menghasilkan POST request, bukan GET
- Attacker tidak bisa trigger lewat URL biasa

---

## 2. Apa Terjadi Kalau `/courses/{course}` Ditulis Sebelum `/courses/create`?

### Penjelasan
Laravel menggunakan **First Match Routing** - route pertama yang cocok akan dieksekusi, route berikutnya diabaikan.

### Demonstrasi Error

**❌ SALAH - Route yang tidak benar:**
```php
// routes/web.php
Route::get('/mata-kuliah/{id}', [CourseController::class, 'show'])->name('mata-kuliah.show');

Route::get('/mata-kuliah/create', [CourseController::class, 'create'])->name('mata-kuliah.create');
```

**Apa terjadi?**
Ketika user akses `/mata-kuliah/create`:
1. Route matcher cek: `/mata-kuliah/{id}` - **MATCH!** (dianggap `{id} = "create"`)
2. Jalankan `show()` dengan parameter `id = "create"`
3. Error 404 - tidak ada mata kuliah dengan id "create"
4. Route `/mata-kuliah/create` **tidak pernah dieksekusi**

**Bukti di Project:**
```php
// ✅ BENAR - Kode di web.php kita
Route::get('/mata-kuliah', [CourseController::class, 'index']) 
    ->name('mata-kuliah.index'); 

Route::get('/mata-kuliah/create', [CourseController::class, 'create']) 
    ->name('mata-kuliah.create'); 

// PENTING: Specific route (/create) HARUS SEBELUM generic route (/{id})
Route::get('/mata-kuliah/{id}', [CourseController::class, 'show']) 
    ->name('mata-kuliah.show');
```

**Urutan Yang Benar:**
```
1. Route paling specific terlebih dahulu (/mata-kuliah/create)
2. Route generic di akhir (/mata-kuliah/{id})
3. ALASAN: Jika dibalik, {id} akan match "create" terlebih dahulu
```

**Test Output:**
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

## 3. Tempat Menggunakan `route()` - Keuntungan vs Hardcode

### Demonstrasi di Kode KampusLMS

**Lokasi 1: Navigation di Layout** (`resources/views/components/layout.blade.php`)
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

**Lokasi 2: Tabel List Mata Kuliah** (`resources/views/courses/index.blade.php`)
```blade
<a href="{{ route('mata-kuliah.show', $course['id']) }}"
   class="inline-flex items-center px-4 py-2...">
    Lihat Detail
</a>
```

**Lokasi 3: Breadcrumb di Detail** (`resources/views/courses/show.blade.php`)
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

### Perbandingan: `route()` vs Hardcode

| Aspek | `route()` | Hardcode |
|-------|-----------|----------|
| **URL Maintenance** | Ubah di routes saja | Ubah di puluhan tempat |
| **Error Detection** | Laravel peringatkan jika route tidak ada | Silent error, link broken |
| **Parameter Handling** | Otomatis generate URL dengan parameter | Manual gabung string, rawan typo |
| **Refactor** | Aman dan mudah | Risiko tinggi, mudah terlupakan |

### Contoh Masalah Hardcode

**❌ BURUK:**
```blade
<!-- Jika route berubah, semua hardcode harus diubah -->
<a href="/mata-kuliah/{{ $course['id'] }}">Lihat Detail</a>
<a href="/mata-kuliah">Kembali</a>
<a href="/dashboard">Home</a>
<!-- Jika ada typo, link silent broken -->
<a href="/mata-kkuliah">❌ Broken!</a>
```

**✅ BAIK:**
```blade
<!-- Route berubah? Cukup ubah di routes/web.php -->
<a href="{{ route('mata-kuliah.show', $course['id']) }}">Lihat Detail</a>
<a href="{{ route('mata-kuliah.index') }}">Kembali</a>
<a href="{{ route('dashboard') }}">Home</a>
<!-- Laravel langsung error jika route tidak ada -->
<a href="{{ route('tidak-ada') }}">❌ Route [tidak-ada] not defined</a>
```

**Keuntungan Utama:**
1. **DRY Principle** - Define once, use everywhere
2. **Type Safety** - Laravel validate route exists
3. **SEO Friendly** - URL bisa berubah tanpa update links
4. **Maintenance** - 1 tempat untuk perubahan semua URL

---

## 4. Perbedaan `{{ }}` dan `{!! !!}` - Demonstrasi XSS

### Penjelasan

| Syntax | Fungsi | Keamanan |
|--------|--------|----------|
| `{{ }}` | **Escape HTML** - Konversi `<`, `>`, dll ke HTML entities | ✅ AMAN |
| `{!! !!}` | **Render raw** - Langsung output tanpa escape | ❌ RISIKO XSS |

### Demonstrasi XSS di Project

**Setup: Input Berbahaya**
```php
// Di CourseController atau Form
$userInput = '<script>alert("Hacked!");</script>';
$dosen = '<img src=x onerror="alert(\'XSS\')">';
```

**❌ BAHAYA - Menggunakan `{!! !!}`**

Di `courses/show.blade.php`:
```blade
<p>Nama Dosen: {!! $dosen !!}</p>
```

**Output di Browser:**
```html
<p>Nama Dosen: <img src=x onerror="alert('XSS')"></p>
```

**Hasilnya:** Script execute! Alert popup muncul - **XSS Vulnerability!** ❌

**✅ AMAN - Menggunakan `{{ }}`**

Di `courses/show.blade.php`:
```blade
<p>Nama Dosen: {{ $dosen }}</p>
```

**Output di Browser:**
```html
<p>Nama Dosen: &lt;img src=x onerror="alert(&#039;XSS&#039;)"&gt;</p>
```

**Hasilnya:** Ditampilkan sebagai text biasa, script tidak execute - **AMAN!** ✅

### Kapan Pakai `{!! !!}`?

Hanya ketika output sudah **dipercaya 100%** (bukan dari user input):

**✅ Boleh `{!! !!}`:**
```blade
<!-- Dari database yang sudah validated -->
{!! $course->description !!}

<!-- Dari file yang sudah kontrol sendiri -->
{!! file_get_contents('terms.html') !!}

<!-- Dari library trusted -->
{!! Markdown::parse($content) !!}
```

**❌ JANGAN `{!! !!}`:**
```blade
<!-- Dari form user -->
{!! $request->get('name') !!}

<!-- Dari URL parameter -->
{!! $request->query('search') !!}

<!-- Dari external API tanpa sanitasi -->
{!! $externalAPI->getContent() !!}
```

---

## 5. Fungsi `@vite` - Perbedaan `npm run dev` vs `npm run build`

### Apa itu `@vite`?

`@vite()` adalah Blade directive yang:
1. **Development mode** - Inject hot reload, source maps, unminified assets
2. **Production mode** - Load minified, optimized assets dari `/public/build/`

### Lokasi di Kode

**Layout (`resources/views/components/layout.blade.php`):**
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

### Perbedaan: `npm run dev` vs `npm run build`

#### `npm run dev` - Development Mode

**Command:**
```bash
npm run dev
```

**Apa yang terjadi:**
```
✅ File TIDAK di-minify (mudah dibaca)
✅ Source maps tersedia (debugging lebih mudah)
✅ Hot reload aktif (refresh otomatis saat file berubah)
✅ File berukuran lebih besar (~500KB+ CSS/JS)
✅ Process tetap running - watch file changes
✅ Output ke dalam-memory, bukan folder public/build
```

**Kegunaan:** Development dan testing

**Terminal harus tetap berjalan:**
```bash
# Terminal 1 - npm dev (tetap running)
npm run dev
# Output:
# VITE v5.0.0  ready in 234 ms
# ➜  Local:   http://localhost:5173/
# ➜  press h to show help

# Terminal 2 - Laravel server
php artisan serve
# Setiap kali save file, browser auto-refresh!
```

#### `npm run build` - Production Mode

**Command:**
```bash
npm run build
```

**Apa yang terjadi:**
```
✅ File di-minify (30-50% lebih kecil)
✅ Dead code elimination (tree shaking)
✅ CSS/JS di-combine & optimize
✅ Output ke folder public/build/ dengan hash
✅ Buat manifest.json untuk asset mapping
✅ Source maps optional (untuk debugging production)
```

**Kegunaan:** Deploy ke production

**Output:**
```
vite v5.0.0 building for production...
✓ 42 modules transformed.
dist/index.html                   0.46 kB │ gzip:  0.32 kB
dist/assets/index-C3iwMIly.js   126.00 kB │ gzip: 41.29 kB
dist/assets/index-xEsJRC0Z.css  352.00 kB │ gzip: 43.12 kB

✓ build complete in 2.81s
```

**File yang dibuat:**
```
public/build/
├── manifest.json (mapping asset names)
├── assets/
│   ├── app-a1b2c3d4.css (hashed filename)
│   ├── app-e5f6g7h8.js (hashed filename)
│   └── bootstrap-i9j0k1l2.js
└── .htaccess
```

### Tabel Perbandingan

| Aspek | `npm run dev` | `npm run build` |
|-------|---------------|-----------------|
| **File Size** | 500KB+ (unminified) | 50-100KB (minified) |
| **Speed** | Cepat build, slow browser | Slow build, fast browser |
| **Debugging** | Mudah, source maps | Harder, minified code |
| **Hot Reload** | ✅ Ya | ❌ Tidak |
| **Untuk** | Development | Production |
| **Saat digunakan** | `npm run dev` running | After `npm run build` |

### Demo Error Jika Tidak Run Vite

**Error yang terjadi sebelum build:**
```
Vite manifest not found at: 
/public/build/manifest.json
```

**Solusi:**
```bash
# Jika sudah di-production
npm run build

# Jika masih development
npm run dev
# Biarkan running di background, lalu di terminal lain:
php artisan serve
```

---

## 6. Mengapa Data dari `Request` Tidak Boleh Dipercaya?

### Penjelasan

Data dari `$_POST`, `$_GET`, `$_FILES`, headers adalah **external input** yang bisa dimanipulasi attacker. Tidak ada jaminan data valid atau aman.

### Skenario Konkret di KampusLMS

**Contoh Attack 1: Manipulasi Form**

**Form Original:**
```html
<form action="/mata-kuliah" method="POST">
    <input type="text" name="name" maxlength="50">
    <input type="number" name="sks" min="1" max="4">
    <button type="submit">Tambah</button>
</form>
```

**Attack dengan Browser DevTools:**
```javascript
// Di Console Browser
// Menghapus validation
document.querySelector('input[name="sks"]').max = '999';
document.querySelector('input[name="name"]').maxlength = '99999';

// Atau submit dengan curl
curl -X POST http://localhost:8000/mata-kuliah \
  -d "name=<script>alert('XSS')</script>" \
  -d "sks=99999"
```

**Attacker bisa:**
```
✗ Insert SKS > batas (99999 atau -1)
✗ Insert script malicious di name field
✗ Insert SQL injection di description
✗ Bypass client-side validation
✗ Manipulasi hidden fields
✗ Fake file uploads
```

### Implementasi Validasi di Kode

**❌ BURUK - Percaya langsung:**
```php
// routes/web.php
Route::post('/mata-kuliah', function (Request $request) {
    // Langsung percaya input!
    $name = $request->get('name'); // ❌ BAHAYA
    $sks = $request->get('sks');   // ❌ BAHAYA
    
    // Simpan langsung ke DB
    Course::create([
        'name' => $name,
        'sks' => $sks,
    ]);
    
    return "Mata kuliah berhasil ditambah";
});
```

**Masalah:**
- XSS via name field
- SKS bisa negative, > 100
- SQL Injection possible
- File upload malware

**✅ BAIK - Validasi terlebih dahulu:**
```php
// app/Http/Controllers/CourseController.php
public function store(Request $request)
{
    // 1. VALIDASI INPUT
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'sks' => 'required|integer|min:1|max:6',
        'semester' => 'required|integer|min:1|max:8',
        'dosen' => 'required|string|max:150',
        'description' => 'nullable|string|max:1000',
    ]);
    
    // 2. SANITASI (jika perlu)
    $validated['name'] = strip_tags($validated['name']);
    $validated['description'] = Str::limit($validated['description'], 1000);
    
    // 3. BARU SIMPAN
    Course::create($validated);
    
    return redirect()->route('mata-kuliah.index')
                    ->with('success', 'Mata kuliah berhasil ditambah');
}
```

**Penjelasan Validasi:**
```php
'name' => 'required|string|max:100'
// ├─ required: Harus ada
// ├─ string: Tipe data string
// └─ max:100: Maksimal 100 karakter

'sks' => 'required|integer|min:1|max:6'
// ├─ required: Harus ada
// ├─ integer: Harus angka bulat
// ├─ min:1: Minimal 1 SKS
// └─ max:6: Maksimal 6 SKS

'description' => 'nullable|string|max:1000'
// ├─ nullable: Boleh kosong
// ├─ string: Kalau ada, harus string
// └─ max:1000: Maksimal 1000 karakter
```

### Serangan yang Dicegah

| Attack | Dicegah oleh |
|--------|-------------|
| XSS (`<script>alert('hack')</script>`) | `string` + `strip_tags()` |
| SQL Injection | Laravel query builder (parameter binding) |
| Negative SKS (-5) | `min:1` validation |
| Oversized SKS (999) | `max:6` validation |
| File upload malware | File validation rules |
| CSRF | `@csrf` token di form |

### Best Practices

```php
// ✅ RULE: Whitelist (Define apa yang boleh)
$validated = $request->validate([
    'email' => 'required|email',
    'age' => 'required|integer|between:18,100',
    'file' => 'required|file|mimes:pdf,doc|max:5120',
]);

// ❌ JANGAN: Blacklist (Define apa yang tidak boleh)
// - Impossible to cover semua attack vectors
// - Attacker selalu punya cara baru

// ✅ RULE: Escape output
{{ $name }}  // ✅ Automatic escape
{!! $name !!} // ❌ Only untuk trusted content

// ✅ RULE: Use Laravel Security Features
@csrf          // CSRF token
@method('DELETE')  // Method spoofing
$request->validate()  // Input validation
$bcrypt()      // Password hashing
```

---

## Summary - Key Takeaways

| Topik | Poin Penting |
|-------|-------------|
| **GET Delete** | Gunakan POST/DELETE, CSRF token wajib |
| **Route Order** | Specific sebelum generic, `/create` sebelum `/{id}` |
| **`route()`** | Define once, use everywhere, maintainable |
| **`{{ }}` vs `{!! !!}`** | Default escape, raw only untuk trusted content |
| **`@vite`** | Dev mode hot reload, build mode minified/optimized |
| **Request Data** | Always validate & sanitize before use |

---

## Referensi

- [Laravel Routes Documentation](https://laravel.com/docs/routing)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Laravel Security - CSRF](https://laravel.com/docs/csrf)
- [Vite Documentation](https://vitejs.dev/)
- [OWASP Top 10 - XSS Prevention](https://owasp.org/www-community/attacks/xss/)
