### 制作 ubuntu 15.10 镜像。
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
php nginx 配置,这些也很重要。

nginx 的配置。
php-fpm 的配置，基本没有配置，都是用的初始配置，只要可以换一下端口就可以了。
php-ini 的配置，这个也简单，如果编译的php是ok的话，需要装的扩展也不是很多，只要安装redis 和 mongo的就差不多了。
编译带上参数的话，那些扩展就被编进php内核了。
启动php-fpm 的方法，记得带上 -c 参数，这个是php-fpm 找 php.ini 的路径，如果找不到，就会出问题的。

nginx 有3个比较重要的配置文件。
1. nginx.conf  
2. 虚拟主机，一般会将对应虚拟主机的配置文件单独放在 vhosts/ 下面，当然自己建一个目录就可以了。然后就是写对应的 server {} 就可以了。

下面是两个比较常见的配置。

### nginx.conf
```nginx
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

### vhosts/pandora.conf

```nginx
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

### vhots/hgadmin.conf

```nginx
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

```nginx
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

具体内容看这个帖子,其实还是挺好的.话说这markdown写得挺丑的.<http://tieba.baidu.com/p/3073502760>
ubuntu unity
其实窗口标题的CSS选择器是UnityDecoation.top，对于Ambiance主题是在/usr/share/themes/Ambiance/gtk-3.0/apps/unity.css文件里。
如果想不影响其他的样式，就只修改这个文件。
将 UnityDecoration.top 的 background-image 设置修改为：
from (shade (alpha (@dark_bg_color, 0.4), 1.5)),
to (shade (alpha (@dark_bg_color, 0.4), 1.04)));
将UnityDecoration.top:backdrop 的 background-image 设置由修改为：
from (shade (alpha (#474642, 0.4), 0.92)),
to (alpha (@dark_bg_color, 0.4)));
#### 附上Numix Daily主题安装方法：
```shell
sudo add-apt-repository ppa:numix/ppa
sudo apt-get update
sudo apt-get install numix-gtk-theme numix-icon-theme-circle numix-icon-theme-shine numix-icon-theme-utouch
```
然后运行gnome-tweak-tool设置GTK+主题和icons主题
将这个主题的窗口的透明度调整一下,调整方法和上面的那个稍有不同.
Numix Daily主题窗口透明方法：
编辑/usr/share/themes/Numix Daily/gtk-3.0/gtk.css文件，在最后面添加以下4行内容：
UnityDecoration.top,
UnityDecoration.top:backdrop {
background-color: alpha(@titlebar_bg_color, 0.4);
}

###  2015-11-26 18:10

ubuntu markdown editor.
sudo add-apt-repository ppa:voldyman/markmywords
sudo apt-get update
sudo apt-get install mark-my-words


### this is another markdown editor.

<http://remarkableapp.github.io/linux/download.html>

vim slowstart.
vim --startuptime vim.log -c q

vim delete duplicate lines.
sort
g/^\(.\+\)$\n\1/d

### 2015-12-12 15:11

tmux 中vim slow start 的原因,就是因为开了多个tmux,启动速度就变慢了.
查看了slowlog,发现是因为xsmp消耗了大概1s的时间.只要保证一个tmux运行就可以了.

学习了一下 sublime ,感觉还是很可以的. 下载,安装,然后破解.然后安装一些扩展.
用起来还是很方便的,唯一的缺点是部支持sougoupinyin.感觉自己要跪了.
<http://www.tuicool.com/articles/NJrQfub>

还是用来写代码比较方便,写笔记什么的还是用我的vim比较好.

虽然使用wunderlist,但是还是要记笔记,wunderlist只是一个辅助,更详细的信息还是要记录在这里.
我的周末主要是用来写代码的,但是今天并没有怎么写代码的,我应该注意,今天一个下午全部用在玩上了.


grub customer
sudo add-apt-repository ppa:danielrichter2007/grub-customizer
sudo apt-get install grub-customizer

让你的ubuntu文件夹变成彩色的.
可以添加下面的ppa,添加这个
sudo add-apt-repository ppa:costales/folder-color
然后安装下面这个 folder-color 就可以了.
sudo apt-get install folder-color

### 2015-12-14 16:23

PHP在命令行模式下的 $_SERVER 变量中的变量可以在shell 中 export 来设置.shell 中的变量会出现在
SERVER 变量中.
在web环境中,要通过在服务器中设置才可以. nginx 在 fastcgi_params 中设置.


在linux中,我想升级gedit,比如说我的是 ubuntu14.04, 但是在 ubuntu15.10 里面,gedit 的版本是比
我的新的.但是在14.04里面我确用不了最新的gedit .
这个时候,我可以从官网下载最新的gedit ,安装,然而安装的时候会出现一些问题.这时候怎么办呢.可以这样.

```
sudo apt-get build-deb gedit
sudo apt-get build-deb libreoffice5.0
```
然后执行安装命令就可以了.安装应该不会出错了.
下面解释一下这个命令究竟是做什么的.

ubuntu source code
如何获取ubuntu的源码
你可以获取任何一个你所使用的源码包.这就是开源的系统.
只要你的系统的源里有dep-src 这个选项,那么就可以随便获得系统源码.
就像下面这样.
```
deb-src http://archive.canonical.com/ubuntu trusty partner
deb-src http://cn.archive.ubuntu.com/ubuntu/ trusty main restricted
deb-src http://cn.archive.ubuntu.com/ubuntu/ trusty multiverse
deb-src http://cn.archive.ubuntu.com/ubuntu/ trusty universe
deb-src http://cn.archive.ubuntu.com/ubuntu/ trusty-backports main restricted universe multiverse
deb-src http://cn.archive.ubuntu.com/ubuntu/ trusty-updates main restricted
deb-src http://cn.archive.ubuntu.com/ubuntu/ trusty-updates multiverse
deb-src http://cn.archive.ubuntu.com/ubuntu/ trusty-updates universe
deb-src http://extras.ubuntu.com/ubuntu trusty main
deb-src http://security.ubuntu.com/ubuntu trusty-security main restricted
deb-src http://security.ubuntu.com/ubuntu trusty-security multiverse
deb-src http://security.ubuntu.com/ubuntu trusty-security universe
```

使用下面的命令.

```
sudo apt-cache showsrc gedit #showsrc 可以用来查询有没有你需要的源码包
sudo apt-cache source gedit  #source 命令用来获取你需要的源码包
```
当然在这些工作之前,我们需要确保安装一些基本的工具.
dpkg-dev 先安装这个.

在编译源码包之前,需要安装具有依赖关系的软件包,可以使用这个命令,就是上面的那个.
build-dep 命令.
```
sudo apt-get build-dep xxx
```
通过上面两个命令,就可以得到自己的源码包了.然后利用
```
cd yoursrc
sudo dpkg-buildpackage 
```
这样就可以得到你的dep文件了.
可以使用下面的命令来安装deb文件.
```
sudo dpkg -i *.deb
```
有了上面的知识,你就可以利用自己的系统,学习各种工具的源码了,包括vim , emacs.
哈哈,你有学习不完的代码了.加油吧.^_^

### 关于ubuntu 的dash 残留应用的问题
在你的本地文件里面. .local/share/applications/ 里面把对应的删除,重新登陆就可以
看到你讨厌的那个东西不见了.


























