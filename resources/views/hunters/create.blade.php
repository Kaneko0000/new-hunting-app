@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>ハンター登録</h1>
        <form action="{{ route('hunters.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">名前</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">電話番号</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">地域</label>
                <select name="region" class="form-control" required>
                    <option value="">地域を選択</option>
                    @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture }}" {{ old('region') == $prefecture ? 'selected' : '' }}>
                            {{ $prefecture }}
                        </option>
                    @endforeach
                </select>
                @error('region')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <label>狩猟免許の種類:</label>
            <div class="form-group">
                @foreach($licenses as $license)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="licenses[]" value="{{ $license->id }}" id="license_{{ $license->id }}">
                        <label class="form-check-label" for="license_{{ $license->id }}">
                            {{ $license->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            
            <div class="mb-3">
                <label class="form-label">狩猟免状の写真</label>
                <input type="file" name="license_image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">狩猟免状の有効期限</label>
                <input type="date" name="license_expiry" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">パスワード</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">パスワード確認</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">登録</button>
        </form>
    </div>
@endsection
