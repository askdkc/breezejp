# Laravel Breeze 日本語化パッケージ

[![Latest Version on Packagist](https://img.shields.io/packagist/v/askdkc/breezejp.svg?style=flat-square)](https://packagist.org/packages/askdkc/breezejp)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/askdkc/breezejp/run-tests?label=tests)](https://github.com/askdkc/breezejp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/askdkc/breezejp/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/askdkc/breezejp/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/askdkc/breezejp.svg?style=flat-square)](https://packagist.org/packages/askdkc/breezejp)

このパッケージはLaravel Breezeを日本語化するパッケージです。
Laravel Breezeをインストールした後に最初にインストールしてください。
後からインストールすると既存の言語ファイルを上書きするため、ご自身の修正が消えてしまう場合があります。

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
 (良かったらこちらのGitHubリポにスター頂けると励みになります)
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
