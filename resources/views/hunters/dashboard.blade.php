@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">狩猟ダッシュボード</h1>

        {{-- フラッシュメッセージ --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h2 class="mb-0">🦅 狩猟記録</h2>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @php
                        use App\Models\Animal;
                        use App\Models\HunterLog;

                        $logCounts = HunterLog::where('hunter_id', auth()->id())
                                    ->select('animal_id', \DB::raw('count(*) as total'))
                                    ->groupBy('animal_id')
                                    ->get();

                        $animals = [
                            ['id' => 1, 'name' => 'イノシシ', 'img' => 'boar.webp'],
                            ['id' => 2, 'name' => 'シカ', 'img' => 'deer.webp'],
                            ['id' => 3, 'name' => 'クマ', 'img' => 'bear.webp'],
                            ['id' => 4, 'name' => 'キツネ', 'img' => 'fox.webp'],
                            ['id' => 5, 'name' => 'タヌキ', 'img' => 'racoon.webp'],
                            ['id' => 6, 'name' => 'その他', 'img' => 'question.webp'],
                        ];
                    @endphp

                    @foreach ($logCounts as $log)
                        @php
                            $animal = collect($animals)->firstWhere('id', $log->animal_id);
                        @endphp
                        @if ($animal)
                            <div class="col-6 col-md-2 mb-4">
                                <img src="/images/{{ $animal['img'] }}" alt="{{ $animal['name'] }}" style="width: 60px; height: 60px; object-fit: contain;">
                                <p class="mt-2 fw-bold">{{ $animal['name'] }}<br><span class="text-success">{{ $log->total }} 頭</span></p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>捕獲ログ</h2>
                <a href="{{ route('hunters.log') }}" class="catch-btn">🐗 捕まえたー！</a>
            </div>
        </div>
        <img src="/images/hokaku.png" id="stampEffect" class="stamp-effect" alt="">

        {{-- 狩野マップ --}}
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h2 class="mb-0">🌍 捕獲場所マップ</h2>
            </div>
            <div class="card-body">
                <div id="hunter-map" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        {{-- 管理者ニュース --}}
        <div class="card mb-4">
            <div class="card-header bg-warning">
                <h2 class="mb-0">📰 管理者のニュース</h2>
            </div>
            <div class="card-body">
                @foreach ($articles as $article)
                <div class="mb-4 border-bottom pb-2">
                    <h4 class="fw-bold text-primary">{{ $article->title }}</h4>
                    <p class="text-muted">{{ $article->content }}</p>
                </div>
                @endforeach
                <a href="#" class="btn btn-outline-secondary mt-2">もっと見る</a>
            </div>
        </div>


        {{-- 採用予定: 掲示板 セクション --}}
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h2 class="mb-0">💬 掲示板</h2>
            </div>
            <div class="card-body">
                <p class="text-muted">現在は未実装ですが、今後「スレッド型のチャット機能」や「グループ向けボード」などの機能を追加予定です。</p>
            </div>
        </div>
    </div>

@endsection

<script>
    const hunterLogs = @json($logs);
    console.log("\ud83d\udccd hunterLogs:", hunterLogs);

    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.querySelector('.catch-btn');
        const stamp = document.getElementById('stampEffect');

        if (btn && stamp) {
            btn.addEventListener('click', function (e) {
                e.preventDefault(); // 遷移を一旦止める

                // スタンプ演出
                stamp.classList.add('active');

                // 数秒後に元の画面に戻す＆ページ遷移
                setTimeout(() => {
                    stamp.classList.remove('active');
                    window.location.href = btn.href;
                }, 1000); // 1秒間演出してから遷移
            });
        }
    });
</script>
