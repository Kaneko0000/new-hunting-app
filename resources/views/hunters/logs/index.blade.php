@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>📅 {{ $date }} の狩猟記録</h2>

        @forelse ($logs as $log)
            <div class="card my-3">
                <div class="card-body">
                    <p>動物: {{ $log->animal->name }}</p>
                    <p>頭数: {{ $log->count }}</p>
                    <p>時間: {{ $log->capture_time }}</p>
                    <p>場所: {{ $log->address ?? '不明' }}</p>
                    <p>天気: {{ $log->weather->name ?? '不明' }}</p>
                    <p>🔫 捕獲方法: {{ $log->huntingMethod->name ?? '不明' }}</p>
                    <p>📝 コメント: {{ $log->comments ?? 'なし' }}</p>
                    @if($log->photo)
                        <p>📷 写真:<br>
                            <img src="{{ asset('storage/' . $log->photo) }}" alt="捕獲写真" style="max-width: 300px;">
                        </p>
                    @endif
                    <div class="mt-3">
                        <a href="{{ route('hunters.logs.edit', $log->id) }}" class="btn btn-primary btn-sm">✏️ 編集</a>
                        <form action="{{ route('hunters.logs.destroy', [$log, 'date' => $date]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑️ 削除</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>この日に記録はありません。</p>
            <!-- <p>{{ $date }} の狩猟記録はありません。</p> -->
        @endforelse
        <div class="text-center my-4">
            <a href="{{ route('hunters.dashboard') }}" class="btn btn-secondary">
                🏠 ダッシュボードへ戻る
            </a>
        </div>
    </div>
@endsection
