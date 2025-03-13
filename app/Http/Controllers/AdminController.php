<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hunter;
use App\Models\License;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewHunterNotification;
use App\Mail\HunterApprovedMail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $hunters = Hunter::all();
        return view('admin.dashboard', compact('hunters'));
    }

    public function adminIndex(Request $request)
    {
        Log::info('🔥 検索クエリ: ', $request->all());

        $query = Hunter::query();
    
        // 名前で検索
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', "%{$request->name}%");
        }
    
        // 地域で検索
        if ($request->has('region') && !empty($request->region)) {
            $query->where('region', $request->region);
        }
    
        $hunters = $query->get();
        $prefectures = config('prefectures');
        $licenses = License::all(); // 🔥 Licenseテーブルのデータを取得



        // $hunters = Hunter::all();
        // $prefectures = config('prefectures');

        return view('admin.hunters.index', [
            'hunters' => $hunters,
            'prefectures' => $prefectures,
            'licenses' => $licenses,
            'isAdmin' => true 
        ]);
    }

    // **ハンターの承認**
    public function approve($id)
    {
        Log::info("🔥 承認リクエストを受け取った: ID = {$id}");

        $hunter = Hunter::findOrFail($id);
        $hunter->status = 'approved';  // ステータスを 'approved' に変更
        $hunter->save();

        Log::info("✅ 承認完了: ID = {$hunter->id}");

        // メール送信
        try {
            Mail::to($hunter->email)->send(new HunterApprovedMail($hunter));
            Log::info('承認メール送信成功: ' . $hunter->email);
        } catch (\Exception $e) {
            Log::error('承認メール送信失敗: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'ハンターを承認し、メールを送信しました。');
    }

    // **ハンターの削除**
    public function adminDestroy(Hunter $hunter)
    {
        $hunter->delete();
        return redirect()->route('admin.hunters.index')->with('success', 'ハンターを削除しました！');
    }

}


