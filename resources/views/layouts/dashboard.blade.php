<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ハンター管理システム')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">ハンター管理</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">管理者ダッシュボード</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('hunters.dashboard') }}">ハンターダッシュボード</a></li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    <!-- @guest
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-primary btn-sm me-2">ログイン</a></li>
                        <li class="nav-item"><a href="{{ route('hunters.create') }}" class="btn btn-success btn-sm">新規登録</a></li>
                    @else -->
                        <li class="nav-item">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger btn-sm">
                                ログアウト
                            </a>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    <!-- @endguest -->
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
