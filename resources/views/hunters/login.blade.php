@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg login-box">
        <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif;">ハンターログイン</h2>

        <form action="{{ route('hunters.login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control rounded-pill" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">パスワード</label>
                <input type="password" name="password" class="form-control rounded-pill" required>
            </div>
            @if ($errors->has('status'))
                <div class="alert alert-danger">
                    {{ $errors->first('status') }}
                </div>
            @endif

            <button type="submit" class="btn btn-primary w-100 rounded-pill">ログイン</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="text-decoration-none">トップページへ戻る</a>
        </div>
    </div>
</div>
@endsection
