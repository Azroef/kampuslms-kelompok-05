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
