<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

// お問い合わせフォーム
Route::get('/', [ContactController::class, 'index'])->name('home');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::get('/confirm/back', [ContactController::class, 'back'])->name('contact.back');
Route::post('/thanks', [ContactController::class, 'store'])->name('contact.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

// 管理画面（認証後）
Route::prefix('admin')->middleware('auth')->group(function () {
    // TODO: 管理画面のルートを追加
});

// 認証
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
