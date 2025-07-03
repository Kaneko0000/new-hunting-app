@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">狩猟記録を入力</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="capture-form"
        action="{{ isset($log) ? route('hunters.logs.update', $log->id) : route('hunters.logs.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @if(isset($log))
            @method('PUT')
        @endif

        <!-- 📅 捕獲日時 -->
        <div class="mb-3">
            <label for="capture_date" class="form-label">捕獲日</label>
            <input type="date" id="capture_date" name="capture_date" class="form-control" required
            value="{{ old('capture_date', isset($log) ? $log->capture_date->format('Y-m-d') : '') }}">

        </div>
        <div class="mb-3">
            <label for="capture_time" class="form-label">捕獲時間</label>
            <!-- <input type="time" id="capture_time" name="capture_time" class="form-control" required> -->
            <input type="time" id="capture_time" name="capture_time" class="form-control" required value="{{ old('capture_time', $log->capture_time ?? '') }}">

        </div>

        <!-- 📍 場所 -->
        <div class="form-group">
            <label for="location">捕獲場所（自動入力）</label>
            <input type="text" id="location" name="location" class="form-control" readonly value="{{ old('location', $log->address ?? '') }}">
            
        </div>

        <div id="log-map" style="width: 100%; height: 400px;"></div>

        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $log->latitude ?? '') }}">
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $log->longitude ?? '') }}">

        <!-- 🏹 狩猟方法（画像選択式） -->
        <div class="mb-3">
            <label for="hunting_method_id" class="form-label">狩猟方法</label>
            <input type="hidden" id="hunting_method_id" name="hunting_method_id" required value="{{ old('hunting_method_id', $log->hunting_method_id ?? '') }}">

            <div class="d-flex justify-content-center flex-wrap gap-3 hunting-method-options">
                @php
                    $methods = [
                        ['id' => 1, 'name' => '箱罠', 'icon' => 'hunting_method1.png'],
                        ['id' => 2, 'name' => 'くくり罠', 'icon' => 'hunting_method2.png'],
                        ['id' => 3, 'name' => '巻狩り', 'icon' => 'hunting_method3.png'],
                    ];
                @endphp

                @foreach ($methods as $method)
                    <div class="hunting-method-option text-center" data-value="{{ $method['id'] }}">
                        <img src="/images/{{ $method['icon'] }}" class="hunting-method-icon" alt="{{ $method['name'] }}" style="width:100px; height:auto;">
                        <p class="fw-bold">{{ $method['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 🐗 捕獲した動物の種類 -->
        <div class="mb-3">
            <label for="animal_id" class="form-label">捕獲した動物</label>
            <!-- <input type="hidden" id="animal_id" name="animal_id"> -->
            <input type="hidden" id="animal_id" name="animal_id" value="{{ old('animal_id', $log->animal_id ?? '') }}">

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
            <input type="hidden" id="count" name="count" value="{{ old('count', $log->count ?? '') }}">
            <div class="d-flex justify-content-center flex-wrap gap-2">
                @for($i = 1; $i <= 6; $i++)
                    <div class="count-option text-center" data-value="{{ $i }}">
                        <span class="count-number">{{ $i }}</span>
                    </div>
                @endfor
            </div>
        </div>

        <!-- ☀️ 天候 -->
        <div class="mb-3">
            <label for="weather_id" class="form-label">天気</label>
            <input type="hidden" id="weather_id" name="weather_id" value="{{ old('weather_id', $log->weather_id ?? '') }}">

            <div class="d-flex justify-content-center flex-wrap gap-3">
                @php
                    $weathers = [
                        ['id' => 1, 'name' => '晴', 'img' => 'weather1.webp'],
                        ['id' => 2, 'name' => '曇り', 'img' => 'weather2.webp'],
                        ['id' => 3, 'name' => '雨', 'img' => 'weather3.webp'],
                        ['id' => 4, 'name' => '雪', 'img' => 'weather4.webp'],
                        ['id' => 5, 'name' => '曇雨', 'img' => 'weather5.webp'],
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
            <textarea id="comments" name="comments">{{ old('comments', $log->comments ?? '') }}</textarea>

        </div>


        <!-- 📸 写真アップロード -->
        @if(isset($log) && $log->photo)
            <div class="mb-3">
                <p>現在の写真:</p>
                <img src="{{ asset('storage/' . $log->photo) }}" alt="捕獲写真" style="max-width: 300px;">
            </div>
        @endif

        <div class="mb-3">
            <label for="photo" class="form-label">捕獲写真 (任意)</label>
            <input type="file" id="photo" name="photo" class="form-control">
        </div>

        <!-- ✅ 保存ボタン -->
        <button type="submit" class="btn btn-success w-100">記録を保存</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    window.mapboxToken = @json($mapboxToken);
</script>
@endsection
