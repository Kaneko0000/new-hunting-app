@extends('layouts.app')

@section('content')
<div class="container">
    <h1>利用規約 & プライバシーポリシー</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h2>利用規約</h2>
            <p>本利用規約（以下、「本規約」）は、[アプリ名]（以下、「本サービス」）の提供者（以下、「運営者」）が、本サービスの利用条件を定めるものです。本サービスを利用するすべての方（以下、「利用者」）は、本規約に同意の上で本サービスを利用するものとします。</p>
            
            <h3>第1条（適用）</h3>
            <ol>
                <li>本規約は、利用者と運営者との間の本サービスの利用に関する一切の関係に適用されます。</li>
                <li>運営者は、本サービスに関し、本規約のほか、個別の利用ルール（以下、「個別規約」）を定めることがあります。個別規約は本規約の一部を構成するものとし、本規約と矛盾する場合は、個別規約が優先されます。</li>
            </ol>

            <h3>第2条（利用登録）</h3>
            <ol>
                <li>本サービスの利用には、利用者が必要な情報を登録し、運営者が承認する必要があります。</li>
                <li>運営者は、利用申請者に以下の事由があると判断した場合、登録を拒否することができます。
                    <ul>
                        <li>虚偽の情報を提供した場合</li>
                        <li>過去に本規約に違反したことがある場合</li>
                        <li>その他、運営者が不適切と判断した場合</li>
                    </ul>
                </li>
            </ol>

            <h3>第3条（アカウント管理）</h3>
            <ol>
                <li>利用者は、本サービスのアカウント情報を自己の責任で管理し、第三者に譲渡・貸与してはなりません。</li>
                <li>アカウントの不正利用による損害について、運営者は責任を負いません。</li>
            </ol>

            <h3>第4条（禁止事項）</h3>
            <p>利用者は、本サービスの利用にあたり、以下の行為を禁止します。</p>
            <ul>
                <li>法令または公序良俗に違反する行為</li>
                <li>虚偽の情報を登録する行為</li>
                <li>他の利用者の情報を不正に取得・利用する行為</li>
                <li>運営者のサービス運営を妨害する行為</li>
                <li>その他、運営者が不適切と判断する行為</li>
            </ul>

            <h3>第5条（データの取扱い）</h3>
            <ol>
                <li>本サービスに登録された狩猟記録は、利用者自身が管理し、必要に応じて編集・削除できます。</li>
                <li>運営者は、統計データとして利用するために、匿名化した情報を活用する場合があります。</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2>プライバシーポリシー</h2>
            <p>本プライバシーポリシー（以下、「本ポリシー」といいます。）は、[アプリ名]（以下、「本アプリ」といいます。）の利用において、ユーザーの個人情報の取り扱いについて定めるものです。</p>

            <h3>1. 収集する情報</h3>
            <ul>
                <li>氏名、メールアドレス、電話番号（任意）、住所・地域情報（任意）</li>
                <li>捕獲日時、捕獲場所（GPS位置情報、手入力情報）</li>
                <li>捕獲した動物の種類、天候情報、捕獲時のコメント、捕獲画像（任意）</li>
                <li>IPアドレス、使用デバイス、ブラウザの種類、アクセス日時</li>
            </ul>

            <h3>2. 情報の利用目的</h3>
            <p>本アプリは、収集した情報を以下の目的で利用します。</p>
            <ul>
                <li>ユーザー管理（認証、アカウント管理、承認処理）</li>
                <li>狩猟記録の保存・管理・統計分析</li>
                <li>本アプリの運営・改善・不具合対応</li>
                <li>ユーザーサポート、問い合わせ対応</li>
                <li>法令遵守のための対応</li>
            </ul>
        </div>
    </div>

    <form action="{{ route('terms.accept') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="terms" name="terms_accepted" value="1" required>
            <label class="form-check-label" for="terms">利用規約に同意します</label>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="privacy" name="privacy_accepted" value="1" required>
            <label class="form-check-label" for="privacy">プライバシーポリシーに同意します</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">同意して進む</button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
@endsection
