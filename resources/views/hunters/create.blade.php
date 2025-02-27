@extends('layouts.app')

@section('content')
    <div class="container">
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
                    <label>名前</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>電話番号</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>地域</label>
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

                <div class="form-group">
                    <label>狩猟免許の種類:</label>
                    <div class="license-buttons">
                        @foreach($licenses as $license)
                            <label class="license-option">
                                <input type="checkbox" name="licenses[]" value="{{ $license->id }}">
                                <span>{{ $license->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>


                <div class="form-group">
                    <label>狩猟免状の写真</label>
                    <input type="file" name="license_image" class="form-control">
                </div>

                <div class="form-group">
                    <label>狩猟免状の有効期限</label>
                    <input type="date" name="license_expiry" class="form-control">
                </div>

                <div class="form-group">
                    <label>パスワード</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>パスワード確認</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-submit">登録</button>
            </form>
        </div>
    </div>
@endsection
