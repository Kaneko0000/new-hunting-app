@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">狩猟記録を入力</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('hunters.logs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 📅 捕獲日時 -->
        <div class="mb-3">
            <label for="capture_date" class="form-label">捕獲日</label>
            <input type="date" id="capture_date" name="capture_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">捕獲時間</label>
            <input type="time" id="time" name="time" class="form-control" required>
        </div>

        <!-- 📍 場所 -->
        <div class="form-group">
            <label for="location">捕獲場所（自動入力）</label>
            <input type="text" id="location" name="location" class="form-control" readonly>
        </div>

        <div id="log-map" style="width: 100%; height: 400px;"></div>

        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <!-- 🐗 捕獲した動物の種類 -->
        <div class="mb-3">
            <label for="animal_id" class="form-label">捕獲した動物</label>
            <input type="hidden" id="animal_id" name="animal_id">
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <!-- 動物リスト -->
                @php
                    $animals = [
                        ['id' => 1, 'name' => 'イノシシ', 'img' => 'boar.webp'],
                        ['id' => 2, 'name' => 'シカ', 'img' => 'deer.webp'],
                        ['id' => 3, 'name' => 'クマ', 'img' => 'bear.webp'],
                        ['id' => 4, 'name' => 'キツネ', 'img' => 'fox.webp'],
                        ['id' => 5, 'name' => 'タヌキ', 'img' => 'racoon.webp'],
                        ['id' => 6, 'name' => 'その他', 'img' => 'question.webp'],
                    ];
                @endphp

                @foreach ($animals as $animal)
                    <div class="animal-option text-center" data-value="{{ $animal['id'] }}">
                        <img src="/images/{{ $animal['img'] }}" class="animal-icon" alt="{{ $animal['name'] }}">
                        <p class="fw-bold">{{ $animal['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label for="count" class="form-label">捕獲数</label>
            <input type="hidden" id="count" name="count">
            <div class="d-flex justify-content-center flex-wrap gap-2">
                @for($i = 1; $i <= 8; $i++)
                    <div class="count-option text-center" data-value="{{ $i }}">
                        <span class="count-number">{{ $i }}</span>
                    </div>
                @endfor
            </div>
        </div>

        <!-- ☀️ 天候 -->
        <div class="mb-3">
            <label for="weather_id" class="form-label">天気</label>
            <input type="hidden" id="weather_id" name="weather_id">
            <div class="d-flex justify-content-center flex-wrap gap-3">
                @php
                    $weathers = [
                        ['id' => 1, 'name' => '晴', 'img' => 'weather1.webp'],
                        ['id' => 2, 'name' => '曇り', 'img' => 'weather2.webp'],
                        ['id' => 3, 'name' => '雨', 'img' => 'weather3.webp'],
                        ['id' => 4, 'name' => '雪', 'img' => 'weather4.webp'],
                        ['id' => 5, 'name' => '曇り時々雨', 'img' => 'weather5.webp'],
                    ];
                @endphp

                @foreach ($weathers as $weather)
                    <div class="weather-option text-center" data-value="{{ $weather['id'] }}">
                        <img src="/images/{{ $weather['img'] }}" class="weather-icon" alt="{{ $weather['name'] }}">
                        <p class="fw-bold">{{ $weather['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>


        <!-- 📝 メモ -->
        <div class="mb-3">
            <label for="notes" class="form-label">メモ (任意)</label>
            <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="備考があれば記入"></textarea>
        </div>

        <!-- 📸 写真アップロード -->
        <div class="mb-3">
            <label for="photo" class="form-label">捕獲写真 (任意)</label>
            <input type="file" id="photo" name="photo" class="form-control">
        </div>

        <!-- ✅ 保存ボタン -->
        <button type="submit" class="btn btn-success w-100">記録を保存</button>
    </form>
</div>

@endsection
