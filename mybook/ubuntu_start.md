制作 ubuntu 15.10 镜像。

使用dd命令，比什么的软碟通，什么的好多了。

```shell
sudo dd if=/home/your.iso of=/dev/sdb
```

安装 fcitx 搜狗输入法。
1. 确保你的语言包是全的。
2. 安装这个语言包。<http://pinyin.sogou.com/linux/>
3. 按照这个做 <http://jingyan.baidu.com/article/adc815134f4b92f722bf7350.html>

安装firefox 插件
json, vimperator, firebug.


安装 nginx ， php ， mysql ， php-redis 扩展。

nginx <http://nginx.org/en/download.html>
php <http://php.net/get/php-5.6.15.tar.gz/from/a/mirror>


php 编译参数.

```shell
./configure --prefix=/opt/server/php --with-config-file-path=/opt/server/php/etc --with-mysql=/usr/ --with-iconv-dir=/usr/ --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --enable-xml --disable-rpath  --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --with-curl --enable-mbregex --enable-fpm --enable-mbstring --with-mcrypt --with-gd --enable-gd-native-ttf --with-openssl --with-mhash --enable-pcntl --enable-sockets --with-xmlrpc --enable-zip --enable-soap --without-pear --with-zlib --enable-pdo --with-pdo-mysql --with-mysql=shared,mysqlnd 
```
安装php-redis 扩展。<http://pecl.php.net/package/redis>

php nginx 配置。
这个也很重要。

nginx 的配置。
php-fpm 的配置，基本没有配置，都是用的初始配置，只要可以换一下端口就可以了。
php-ini 的配置，这个也简单，如果编译的php是ok的话，需要装的扩展也不是很多，只要安装redis 和 mongo的就差不多了。
编译带上参数的话，那些扩展就被编进php内核了。
启动php-fpm 的方法，记得带上 -c 参数，这个是php-fpm 找 php.ini 的路径，如果找不到，就会出问题的。

nginx 有3个比较重要的配置文件。
1. nginx.conf  
2. 虚拟主机，一般会将对应虚拟主机的配置文件单独放在  vhosts/ 下面，当然自己建一个目录就可以了。然后就是写对应的 server {} 就可以了。

下面是两个比较常见的配置。

```nginx
#nginx.confg
worker_processes  1;
error_log  logs/error.log;
pid        logs/nginx.pid;
events {
    worker_connections  1024;
}

http {
    include       mime.types;
    default_type  application/octet-stream;
    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';
    access_log  logs/access.log  main;
    sendfile        on;
    keepalive_timeout  65;
	include vhosts/*.conf;
	include fastcgi_params;
}
```

vhosts/pandora.conf

```
upstream pandora {
	server 127.0.0.1:9001;
}
server {
	charset utf-8;
	index index.php;
	listen    80; 
	server_name  higo.api;
	access_log	logs/pandora.log;
	error_log logs/pandora.error.log;
	root  /home/faith/blackh/code/pandora/public/api/mob;
	location / { 
		if (!-e $request_filename) {
			rewrite ^(.*)$ /index.php last;
		}   
	}   
	location ~ .*\.(php)?$ { 
		fastcgi_pass  pandora;
		fastcgi_next_upstream error timeout invalid_header http_500;
		fastcgi_index index.php;
		fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
		fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
		fastcgi_param  REQUEST_URI        $request_uri;
		fastcgi_param  DOCUMENT_URI       $document_uri;
		include        fastcgi_params;
	}   
	location ~ (favicon.ico){
		log_not_found off;
		expires 100d;
		access_log off;
		break;
	}   
}

```

vhots/hgadmin.conf

```
upstream h.higo {
    server 127.0.0.1:9001;
}
server {
    charset utf-8;
    index index.php;
    listen    80; 
    #server_name  higotest.meilishuo.com;
    server_name  hgadmin.higo.meilishuo.com;
	root  /home/faith/blackh/code/hgadmin/;
location / { 
        if (!-e $request_filename) {
            rewrite ^(.*)$ /index.php last;
        }   
    }   
    location ~ .*\.(php)?$ { 
        fastcgi_pass  h.higo;
        fastcgi_next_upstream error timeout invalid_header http_500;
        fastcgi_index index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
        fastcgi_param  REQUEST_URI        $request_uri;
        fastcgi_param  DOCUMENT_URI       $document_uri;
        include        fastcgi_params;
    }   
     location ~ (favicon.ico){
        log_not_found off;
        expires 100d;
        access_log off;
        break;
    }   
}

```

上面的三个配置文件基本可以保证程序的正常运行了。但是我们还需要知道另一个配置文件。

4. fastcgi_params;

```
fastcgi_param  QUERY_STRING       $query_string;
fastcgi_param  REQUEST_METHOD     $request_method;
fastcgi_param  CONTENT_TYPE       $content_type;
fastcgi_param  CONTENT_LENGTH     $content_length;

fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
fastcgi_param  REQUEST_URI        $request_uri;
fastcgi_param  DOCUMENT_URI       $document_uri;
fastcgi_param  DOCUMENT_ROOT      $document_root;
fastcgi_param  SERVER_PROTOCOL    $server_protocol;
fastcgi_param  REQUEST_SCHEME     $scheme;
fastcgi_param  HTTPS              $https if_not_empty;

fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
fastcgi_param  SERVER_SOFTWARE    nginx/$nginx_version;

fastcgi_param  REMOTE_ADDR        $remote_addr;
fastcgi_param  REMOTE_PORT        $remote_port;
fastcgi_param  SERVER_ADDR        $server_addr;
fastcgi_param  SERVER_PORT        $server_port;
fastcgi_param  SERVER_NAME        $server_name;
fastcgi_param  RUNTIME_ENVIROMENT dev;

# PHP only, required if PHP was built with --enable-force-cgi-redirect
fastcgi_param  REDIRECT_STATUS    200;
```
其中大部分都是默认的，就是原来就有， RUNTIME_ENVIROMENT 是我自己加进去的，这只是一个例子，我们可以加入进去任何自己想要的变量。
这样，基本就配置完了我们的 lnmp 环境，基本就可以访问使用了。

###  2015-11-23 20:42

>
ubuntu unity
其实窗口标题的CSS选择器是UnityDecoation.top，对于Ambiance主题是在/usr/share/themes/Ambiance/gtk-3.0/apps/unity.css文件里。
如果想不影响其他的样式，就只修改这个文件。
将 UnityDecoration.top 的 background-image 设置由：
from (shade (@dark_bg_color, 1.5)),
     to (shade (@dark_bg_color, 1.04)));
修改为：
from (shade (alpha (@dark_bg_color, 0.4), 1.5)),
     to (shade (alpha (@dark_bg_color, 0.4), 1.04)));
将UnityDecoration.top:backdrop 的 background-image 设置由：
from (shade (#474642, 0.92)),
     to (@dark_bg_color));
修改为：
from (shade (alpha (#474642, 0.4), 0.92)),
     to (alpha (@dark_bg_color, 0.4)));


附上Numix Daily主题安装方法：
sudo add-apt-repository ppa:numix/ppa
sudo apt-get update
sudo apt-get install numix-gtk-theme numix-icon-theme-circle numix-icon-theme-shine numix-icon-theme-utouch
然后运行gnome-tweak-tool设置GTK+主题和icons主题
