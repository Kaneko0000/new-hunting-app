<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HunterAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HunterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HunterLogController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\ArticleController;

use App\Http\Middleware\CheckTerms;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// ✅ **ハンター認証関連 (ログイン・登録・ログアウト)**
Route::prefix('hunters')->group(function () {
    Route::get('/register', [HunterController::class, 'create'])->name('hunters.register');
    Route::post('/register', [HunterController::class, 'store']);

    Route::get('/login', [HunterAuthController::class, 'showLoginForm'])->name('hunters.login');
    Route::post('/login', [HunterAuthController::class, 'login']);
    Route::post('/logout', [HunterAuthController::class, 'logout'])->name('hunters.logout');
});

// ✅ **ハンター専用ルート（ログイン必須）**
Route::middleware(['auth:hunter'])->prefix('hunters')->group(function () {
    
    // 🔥 **利用規約同意ルート**
    Route::get('/terms', [TermsController::class, 'show'])->name('terms.show');
    Route::post('/terms/accept', [TermsController::class, 'accept'])->name('terms.accept');

    // ✅ **規約同意済みのハンターのみアクセス可能**
    Route::middleware([CheckTerms::class])->group(function () {
        Route::get('/dashboard', [HunterController::class, 'dashboard'])->name('hunters.dashboard');
        // ✅ 狩猟記録
        Route::get('/log', [HunterLogController::class, 'create'])->name('hunters.log');
        Route::get('/logs', [HunterLogController::class, 'index'])->name('hunters.logs.index');
        Route::get('/logs/{log}/edit', [HunterLogController::class, 'edit'])->name('hunters.logs.edit');
        Route::put('/logs/{log}', [HunterLogController::class, 'update'])->name('hunters.logs.update');
        Route::delete('/logs/{log}', [HunterLogController::class, 'destroy'])->name('hunters.logs.destroy');

        // Route::post('/logs/create', [HunterLogController::class, 'create'])->name('hunters.logs.create');
        Route::post('/logs', [HunterLogController::class, 'store'])->name('hunters.logs.store');
        
        Route::get('/api/hunter-logs', [HunterController::class, 'apiHunterLogs'])
        ->middleware('auth')
        ->name('api.hunter.logs');
    });
});

// ✅ **管理者認証関連**
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ✅ **管理者専用ルート**
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/articles', [ArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/hunters', [AdminController::class, 'adminIndex'])->name('admin.hunters.index');
    Route::post('/hunters/{id}/approve', [AdminController::class, 'approve'])->name('admin.hunters.approve');
    Route::delete('/hunters/{hunter}', [AdminController::class, 'adminDestroy'])->name('admin.hunters.destroy');
});

// ✅ **プロフィール管理（認証ユーザーのみ）**
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.hunters.index');
        } else {
            return redirect()->route('hunters.dashboard');
        }
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ **認証待ちのハンター用ページ**
Route::get('/hunters/pending', function () {
    return view('hunters.pending');
})->name('hunters.pending');


require __DIR__.'/auth.php'; // 認証関連のルート
