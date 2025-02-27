<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>狩猟アプリ トップページ</title>]

    <!-- ✅ ViteでCSSを適用 -->
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">狩猟アプリ</a>
            <div class="collapse navbar-collapse justify-content-end">
                <!-- <a href="{{ route('hunters.login') }}" class="btn btn-outline-light me-2">ログイン</a>
                <a href="{{ route('hunters.register') }}" class="btn btn-success">新規登録</a> -->
            </div>
        </div>
    </nav>


    <!-- ヒーローセクション -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">狩猟の世界へようこそ</h1>
            <p class="hero-subtitle">狩猟記録、コミュニティ交流、最新情報がここに。</p>

            <!-- 🟢 メインの「今すぐ参加」ボタン -->
            <a href="{{ route('hunters.register') }}" class="btn btn-primary hero-button">今すぐ参加</a>

            <!-- 🔵 既にアカウントがある人向け「ログイン」ボタン -->
            <a href="{{ route('hunters.login') }}" class="btn btn-outline-light hero-button">ログイン</a>
        </div>
    </section>


    <!-- 天気予報セクション -->
    <section class="weather-widget">
        <!-- <div class="container">
            <h2 class="weather-title">現地の天気予報</h2>
            <iframe src="https://www.jma.go.jp/bosai/forecast/#area_type=offices&area_code=430000" width="100%" height="300" frameborder="0"></iframe>
        </div> -->
        <div id="ww_e6e54da46e54d" v='1.3' loc='id' a='{"t":"horizontal","lang":"ja","sl_lpl":1,"ids":[],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'>More forecasts: <a href="https://oneweather.org/ja/tokyo/10_days/" id="ww_e6e54da46e54d_u" target="_blank">10日間天気 東京</a></div><script async src="https://app3.weatherwidget.org/js/?id=ww_e6e54da46e54d"></script>
    </section>

</body>
</html>
