---
title: linux 下编译安装php及常用扩展
date: 2016-10-11 10:18
tags: 
- php
---

#### php 编译

1. 下载php源码
2. 安装一些以来的库，如果这些库缺失的话，configure 会失败。也可以失败一次安装一个。这类问题的解决方案相对简单，在linux上用apt-get 安装对应的库就可以了。不行的话，用搜索引擎找一下就会有大片的解决方案。
```shell
sudo apt-get install libcurl4-openssl-dev
sudo apt-get install libssl-dev
sudo apt-get install libxml2-dev

./configure --prefix=/home/faith/blackh/server/php --with-config-file-path=/home/faith/blackh/server/php/etc --with-mysql=/usr/ --with-iconv-dir=/usr/ --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --enable-xml --disable-rpath  --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --with-curl --enable-mbregex --enable-fpm --enable-mbstring --with-mcrypt --with-gd --enable-gd-native-ttf --with-openssl --with-mhash --enable-pcntl --enable-sockets --with-xmlrpc --enable-zip --enable-soap --without-pear --with-zlib --enable-pdo --with-pdo-mysql --with-mysql=shared,mysqlnd 
```
3. make -j4  `-j4` 这个参数不是必须的，如果你的电脑是4核的，这样会加快编译速度。

#### php 扩展安装

1. 下载php扩展，比如phpredis ，可以直接来这里找<https://pecl.php.net/>
2. 进入php扩展目录，操作如下：
```shell
/your/path/phpize 
./configure 
make
make install
```
