2015-01-31 17:51

margin: 的4个参数。up ,right, down , left;
如果只有一个参数，那么表示4个都是n px。可以是1-4个参数。

my understanding for web server is gaining, but it's not enough,I need to know more to host my craeer.
sudo service gdm restart|stop|start
if you gdm freezen, you can use this command to avoid restart your computer from poweroff.
First you should in character mode.

After all these years, I find official documentation is most powerful, thanks for all.
stackoverflow.
account: myemail.  passwd: strongest.

2015-03-26 19:05
下载基本的编译组件。

用如下方式加载需要的扩展。
`imagick.so ` 应该在 `gmagick.so` 前面加载，否则会报错。

PHP 编译安装
首先是编译PHP的参数。
```
./configure  '--prefix=/home/service/php/' '--with-config-file-path=/home/service/php/etc' 
    '--with-apxs2=/home/service/apache2/bin/apxs' '--with-zlib' '--with-curl' '--with-gd' '--without-pear'
    '--enable-mbstring' '--with-gettext' '--with-freetype-dir=/usr/' '--with-jpeg-dir=/usr/local/jpeg'
    '--with-png-dir=/usr/local/libpng' '--enable-sockets' '--enable-shmop' '--with-libxml-dir=/usr/local/libxml2/' 
    '--with-openssl' '--with-mcrypt=/usr/local/libmcrypt/ --with-mysql --with-pdo-mysql
```
其中 mysq.so pdo_mysql.so 就不用再加载了。如果写上，会提示这个错误。因为这些模块在编译PHP的时候已经开启了，
`--with-mysql` 和 `--with-pdo-mysql` 所以PHP已经默认加载这些模块了，不用再在配置文件中添加。如果PHP编译时
没有那个参数，那么需要再编译mysql 和 pdo-mysql 扩展，然后安装，方法和其他模块的安装是一样的，在PHP源码的 ext
目录下可以找到,安装方式下面有详细描述。
>
PHP Warning:  PHP Startup: Invalid library (maybe not a PHP library) 
'/home/service/php/lib/php/extensions/no-debug-zts-20131226/pdo_mysql.so' in Unknown on line 0

pkhp.ini 里面的配置应该是这样的。
```
extension="home/service/php/lib/php/extensions/xxx/imagick.so"
extension="home/service/php/lib/php/extensions/xxx/gmagick.so"
```
首先要安装 gmagick。 在安装 gmagik 的过程中，要注意这个选项。在configure的过程中。需要这样。
```shell
CFLAGS="-O3 -fPIC" ./configure
make && make install
```

这里可以找到基本上所有的PHP扩展。
<http://pecl.php.net>
`gmagic` 和 `imagic` 都下载了最新版本。

编译过程,进入主目录,大部分的编译过程都下面这样。
```
/home/service/php/bin/phpize
./configure --with-php-config=/home/service/php/bin/phpize
make
make install
```
之后扩展都会被安装到项目的主目录下。`/home/service/php/lib/php/extensions/no-debug-zts-20131226/`
```shell
sudo wget http://sourceforge.net/projects/graphicsmagick/files/latest/download?source=files
sudo wget http://pecl.php.net/get/imagick-3.1.2.tgz
sudo wget http://pecl.php.net/get/gmagick-1.1.7RC2.tgz
sudo wget http://pecl.php.net/get/redis-2.2.7.tgz
sudo wget http://pecl.php.net/get/mongo-1.6.6.tgz
CFLAGS="-O3 -fPIC" ./configure --with-php-config=/home/service/php/bin/php-config
```
装完了之后注意写好你的配置文件。在主目录下的etc下面。加载对应的扩展就可以了,可以这样测试。
```
/home/service/php/bin/php -m | grep gd
/home/service/php/bin/php -m | grep redis 
/home/service/php/bin/php -m | grep mongo
/home/service/php/bin/php -m | grep gmagick
/home/service/php/bin/php -m | grep imagick
/home/service/php/bin/php -m | grep mysql
/home/service/php/bin/php -m | grep pdo
```
最后重启 apache 应该就可以了。
遇到了不少问题，主要都是编译 gmagick 扩展过程中遇到的最关键的应该是那个CFLAGS参数。在configure之前加上就可以了。
还有就是配置中imagick要在gmagick之前。
