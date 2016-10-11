---
title: Ubuntu学习笔记
date: 2016-09-09 14:42
tags:
- linux
- ubuntu
---

#### tmux vim slowstart

tmux 中vim slow start 的原因,就是因为开了多个tmux,启动速度就变慢了.
查看了slowlog,发现是因为xsmp消耗了大概1s的时间.只要保证一个tmux运行就可以了.

让你的ubuntu文件夹变成彩色的.
可以添加下面的ppa,添加这个
sudo add-apt-repository ppa:costales/folder-color
然后安装下面这个 folder-color 就可以了.
sudo apt-get install folder-color

#### ubuntu get source code
如何获取ubuntu的源码
你可以获取任何一个你所使用的源码包.这就是开源的系统.
只要你的系统的源里有dep-src 这个选项,那么就可以随便获得系统源码.
就像下面这样.

```bash
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

#### ubuntu自己编译出deb

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
加油吧.^_^

#### ubuntu desktop

firefox 插件 `json`, `vimperator`, `firebug`.
chrome插件 `json` , `vimium` , 登录自己的账号之后，可以同步chrome插件和书签，很方便

ubuntu 关闭没用的 crash report。
执行`sudo vim /etc/default/apport` 把那个1 改成0
ubuntu 上换显卡驱动要谨慎，很容易就重登陆之后就进不去系统了。如果进不去系统了，那就去认真google吧。我曾经折腾过，这里就不记录了，
总之不建议在在ubuntu上折腾太多桌面的东西，linux是用来做server的，好多经典的软件都是no gui的。所以应当将精力放在server这边来，桌面的话，
简单玩玩就可以了。

在你的本地文件里面. .local/share/applications/ 里面把对应的删除,重新登陆就可以看到你讨厌的那个东西不见了.

重启linux的图形界面`startx sudo service start lightdm `
`lspci` 和 `glxinfo | head`  如果显卡驱动有问题，这个命令会不正常。
正常的话，会列出来一些相关的东西。

modinfo 
系统默认安装的驱动是这个。
xserver-xorg-video-intel
modprobe -r nouveau  用这个命令来卸载这个模块，从内核中卸载这个模块。

ubuntu firefox flash `sudo apt-get install flashplugin-downloader`

在linux中,我想升级gedit,比如说我的是 ubuntu14.04, 但是在 ubuntu15.10 里面,gedit 的版本是比
我的新的.但是在14.04里面我确用不了最新的gedit .
这个时候,我可以从官网下载最新的gedit ,安装,然而安装的时候会出现一些问题.这时候怎么办呢.可以这样.

```
sudo apt-get build-deb gedit
```
然后执行安装命令就可以了.安装应该不会出错了.

ubuntu 创建自定义的快捷方式launcher。
ubuntu launcher.  alacarte
在mate桌面上安装创建自己的启动方式．要给我的zendstudio 创建．

`rm -rf *`是不会删除隐藏文件的.  linux rm hidden files `rm -rf .*`
这个命令会过滤调. .. ,这两个目录是无法删除的.

ubuntu 安装中文字体
```shell
sudo apt-get install mysql-workbench
sudo apt-get install ttf-wqy-microhei  
sudo apt-get install ttf-wqy-zenhei  
```


#### linux 权限管理

```shell
# provided their password
# (Note that later entries override this, so you might need to move
# it further down)
%sudo ALL=(ALL) ALL

groupadd sudo
sudo usermod -aG sudo work

```
http://www.cnblogs.com/xd502djj/archive/2011/11/23/2260094.html

允许程序没有sudo权限执行
sudo chmod +s /usr/sbin/hddtemp
这样就可以让 hddtemp 在没有 sudo 权限的情况下运行了。


#### Linux 更新时间
Linux 更新时间.主要的就是这个命令.
ntpdate cn.pool.ntp.org
好像 windows 时间 和 Linux 时间一定会又一个出问题.现在有点没有办法.
将时间写入到 cmos

主要是系统时间写入 硬件时间 和 硬件时间写入系统的区别.
sudo hwclock --systohc
sudo hwclock --hctosys


#### ubuntu 常用命令

| 命令 | 说明 |
|---|--- |
|`apt-cache search` | ubuntu 在source里查找某个软件包|
|`apt-cache install` | 安装指定的软件包 |
|`dpkg -i your.deb` | 安装一个deb文件 |
|`sudo dd if=/home/your.iso of=/dev/sdb` |  用U盘烧镜像 |
|`groups faith` | 查看faith的用户详情|
`ls | xargs rm -rf *`这个命令比较调皮，markdown的表格里写不进去，单独拿出来伺候。`删除文件，主要是xargs，可以将管道传过来的内容交给后面的命令，作为它的输入`
