<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Hunter;
use Illuminate\Support\Facades\Log; 

class TermsController extends Controller
{
    public function show()
    {
        Log::info('利用規約のTermsController@showに到達！');
        return view('hunters.terms'); // 利用規約・プライバシーポリシーページを表示
    }

    public function accept(Request $request)
    {
        Log::info('利用規約のTermsController@acceptに到達！');

        // 🔥 バリデーションの前にリクエストデータをログに出力
        Log::info('受け取ったリクエストデータ: ', $request->all());

        // 🔥 バリデーションのメッセージを明確に
        try {
            $request->validate([
                'terms_accepted' => ['required', 'accepted'],
                'privacy_accepted' => ['required', 'accepted'],
            ], [
                'terms_accepted.required' => '利用規約への同意が必要です。',
                'terms_accepted.accepted' => '利用規約に同意してください。',
                'privacy_accepted.required' => 'プライバシーポリシーへの同意が必要です。',
                'privacy_accepted.accepted' => 'プライバシーポリシーに同意してください。',
            ]);

            Log::info('バリデーション成功！');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('バリデーション失敗: ', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // 🔥 ユーザーがログインしているかチェック
        $hunter = Auth::guard('hunter')->user();
        if (!$hunter) {
            return redirect()->route('hunters.login')->withErrors(['error' => 'ログインが必要です。']);
        }

        // 同意フラグを更新
        $hunter->update([
            'terms_accepted' => true,
            'privacy_accepted' => true,
        ]);

        Log::info('利用規約同意が正常に完了しました！');
        return redirect()->route('hunters.dashboard')->with('success', '利用規約に同意しました！');
    }
}
