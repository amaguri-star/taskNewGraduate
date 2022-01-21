# DockerでLaravelの環境構築
## 全体の手順
***
- Docker環境のディレクトリ構造
- docker-compose.ymlを作成する
- 環境変数の設定
    - .envの作成
    - .gitignoreの作成
- 各コンテナのDockerfileを作成
    - PHP用のDockerfile
    - Nginx用のDockerfile
    - MySQL用のDockerfile
- 各ミドルウェアの設定ファイルを作成する
    - PHPの設定ファイルの作成
    - Nginxの設定ファイルの作成
    - MySQLの設定ファイルの作成
- イメージの構築
- コンテナの起動
- Laravelのインストール
- Vue.jsのインストール

### Docker環境のディレクトリ構造
***
最終的には、下記のような構造にする
docker下のディレクリ名はapp, web, dbでも可
```
root-project
├─ docker
│    ├─ php
│    │   └─ Dockerfile
│    │   └─ php.ini
│    ├─ nginx
│    │    └─ Dockerfile
│    │    └─ default.conf
│    └─ mysql
│         └─ Dockerfile
│         └─ my.cnf
│    
├─ src
│    └─ ここにLaravelのPJディレクトが作られる
│─ .env
│─ .gitignore
└─ docker-compose.yml
```

### docker-compose.ymlを作成
***
ファイルの全体のコード  
バージョンは最新にしておくと良い（下記の例だと’3.8’）  
サービス名に制約はないが、app, web, dbなどにするとわかりやすい
>docker-composeファイル内のappのenvironmentに直接DB系の環境変数を指定すると、テスト用のdbを新しく作成する際に、テスト用の環境変数が上書きされてしまうの可能性があるので、実際には、Laravel側で記述する方が良いケースもある

>build句には、contextと、dockerfileまでのパスを指定する-->[参照記事](https://qiita.com/sam8helloworld/items/e7fffa9afc82aea68a7a)
```
version: '3.8'

volumes:
  mysql-volume:

services:
  app:
    build:
      context: .
      dockerfile: ./docker/php/Dockerfile
    volumes:
      - ./src:/var/www/html
    environment:
      - DB_CONNECTION=mysql
      - DB_HOST=db
      - DB_PORT=3306
      - DB_DATABASE=${DB_NAME}
      - DB_USERNAME=${DB_USER}
      - DB_PASSWORD=${DB_PASSWORD}

  web:
    build:
      context: .
      dockerfile: ./docker/nginx/Dockerfile
    ports:
      - ${WEB_PORT}:80
    depends_on:
      - app
    volumes:
      - ./src:/var/www/html

  db:
    build:
      context: .
      dockerfile: ./docker/mysql/Dockerfile
    ports:
      - ${DB_PORT}:3306
    environment:
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_PASSWORD: ${DB_PASSWORD}
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      TZ: 'Asia/Tokyo'
    volumes:
      - mysql-volume:/var/lib/mysql
```

### 環境変数の設定
***
#### .envの作成
.envファイルに記述  
値は適宜変更
```
WEB_PORT=80
DB_PORT=3306

DB_NAME=db_name
DB_USER=db_user
DB_PASSWORD=db_password
DB_ROOT_PASSWORD=root
```

#### .gitignoreの作成
さっき作成した.envファイルを追加
githubにうっかりpushするのを防ぐ
```
.env
```

### 各コンテナのDockerfileを作成
***
#### PHP用のDockerfile
Laravel&Vueを使用するため、次の二つをインストール

- Composer: パッケージ管理ツール。Laravelをインストールするために必要。
- npm: パッケージ管理ツール。Vue.jsをインストールするために必要。  

もし、フロントにVue.jsを使用しない場合は、該当のコードは記述不要

```
FROM php:7.4.1-fpm

# COPY php.ini
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

# Composer install
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# install Node.js
# Nodeのバージョンは、適宜変更
COPY --from=node:10.22 /usr/local/bin /usr/local/bin
COPY --from=node:10.22 /usr/local/lib /usr/local/lib

RUN apt-get update && \
    apt-get -y install \
    git \
    zip \
    unzip \
    vim \
    && docker-php-ext-install pdo_mysql bcmath

WORKDIR /var/www/html
```
>php-fpm-alpineだとNodeをインストールできないので注意

#### Nginx用のDockerfile

- イメージのベースを指定
- 環境変数（TZ）をを定義
- Nginxの設定ファイルをコンテナ内にコピーして対応づける
- コンテナに入った時の作業ディレクトリを指定

```
FROM nginx:1.18-alpine

ENV TZ=UTC

# nginx config file
COPY ./docker/nginx/*.conf /etc/nginx/conf.d/

WORKDIR /var/www/html
```

#### MySQL用のDockerfileを作成
- イメージのベースを指定
- 環境変数を定義
- MySQLの設定ファイルをコンテナ内にコピーする

```
FROM mysql:8.0

ENV TZ=UTC

COPY ./docker/mysql/my.cnf /etc/my.cnf
```

### 各ミドルウェアの設定ファイルを作成する
***
#### PHPの設定ファイルの作成
- root-project/docker/phpディレクトリにphp.iniファイルを作成

```
[Date]
date.timezone = "Asia/Tokyo"
[mbstring]
mbstring.internal_encoding = "UTF-8"
mbstring.language = "Japanese"
```

#### Nginxの設定ファイルの作成
- root-project/docker/nginxディレクトリにdefault.confを作成
- もっと詳しく知りたい場合は、LaravelとNginxのドキュメントを参照

```
server {
    listen 80;
    
    root /var/www/html/public;

    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html index.htm;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### MySQLの設定ファイルの作成
- root-project/docker/mysqlディレクトリにmy.cnfを作成
- 5系と8系でcollation_serverを適宜変更しなければエラーが起こるので注意

```
[mysqld]
user=mysql
character_set_server = utf8mb4
# mysql8系の時
collation_server = utf8mb4_0900_ai_ci
# MySQL5系の時
collation_server = utf8mb4_bin

# timezone
default-time-zone = SYSTEM
log_timestamps = SYSTEM

# Error Log
log-error = mysql-error.log

# Slow Query Log
slow_query_log = 1
slow_query_log_file = mysql-slow.log
long_query_time = 1.0
log_queries_not_using_indexes = 0

# General Log
general_log = 1
general_log_file = mysql-general.log

[mysql]
default-character-set = utf8mb4

[client]
default-character-set = utf8mb4
```
### イメージの構築（build）
***
次のコマンドを実行
```
docker-compsoe build
```

### コンテナの起動（up）
***
次のコマンドを実行
```
docker-compose up -d
```

### Laravelのインストール
***
コンテナ内に入る
```
docker-compose exec app bash
```
入ったらディレクトリは変えずに以下のコマンドを実行
```
composer create-project --prefer-dist "laravel/laravel=7.*" .
```
localhost:80にアクセスして、welcomeページが表示されたらDockerを使ったlaravelの実行環境（LEMP環境）の構築は完了

### Vue.jsのインストール
***
npmがインストールされているか確認
```
npm -v
```
vueをインストール
```
npm install -D vue
```
vue-template-compailerをインストール
```
npm install -D vue-template-compiler
```
念のため、package.jsonというファイルにの"devDependencies"の中に以下の記載があるかどうかを確認
```
        "vue": "^2.6.12",
        "vue-template-compiler": "^2.6.12"
```

以上で環境構築は完了



