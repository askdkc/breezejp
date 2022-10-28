# Laravel Breeze 日本語化パッケージ

[![Latest Version on Packagist](https://img.shields.io/packagist/v/askdkc/breezejp.svg?style=flat-square)](https://packagist.org/packages/askdkc/breezejp)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/askdkc/breezejp/run-tests?label=tests)](https://github.com/askdkc/breezejp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/askdkc/breezejp/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/askdkc/breezejp/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/askdkc/breezejp.svg?style=flat-square)](https://packagist.org/packages/askdkc/breezejp)

このパッケージはLaravel Breezeを日本語化するパッケージです。<br>
Laravel Breezeをインストールした後にインストールしてください。<br>
翻訳ファイルをLaravelの`lang`ディレクトリ配下に出力して日本語化していますので、詳しくはこのREADMEの[日本語のカスタマイズ](#日本語のカスタマイズ)をご確認願います。

## インストール

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

## 使い方
### Laravel Breezeのインストール
```bash
composer require laravel/breeze --dev
php artisan breeze:install

php artisan migrate
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
<img width="808" alt="image" src="https://user-images.githubusercontent.com/7894265/197893902-40d723bf-c9a4-4886-82a7-93beb7fcf13d.png">

- パスワードリセット通知のメールの日本語化も対応
<img width="808" alt="image" src="https://user-images.githubusercontent.com/7894265/197893683-b83215b3-6e0f-4e5d-816e-b13093ea8b32.png">


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
```

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
