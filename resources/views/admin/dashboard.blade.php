@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>管理者ダッシュボード</h1>
        <p>ここでハンターの管理やニュース投稿ができます。</p>

        <h2>ハンター一覧</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>Email</th>
                    <th>承認ステータス</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hunters as $hunter)
                    <tr>
                        <td>{{ $hunter->id }}</td>
                        <td>{{ $hunter->name }}</td>
                        <td>{{ $hunter->email }}</td>
                        <td>{{ $hunter->status === 'approved' ? '承認済み' : '未承認' }}</td>
                        <td>
                            @if($hunter->status !== 'approved')
                                <form action="{{ route('hunters.approve', $hunter->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">承認</button>
                                </form>
                            @else
                                <span class="text-success">承認済み</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
