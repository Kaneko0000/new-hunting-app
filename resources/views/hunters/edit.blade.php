@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>ハンター情報編集</h1>
        <form action="{{ route('hunters.update', $hunter->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">名前</label>
                <input type="text" name="name" class="form-control" value="{{ $hunter->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $hunter->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">電話番号</label>
                <input type="text" name="phone" class="form-control" value="{{ $hunter->phone }}">
            </div>
            <div class="mb-3">
                <label class="form-label">地域</label>
                <select name="region" class="form-control" required>
                  <option value="">選択してください</option>
                  @foreach($prefectures as $prefecture)
                    <option value="{{ $prefecture }}" {{ old('region', $hunter->region ?? '') ==$prefecture ? 'selected' : '' }}>
                      {{ $prefecture }}
                    </option>
                  @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">狩猟免許の種類</label><br>
                @foreach ($licenses as $license)
                    <div class="form-check form-check-inline">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="licenses[]" 
                            value="{{ $license->id }}" 
                            {{ in_array($license->id, $hunterLicenses) ? 'checked' : '' }}
                        >
                        <label class="form-check-label">{{ $license->name }}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
@endsection
