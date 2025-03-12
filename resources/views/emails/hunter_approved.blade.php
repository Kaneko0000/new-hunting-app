<!DOCTYPE html>
<html>
<head>
    <title>【狩猟アプリ】登録承認のお知らせ</title>
</head>
<body>
    <h1>{{ $hunter->name }} さん</h1>
    <p>おめでとうございます！あなたの登録が管理者によって承認されました。</p>
    <p>狩猟アプリにログインし、機能を利用開始してください。</p>
    <p>
        <a href="{{ url('/hunters/login') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            ログインページへ
        </a>
    </p>
</body>
</html>
