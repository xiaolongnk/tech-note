---
title: Ubuntu学习笔记
categories:
- Linux
tags:
- Linux
---

### 制作 ubuntu 镜像
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
sudo apt-get install libcurl4-openssl-dev
sudo apt-get install libssl-dev
sudo apt-get install libxml2-dev

./configure --prefix=/home/faith/blackh/server/php --with-config-file-path=/home/faith/blackh/server/php/etc --with-mysql=/usr/ --with-iconv-dir=/usr/ --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --enable-xml --disable-rpath  --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --with-curl --enable-mbregex --enable-fpm --enable-mbstring --with-mcrypt --with-gd --enable-gd-native-ttf --with-openssl --with-mhash --enable-pcntl --enable-sockets --with-xmlrpc --enable-zip --enable-soap --without-pear --with-zlib --enable-pdo --with-pdo-mysql --with-mysql=shared,mysqlnd 
```

安装php-redis 扩展。<http://pecl.php.net/package/redis>
php nginx 配置,这些也很重要。

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

#### ubuntu source code
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

使用下面的命令.

sudo apt-cache showsrc gedit #showsrc 可以用来查询有没有你需要的源码包
sudo apt-cache source gedit  #source 命令用来获取你需要的源码包
```
当然在这些工作之前,我们需要确保安装一些基本的工具.
dpkg-dev 先安装这个.

在编译源码包之前,需要安装具有依赖关系的软件包,可以使用这个命令,就是上面的那个.
build-dep 命令.

```
sudo apt-get build-dep xxx
#通过上面两个命令,就可以得到自己的源码包了.然后利用
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
下面是我的 ubuntu dash 中的eclipse的快捷方式.可以很明显的看到是我的路径出了问题. 我需要修改一下路径就可以了.

```
sudo apt-get install mysql-workbench
这个用起来还是很方便的.工作中又多了一个效率工具.要加入到我的worklist里面.

之前我的 ubuntu 浏览器一些字体看起来不太对劲,那是因为系统的中文字体不够
全,解决这个问题,只需要重新安装中文字体就可以了.

ubuntu 安装中文字体。

sudo apt-get install ttf-wqy-microhei  
sudo apt-get install ttf-wqy-zenhei  

ubuntu 修改自己的键盘映射,交换 capsloc 和 ese.
<http://www.dutor.net/index.php/2010/05/vim-swap-capslock-esc/comment-page-1/> 
如何查看局域网内的ip个数，查看自己路由器中的网段。了解一下路由器什么的。学习了解局域网。
学习一点黑客工具什么的。
nmap 具体的参数还需要进一步阅读手册。

nmap -PS 192.168.0.102  #扫描一个主机所有开启的端口。
nmap -sP 192.168.0.*  #扫描一个网段下的所有活动的主机。
```

最近用了很多桌面，发现都有问题，现在看来，还是用gnome3算了，也不用纠结什么配置了，只要基本的快捷键可以使用就可以了吧，不用
追求太多的东西，其实都是次要的，在上面工作顺手才是最重要的。配置什么的，最没有影响了。感觉虽然gnome也有问题，但是感觉gnome
还是稳定一点的。

#### Ubuntu create launcher
ubuntu launcher.  alacarte
ubuntu 创建快捷方式．用这个软件．
在mate桌面上安装创建自己的启动方式．要给我的zendstudio 创建．
sudo apt-get install gnome-panel

linux rm hidden files
rm -rf * 是不会删除隐藏文件的.
rm -rf .*
这个命令会过滤调. .. ,这两个目录是无法删除的.

#### Ubuntu 关闭 crash report
ubuntu 关闭没用的 crash report。
sudo vim /etc/default/apport

#### Ubuntu N卡驱动

对硬件的了解是我的最大的弱点。
电脑的什么显卡驱动啊，什么网卡驱动，我都没有搞清楚。今天驱动挂了，所以开不开gui了，没办法，逼着
学了一把。了解了一些。

I installed latest nvidia drivers by this method:

sudo add-apt-repository ppa:ubuntu-x-swat/x-updates
sudo apt-get update
sudo apt-get install nvidia-current
It is working fine with unity 3d. Thanks to all.

幸好是可以上网，如果不能上网，我真是有点没招了。
glxinfo | head

然而，上面的命令并没有解决我的问题。看下面的这个。

http://askubuntu.com/questions/319671/how-to-change-the-graphics-card-driver-via-terminal
ubuntu-drivers devices
to get a list of your devices and identify the one you want. My output looked like this:

ubuntu-drivers devices
== /sys/devices/pci0000:00/0000:00:01.0/0000:01:00.0 ==
modalias : pci:v000010DEd00000391sv00001462sd00000630bc03sc00i00
vendor : NVIDIA Corporation
model : G73 [GeForce 7600 GT]
driver : nvidia-304 - distro non-free recommended
driver : nvidia-173 - distro non-free
driver : xserver-xorg-video-nouveau - distro free builtin
driver : nvidia-304-updates - distro non-free
I wanted nvidia-304 so I typed:

apt-get install nvidia-304
Then I rebooted and confirmed using the desktop appliaction Additional Drivers that I was indeed using the driver I had chosen.

我遇到的最本质的问题是，我不会在命令行下安装显卡驱动，切换显卡驱动。所以导致各种问题。
上面的命令正好是教会这个。

执行完上面的安装命令，然后startx sudo service start lightdm 就可以启动了图形界面了，回到原来的样子。

还看了几个其他的命令，一个是

#### ag

like ack but faster.

lspci 

glxinfo | head  如果显卡驱动有问题，这个命令会不正常。
正常的话，会列出来一些相关的东西。

modinfo 
系统默认安装的驱动是这个。
xserver-xorg-video-intel
modprobe -r nouveau  用这个命令来卸载这个模块，从内核中卸载这个模块。


2016-04-24 02:37

firefox 的flash也是不错的。我观察了下kde，发现kubuntu的问题还是很多的，搞了好几次都失败了。
最终还是放弃了，没什么意义。unity 和 kde都不太适合我的机械师。可能是显卡太高端了，不适合。
在别的电脑上可能没有问题。毕竟，很少有像我这样的脑残，拿个游戏本来玩linux。

2016-05-06 10:32

The default effects of different desktop are differnet. Now I prefer gnome , but not ubuntu-mate since
I found bad effects of eclipse in my high-definition-screen.;

mate 的 jetbrains 的字体兼职不能忍受。gnome3 is better, and I have a little bit thought about opensuse. 
try opensuse , may opensuse have a better performance for userinterface for developer in linux.

I want to change gnome3 login gdm background , just install ubuntu tweak , and you can do this change for your sys.

here is gdmsetup
https://github.com/Nano77/gdm3setup

#2016-05-10 20:07
First change /etc/sudoers files allow sudoer execute any command;
```
# Allow members of group sudo to execute any command after they have
# provided their password
# (Note that later entries override this, so you might need to move
# it further down)
%sudo ALL=(ALL) ALL
```
then add the sudo group just like this;

```
groupadd sudo
sudo usermod -aG sudo work
```
http://www.cnblogs.com/xd502djj/archive/2011/11/23/2260094.html


遇到的问题是 firefox has prevented the outdated flashplugin from xxx website.
我从官网下载 tar.gz 之后，安装还是没有解决问题。
貌似要用 apt-cache 来搜索才行，现在貌似好了，问题就是这样解决的。
sudo apt-get install flashplugin-downloader
貌似真得好了。


#### Linux 更新时间
Linux 更新时间.主要的就是这个命令.
ntpdate cn.pool.ntp.org
好像 windows 时间 和 Linux 时间一定会又一个出问题.现在有点没有办法.
将时间写入到 cmos

主要是系统时间写入 硬件时间 和 硬件时间写入系统的区别.
sudo hwclock --systohc
sudo hwclock --hctosys

#### 允许程序没有sudo权限执行

sudo chmod +s /usr/sbin/hddtemp
这样就可以让 hddtemp 在没有 sudo 权限的情况下运行了。

#### xargs
ok, today I learned about xargs command. this solve the problem like this.
rm -rf `ls`
now you can do like this;
ls | xargs rm -rf
