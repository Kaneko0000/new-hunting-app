<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>狩猟アプリ トップページ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        .hero-section {
            background: url('/path/to/your-image.jpg') center/cover no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            position: relative;
        }
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .btn-custom {
            margin: 10px;
        }
        .section {
            padding: 50px 0;
        }
        .weather-widget, .news-section, .app-intro {
            text-align: center;
        }
        .bg-cover {
        transition: transform 0.5s ease;
        }
        .bg-cover:hover {
            transform: scale(1.05);
        }
    </style>
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
            <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in">狩猟の世界へようこそ</h1>
            <p class="text-lg md:text-2xl mb-6 animate-slide-up">狩猟記録、コミュニティ交流、最新情報がここに。</p>
            <a href="{{ url('/register') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition transform hover:scale-105 animate-bounce">今すぐ参加</a>
        </div>
    </section>

    <!-- 天気予報セクション -->
    <section class="section weather-widget bg-light">
        <div class="container">
            <h2 class="mb-4">現地の天気予報</h2>
            <!-- 天気APIをここに埋め込み -->
            <iframe src="https://www.jma.go.jp/bosai/forecast/#area_type=offices&area_code=430000" width="100%" height="300" frameborder="0"></iframe>
        </div>
    </section>

    <!-- アプリ紹介セクション -->
    <section class="section app-intro">
        <div class="container">
            <h2 class="mb-4">アプリの特徴</h2>
            <p>狩猟記録、天気情報、狩猟コミュニティとつながるための機能が満載。</p>
            <div class="row">
                <div class="col-md-4">
                    <h4>狩猟記録</h4>
                    <p>日付や場所、捕獲情報を簡単に記録可能。</p>
                </div>
                <div class="col-md-4">
                    <h4>コミュニティ</h4>
                    <p>他のハンターと交流し、情報交換を行いましょう。</p>
                </div>
                <div class="col-md-4">
                    <h4>最新ニュース</h4>
                    <p>狩猟に関する最新のニュースや法律情報を提供。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ニュースセクション -->
    <section class="section news-section bg-light">
        <div class="container">
            <h2 class="mb-4">最新の狩猟ニュース</h2>
            <ul class="list-group">
                <li class="list-group-item">狩猟法の改正についての最新情報</li>
                <li class="list-group-item">地域の狩猟イベントスケジュール</li>
                <li class="list-group-item">新しい狩猟装備のレビュー</li>
            </ul>
        </div>
    </section>

    <!-- お問い合わせフォーム -->
    <section class="section bg-dark text-white" id="contact">
        <div class="container">
            <h2 class="mb-4">お問い合わせ</h2>
            <form action="/contact" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">お名前</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">お問い合わせ内容</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-outline-light">送信</button>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
