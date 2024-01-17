## Overview

以下アーキテクチャで動作するwebアプリケーションを構築するためのTemplate Repository

- Docker
- nginx
- Laravel
- postgres

## Structure

### Technologies and Tools

```
- Nginx : 1.24
- PHP: 8.3
- PostgreSQL: 15.5
- Composer: 2.6
- Xdebug: 3.3
```

### Dir

```
root/
|-- docker
|    |-- nginx
|    |   |-- default.conf
|    |   |-- Dockerfile
|    |-- php-fpm
|    |   |-- ini
|    |   |   |-- xdebug.ini
|    |   |-- Dockerfile
|    |-- postgres
|    |   |-- Dockerfile
|-- docker-compose
|-- Makefile
```

### Container

```
- web
- app
- db
```

- web
  - docker base image： [nginx:1.24.0-bullseye](https://hub.docker.com/layers/library/nginx/1.24.0-bullseye/images/sha256-f618a6de3e2c6464699f7f0cddeb5aff68534932cefad83e9c225b0db4024a03?context=explore)
- app
  - docker base image： [php:8.3.0-fpm-bullseye](https://hub.docker.com/layers/library/php/8.3.0-fpm-bullseye/images/sha256-7f9a0d39b9fa3ce6b07aa5d7bfd06d059236c0a77cc965008afd76d220f95fa3?context=explore)
- db
  - docker base image： [postgres:15.5-bullseye](https://hub.docker.com/layers/library/postgres/15.5-bullseye/images/sha256-b243ba597985f628f09df2726021aa13234afeabf545d7964b2f2ef258c0956a?context=explore)

## Usage

[template reposigory](https://docs.github.com/ja/repositories/creating-and-managing-repositories/creating-a-template-repository)として作成しているので、
本repositoryをtemplateとして、新規Repositoryを作成可能です。

### Start

docker compose でcontainer類を作成。
Laravelを[create project](https://laravel.com/docs/10.x/installation#creating-a-laravel-project)して、
アプリケーションを動作可能な状態にセットアップする。

#### 1. laravel projectを作成
```
$ make create-project
```

#### 2. xdebugの設定

xdebugを使う場合、必要に応じて設定

参考：
- vscode：[【PHP】VScodeでXdebugを使ってデバッグする](https://zenn.dev/ikeo/articles/244d6a8042bcd8c55fe9#vscode%E3%81%AE%E8%A8%AD%E5%AE%9A)
- IntelliJ：[Docker + Phpstorm で Xdebug を使用する](https://zenn.dev/micronn/articles/5f3cd1d94f99fd)
### end

docker composeで立ち上げたcontainer類を停止・削除する

```
$ make down
```

### Reference

- Laravel10 document
https://laravel.com/docs/10.x/
- 構成に関して大いに参考にさせて頂いた
https://github.com/ucan-lab/docker-laravel