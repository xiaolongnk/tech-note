## MAC 包管理器homebrew
`mac`下`lnmp`环境的配置。在mac下配置开发环境，首先应该掌握的工具就是`brew`,全称叫`homebrew`,方便起见，后文中我们都用简称。`brew` 有点类似linux的apt-get,yum 之类的工具，提供的服务虽然比不上在linux下的体验，但是对开发者来说也是方便很多了。用`brew`安装之后的软件包基本都在`/usr/local/` + 软件包的名字。比如说配置会在`/usr/local/etc/php/`,可执行程序bin会在`/usr/local/bin/`下面. 要配置好lnmp环境，我们需要安装`nginx`,`mysql-server`,`php`以及相关的扩展。当然上面的这些软件，我们都可以通过下载源码，然后自己编译安装的方式来完成，但是笔者认为这种方式比较看脸，有时候可以，有时候不可以，在我尝试了几个小时都没能搞定重编php的问题之后，我决定转向brew求助，没想到还真成功了，为了让下次再重新配置环境时省点时间，我决定认真研究一下`brew`这个东东，然后用blog的方式将这个过程详细的记录下来，以期减免一些重复劳动的代价。在开始安装之前，我们最好执行以下这个命令`xcode-select --install` 和 `xcode-select --upgrade`

**安装homebrew**

> `/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`

如下图所示，在terminal中执行这个命令,一路确认即可成功安装。
![安装 homebrew](https://omssgfgqf.qnssl.com/images/2017/11/08/15101204044424.png)

`brew`支持的几个命令`brew info`,`brew install`,`brew upgrade`, `brew install` 用来安装需要的包，`brew info` 可以查看这个包的安装信息，比如说用brew安装了nginx，但是几天之后不知道nginx的配置文件装到哪里了，就可以用`brew info`这个命令来查看。`brew upgrade`是用来更新软件的，如果**[tmux](https://blog.nofile.cc/2017/07/06/tmux-%E5%85%A5%E9%97%A8/)**已经安装过，但是版本比较老，可以用`brew upgrade tmux` 来更新`tmux`。

## brew 安装 mysql 和 php
`brew` 安装`mysql-server`:`brew install mysql`
`brew` 安装`php71`:在mac的brew仓库中，php有好多个版本，可以用`brew search php`来查看仓库中的所有的php包。`brew search php`查看之后，我们选择安装php71 ，这个相对稳定。如果需要其他版本的，也可以自己选择。`brew install php71` 安装完成之后，b`brew`会将安装信息给列出来，还会提供一些其他的信息，比如说对`php-fpm`还会告诉你，将`php-fpm`加入开机启动中的方法，所以安装玩一个软件包之后，最好可以认真读一下`brew`给我们的提示信息。

## 安装php的redis扩展
所有`php`扩展的安装方式都类似，下面是几个例子，只需要知道需要什么报名就可以，如果只知道个大概，可以用`brew search`搜索来帮助确定，确定之后安装就可以了。安装完成后，请用`php -i | grep redis` 来验证`php-redis`扩展存在，同理可以验证其他扩展，这里省略。
> `brew install php71-redis`
> `brew install memcached`
> `brew install mongodb`

## brew 安装 nginx 
这里，在`MAC`上的`web php`开发所需要的软件基本都安装完成了，我们可以通过下面的方式来启动服务。启动服务和关闭服务也比较麻烦，我们可以实现一个脚本将他们集成起来，以方便我们快速的启动脚本，这里提供一个我自己的**[nginx php 服务脚本](https://coding.net/u/xiaolongnk/p/mscript/git/raw/master/shell/m_start)**，大家可以参考,通过命令`m_start start|stop|restart`来使用。
> `brew install nginx`
> `sudo nginx`
> `sudo /usr/local/sbin/php-fpm`

![nginx php-fpm](https://omssgfgqf.qnssl.com/images/2017/11/08/15101223517163.png)
最后用`ps`来检查一下我们启动的服务，验证正常。目前需要的软件基本都安装好了，也可以启动了，但是他们都是以默认配置运行的，一般来讲，`php`和`nginx`都需要我们单独配置一下，才能和我们的项目运行起来，配置的问题，我们下一节在具体来说，传送门:**[php nginx 配置](https://blog.nofile.cc)**。

**最后想说的是，在`mac`上尽量少编译东西，能用`brew`就用`brew`，包依赖的复杂，不是那么容易就能搞定的,人身苦短，尽量把精力放在有意义的事情上。**
