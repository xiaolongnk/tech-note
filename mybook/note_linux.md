---
title: linux 标准开发环境
date: 2016-10-11 10:18
tags:
- linux
- web
- zsh
- spider
---

在我们拿到一个刚被初始化的server之后，我们需要做一些配置工作，才能让这台server变成适合我们的工作机，一般来说，我通常会做下面这些准备工作。

#### 配置zsh
大部分学习linux的刚接触的基本都是bash，我之前也是，最近了解了zsh之后，发现zsh确实很强大，好多地方都很人性化，所以这里也推荐大家尝试一下，不喜欢的话可以再滚回bash。
简单介绍一下zsh的优点：
1. 强大的补全功能
2. git命令的完美支持
3. autojump 可以迅速切换目录，支持模糊匹配，比我之前了解的前缀匹配强多了
上面这三点以前用bash的时候我都是自己在配置问价里面，集成了一些插件搞出来的，现在zsh里面都是现成的了。

zsh 和 oh-my-zsh 相关文章已经很多了，我也是参考了他们的文章开始的。 https://zhuanlan.zhihu.com/p/19556676 

```shell
sudo apt-get install zsh
wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | sh
chsh $USER -s $(which zsh)  #将系统的bash换成zsh
wget https://github.com/downloads/joelthelion/autojump/autojump_v21.1.2.tar.gz
```
zsh 的插件，默认会装git，我这里装了autojump。
配置过程中，遇到了任何问题，请参考上面那个链接。

#### 基本的配置

1. vim，基本的编辑器，对我来说，只会用vim，nano都不怎么会，emacs更是不用提。vim的初始化，这里有一套比较成熟的配置文件，可以比较方便的搞定，一般情况，可以将一些个人习惯的配置脚本化，我就这样做了，基本软件的安装可以用脚本很方便的完成。需要配置常用的扩展，并配置正确的vimrc。可以参考我的那篇vim的文章。
2. git 需要搞定~/.gitconfig
3. openssh-server 默认情况下，需要安装这个，才可以远程ssh连接。
4. ag 一个更强大的grep，类似的还有ack
```shell
sudo apt-get install vim-gtk
sudo apt-get install git tig
sudo apt-get install openssh-server
sudo apt-get install silversearcher-ag
```

#### 标准的web环境
通常来说，一套相对简单的web开发环境，服务器软件到，php，再到存储层，包括需要以下这些组件的支持。

1. nginx  编译安装，参考编译nginx的文章
2. php    编译安装，参考编译php的文章
3. php扩展 (redis , memcached , imagic , gmagic) 编译安装
4. mysql  (可靠存储)
5. redis  (缓存)
6. memcached  (缓存)

安装命令:

```shell
sudo apt-get install mysql-server
sudo apt-get install redis-server
sudo apt-get install memcached
```

#### python(2.7) 环境

1. pip , ipython
2. Scrapy  python的爬虫框架
3. python-openssl-dev

安装命令如下:
```shell
sudo apt-get install python-pip
sudo apt-get install python-openssl-dev
sudo -H pip install --upgrade pip
sudo -H pip install Scrapy
```

#### node 环境

1. nvm (node version manager)
2. npm (node package manager)

安装完nvm需要重启一下shell。或者source 一下你的.zshrc 或者 .bashrc。

```shell
wget -qO- https://raw.github.com/creationix/nvm/v0.4.0/install.sh | sh
nvm install 0.10
sudo apt-get install npm

npm install -g cnpm --registry=https://registry.npm.taobao.org

或者下面这个

echo '\n#alias for cnpm\nalias cnpm="npm --registry=https://registry.npm.taobao.org \
  --cache=$HOME/.npm/.cache/cnpm \
  --disturl=https://npm.taobao.org/dist \
  --userconfig=$HOME/.cnpmrc"' >> ~/.zshrc && source ~/.zshrc

npm install hexo-cli -g
```

npm 淘宝镜像<https://npm.taobao.org/>
安装hexo <https://hexo.io>

#### php 相关

1. composer (php package manager)
2. laravel

安装composer
```shell
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```
更多参考，请看[这里](https://segmentfault.com/a/1190000000353129)

