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
    Route::get('/', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.dashboard');
    Route::delete('/contacts/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('admin.contacts.destroy');
    Route::get('/export', [\App\Http\Controllers\Admin\ContactController::class, 'export'])->name('admin.contacts.export');
});

// Fortifyが認証ルートを自動生成するため、手動ルートは削除
