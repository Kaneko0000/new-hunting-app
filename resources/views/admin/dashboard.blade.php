@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>管理者ダッシュボード</h1>
        <p>ここでハンターの管理やニュース投稿ができます。</p>

        <a href="{{ route('admin.hunters.index') }}" class="btn btn-primary">ハンター管理画面へ</a>
    </div>
@endsection
