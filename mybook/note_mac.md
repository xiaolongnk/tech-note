---
title: MAC 使用心得
date: 2016-08-23 14:40
tags:
- 开发工具
- mac
---

#### mac中让vim共享剪切板 

安装vim

默认情况下，mac terminal中是带了vim 的。但是vim --version 看一下，发现是7.3版本的。
这个版本的vim，和mac系统的clipboard交互有点困难。如果想将vim中的内容复制出来的话，会有点
麻烦，这又是一个很常用的操作，所以很麻烦。查资料可以知道，7.4的vim可以支持。所以我们通过
安装7.4版本的vim来解决这个问题。安装方式如下：

```bash
brew install vim -clipboard -xterm_clipboard --with-client-server
#上面的命令不能成功，出一个很奇怪的错误，所以就没有太纠结。
brew install vim --override-system-vim
#通过提示可以知道，安装后的vim在下面这这个路径,我们可以通过一个简单的alias搞定。
alias v='/usr/local/Cellar/vim/7.4.2152/bin/vim'
```

然后再试一下，发现不管是terminal中的vim，还是tmux中都可以看到*寄存器了。有了这个寄存器，就说明
我们的vim剪切板可以和clipboard之间交互了。

vim backspace不能删除内容的解决方案

可以通过增加配置来解决。

```vim
set nocompatible
set backspace=indent,eol,start
```


#### mac 中编译安装php nginx

编译的过程中，很可能遇到这个问题。
找不到openssl的header files。
其实解决办法就是安装openssl。brew install openssl 。

但是只是安装了也可能报这个错误。找到了下面这个帖子。来自 stackoverflow。
核心的是这个 

brew install openssl
brew link openssl --force

遇到其他的报错，卡主了 confiture ，基本上用brew 安装那个就可以过关了。
configure 过了之后，就可以make && make install 了。

```
If you are on Mac OS X El Capitan, Apple doesn't include openssl any more because of security problems openssl had, I have similar problem installing Passenger. brew just installs openssl itself without development headers.

If you are on an older version of Mac OS X than El Capitan, you can use: xcode-select --install which installs openssl development headers as well.

EDIT:

Updating brew and installing openssl and force linking openssl to brew version solved my problem:

$ brew update 
$ which openssl  
/usr/bin/openssl 
$ brew install openssl
$ brew link openssl --force 
$ which openssl 
/usr/local/bin/openssl
```


#### mac 上虚拟linux 

一般来说，mac和linux已经非常像了，但是有些工作(比如，搭建服务器环境，编译nginx，php什么的，在linux下会方便很多，再比如要搞php源码，学学扩展开发什么的)，还是建议在linux下搞。所以在mac上，我们仍然需要一个linux。想到了virtualbox。

virtualbox的使用。mac的retina屏幕，导致在上面安装ubuntu桌面之后，分辨率很是难用，所以想要和之前一样使用linux的话就比较困难了，在retina屏幕上看见超低分辨率还是难以接受的。
但是考虑到我们的日常，基本都是在terminal里面度过，所以我们完全可以放弃linux桌面，用mac的terminal ssh 到我们的虚拟机就可以了。需要解决的问题就是网络问题。让主机和虚拟机在同一个网段，这样就可以互相ssh了。
更改virtualbox的网络设置，把默认的NAT方式换成birdge方式，并且在高级选项里面选成allow all。重启虚拟机，看一下ip，发现和主机在同一个网段了，然后就可以ssh进去，愉快的玩耍了。

有了这个方案之后，我们可以利用虚拟机做一些集群相关的实验，只需要多安装几个虚拟机就可以了，同样的方法。不过貌似virtualbox的网络adaptor最多只有4个，不过4个应该也足够了。

