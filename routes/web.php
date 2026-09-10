<!-- route original
<?php 
use App\Http\Controllers\CourseController; 
use Illuminate\Support\Facades\Route; 

Route::get('/', function () { 
    return view('welcome'); 
})->name('home'); 

Route::get('/dashboard', function () { 
    return view('dashboard'); 
})->name('dashboard'); 

Route::get('/tentang', function () { 
    return view('tentang'); 
})->name('tentang'); 

Route::get('/mata-kuliah', [CourseController::class, 'index']) 
    ->name('mata-kuliah.index'); 

// Route untuk menampilkan detail satu mata kuliah. 
Route::get('/mata-kuliah/{id}', [CourseController::class, 'show']) 
    ->name('mata-kuliah.show'); 

Route::get('/error', function () { 
    abort(404); 
})->name('error');

// Route benar dengan create
// <?php 
// use App\Http\Controllers\CourseController; 
// use Illuminate\Support\Facades\Route; 

// Route::get('/', function () { 
//     return view('welcome'); 
// })->name('home'); 

// Route::get('/dashboard', function () { 
//     return view('dashboard'); 
// })->name('dashboard'); 

// Route::get('/tentang', function () { 
//     return view('tentang'); 
// })->name('tentang'); 

// Route::get('/mata-kuliah', [CourseController::class, 'index']) 
//     ->name('mata-kuliah.index'); 

// // BENAR: route spesifik (create) ditulis SEBELUM route parameter ({id})
// Route::get('/mata-kuliah/create', [CourseController::class, 'create'])
//     ->name('mata-kuliah.create');

// Route::get('/mata-kuliah/{id}', [CourseController::class, 'show']) 
//     ->name('mata-kuliah.show'); 

// Route::get('/error', function () { 
//     abort(404); 
// })->name('error'); -->

//route create salah
// <?php 
// use App\Http\Controllers\CourseController; 
// use Illuminate\Support\Facades\Route; 

// Route::get('/', function () { 
//     return view('welcome'); 
// })->name('home'); 

// Route::get('/dashboard', function () { 
//     return view('dashboard'); 
// })->name('dashboard'); 

// Route::get('/tentang', function () { 
//     return view('tentang'); 
// })->name('tentang'); 

// Route::get('/mata-kuliah', [CourseController::class, 'index']) 
//     ->name('mata-kuliah.index'); 

// // SENGAJA DITUKAR: {id} ditulis SEBELUM create (ini yang salah)
// Route::get('/mata-kuliah/{id}', [CourseController::class, 'show']) 
//     ->name('mata-kuliah.show'); 

// Route::get('/mata-kuliah/create', [CourseController::class, 'create'])
//     ->name('mata-kuliah.create');

// Route::get('/error', function () { 
//     abort(404); 
// })->name('error');