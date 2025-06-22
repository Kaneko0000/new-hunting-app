<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hunter;
use App\Models\HunterLog;
use App\Models\Article;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\HunterRequest;
use App\Models\License;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewHunterNotification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HunterController extends Controller
{
    public function index(Request $request)
    {
        $query = Hunter::with('licenses');
        $prefectures = config('prefectures');
    
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }
    
        $hunters = $query->get();
        // ユーザーが管理者であるかどうかを判定
        $isAdmin = request()->is('admin/*');
    
        return view('hunters.log', compact('hunters', 'prefectures', 'isAdmin'));
    }

    public function create() {
        // dd('create メソッド実行'); 
        $prefectures = config('prefectures');
        $licenses = License::all(); // すべてのライセンスを取得
        return view('hunters.create', compact('prefectures', 'licenses'));
    }

    public function store(Request $request) {
        // フォームからのリクエストデータをログ出力
        Log::info('受け取ったリクエスト:', $request->all());
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:hunters,email',
            'phone' => 'required|regex:/^[0-9]{10,11}$/',
            'region' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
            'license_expiry' => 'nullable|date',
            'license_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'licenses' => 'array', //複数対応
        ]);
    
        // 🔥 バリデーションを通過した場合のみ以下の処理を実行 🔥
    
        // ハンター情報を作成
        $hunter = Hunter::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'region' => $validatedData['region'],
            'password' => Hash::make($validatedData['password']),
            'license_expiry' => $validatedData['license_expiry'] ?? null, // 有効期限を保存
        ]);
    
        // 🔥 免許画像を保存
        if ($request->hasFile('license_image')) {
            $path = $request->file('license_image')->store('licenses', 'public');
            Log::info('画像パス: ', ['path' => $path]);
            $hunter->update(['license_image' => $path]);
        }

        // 🔥 免許情報を中間テーブルに保存
        if ($request->has('licenses')) {
            $hunter->licenses()->attach($request->licenses);
            Log::info('ライセンス情報を登録: ', ['licenses' => $request->licenses]);
        }
    
        try {
            Mail::to('vs.noo.moo@gmail.com')->send(new NewHunterNotification($hunter));
            Log::info('メール送信成功: ' . $hunter->email);
        } catch (\Exception $e) {
            Log::error('管理者へのメール送信に失敗: ' . $e->getMessage());
        }
    
        return redirect()->route('hunters.pending')->with('success', '登録申請が完了しました。管理者の承認をお待ちください。');
    }
    

    public function show(string $id)
    {
        //
    }

    public function edit(Hunter $hunter)
    {
        $prefectures = config('prefectures');
        $licenses = License::all();

        // ハンターの免許IDを配列として取得（編集画面でチェックをつけるため）
        $hunterLicenses = $hunter->licenses->pluck('id')->toArray();

        return view('hunters.edit', compact('hunter', 'prefectures', 'licenses', 'hunterLicenses'));
    }

    public function update(HunterRequest $request, Hunter $hunter)
    {
        $hunter->update($request->validated());

        // 免許の更新（多対多の同期）
        if ($request->has('licenses')) {
            $hunter->licenses()->sync($request->licenses);
        } else {
            $hunter->licenses()->detach(); // 免許が選択されていない場合は全て解除
        }
        
        return redirect()->route('hunters.index')->with('success', 'ハンター情報を更新しました！');
    }

    // 一般ユーザー用のdestroy
    public function destroy(Hunter $hunter)
    {
        $hunter->delete();
        return redirect()->route('hunters.index')->with('success', 'ハンターを削除しました！');
    }

    public function dashboard()
    {
        $hunter = auth()->user();

        // 地図マーカー用ログデータ（緯度経度、日付、動物名）
        $logs = HunterLog::where('hunter_id', $hunter->id)
        ->with('animal:id,name')
        ->select('id', 'animal_id', 'latitude', 'longitude', 'capture_date')
        ->get();

        // FullCalendar用のイベント形式データ
        $calendarEvents = HunterLog::where('hunter_id', $hunter->id)
        ->with('animal:id,name')
        ->select('capture_date', 'animal_id', 'count')
        ->get()
        ->map(function ($log) {
            $animalIcons = [
                1 => '/images/boar.webp',
                2 => '/images/deer.webp',
                3 => '/images/bear.webp',
                4 => '/images/fox.webp',
                5 => '/images/racoon.webp',
                6 => '/images/question.webp',
            ];
            return [
                // 'title' => "{$log->animal->name} {$log->count}頭",
                'start' => Carbon::parse($log->capture_date)->toDateString(),
                'allDay' => true,
                'icon' => $animalIcons[$log->animal_id] ?? '/images/question.png',
            ];
        });

        // 管理者記事を取得
        $articles = Article::latest()->take(5)->get();
        $mapboxToken = config('services.mapbox.token');

        return view('hunters.dashboard', compact('hunter', 'logs', 'calendarEvents', 'articles', 'mapboxToken'));
    }
    public function apiHunterLogs()
    {
        // 認証ユーザーのログを全件取得（動物の名前も一緒に取得）
        $logs = HunterLog::where('hunter_id', auth()->id())
                    ->with('animal:id,name')
                    ->select('id', 'animal_id', 'latitude', 'longitude', 'capture_date')
                    ->get();

        return response()->json($logs);
    }

}
