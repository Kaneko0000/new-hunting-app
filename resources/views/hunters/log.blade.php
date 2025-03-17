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
            <label for="date" class="form-label">捕獲日</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">捕獲時間</label>
            <input type="time" id="time" name="time" class="form-control" required>
        </div>

        <!-- 📍 場所 -->
        <div class="form-group">
            <label for="location">捕獲場所</label>
            <input type="text" id="location" name="location" class="form-control" placeholder="例: 熊本県天草市" required>
        </div>

        <div id="log-map" style="width: 100%; height: 400px;"></div>

        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">

        <!-- 🐗 捕獲した動物の種類 -->
        <div class="mb-3">
            <label for="animal" class="form-label">捕獲した動物</label>
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <input type="hidden" id="selectedAnimal" name="animal">

                <!-- 動物リスト -->
                @php
                    $animals = [
                        ['name' => 'イノシシ', 'img' => 'boar.webp'],
                        ['name' => 'シカ', 'img' => 'deer.webp'],
                        ['name' => 'クマ', 'img' => 'bear.webp'],
                        ['name' => 'キツネ', 'img' => 'fox.webp'],
                        ['name' => 'タヌキ', 'img' => 'racoon.webp'],
                        ['name' => 'その他', 'img' => 'question.webp'],
                    ];
                @endphp

                @foreach ($animals as $animal)
                    <div class="animal-option text-center" data-value="{{ $animal['name'] }}">
                        <img src="/images/{{ $animal['img'] }}" class="animal-icon" alt="{{ $animal['name'] }}">
                        <p class="fw-bold">{{ $animal['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 🔢 捕獲数 -->
        <div class="form-group">
            <label for="count">捕獲数</label>
            <input type="hidden" id="selectedCount" name="count">
            <div class="count-options">
                @for($i = 1; $i <= 8; $i++)
                    <div class="count-option" data-value="{{ $i }}">
                        <span>{{ $i }}</span>
                    </div>
                @endfor
            </div>
        </div>

        <!-- ☀️ 天候 -->
        <div class="form-group">
            <label for="weather">天候</label>
            <div class="weather-options">
                <input type="hidden" id="selectedWeather" name="weather">

                <!-- 晴れ -->
                <div class="weather-option" data-value="晴れ">
                    <img src="/images/weather1.webp" class="weather-icon" alt="晴れ">
                    <span>晴れ</span>
                </div>

                <!-- 曇り -->
                <div class="weather-option" data-value="曇り">
                    <img src="/images/weather2.webp" class="weather-icon" alt="曇り">
                    <span>曇り</span>
                </div>

                <!-- 雨 -->
                <div class="weather-option" data-value="雨">
                    <img src="/images/weather3.webp" class="weather-icon" alt="雨">
                    <span>雨</span>
                </div>

                <!-- 雪 -->
                <div class="weather-option" data-value="雪">
                    <img src="/images/weather4.webp" class="weather-icon" alt="雪">
                    <span>雪</span>
                </div>

                <!-- 曇り時々雨 -->
                <div class="weather-option" data-value="曇り時々雨">
                    <img src="/images/weather5.webp" class="weather-icon" alt="曇り時々雨">
                    <span>曇り時々雨</span>
                </div>
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
