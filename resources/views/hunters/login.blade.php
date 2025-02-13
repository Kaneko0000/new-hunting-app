@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>ハンターログイン</h1>
        <form action="{{ route('hunters.login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">パスワード</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">ログイン</button>
        </form>
    </div>
@endsection
