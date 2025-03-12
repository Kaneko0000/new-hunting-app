@extends('layouts.admin')
@section('title', '管理者用ハンター一覧')

@section('content')
    <h1 class="mb-4 mt-55 pb-2 text-center">
        管理者用ハンター一覧
    </h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" action="{{ route('admin.hunters.index') }}" class="d-flex">
            <input type="text" name="name" class="form-control me-2" placeholder="名前で検索" value="{{ request('name') }}" style="width: 200px;">
            <select name="region" class="form-control me-2" style="width: 200px;">
                <option value="">地域で検索</option>
                @foreach($prefectures as $prefecture)
                    <option value="{{ $prefecture }}" {{ request('region') == $prefecture ? 'selected' : '' }}>
                        {{ $prefecture }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary me-2">検索</button>
            <a href="{{ route('admin.hunters.index') }}" class="btn btn-secondary">リセット</a>
        </form>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>Email</th>
                <th>電話番号</th>
                <th>地域</th>
                <th>狩猟免許の種類</th>
                <th>ステータス</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hunters as $hunter)
                <tr>
                    <td>{{ $hunter->id }}</td>
                    <td>{{ $hunter->name }}</td>
                    <td>{{ $hunter->email }}</td>
                    <td>{{ $hunter->phone }}</td>
                    <td>{{ $hunter->region }}</td>
                    <td>
                        @foreach($hunter->licenses as $license)
                            <span class="badge bg-success">{{ $license->name }}</span><br>
                        @endforeach
                    </td>
                    <td>
                        @if($hunter->status === 'approved')
                            <span class="badge bg-success">承認済み</span>
                        @else
                            <form method="POST" action="{{ route('admin.hunters.approve', ['id' => $hunter->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm px-3 py-1">承認</button>
                            </form>
                        @endif
                    </td>
                    <td class="d-flex gap-2 justify-content-center align-items-center">
                        <form action="{{ route('admin.hunters.destroy', $hunter->id) }}" method="POST" class="m-0 p-0 d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-action">削除</button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection