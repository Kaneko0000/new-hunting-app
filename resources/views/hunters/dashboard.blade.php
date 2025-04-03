@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>ハンターダッシュボード</h1>

        {{-- フラッシュメッセージの表示 --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- {{-- セクション切り替えタブ --}}
        <div class="d-flex justify-content-around my-4">
            <button class="btn btn-outline-primary" onclick="showSection('capture')">捕獲実績</button>
            <button class="btn btn-outline-primary" onclick="showSection('board')">掲示板</button>
            <button class="btn btn-outline-primary" onclick="showSection('map')">マップ</button>
            <button class="btn btn-outline-primary" onclick="showSection('message')">メッセージ</button>
        </div>

        {{-- 捕獲実績セクション --}}
        <div id="section-capture" class="card section-content">
            <div class="card-body">
                <h2>捕獲実績</h2>
                <p>これまでの捕獲頭数を表示（モック表示）</p>
                <div class="row text-center">
                    <div class="col"><img src="/images/boar.webp" width="40"><p>イノシシ: 3</p></div>
                    <div class="col"><img src="/images/deer.webp" width="40"><p>シカ: 2</p></div>
                    <div class="col"><img src="/images/fox.webp" width="40"><p>キツネ: 1</p></div>
                    <div class="col"><img src="/images/racoon.webp" width="40"><p>タヌキ: 4</p></div>
                </div>
            </div>
        </div>

        {{-- 掲示板セクション --}}
        <div id="section-board" class="card section-content d-none">
            <div class="card-body">
                <h2>掲示板</h2>
                <p>最新のお知らせ5件を表示（例としてダミー）</p>
                <ul>
                    <li>【重要】春の狩猟安全講習について</li>
                    <li>新しい罠設置区域のお知らせ</li>
                    <li>4月のイベント情報</li>
                    <li>報奨金制度について</li>
                    <li>熊注意報が出ています</li>
                </ul>
                <a href="#" class="btn btn-link">もっと見る</a>
            </div>
        </div>
        {{-- マップセクション --}}
        <div id="section-map" class="card section-content d-none">
            <div class="card-body">
                <h2>マップ</h2>
                <div id="hunter-map" style="width: 100%; height: 500px;"></div>
            </div>
        </div>

        {{-- メッセージセクション --}}
        <div id="section-message" class="card section-content d-none">
            <div class="card-body">
                <h2>メッセージ</h2>
                <p>ここに個別またはグループメッセージを表示予定</p>
            </div>
        </div> -->

        <div class="card mt-4">
            <div class="card-body">
                <h2>狩猟統計</h2>
                <div id="hunter-map" style="width: 100%; height: 500px;"></div>
            </div>
            {{-- 狩猟統計セクション --}}
    <div class="card mt-4">
        <div class="card-body">
            <h2>狩猟統計</h2>

            <div class="d-flex flex-wrap gap-4 justify-content-center">
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

                @foreach ($logs as $log)
                    @php
                        $animal = collect($animals)->firstWhere('id', $log->animal_id);
                    @endphp
                    @if ($animal)
                        <div class="text-center">
                            <img src="/images/{{ $animal['img'] }}" alt="{{ $animal['name'] }}" style="width: 80px; height: 80px; object-fit: contain;">
                            <p class="mt-2 fw-bold">{{ $animal['name'] }}: {{ $log->total }} 頭</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2>捕獲ログ</h2>
                <a href="{{ route('hunters.log') }}" class="btn btn-secondary">捕獲！！</a>
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

<script>
    const hunterLogs = @json($logs);
    console.log("📍hunterLogs:", hunterLogs);
</script>