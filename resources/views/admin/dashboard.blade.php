@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="dashboard-title">管理者ダッシュボード</h1>
        <a href="{{ route('admin.hunters.index') }}" class="btn btn-primary">ハンター管理画面へ</a>
    </div>
    <p class="text-muted">ここでハンターの管理やニュース投稿ができます。</p>

    <div class="row">
        <!-- 記事投稿フォーム -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">新規記事投稿</div>
                <div class="card-body">
                    <form action="{{ route('admin.articles.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">タイトル</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="タイトルを入力" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="content" class="form-label">内容</label>
                            <textarea name="content" id="content" class="form-control" rows="5" placeholder="記事の内容を入力" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">投稿する</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 最新記事一覧 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">最新の記事（最大10件）</div>
                <ul class="list-group list-group-flush">
                    @foreach ($articles as $article)
                        <li class="list-group-item">
                            <h5 class="mb-1">{{ $article->title }}</h5>
                            <p class="mb-1">{{ $article->content }}</p>
                            <small class="text-muted">投稿日: {{ $article->created_at->format('Y-m-d H:i') }}</small>
                        </li>
                    @endforeach
                    @if ($articles->isEmpty())
                        <li class="list-group-item text-muted">記事がまだありません。</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
