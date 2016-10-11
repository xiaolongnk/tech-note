---
title: linux 下编译安装php及常用扩展
date: 2016-10-11 10:18
tags: 
- php
- linux
- php-extension
---

#### php 编译

1. 下载php源码
2. 安装一些以来的库，如果这些库缺失的话，configure 会失败。也可以失败一次安装一个。这类问题的解决方案相对简单，在linux上用apt-get 安装对应的库就可以了。不行的话，用搜索引擎找一下就会有大片的解决方案，随便一个都可以拿来参考。
```shell
sudo apt-get install libcurl4-openssl-dev
sudo apt-get install libssl-dev
sudo apt-get install libxml2-dev

./configure \
    --prefix=/home/faith/blackh/server/php
    --with-config-file-path=/home/faith/blackh/server/php/etc
    --with-mysql=/usr/ 
    --with-iconv-dir=/usr/ 
    --with-freetype-dir 
    --with-jpeg-dir 
    --with-png-dir 
    --with-zlib 
    --with-libxml-dir=/usr
    --with-curl
    --with-mcrypt
    --with-gd 
    --with-openssl
    --with-mhash
    --with-xmlrpc
    --with-zlib
    --with-pdo-mysql
    --with-mysql=shared,mysqlnd 
    --enable-xml 
    --enable-bcmath
    --enable-shmop 
    --enable-sysvsem
    --enable-inline-optimization
    --enable-mbregex
    --enable-fpm
    --enable-mbstring
    --enable-gd-native-ttf
    --enable-pcntl 
    --enable-sockets
    --enable-zip
    --enable-pdo
    --disable-rpath
```
配置中我们开启了好多功能，有好多我们都不知道是干什么的，没关系，好奇的同学们可以先`./configure --help`来了解下，这个问题先留着，后面有空了我们开专题专门堂研究下这个问题。

3. 可能会遇到的问题。
    1. openssl.h not found
    2. libxml2 没有安装
    3. jpeglib.h not found
    4. pnglib.h not found
    5. freetype-config not found
    6. mcrypt.h not found

```shell
sudo apt-get install libxml2-dev
sudo apt-get install pkg-config
sudo apt-get install libssl-dev libsslcommon2-dev
sudo apt-get install libjpeg-dev
sudo apt-get install libpng++-dev
sudo apt-get install libfreetype6-dev
sudo apt-get install libmcrypt-dev 
```

4. make -j4  `-j4` 这个参数不是必须的，如果你的电脑是4核的，这样会加快编译速度。

#### php 扩展安装

1. 下载php扩展，比如phpredis ，可以直接来这里找<https://pecl.php.net/>
2. 进入php扩展目录，操作如下：
```shell
/your/path/phpize 
./configure 
make
make install
```
3. 如果按照上面的方法安装扩展的时候还是会失败，那么可以换一个版本的扩展再试下。
