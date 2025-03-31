@extends('layouts.app')

@section('content')
    <div class="container hunter-register-page">
        <div class="registration-form">
            <h1>ハンター登録</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('hunters.register') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">名前</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">電話番号</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="region">地域</label>
                    <select id="region" name="region" class="form-control" required>
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

                <!-- <div class="form-group">
                    <label>狩猟免許の種類:</label>
                    <div class="license-buttons">
                        @foreach($licenses as $license)
                            <label class="license-option">
                                <input type="checkbox" name="licenses[]" value="{{ $license->id }}">
                                <span>{{ $license->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div> -->
                <div class="form-group">
                    <label>狩猟免許の種類:</label>
                    <div class="license-buttons">
                        @foreach($licenses as $license)
                            <label class="license-option">
                                <input type="checkbox" name="licenses[]" value="{{ $license->id }}" 
                                    {{ is_array(old('licenses')) && in_array($license->id, old('licenses')) ? 'checked' : '' }}>
                                <span>{{ $license->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('licenses')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="license_image">狩猟免状の写真</label>
                    <input type="file" id="license_image" name="license_image" class="form-control">
                </div>

                <div class="form-group">
                    <label for="license_expiry">狩猟免状の有効期限</label>
                    <input type="date" id="license_expiry" name="license_expiry" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">パスワード確認</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-submit">登録</button>
            </form>
        </div>
    </div>
@endsection
