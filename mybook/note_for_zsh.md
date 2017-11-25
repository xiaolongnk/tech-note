### 配置zsh

![linux zsh mac autojump](https://omssgfgqf.qnssl.com/images/2017/11/25/15116096354756.png)
大部同学刚学习linux的时候基本都是从bash开始的，我之前也是，最近了解了zsh之后，发现zsh确实很强大，好多地方都很人性化，所以这里也推荐大家尝试一下，不喜欢的话可以再滚回bash。
简单介绍一下zsh的优点：
    * 强大的补全功能
    * git命令的完美支持
    * autojump 可以迅速切换目录，支持模糊匹配，比我之前了解的前缀匹配强多了
上面这几个特性在bash中也可以实现，但是实现起来也相对复杂。在oh-my-zsh中，这些功能配置起来相对容易很多。oh-my-zsh 相关文章已经很多了，我也是参考其他文章开始的。

首先安装zsh，mac和ubuntu下安装zsh的方法。
>   brew install zsh
>   sudo apt-get install zsh
下载oh-my-zsh并安装
>   wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | sh
>   chsh $USER -s $(which zsh)  #将系统的bash换成zsh
下载autojump，并安装autojump.
>   wget https://github.com/downloads/joelthelion/autojump/autojump_v21.1.2.tar.gz
>   tar -zxvf autojump_v21.1.2.tar.gz
>   cd autojump
>   ./install.sh

`./install.sh`安装完之后，会提示我们将`[[ -s ~/.autojump/etc/profile.d/autojump.sh ]] && . ~/.autojump/etc/profile.d/autojump.sh`这一行加入到我们的.zshrc里面，写的位置需要注意一下，一定要放在.zshrc中`source $ZSH/oh-my-zsh.sh`这一行的前面。否则会出现需要执行2此source ~/.zshrc 才会生效的现象。

配置2个插件，我们这里安装git的和autojunp 的。装了git的插件之后，zsh的prompt会显示出当前的目录中git repo 的分支
。autojump插件会记录下常见的目录，下次进入这个目录的时候，可智能补全，比Tab补全强大很多，Tab补全只是基于当前目
录下的所有文件的，但是autojump是基于历史目录的,所以用起来会方便很多，可以快速访问常用目录。
>   plugins=(git autojump)
>   [[ -s ~/.autojump/etc/profile.d/autojump.zsh ]] && . ~/.autojump/etc/profile.d/autojump.zsh

参考资料: https://zhuanlan.zhihu.com/p/19556676 

