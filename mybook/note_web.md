2015--01-31 17:51 
margin: 的4个参数。up ,right, down , left;
如果只有一个参数，那么表示4个都是n px。可以是1--4个参数。

这里可以找到基本上所有的PHP扩展。<http://pecl.php.net>

之后扩展都会被安装到项目的主目录下。`/home/service/php/lib/php/extensions/no--debug-zts-20131226/`

```shell
sudo wget http://sourceforge.net/projects/graphicsmagick/files/latest/download?source=files
sudo wget http://pecl.php.net/get/imagick--3.1.2.tgz
sudo wget http://pecl.php.net/get/gmagick--1.1.7RC2.tgz
sudo wget http://pecl.php.net/get/redis--2.2.7.tgz
sudo wget http://pecl.php.net/get/mongo--1.6.6.tgz
CFLAGS="--O3 -fPIC" ./configure --with-php-config=/home/service/php/bin/php-config
```
装完了之后注意写好你的配置文件。在主目录下的etc下面。加载对应的扩展就可以了,可以这样测试。

```
/home/service/php/bin/php --m | grep gd
/home/service/php/bin/php --m | grep redis
/home/service/php/bin/php --m | grep mongo
/home/service/php/bin/php --m | grep gmagick
/home/service/php/bin/php --m | grep imagick
/home/service/php/bin/php --m | grep mysql
/home/service/php/bin/php --m | grep pdo
```

netstat --tunlp |grep 90

nginx 配置自己代码的问题。现在环境都好了。昨晚和今早都跳了很多坑，应该找时间记录一下。
nginx 中加环境变量.
fastcgi\_params define_params hhh


## 编译参数
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
### Linux 守护进程
set_time_limit(0); 设置程序的执行时间,如果是0说明永久执行下去.

学习写守护进程,用PHP实现.或这其他的也行.

每个进程都有一个父进程,子进程退出,父进程能得到子进程退出的状态.
进程组, 每个进程都属于一个进程组,这个号码等于该进程组组长的pid.

守护进程编程要点.


### 2016-01-10 23:41
学习两个前端页面会使用到的js。  

https://www.woothemes.com/flexslider/  这个是用来做轮播图的js。
http://fontawesome.dashgame.com/   这个是用来给页面中显示一些字体用的。还有一些常用的图标，用法也很简单，
可以参考官网。功能很全，应该系统学习一下。
http://www.cnblogs.com/lhb25/p/flexslider-responsive-content-slider.html  这里是一个使用案例,可以参考。

并不是所有的东西都需要自己来写，好多东西都已经写好了，你只要会拿来用就可以了。

304 错误. 强制不从本地设备读取内容.
```html
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
```

### docs with juniper vpn on ubuntu linux firefox
这个是最正确的教程，没有之一。
http://mad-scientist.us/juniper.html

```
sudo apt-get install libstdc++6:i386 lib32z1 lib32ncurses5 libxext6:i386 libxrender1:i386 libxtst6:i386 libxi6:i386
sudo apt-get install openjdk-7-jre icedtea-7-plugin openjdk-7-jre:i386
sudo apt-get install  icedtea-plugin
sudo apt-get install libc6-i386 lib32nss-mdns
sudo apt-get install libgtk2-perl libwww-perl
wget -q -O /tmp/msjnc https://raw.github.com/madscientist/msjnc/master/msjnc
chmod 755 /tmp/msjnc
sudo cp /tmp/msjnc /usr/bin
```

http://www.scc.kit.edu/scc/net/juniper-vpn/linux/

还可以参考这个帖子。需要得到realm这个东西，这个东西，去你公司的vpn网站爬一下就可以了。搜索一下realm这个字，就可以看到
这个内容的值。


linux nodejs cnpm.

http://npm.taobao.org/

cnpm 比npm 速度块很多，用alias比较靠谱。 换一个淘宝镜像。

nvm 可以选择安装 node 的版本，也很方便。

这里下载。
https://raw.githubusercontent.com/creationix/nvm/v0.4.0/install.sh


cnpm install

charles 破解。我的link。 http://pan.baidu.com/s/1i4UUbOh

那天发现我本地环境速度很慢的原因是 php-fpm.conf 中的maxchildren 数量太少了。
我改成static 的，然后把最大数量变成128； 一下子就不用排队了。
当时的现象是这样的。我看network，显示网络请求在排队，但是我完了单独访问每一个排队排了很久的接口，速度都很快，所以很疑惑。
我开了php的slowlog，但是并没有出现slowlog。貌似php的slowlog并不是我理解的那样。
并且slowlog，我自己写了一个sleep都不会打印出slowlog。

firefox访问google的问题。
https://www.google.com/ncr

或者在firefox上下载一个插件，就可以和chrome一样搜索了。


2016-04-27 19:12
这几天写了一点js。感觉有什么收获吗？
在这种框架下写了一点新功能，发现开发确实挺慢的。
postman 是一个不错的工具， 不用一直在那里拼凑接口了。写一次保存下来，就可以一直使用了。

angular 中的浮层，请求模块。

其实，一个页面中常用的请求也就那些，浮层，ajax网络请求,gridlist , gridlist search.
把这些常用的东西封装一下，就可以比较方便的开发了.
写一点js，是必须的。无论如何，jquery，underscore，都可以加速开发效率。

对于一个系统来讲，基础service应该包含所有的逻辑，逻辑应该收敛在基础服务里面。
基于这个原则去构建系统，应该不会太乱。


grep -o -E "\"shop_id\":\"[0-9]*\"" out.txt

2016-08-05 19:20
在 lavarel 中使用静态图片。

q1: 在页面中中使让一段字体在一个div中垂直居中？
http://stackoverflow.com/questions/79461/vertical-alignment-of-elements-in-a-div
