### MAC 使用心得 
安装vim

默认情况下，mac terminal中是带了vim 的。但是vim --version 看一下，发现是7.3版本的。
这个版本的vim，和mac系统的clipboard交互有点困难。如果想将vim中的内容复制出来的话，会有点
麻烦，这又是一个很常用的操作，所以很麻烦。查资料可以知道，7.4的vim可以支持。所以我们通过
安装7.4版本的vim来解决这个问题。安装方式如下：
```
brew install vim -clipboard -xterm_clipboard --with-client-server

上面的命令不能成功，出一个很奇怪的错误，所以就没有太纠结。
brew install vim --override-system-vim

通过提示可以知道，安装后的vim在下面这这个路径,我们可以通过一个简单的alias搞定。
alias v='/usr/local/Cellar/vim/7.4.2152/bin/vim'

```
然后再试一下，发现不管是vim，还是tmux中都可以看到*寄存器了呢。有了这个寄存器，就说明
我们的vim剪切板可以和clipboard之间交互了呢。

vim backspace不能删除内容的解决方案

可以通过增加配置来解决。
```
set nocompatible
set backspace=indent,eol,start
```

