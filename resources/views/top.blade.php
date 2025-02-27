<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>狩猟アプリ トップページ</title>

    <!-- ✅ ViteでCSSを適用 -->
    @vite(['resources/css/app.css', 'resources/css/custom.css'])

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">狩猟アプリ</a>
            <div class="collapse navbar-collapse justify-content-end">
                <a href="/login" class="btn btn-outline-light btn-custom">ログイン</a>
                <a href="/hunters/create" class="btn btn-outline-light btn-custom">新規登録</a>
                <a href="#contact" class="btn btn-outline-light btn-custom">お問い合わせ</a>
            </div>
        </div>
    </nav>

    <!-- ヒーローセクション -->
    <section class="relative bg-cover bg-center h-screen" style="background-image: url('{{ asset('images/top-1.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">狩猟の世界へようこそ</h1>
            <p class="text-lg md:text-2xl mb-6">狩猟記録、コミュニティ交流、最新情報がここに。</p>
            <a href="{{ url('/register') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition transform hover:scale-105">今すぐ参加</a>
        </div>
    </section>

    <!-- ✅ ViteでJSを適用 -->
    @vite(['resources/js/app.js', 'resources/js/custom.js'])

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
