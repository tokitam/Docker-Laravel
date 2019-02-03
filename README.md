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
$ git clone https://github.com/rinonkia/Docker-Laravel.git sample_app
```
`sample_app`を任意の名前にする。<br>

```
//.env_db

MYSQL_RANDOM_ROOT_PASSWORD=yes

MYSQL_DATABASE=sample
MYSQL_USER=user
MYSQL_PASSWORD=password
```

MySQLの環境変数は任意で変更する。<br>
`.gitignore`も任意で変更。<br>

## Docker compose -イメージビルド-

`docker-composer.yml`ファイル内の`app: build`を元に`docker/php/Dockerfile`の内容を実行。<br>

```shell
$ cd sample_app
$ docker-compose build
```

`docker images`で確認。

```shell
$ docker images

REPOSITORY          TAG                 IMAGE ID            CREATED             SIZE
sample_app          latest              d5f4615b1d01        38 seconds ago      469MB
php                 7.2.12-fpm          9d11d506e313        2 months ago        367MB
```

`7.2.12-fpm`の`image`を元に`sample_app`imageが作成されている。<br>

## Docker compose -コンテナ起動-

`docker-compose.yml`ファイルの`image`を元にMySQLとNginxのイメージをpullしてくる。それを元にしてコンテナ起動。

```shell
$ docker-compose up -d
```

以下の内容が出たら成功。

```shell
Creating sample_mysql_1 ... done
Creating sample_app_1   ... done
Creating sample_web_1   ... done
```

しっかりと動いているか確認する。<br>

```shell
$ docker-compose ps
     Name                   Command              State                 Ports
------------------------------------------------------------------------------------------
sample_app_1     docker-php-entrypoint php-fpm   Up      9000/tcp
sample_mysql_1   docker-entrypoint.sh mysqld     Up      0.0.0.0:3306->3306/tcp, 33060/tcp
sample_web_1     nginx -g daemon off;            Up      0.0.0.0:8000->80/tcp
```

`http://localhost:8000/`にアクセスし、`403 Forbidden nginx/1.15.6`と出ていたら成功。

上手くいかない場合は`docker-compose logs`でログを確認。

## Laravelインストール

コンテナにbashログインする。<br>

```shell
$ docker-compose exec app bash
```

```shell
# composer create-project --prefer-dist laravel/laravel sample_app "5.5.*"
```

以下の警告が出るが気にしない。<br>

`do not run Composer as root/super user! See https://getcomposer.org/root for details`


`docker/web/default.conf`の変更。<br>

```conf
root  /var/www/html/sample_app/public;
```

`sample/.env`ファイルのDB環境変数を変更。<br>

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=sample
DB_USERNAME=user
DB_PASSWORD=password
```

コンテナ内から退却し再起動。<br>

```shell
$ docker-compose restart
```

`http://localhost:8000/`にアクセスし、Laravelが表示されたらOK。

## マイグレーション

またもやコンテナにbashログイン。<br>

```
$ docker-compose exec app bash
```

```shell
# cd sample_app
# php artisan migrate
```

マイグレーションできれば成功。<br>