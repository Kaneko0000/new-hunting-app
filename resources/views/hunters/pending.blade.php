@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <h1 class="mb-3">登録申請完了</h1>
        <p>登録申請が完了しました。管理者の承認をお待ちください。</p>

        <!-- 🔥 トップページに戻るボタン（デザインを適用） -->
        <a href="{{ url('/') }}" class="return-button">
            トップページへ戻る
        </a>
    </div>
@endsection
