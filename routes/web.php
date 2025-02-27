<!-- <?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HunterController;
use App\Http\Controllers\HunterAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// **ログイン関連**
Route::get('/login', [HunterAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [HunterAuthController::class, 'login']);
Route::post('/logout', [HunterAuthController::class, 'logout'])->name('logout');

// **ログイン後のリダイレクト修正**
Route::get('/dashboard', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')  // 管理者なら管理画面へ
            : redirect()->route('hunters.dashboard'); // ハンターならハンター画面へ
    }
    return redirect('/login'); // 未ログインならログインページへ
})->name('dashboard');

// **管理者専用ルート**
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/hunters', [HunterController::class, 'adminIndex'])->name('admin.hunters.index');
    Route::post('/hunters/{id}/approve', [HunterController::class, 'approve'])->name('admin.hunters.approve');
});

// **ハンター専用ルート**
Route::prefix('hunters')->middleware(['auth', 'role:hunter'])->group(function () {
    Route::get('/dashboard', [HunterController::class, 'dashboard'])->name('hunters.dashboard');
    Route::get('/', [HunterController::class, 'index'])->name('hunters.index');
});


// **プロフィール管理（認証ユーザーのみ）**
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/hunters/pending', function () {
    return view('hunters.pending');
})->name('hunters.pending');

// **ハンター認証関連**
Route::get('/hunters/register', [HunterController::class, 'create'])->name('hunters.register');
Route::post('/hunters/register', [HunterController::class, 'store']);

Route::get('/hunters/login', [HunterAuthController::class, 'showLoginForm'])->name('hunters.login');
Route::post('/hunters/login', [HunterAuthController::class, 'login']);
Route::post('/hunters/logout', [HunterAuthController::class, 'logout'])->name('hunters.logout');


// **ハンターのリソースルート（CRUD操作）**
Route::resource('hunters', HunterController::class);

require __DIR__.'/auth.php'; // 認証関連のルート -->
