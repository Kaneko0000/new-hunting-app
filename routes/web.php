<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HunterAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HunterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HunterLogController;
use App\Http\Controllers\TermsController;

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
        Route::get('/log', [HunterController::class, 'index'])->name('hunters.log');
        
        // ✅ 狩猟記録
        Route::post('/logs/create', [HunterLogController::class, 'create'])->name('hunters.logs.create');
        Route::post('/logs', [HunterLogController::class, 'store'])->name('hunters.logs.store');
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







// // **規約同意のルート**
// Route::middleware(['auth:hunter'])->group(function () {
//     Route::get('/hunters/terms', [TermsController::class, 'show'])->name('terms.show');
//     Route::post('/hunters/terms/accept', [TermsController::class, 'accept'])->name('terms.accept');
// });
// // **ハンター専用ルート**
// Route::middleware([CheckTerms::class])->group(function () {
//     Route::get('/hunters/dashboard', [DashboardController::class, 'index'])->name('hunters.dashboard');
// });

// Route::middleware(['auth:hunter'])->prefix('hunters')->group(function () {
//     Route::get('/dashboard', [HunterController::class, 'dashboard'])->name('hunters.dashboard');
//     Route::get('/log', [HunterController::class, 'index'])->name('hunters.log');
//     Route::post('/logs/create', [HunterLogController::class, 'create'])->name('hunters.logs.create'); //記録フォーム作成
//     Route::post('/logs', [HunterLogController::class, 'store'])->name('hunters.logs.store'); // 記録保存
// });

// // **管理者認証関連**
// Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
// Route::post('/admin/login', [AdminAuthController::class, 'login']);
// Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// // **管理者専用ルート**
// Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::get('/hunters', [AdminController::class, 'adminIndex'])->name('admin.hunters.index');
//     Route::post('/admin/hunters/{id}/approve', [AdminController::class, 'approve'])->name('admin.hunters.approve');
//     Route::delete('/hunters/{hunter}', [AdminController::class, 'adminDestroy'])->name('admin.hunters.destroy');
// });


// // **プロフィール管理（認証ユーザーのみ）**
// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', function () {
//         if (Auth::user()->role === 'admin') {
//             return redirect()->route('admin.hunters.index');
//         } else {
//             return redirect()->route('hunters.index');
//         }
//     })->name('dashboard');

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::get('/hunters/pending', function () {
//     return view('hunters.pending');
// })->name('hunters.pending');

// // **ハンター認証関連**
// Route::get('/hunters/register', [HunterController::class, 'create'])->name('hunters.register');
// Route::post('/hunters/register', [HunterController::class, 'store']);

// Route::get('/hunters/login', [HunterAuthController::class, 'showLoginForm'])->name('hunters.login');
// Route::post('/hunters/login', [HunterAuthController::class, 'login']);
// Route::post('/hunters/logout', [HunterAuthController::class, 'logout'])->name('hunters.logout');


// // **ハンターのリソースルート（CRUD操作）**
// Route::resource('hunters', HunterController::class);







require __DIR__.'/auth.php'; // 認証関連のルート
