<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Post;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/test1', function () {
        return Inertia::render('Test1');
    })->name('test1');
    Route::get('/test2', function () {
        return Inertia::render('Test2');
    })->name('test2');
    Route::get('/post', function () {
        $posts = Post::all();
        return Inertia::render('Post/Post',compact('posts'));
    })->name('post');

    Route::get('/user', function () {
        return Inertia::render('User');
    })->name('user.index');

    Route::get('/posts', function () {
        return Post::paginate();
    });

    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('graphic',[EmployeeController::class,'EmployeeByDepartment'])->name('graphic');
    Route::get('reports', [EmployeeController::class, 'reports'])->name('reports');

    Route::get('/testforms', function () {
        return Inertia::render('TestForms');
    })->name('testforms');
});
