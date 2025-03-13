@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>狩猟記録を入力</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('hunters.logs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 📅 捕獲日時 -->
            <div class="form-group">
                <label for="date">捕獲日</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="time">捕獲時間</label>
                <input type="time" id="time" name="time" class="form-control" required>
            </div>

            <!-- 📍 場所 -->
            <div class="form-group">
                <label for="location">捕獲場所</label>
                <input type="text" id="location" name="location" class="form-control" placeholder="例: 熊本県天草市" required>
            </div>

            <!-- 🐗 捕獲した動物の種類 -->
            <div class="form-group">
                <label for="animal">捕獲した動物</label>
                <select id="animal" name="animal" class="form-control" required>
                    <option value="">選択してください</option>
                    <option value="イノシシ">イノシシ</option>
                    <option value="シカ">シカ</option>
                    <option value="クマ">クマ</option>
                    <option value="キツネ">キツネ</option>
                    <option value="タヌキ">タヌキ</option>
                    <option value="その他">その他</option>
                </select>
            </div>

            <!-- 🔢 個体数 -->
            <div class="form-group">
                <label for="count">捕獲数</label>
                <input type="number" id="count" name="count" class="form-control" min="1" required>
            </div>

            <!-- ☀️ 天候 -->
            <div class="form-group">
                <label for="weather">天候</label>
                <select id="weather" name="weather" class="form-control">
                    <option value="晴れ">晴れ</option>
                    <option value="曇り">曇り</option>
                    <option value="雨">雨</option>
                    <option value="雪">雪</option>
                </select>
            </div>

            <!-- 📝 メモ -->
            <div class="form-group">
                <label for="notes">メモ (任意)</label>
                <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="備考があれば記入"></textarea>
            </div>

            <!-- 📸 写真アップロード -->
            <div class="form-group">
                <label for="photo">捕獲写真 (任意)</label>
                <input type="file" id="photo" name="photo" class="form-control">
            </div>

            <!-- ✅ 保存ボタン -->
            <button type="submit" class="btn btn-success">記録を保存</button>
        </form>
    </div>
@endsection
