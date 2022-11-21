# Laravel Breeze 日本語化パッケージ：Breezejp

[![Latest Version on Packagist](https://img.shields.io/packagist/v/askdkc/breezejp.svg?style=flat-square)](https://packagist.org/packages/askdkc/breezejp)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/askdkc/breezejp/run-tests?label=tests)](https://github.com/askdkc/breezejp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/askdkc/breezejp/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/askdkc/breezejp/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/askdkc/breezejp.svg?style=flat-square)](https://packagist.org/packages/askdkc/breezejp)

## テーブルオブコンテンツ
- [はじめに](#はじめに)
- [使い方](#使い方)
  - [まずはBreezeのインストール](#まずはlaravel-breezeのインストール)
  - [そしてこのBreezejpパッケージのインストール](#そしてこのbreezejpパッケージのインストール)
  - [Laravelの言語設定](#laravelの言語設定)
  - [動作確認](#動作確認)
- [日本語のカスタマイズ](#日本語のカスタマイズ)
- [テスト方法](#テスト方法)
- [メールのテスト方法](#メールのテスト方法)
  - [mailhogを使うやり方](#mailhogを使うやり方)
  - [mailtrapを使うやり方](#mailtrapを使うやり方)
- [Laravel Langと何が違うの？](#laravel-langと何が違うの)
- [変更履歴](#変更履歴)
- [貢献について](#貢献について)
- [セキュリティや脆弱性について](#セキュリティや脆弱性について)
- [貢献者](#貢献者)
- [ライセンス](#ライセンス)

## はじめに
このパッケージはLaravel Breezeを日本語化するパッケージです。<br>
Laravel Breezeをインストールした後にインストールしてください。<br>
翻訳ファイルをLaravelの`lang`ディレクトリ配下に出力して日本語化していますので、詳しくはこのREADMEの[日本語のカスタマイズ](#日本語のカスタマイズ)をご確認願います。

<img src="https://user-images.githubusercontent.com/7894265/198011737-c40cedc8-9f5d-4517-8407-93b2844bbeb2.gif" width="600">


## 使い方
### まずはLaravel Breezeのインストール
```bash
composer require laravel/breeze --dev
php artisan breeze:install

php artisan migrate
```

### そしてこのBreezejpパッケージのインストール
#### (このパッケージのインストールよりも先に上記のLaravel Breezeをインストール願います)

composerを使ってインストールしてください:

```bash
composer require askdkc/breezejp --dev
```

下記のコマンドで必要な言語ファイルの出力が実行されます:

```bash
php artisan breezejp

出力内容：
Laravel Breeze用に日本語翻訳ファイルを準備します

 GitHubリポジトリにスターの御協力をお願いします🙏 (yes/no) [yes]: 
 
 (ブラウザが開いてこのGitHubリポが開きます。スター頂けると励みになります)
 
 Thank you! / ありがとう💓
日本語ファイルのインストールが完了しました!
```

### Laravelの言語設定
Laravelの設定ファイル`config/app.php`で日本語を選択します

```vim
---before---
'locale' => 'en',
------------
↓
---after---
'locale' => 'ja',
-----------
```

### 動作確認
LaravelにアクセスするとBreezeの各メニューやバリデーションメッセージが日本語化されています

```php
php artsan serve

http://localhost:8000/ にアクセス
```

- ユーザ登録画面
<img width="1062" alt="image" src="https://user-images.githubusercontent.com/7894265/197683533-194da23f-01e1-4f76-a2ec-3ee6412e3c93.png">

- ログイン画面
<img width="1062" alt="image" src="https://user-images.githubusercontent.com/7894265/197683653-e58c4f46-ad2a-458b-86a9-96b428f0c711.png">

- 各種警告メッセージも日本語化されてます
<img width="1062" alt="image" src="https://user-images.githubusercontent.com/7894265/197683736-701ed978-9cf3-43e1-9f27-0961e760489e.png">

- Breezeから送信されるメールアドレス確認通知メールの日本語化や
<img width="803" alt="image" src="https://user-images.githubusercontent.com/7894265/198680835-d6ad3cfa-af92-46dc-9f3c-ea30f7e7c94e.png">

- パスワードリセット通知のメールの日本語化も対応
<img width="803" alt="image" src="https://user-images.githubusercontent.com/7894265/198681087-3847b5f8-98c5-4b3f-b8b7-444167e1e6b8.png">

- breeze v1.15から追加されたProfile画面の日本語化も対応
<img width="1328" alt="image" src="https://user-images.githubusercontent.com/7894265/202038869-b1f6a9e0-fcf5-4618-b036-6f7d263a8742.png">


## 日本語のカスタマイズ
言語ファイルは下記ディレクトリに出力されていますので、こちらのファイルの中身を修正することで自由にカスタマイズ可能です
```
.
└─ lang
   ├── ja.json ← Breezeの各画面の日本語ファイル / メール通知の翻訳もこちら
   └─ ja
       ├── auth.php ← 認証画面の警告メッセージの日本語ファイル
       ├── pagination.php ← ページ送りの日本語ファイル
       ├── auth.php ← 認証画面のパスワード関係の日本語ファイル
       └── validation.php ← 各種バリデーションの日本語ファイル
```

## テスト方法

```bash
composer test
composer analyse
```

## メールのテスト方法
Breezeはユーザ登録されたメールアドレスを確認するメールやパスワードリセットをユーザ自身で出来るパスワードリセットメールを送信します

### mailhogを使うやり方
これらのメールの日本語化が出来てるかをmailhogを使えばお手軽に可能です<br>
(`MAIL_MAILER=log`という方法もありますが、日本語はlogファイル内で文字化けてしまい辛い🫠)

- Laravelは標準の`.env`ファイルにmailhogを使用するサンプルが書かれているので、こいつをちょっといじります

```vim
MAIL_MAILER=smtp
MAIL_HOST=localhost //ここをlocalhostに変えてね
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

- macOSの場合は[Homebrew](https://brew.sh)をお使いだと思うので、brewでmailhogを入れます(まだ入れてないなら)

```bash
brew install mailhog
```
> **メモ：Macじゃない人は[こちら](https://www.apple.com/jp/)**
<br>

- mailhogを起動します

```bash
mailhog
```
> **メモ：(初回はネットワーク接続を許可する？とポップアップが出るので許可してください)**
<br>

- mailhog確認画面にアクセスします

ブラウザを開いて[http://localhost:8025](http://localhost:8025)にアクセスします

<img width="1170" alt="image" src="https://user-images.githubusercontent.com/7894265/198750115-30c28afe-b239-4ff3-b844-5c96238f18c0.png">

あら、便利💓

### mailtrapを使うやり方
古いバージョンのLaravelではMailtrapが`.env`にサンプルで書かれていたので、Mailtrapを使う方法も書いておきます

- まずはサインアップ


[Mailtrap](https://mailtrap.io)にアクセスしてサインアップします（GitHubアカウント連携とか楽で良いです）
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857616-cd1ca19c-51a3-4144-9586-97cdffa8925b.png">

- メールボックスの作成
Sandboxにある`Setup Inbox`をクリックします
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857638-3b6a1d66-6f0d-43ef-a714-94ac40b2dc20.png">

- 右上にある`Add Project`をクリックします
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857675-85948f68-80ee-4081-ab8a-099b6cfb4ec6.png">

- Project Nameを適当に入力（Laravelとか）して`Add`をクリックします
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857688-333cebbc-e87c-484e-bbf0-bb99e698eb3b.png">

- Add Inboxをクリックしてインボックスを作成します
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857709-37adc06b-916e-4a2b-b81c-8f6c0dd56b3e.png">

<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857714-2d36405c-1ef8-473c-996c-b17dd4e7cff8.png">

- 作成したインボックスをクリックします
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857735-26a32e37-7cff-4af5-92e2-530db944149e.png">

- Integrationsをクリックして`Laravel 7+`を選択します
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857783-b8e70965-eb66-4d3a-999f-c361062f281a.png">

- Laravelの`.env`用の認証情報が表示されます (*下記の情報はサンプルで既に破棄済みです)
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198857811-77dbd6f7-fa84-4cbc-af83-c344c84ddc25.png">

`.env`ファイルの下記をMailtrapの認証情報に合わせて変更します

```vim
MAIL_MAILER=smtp //mailtrapを貼り付け
MAIL_HOST=smtp.mailtrap.io //mailtrapを貼り付け
MAIL_PORT=2525  //mailtrapを貼り付け
MAIL_USERNAME=生成されたUSERNAME  //mailtrapを貼り付け
MAIL_PASSWORD=生成されたPASSWORD  //mailtrapを貼り付け
MAIL_ENCRYPTION=tls  //mailtrapを貼り付け
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

- メールを送るとMailtrapのインボックス内に表示されます
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198858006-31db2c44-8fab-4b16-af08-7e28ba0c1b02.png">

あらあら、便利💓


## Laravel Langと何が違うの？

確かに🦀　[https://laravel-lang.com](https://laravel-lang.com)ってのが世の中にありましたね。。。<br>
（作る前に存在を知っておけば良かったぜ🤦‍♂️）

このBreezejpパッケージのメリットとしては、今のところ次の2点です:

- この日本語READMEの分かりやすさ（そうであって欲しい）
- Breezeが送るメールに余計なカンマが含まれたりする👇部分が修正されてる（ときめかないカンマ全部消した💅）
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198923216-ded83143-6f99-44d8-a5d1-50afeba59940.png">

あとはLaravel Langと動きも殆ど一緒（単に言語ファイルをlangに作ってくれる）なので、出力されたファイルを必要に応じて自由にカスタマイズしてご利用願います💓

## 変更履歴

最近の変更履歴については[CHANGELOG](CHANGELOG.md)を参照してください

## 貢献について

このパッケージに貢献したい人は[CONTRIBUTING](CONTRIBUTING.md)を参考にしてください

## セキュリティや脆弱性について

[セキュリティポリシー](../../security/policy)を見て、必要な情報を送ってくれると助かります

## 貢献者

- [askdkc](https://github.com/askdkc)
- [All Contributors](../../contributors)

## ライセンス

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
