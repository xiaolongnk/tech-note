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
