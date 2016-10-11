---
title: nginx 学习笔记
date: 2016-08-26 14:41
tags:
- nginx
---

#### nginx编译参数

```shell
sudo apt-get install libpcre3
sudo apt-get install libpcre++-dev
sudo apt-get install libgd-dev

./configure \
    --prefix=/home/service/nginx \
    --with-http_ssl_module \
    --with-http_realip_module \
    --with-http_addition_module \
    --with-http_xslt_module \
    --with-http_image_filter_module \
    --with-http_sub_module \
    --with-http_dav_module \
    --with-http_flv_module \
    --with-http_mp4_module \
    --with-http_gunzip_module \
    --with-http_gzip_static_module \
    --with-http_auth_request_module \
    --with-http_random_index_module \
    --with-http_secure_link_module \
    --with-http_degradation_module \
    --with-http_stub_status_module \
    --with-pcre \
    --with-zlib=../zlib-1.2.8 \
    --with-openssl=../openssl-OpenSSL_1_0_2d \
```
编译过程中容易遇到的问题。 前面三行是安装configure参数中需要依赖的内容，先安装可以保证configure可以通过。
openssl比较容易出问题，需要openssl的源码包。编译之前貌似会先编译openssl，要保证openssl可以编译。先要在openssl的目录，`./config` 一下。然后`make depend`，然后再进入nginx的源码目录进行`make`。需要依赖一些其他的东西，zlib是必须的，要下载源码包。

#### nginx 配置规则

1. location 写法。

2. log_format
    nginx 的log_format , log 需要几下post参数。记得上次查问题，我只能定位到url，并不能定位
    到参数，这导致有些问题没有办法追查。

    fastcgi\_params define_params hhh

    #### nginx 启动和重启
检测配置文件的正确性，不要加载一个又明显错误的配置文件
```shell
nginx -t -c /usr/nginx/conf/nginx.conf
#启动  停止  或者重启 nginx 。
nginx  -s reload  nginx  #重新加载配置文件
pkill nginx     #停止nginx
```

