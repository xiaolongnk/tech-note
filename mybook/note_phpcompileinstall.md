### PHP编译安装

* 本文安装的系统环境是 ubuntu 16.04,包管理器是apt-get,编译的php版本为5.6。和centos 的yum 略有不同，但不同仅仅实在包方面，需要安装依赖包的时候，搜索引擎找一下即可,其他方面基本一致。
* 下载PHP源码包,本文选择的版本为php5.6.
* 安装一些依赖的库，如果这些库缺失的话，configure 会失败。也可以失败一次安装一个。这类问题的解决方案相对简单，在linux上用apt-get 安装对应的库就可以了。在 ubuntu 下，我们执行下面的命令. 对于PHP7以上的版本，编译参数可能有些会不一样，可以通过configure --help 来了解一下。
* 最终的编译参数,包括pdo，gd图像支持,php-fpm, 指定自己的安装path，mbstring支持中文...等常用特性的支持.
[shell]
./configure --prefix=/yourpath/php --with-config-file-path=/yourpath/php/etc --with-mysql=/usr/ --with-iconv-dir=/usr/ --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --with-curl --with-mcrypt --with-gd --with-openssl --with-mhash --with-xmlrpc --with-zlib --with-pdo-mysql --with-mysql=shared,mysqlnd --enable-xml --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --enable-mbregex --enable-fpm --enable-mbstring --enable-gd-native-ttf --enable-pcntl --enable-sockets --enable-zip --enable-pdo --disable-rpath
[/shell]
* 可能会遇到的问题,错误提示可能和下面几个选项有关，都是依赖库不全的原因.
  1. openssl.h not found
  2. libxml2 没有安装
  3. jpeglib.h not found
  4. pnglib.h not found
  5. freetype-config not found
  6. mcrypt.h not found
* 安装自己系统对应的库就可以。
[shell]
sudo apt-get install libxml2-dev
sudo apt-get install pkg-config
sudo apt-get install libssl-dev libsslcommon2-dev
sudo apt-get install libjpeg-dev
sudo apt-get install libpng++-dev
sudo apt-get install libfreetype6-dev
sudo apt-get install libmcrypt-dev 
sudo apt-get install libcurl4-openssl-dev
[/shell]
* `make -j4`  `-j4` 这个参数不是必须的，如果你的电脑是4核的，这样会加快编译速度。
* make 成功结束之后，make install 就可以了。需要注意的是，在configure参数中，我们指定了一个path，所以make install 会将php系统安装到指定的path中。如果需要让系统能找到我们的php，可以将指定的path加入到环境变量中。

### 编译安装PHP扩展

* 下载php扩展，比如phpredis ，可以直接来这里找<https://pecl.php.net/>
* 进入php扩展目录，操作如下：
[shell]
/your/path/phpize 
./configure 
make
make install
[/shell]
* 如果按照上面的方法安装扩展的时候还是会失败，那么可以换一个版本的扩展再试下。

### pecl 安装PHP扩展
* 安装好php之后，php的bin目录下会有一个pecl，pecl可以让我们更方便的安装php扩展，只要知道扩展的名字，pecl会帮我们选择合适的版本来安装好。
[shell]
sudo pecl install redis
[/shell]
* 安装完成之后，会注意到这个输出,所以我们要打开php.ini ，将extension=redis.so 加入到php中。
[shell]
Build process completed successfully
Installing '/home/service/php/lib/php/extensions/no-debug-non-zts-20131226/redis.so'
install ok: channel://pecl.php.net/redis-3.1.4
configuration option "php_ini" is not set to php.ini location
You should add "extension=redis.so" to php.ini
[/shell]
* 通过`php -i | grep redis` 来检查，发现php已经有redis扩展了。
