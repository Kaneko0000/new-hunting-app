@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>ハンターダッシュボード</h1>

        <div class="card">
            <div class="card-body">
                <h2>捕獲ログ</h2>
                <a href="{{ route('hunters.log') }}" class="btn btn-secondary">ログを見る</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h2>狩猟統計</h2>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h2>掲示板</h2>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h2>メッセージ</h2>
            </div>
        </div>
    </div>
@endsection
