---
title: MAC 使用心得
date: 2016-08-23 14:40
tags:
- 开发工具
- mac
---

#### MAC 使用心得 
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


#### MAC编译安装php nginx

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

