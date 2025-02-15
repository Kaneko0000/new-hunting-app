<!DOCTYPE html>
<html>
<head>
    <title>新規ハンター登録のお知らせ</title>
</head>
<body>
    <h1>新規ハンター登録がありました</h1>
    <p>以下の情報で新規登録がありました。</p>
    <ul>
        <li><strong>名前:</strong> {{ $hunter->name }}</li>
        <li><strong>Email:</strong> {{ $hunter->email }}</li>
        <li><strong>電話番号:</strong> {{ $hunter->phone }}</li>
        <li><strong>地域:</strong> {{ $hunter->region }}</li>
    </ul>
    <p><a href="{{ url('/admin/hunters') }}">管理画面で確認</a></p>
</body>
</html>
