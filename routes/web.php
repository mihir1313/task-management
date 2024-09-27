<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::fallback(function () {
    return redirect()->route('login'); 
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Route

Route::middleware(['auth', 'checkUserRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('dashboard');

    Route::any('/users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users');
    Route::post('/insert/users', [App\Http\Controllers\Admin\UsersController::class, 'insert'])->name('insert.users');
    Route::get('/edit/users', [App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('edit.users');
    Route::delete('/delete/users', [App\Http\Controllers\Admin\UsersController::class, 'delete'])->name('delete.users');
   
    Route::any('/projects', [App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('projects');
    Route::post('/insert/projects', [App\Http\Controllers\Admin\ProjectController::class, 'insert'])->name('insert.projects');
    Route::get('/edit/projects', [App\Http\Controllers\Admin\ProjectController::class, 'edit'])->name('edit.projects');
    Route::delete('/delete/projects', [App\Http\Controllers\Admin\ProjectController::class, 'delete'])->name('delete.projects');
    
    Route::any('/tasks/{id?}', [App\Http\Controllers\Admin\TaskController::class, 'index'])->name('tasks');
    Route::post('/insert/tasks', [App\Http\Controllers\Admin\TaskController::class, 'insert'])->name('insert.tasks');
    Route::get('/edit/tasks', [App\Http\Controllers\Admin\TaskController::class, 'edit'])->name('edit.tasks');
    Route::delete('/delete/tasks', [App\Http\Controllers\Admin\TaskController::class, 'delete'])->name('delete.tasks');

});

// User Route
Route::middleware(['auth', 'checkUserRole:user'])->prefix('user')->name('user.')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('user.dashboard');
    // })->name('dashboard');

    Route::any('/projects', [App\Http\Controllers\User\ProjectController::class, 'index'])->name('projects');
    
    Route::any('/tasks/{id?}', [App\Http\Controllers\User\TaskController::class, 'index'])->name('tasks');
    Route::post('/insert/tasks', [App\Http\Controllers\User\TaskController::class, 'insert'])->name('insert.tasks');
    Route::get('/edit/tasks', [App\Http\Controllers\User\TaskController::class, 'edit'])->name('edit.tasks');
    Route::delete('/delete/tasks', [App\Http\Controllers\User\TaskController::class, 'delete'])->name('delete.tasks');
});
