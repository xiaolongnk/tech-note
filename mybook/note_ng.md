---
title: nginx 学习笔记
categories:
- nginx
tags:
- nginx
---

nginx
检测配置文件的正确性，不要加载一个又明显错误的配置文件
nginx -t -c /usr/nginx/conf/nginx.conf 或者向下面这样也可以 nginx -t
启动  停止  或者重启 nginx 。
nginx  -s reload


#### nginx编译参数

```shell
./configure \
    --prefix=/home/service/nginx \
    --with-http_ssl_module \
    --with-http_spdy_module \
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
    --with-pcre=/root/src/pcre-8.37 \
    --with-zlib=/root/src/zlib-1.2.8 \
    --with-openssl=/root/src/openssl-OpenSSL_1_0_2d \
    --add-module=/root/src/naxsi-0.54/naxsi_src \
    --add-module=/root/src/headers-more-nginx-module-0.27 \
    --add-module=/root/src/echo-nginx-module-0.58 \
    --add-module=/root/src/lua-nginx-module-0.9.18rc1 \
    --add-module=/root/src/redis2-nginx-module-0.12
```
#### nginx 中加环境变量.
fastcgi\_params define_params hhh



