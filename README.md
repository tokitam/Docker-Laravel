# Laravel開発環境@Docker

## 概要

LaraDockを使う方法がありましたが、少々大きすぎるので必要最小限のものを自分で用意したくで作ってみました。<br>

### Docker環境

 - Docker-Desctop 2.0.0.2 
 - docker-compose 1.23.2

### 構築環境

 - php:7.2.12-fpm
 - nginx:1.15.6
 - mysql:5.7

### 参考

 - [Laravelの環境（Nginx+MySQL+PHP）をdocker-composeでイチから作るチュートリアル](https://windii.jp/backend/laravel/laravel-with-docker-compose)
 - [DockerのMySQLイメージ起動時に渡す環境変数](https://qiita.com/nanakenashi/items/180941699dc7ba9d0922)

## 手順

### Git cloneと環境変数の変更

```
git clone https://github.com/rinonkia/Docker-Laravel.git sample_app
```
`sample_app`を任意の名前にする。<br>

```.env:.env_db
MYSQL_RANDOM_ROOT_PASSWORD=yes

MYSQL_DATABASE=sample
MYSQL_USER=user
MYSQL_PASSWORD=password
```

MySQLの環境変数は任意で変更する。<br>
`.gitignore`も任意で変更。<br>

## Docker composeの実行

```shell
cd sample_app
docker-compose build
```

