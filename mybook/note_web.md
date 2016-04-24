2015--01-31 17:51 
margin: 的4个参数。up ,right, down , left;
如果只有一个参数，那么表示4个都是n px。可以是1--4个参数。

my understanding for web server is gaining, but it's not enough,I need to know more to host my craeer.

sudo service gdm restart|stop|start

if you gdm freezen, you can use this command to avoid restart your computer from poweroff.
First you should in character mode.

After all these years, I find official documentation is most powerful, thanks for all.
stackoverflow.
account: myemail.  passwd: strongest.

2015--03-26 19:05
下载基本的编译组件。

用如下方式加载需要的扩展。
`imagick.so ` 应该在 `gmagick.so` 前面加载，否则会报错。

PHP 编译安装
首先是编译PHP的参数。

```shell
./configure  '--prefix=/home/service/php/' '--with-config-file-path=/home/service/php/etc'
    '--with-apxs2=/home/service/apache2/bin/apxs' '--with-zlib' '--with-curl' '--with-gd' '--without-pear'
    '--enable-mbstring' '--with-gettext' '--with-freetype-dir=/usr/' '--with-jpeg-dir=/usr/local/jpeg'
    '--with-png-dir=/usr/local/libpng' '--enable-sockets' '--enable-shmop' '--with-libxml-dir=/usr/local/libxml2/'
    '--with-openssl' '--with-mcrypt=/usr/local/libmcrypt/ --with-mysql --with-pdo-mysql
```
其中 mysq.so pdo_mysql.so 就不用再加载了。如果写上，会提示这个错误。因为这些模块在编译PHP的时候已经开启了，
`--with-mysql` 和 `--with-pdo-mysql` 所以PHP已经默认加载这些模块了，不用再在配置文件中添加。如果PHP编译时
没有那个参数，那么需要再编译mysql 和 pdo--mysql 扩展，然后安装，方法和其他模块的安装是一样的，在PHP源码的 ext
目录下可以找到,安装方式下面有详细描述。
>
PHP Warning:  PHP Startup: Invalid library (maybe not a PHP library)
'/home/service/php/lib/php/extensions/no--debug-zts-20131226/pdo_mysql.so' in Unknown on line 0

pkhp.ini 里面的配置应该是这样的。

```shell
extension="home/service/php/lib/php/extensions/xxx/imagick.so"
Iextension="home/service/php/lib/php/extensions/xxx/gmagick.so"
```
首先要安装 gmagick。 在安装 gmagik 的过程中，要注意这个选项。在configure的过程中。需要这样。

```shell
CFLAGS="--O3 -fPIC" ./configure
make && make install
```

这里可以找到基本上所有的PHP扩展。
<http://pecl.php.net>
`gmagic` 和 `imagic` 都下载了最新版本。

编译过程,进入主目录,大部分的编译过程都下面这样。

```shell
/home/service/php/bin/phpize
./configure --with-php-config=/home/service/php/bin/phpize
make
make install
```
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
最后重启 apache 应该就可以了。
遇到了不少问题，主要都是编译 gmagick 扩展过程中遇到的最关键的应该是那个CFLAGS参数。在configure之前加上就可以了。
还有就是配置中imagick要在gmagick之前。

http://www.2cto.com/os/201406/306493.html

2015--10-25 05:34

this command can find which process take 80 port.
netstat is usefull, but the args is the key point.
netstat --tunlp |grep 90

2015--10-27 17:12

编译PHP的参数.
./configure --prefix=/opt/server/php --with-mysql --with-iconv-dir --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --enable-xml --disable-rpath --enable-discard-path --enable-safe-mode --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --with-curl=/usr/ --with-curlwrappers --enable-mbregex --enable-fpm --enable-force-cgi-redirect --enable-mbstring --with-mcrypt --with-gd --enable-gd-native-ttf --with-mhash --enable-pcntl --enable-sockets --with-xmlrpc --enable-zip --enable-soap --without-pear --with-zlib --enable-pdo --with-pdo-mysql --with-mysql

解决完configure 中遇到的问题基本就ok了，安装应该全面，不然后面安装其他应用还会遇到问题。

剩下的就是 nginx 配置自己代码的问题。现在环境都好了。昨晚和今早都跳了很多坑，应该找时间记录一下。
nginx 中加环境变量.
fastcgi\_params define_params hhh
pandora API 需要重定向才能工作
运营后台不需要，只要PHP是对的，就可以工作.


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
### 2015-12-03 19:52  
```sql
create table t_pandora_goods_record(
    id bigint(20) not null auto_increment primary key,
    account_id bigint(20) not null default 0 comment '用户ID',
    goods_ids text not null default '' comment '浏览过的商品id,用逗号分隔,最多300个',
    mtime timestamp not null defult '' comment '修改时间'
)engine = InnoDB, charset =utf8, auto_increment = 1;
```
2. 实现思路
    1. 利用redis pub/sub 功能.在商品详情接口中添加publish操作.
    2. 启动subscribe任务,监听channle.在subscribe的callback中执行数据维护操作.
    3. 数据维护操作如下:
        `goods_ids` 最大长度是300个`goods_id`,先拿到用户id对应的`goods_ids`,在程序中
        判断`goods_ids`中`goods_id`的长度,如果长度大于300,讲最后面的pop,push最新的
        `goods_id`到数组的最前面,然后讲这个`goods_id`写入数据表.
    4. 清楚浏览足迹,将这个用户的数据置空.
    5. 可能出现的问题,单进程的subscribe进程处理能力有限,是否可靠.如果不可靠,就要用redis
        消息队列来实现,因为这里数据是敏感的,不能丢失.
        从目前来看,redis queue 更为可靠,难点在于用php实现守护进程.


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

2016-04-11 15:45

charles 破解。我的link。
http://pan.baidu.com/s/1i4UUbOh
linux可以使用。


git

```
git stash specific files;
use git stash save command.
git stash save common/app.constants.js
```

那天发现我本地环境速度很慢的原因是
