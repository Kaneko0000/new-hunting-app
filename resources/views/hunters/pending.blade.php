@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="text-center p-4 shadow-lg rounded bg-white">
        <h2 class="mb-3" style="font-family: 'Poppins', sans-serif;">登録申請完了</h2>
        <p class="lead">登録申請が完了しました。管理者の承認をお待ちください。</p>

        <!-- 🔥 トップページに戻るボタン（デザインを適用） -->
        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 py-2">
            トップページへ戻る
        </a>
    </div>
</div>
@endsection
