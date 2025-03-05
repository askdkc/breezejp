# Laravel Starter Kit 日本語化パッケージ：Breezejp

[![Latest Version on Packagist](https://img.shields.io/packagist/v/askdkc/breezejp.svg)](https://packagist.org/packages/askdkc/breezejp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/askdkc/breezejp/run-tests.yml?branch=main&label=tests)](https://github.com/askdkc/breezejp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/askdkc/breezejp/fix-php-code-style-issues.yml?branch=main&label=code%20style)](https://github.com/askdkc/breezejp/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/askdkc/breezejp.svg)](https://packagist.org/packages/askdkc/breezejp)
[![](https://img.shields.io/static/v1?label=Sponsor&message=%E2%9D%A4&logo=GitHub&color=%23fe8e86)](https://github.com/sponsors/askdkc)

### 2025/2/23： Laravel 12に対応しました🎉
[新しいスターターキット(Livewire版)もサポート](#laravel-12の新しいスターターキットlivewireのサポート)

## これは何？ TL;DR
Laravelの各種スターターキット（Livewire, Breeze, Jetstream, UI）を下記2コマンドだけで自動で日本語化できちゃうパッケージです👍
```bash
composer require askdkc/breezejp --dev

php artisan breezejp
```

> **メモ：Laravel Sail(Docker)を使って開発している人は下記コマンドになります**
> ```bash
> ./vendor/bin/sail composer require askdkc/breezejp --dev
> 
> ./vendor/bin/sail artisan breezejp
<br>

<img src="https://user-images.githubusercontent.com/7894265/198011737-c40cedc8-9f5d-4517-8407-93b2844bbeb2.gif" width="600">
<br>

また、下記1コマンドだけで言語切替機能も追加できます👍
```bash
php artisan breezejp --langswitch
```
> **メモ：Sailの場合**
> ```bash
> ./vendor/bin/sail artisan breezejp --langswitch
<br>

<img src="https://github.com/askdkc/breezejp/assets/7894265/d52738c5-c6ae-4f92-87ef-0046f8cff4f7" width="600">

便利だと思ったらサポートしてね

[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/X7X8O7KCU)

[![](https://img.shields.io/static/v1?label=Sponsor&message=%E2%9D%A4&logo=GitHub&color=%23fe8e86)](https://github.com/sponsors/askdkc)

## テーブルオブコンテンツ
- [はじめに](#はじめに)
- [使い方](#使い方)
  - [まずはBreezeのインストール](#まずはlaravel-breezeのインストール)
  - [そしてこのBreezejpパッケージのインストール](#そしてこのbreezejpパッケージのインストール)
  - [Laravelの言語設定やタイムゾーン設定が自動で行われます](#laravelの言語設定やタイムゾーン設定が自動で行われます)
  - [動作確認](#動作確認)
- [日本語のカスタマイズ](#日本語のカスタマイズ)
- [テスト方法](#テスト方法)
- [メールのテスト方法](#メールのテスト方法)
  - [mailpitを使うやり方](#mailpitを使うやり方)
  - [mailhogを使うやり方](#mailhogを使うやり方)
  - [mailtrapを使うやり方](#mailtrapを使うやり方)
- [Laravel Langと何が違うの？](#laravel-langと何が違うの)
- [おまけ](#おまけ)
- [言語切り替えサンプルアプリ](#言語の切り替えサンプルアプリ)
- [言語切替機能のインストール](#言語の切り替え機能のインストール)
- [変更履歴](#変更履歴)
- [貢献について](#貢献について)
- [セキュリティや脆弱性について](#セキュリティや脆弱性について)
- [貢献者](#貢献者)
- [ライセンス](#ライセンス)
- [パッケージ作りに興味がある人は](#パッケージ作りに興味がある人は)

## はじめに
このパッケージはLaravel Breezeを日本語化するパッケージとして誕生しましたが、現在ではLaravel 12のスターターキット(Livewire版)、Breeze、Jetstream、Laravel UIに対応しています😁 また、Laravelが持つ各種バリデーションメッセージを日本語化するので、Breeze等をインストールしていない環境でも実は便利に使えます😏<br>
<br>
基本的な機能を確認するにはLaravelのスターターキットのいずれかをインストールした後にこのパッケージをインストールしてください（以降の使い方の解説がその前提で書かれているため）<br><br>
動作としてはLaravelの`lang`ディレクトリ配下に日本語化に必要な翻訳ファイルを出力し、config内の言語設定も自動で日本語に変えています🇯🇵<br>


> **翻訳について：**<br>
> 翻訳内容を修正したい場合には、このREADMEの[日本語のカスタマイズ](#日本語のカスタマイズ)をご確認願います🙇‍♂️

## 使い方
### まずはLaravel Breezeのインストール
```bash
composer require laravel/breeze --dev

php artisan breeze:install blade --dark
```

(もしダークモードが不要な人は👇のように末尾の --darkオプション無しで実行してね)

```bash
php artisan breeze:install blade

php artisan migrate
```

### そしてこのBreezejpパッケージのインストール

composerを使ってインストールしてください:

```bash
composer require askdkc/breezejp --dev
```

下記のコマンドで必要な言語ファイルの出力が実行されます:

```bash
php artisan breezejp
```

出力内容：

```bash
Laravel Breeze用に日本語翻訳ファイルを準備します
config/app.phpのlocaleをjaにします

 GitHubリポジトリにスターの御協力をお願いします🙏 (yes/no) [yes]: 
 
 (ブラウザが開いてこのGitHubリポが開きます。スター頂けると励みになります)
 
 Thank you! / ありがとう💓
日本語ファイルのインストールが完了しました!
```

### Laravelの言語設定やタイムゾーン設定が自動で行われます
Breezejpは`php artisan breezejp`コマンド実行時にLaravelの設定ファイル`.env`のlocaleを自動でenからjaに変更します👍

ついでにTimezoneの設定も日本向けに直します🕛

具体的にはインストール時に自動でこうなりますので、特に何もしないでもOK👀✨💓

---`.env`:インストール前---
```vim
'APP_TIMEZONE=UTC'

'APP_LOCALE=en'

'APP_FAKER_LOCALE=en_US'
```

↓ `php artisan breezejp` の実行後

---`config/app.php`:インストール後---
```vim
'APP_TIMEZONE=Asia/Tokyo'

'APP_LOCALE=ja'

'APP_FAKER_LOCALE=ja_JP'
```

---`config/app.php`:インストール前---
```vim
'timezone' => 'UTC',
```

↓ `php artisan breezejp` の実行後

---`config/app.php`:インストール後---
```vim
'timezone' => 'Asia/Tokyo',
```

### 動作確認
LaravelにアクセスするとBreezeの各メニューやバリデーションメッセージが日本語化されています

Laravelを起動して
```bash
php artsan serve
```

[http://localhost:8000/](http://localhost:8000/) にアクセス

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
<br>

- Breezejp v1.64からページネーションの日本語化にも対応しました
<br>
<img width="1066" alt="pagination" src="https://github.com/askdkc/breezejp/assets/7894265/7c86fb75-fcb2-4091-81e9-e5ac60fbfff9">
<br>

### Laravel 12の新しいスターターキット(Livewire)のサポート

Laravel 12からの新しいLivewire版スターターキットに自分が送った多言語対応への追加修正PR([#24](https://github.com/laravel/livewire-starter-kit/pull/24)と[#39](https://github.com/laravel/livewire-starter-kit/pull/39))がマージされたので、全体的に日本語化対応が進みました🎉

<img width="713" alt="image" src="https://github.com/user-attachments/assets/fd3e584c-8a21-44a3-b9f7-f8a14a5822cb" />

## パッケージの更新
Laravelで新規のバリデーションルールが追加された際に、情報が追えていれば、このパッケージも更新します

新たな翻訳ファイルを適用したい場合には以下のようにします
```bash
composer update
php artisan breezejp
```
> **注意：**
> 次のセクションの「日本語のカスタマイズ」をしている時は、Breezejpの新規テンプレートで言語ファイルが上書きされますので、この上書きインストールは実施せずに個別修正で対応願います

## 日本語のカスタマイズ
言語ファイルは下記ディレクトリに出力されていますので、こちらのファイルの中身を修正することで自由にカスタマイズ可能です
```
.
└─ lang
   ├── ja.json ← Breezeの各画面の日本語ファイル / メール通知の翻訳もこちら
   └─ ja
       ├── auth.php ← 認証画面の警告メッセージの日本語ファイル
       ├── pagination.php ← ページ送りの日本語ファイル
       ├── passwords.php ← 認証画面のパスワード関係の日本語ファイル
       └── validation.php ← 各種バリデーションの日本語ファイル
```

## テスト方法

```bash
composer test
composer analyse
```

## メールのテスト方法
Laravel Breeze(Laravel UI、そしてJetstream)はユーザ登録されたメールアドレスを確認するメールやパスワードリセットをユーザ自身で出来るパスワードリセットメールを送信します


### mailpitを使うやり方
mailpitを使えば上記のメールの日本語化が問題なく出来ているかをお手軽に可能です<br>
(`MAIL_MAILER=log`という方法もありますが、日本語はlogファイル内で文字化けてしまい辛い🫠)

> **メモ：**
> 2023/2/1にLaravelの`.env`のサンプルが[mailhogからmailpitに変更されました](https://github.com/laravel/laravel/commit/6092ff46b3d5e4436948b8d576894b51955f3a5e) <br>
> mailpitは旧来のmailhogの機能強化版ですが、[使い方は一緒です](#mailhogを使うやり方)

- Laravelは標準の`.env`ファイルにmailpitを使用するサンプルが書かれているので、こいつをちょっといじります

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

- macOSの場合は[Homebrew](https://brew.sh)をお使いだと思うので、brewでmailpitを入れます(まだ入れてないなら)

```bash
brew tap axllent/apps
brew install mailpit
```
> **メモ：Macじゃない人は[こちら](https://www.apple.com/jp/)**
<br>

- mailpitを起動します

```bash
mailpit
```
> **メモ：(初回はネットワーク接続を許可する？とポップアップが出るので許可してください)**
<br>

- メール送信テスト

Breezeの`log in` > `パスワード忘れた？`リンクから登録に使用したメールアドレスを入力しパスワードリセットリンクを送信します

<img width="969" alt="image" src="https://user-images.githubusercontent.com/7894265/217967834-11c95cf5-322d-4d25-bfe4-0547de95e324.png">

- mailpit確認画面にアクセスします

ブラウザを開いて[http://localhost:8025](http://localhost:8025)にアクセスします

<img width="1310" alt="image" src="https://user-images.githubusercontent.com/7894265/217968231-73bbb044-ebf3-4a65-91ab-251e8fb2b2d3.png">

便利💓

### mailhogを使うやり方
mailpitに置き換わるまではLaravelではmailhogを使ったメールテストのやり方が一般的でした<br>
(mailpitはこのmailhogが元になっているので使い方が完全に一緒です)

- `.env`ファイルを下記のようにちょっといじります

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

このBreezejpパッケージのメリットとしては、今のところ次の3点です:

- `breezejp`コマンド一発で言語設定含めて日本語化完了（手間が段違い）
- この日本語READMEの分かりやすさ（そうであって欲しい）
- Breezeが送るメールに余計なカンマが含まれたりする👇部分が修正されてる（ときめかないカンマ全部消した💅）
<img width="640" alt="image" src="https://user-images.githubusercontent.com/7894265/198923216-ded83143-6f99-44d8-a5d1-50afeba59940.png">

あとはLaravel Langと動きも殆ど一緒（単に言語ファイルをlangに作ってくれる）なので、出力されたファイルを必要に応じて自由にカスタマイズしてご利用願います💓

## おまけ
ついでにJetstreamの日本語化もできちゃいます🤫

<img width="640" alt="jetstream" src="https://user-images.githubusercontent.com/7894265/208773006-2feea23e-ca45-4d40-9911-49f03db9ed4d.png">


## 言語の切り替えサンプルアプリ
せっかく日本語に対応したので、例えば元の英語と日本語を切り替えられる方が便利よね？となるかと思います😁

そのためのサンプルアプリ:[Language Switcher Sample (言語切り替えサンプル)](https://github.com/askdkc/laravel-language-switcher)を作成しましたので、ご参考にしてください💓

![251501263-d807d110-971e-44c0-a284-9e1b57c73894](https://github.com/askdkc/breezejp/assets/7894265/d52738c5-c6ae-4f92-87ef-0046f8cff4f7)

## 言語の切り替え機能のインストール
サンプルアプリなんて面倒だよ、さっさと言語切り替え使いたいよ！という人のために、言語切り替え機能をインストールする方法をご紹介します🤗

```bash
php artisan breezejp --langswitch
```

後は `/language/{locale}` にアクセスするだけで言語が切り替わるので、そこを叩くリクエストを送ってご利用ください

#### Laravelアプリの起動

```bash
php artisan serve
```

- 日本語に切り替える例

```
http://127.0.0.1:8000/language/ja
```

- 英語に切り替える例

```
http://127.0.0.1:8000/language/en
```

これでLaravel Breezeの各種メニューの言語が切り替わるのが確認できると思います🤯


簡単でしょ？😁

## 変更履歴

最近の変更履歴については[CHANGELOG](CHANGELOG.md)を参照してください

## 貢献について

このパッケージに貢献したい人は[CONTRIBUTING](CONTRIBUTING.md)を参考にしてください

## セキュリティや脆弱性について

[セキュリティポリシー](../../security/policy)を見て、必要な情報を送ってくれると助かります

## 貢献者

- [askdkc](https://github.com/askdkc)
- [nshiro](https://github.com/nshiro)
- [All Contributors](../../contributors)

## ライセンス

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## パッケージ作りに興味がある人は

[こちらにパッケージの作り方を書いた](https://github.com/askdkc/create-laravel-package)ので参考にしてみてね
