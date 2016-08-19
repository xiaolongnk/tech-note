---
title: HTTPS Your site
date: 2016-08-19 16:54
categories:
- web
tags:
- https
- nginx
---
#### 让NGINX支持SSL
需要编译时支持ssl，可以sbin/nginx -V 来查看confiture参数，如果当时没有支持，那么需要重新编译安装。 编译参数前面已经有一篇文章了。[nginx编译参数](https://blog.nofile.cc/posts/nginx/2016/08/17/note-ng.html),也不用全加，用`--with-http_ssl_module` 就可以了。

#### 生成证书
主要参考这个[letsencrypty](https://letsencrypt.org/getting-started/)，可以生成免费证书。 生成方式也很简单，读上面的文章基本就能明白。[ubuntu+nginx](https://certbot.eff.org/#ubuntutrusty-nginx).

大致步骤如下：

```
wget https://dl.eff.org/certbot-auto
chmod a+x certbot-auto
./certbot-auto
./path/to/certbot-auto certonly --webroot -w /var/www/example -d example.com -d www.example.com -w /var/www/thing -d thing.is -d m.thing.is
```
执行完之后系统中会生成这些文件。![系统中生成的文件](http://img.nofile.cc/cert.jpg)

	This command will obtain a single cert for example.com, www.example.com, thing.is, and m.thing.is; it will place files below /var/www/example to prove control of the first two domains, and under /var/www/thing for the second pair.




#### Automating renewal

上面生成的证书，有效期好像是1个月，所以需要到期自己重新renewal一下。方法如下：

```
./path/to/certbot-auto renew --dry-run
./path/to/certbot-auto renew --quiet --no-self-upgrade
```

#### 配置NGINX

配置就不多说了.首先需要配置2个server，监听2个端口。这样可以强制将80端口的请求重定向至443端口。https本身监听的是443端口。最主要的是ssl中间那3行。将步骤2中生成的对应key写在nginx的配置文件里。注意改成你的具体路径。

```
server {

    listen       443;
    server_name  blog.nofile.cc;

    ssl                  on;
    ssl_certificate      /xxxx/letsencrypt/live/yoursite/fullchain.pem;
    ssl_certificate_key  /xxxx/letsencrypt/live/yoursite/privkey.pem;
   
     location / {
        #这个地方指定被访问的文件夹位置
        root   /your/webroot/;
        index  index.html;
    }
}

server {
    listen      80;
    server_name blog.nofile.cc;
    return 301 https://blog.nofile.cc$request_uri;  
}
```

配置好之后，重启nginx，应该就可以看到绿色的锁了。
