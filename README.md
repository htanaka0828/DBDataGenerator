# テストデータジェネレータ
テストデータ生成スクリプト

設計無しに自分用に適当に作ったものを公開

カスタマイズは各自でお願いします

## 必要な環境
* php
* PDOドライバ
* MySQL(別サーバでも可\)

## 初期設定
まずはDBの設定をする

db.php

```php
// @todo 最初にこいつらを設定してあげてね！！
const DB_HOST = 'localhost';
const DB_USER = 'admin';
const DB_PASS = 'admin';
const DB_NAME = 'test';
```
次にutil.phpの初期化フラグをtrueにする

```php
// @todo 最初にこいつをtrueにしてあげてね
const initCheck = false;
```

とりあえずはこれでOK

## 起動方法
### 一行ずつ入れる
作業ディレクトリに入り

`php index.php`

これで起動

対象のDBのテーブル一覧が取得出来るので

番号を入力して1カラムずつ値を入力してあげるだけ

### 複数行一気に入れる
サンプルは「tables/user.php」です。

詳細はコードを見て下しあ＞＜

Abstクラスを継承してあげれば結構汎用的に色々なデータを作り出せます。

パラメータの設定は「user::getNextVal」を参照
