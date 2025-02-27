@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>ハンターダッシュボード</h1>

        <div class="card">
            <div class="card-body">
                <h2>捕獲ログ</h2>
                <a href="{{ route('hunters.logs.create') }}" class="btn btn-primary">新規記録</a>
                <a href="{{ route('hunters.logs') }}" class="btn btn-secondary">ログを見る</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h2>狩猟統計</h2>
                <a href="{{ route('hunters.premium') }}" class="btn btn-warning">統計データを見る（有料）</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h2>掲示板</h2>
                <a href="{{ route('hunters.forum.index') }}" class="btn btn-success">掲示板を見る</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h2>メッセージ</h2>
                <a href="{{ route('hunters.messages.index') }}" class="btn btn-info">メッセージを見る</a>
            </div>
        </div>
    </div>
@endsection
