---
title: vim 学习笔记
date: 2016-08-28 14:43
tags:
- vim
- cscope
- ctags
---

#### vim的几个常用的插件

| 插件 | 说明 |
|---|--- |
|vim-ariline | 彩色 的状态栏 |
|nerdtree | 一个文件管理器 |
|gittur | git集成插件,可以显示修改了的内容|
|bundle  | 插件管理|
|vim-markdown | 支持markdown的语法 |
|taglist | 和ctags配合使用的，会在右边出现一列，展示所有的变量和函数。 常用的快捷键是这3个 ctrl + ] , ctrl + t ,ctrl + o |

1. `ctags` 安装比较简单`sudo apt-get install ctags` , 安装之后，进入代码目录，执行 `ctags -R .`
2. `cscope`安装 `sudo apt-get install cscope` 下载就好 ，进入代码目录，执行 `cscope -Rbkq`执行这个命令后，会生成3个文件，cscope.in.out和cscope.po.out文件,cscope.out .然后配置vim ，将如下配置文件写入vimrc 。
*vim cscope file not found*
3. 用cscope的话，需要给vim中增加一个配置。`set csre` ,具体的可以:help csre 看一下。增加这个设置，可以让vim中的cscope真正能用起来。如果没有的话，在你找到了东西想跳转的时候，会提示没有这个文件的错误，这个在下面的配置中已经增加了。

```shell
set tags=tags;  "conf for ctags
set csre        "use absolute path in cscope
if filereadable("cscope.out") 
	cs add cscope.out 
endif

if has("cscope")
	set cscopetag   " 使支持用 Ctrl+]  和 Ctrl+t 快捷键在代码间跳来跳去
	" check cscope for definition of a symbol before checking ctags:
	" set to 1 if you want the reverse search order.
	set csto=1

	" add any cscope database in current directory
	if filereadable("cscope.out")
		cs add cscope.out
		" else add the database pointed to by environment variable
	elseif $CSCOPE_DB !=""
		cs add $CSCOPE_DB
	endif

	" show msg when any other cscope db added
    set cscopeverbose

    nmap <C-S> :cs find s <C-R>=expand("<cword>")<CR><CR>
    nmap <C-G> :cs find g <C-R>=expand("<cword>")<CR><CR>
    nmap <C-C> :cs find c <C-R>=expand("<cword>")<CR><CR>
    nmap <C-T> :cs find t <C-R>=expand("<cword>")<CR><CR>
    nmap <C-E> :cs find e <C-R>=expand("<cword>")<CR><CR>
    nmap <C-Y> :cs find f <C-R>=expand("<cfile>")<CR><CR>
    nmap <C-I> :cs find i ^<C-R>=expand("<cfile>")<CR>$<CR>
    nmap <C-D> :cs find d <C-R>=expand("<cword>")<CR><CR>
endif

set autochdir
```
3. 使用，在if语句里面，我们队cscope进行了快捷键映射，这样会方便我们使用。快捷键是Ctrl 和 字母的组合，例如Ctrl + S ，可以触发:cs find s + `光标所在位置的单词`  这个命令。 其他的同理。在vim中忘记了我们设置的映射，可以用:map 来查看。关于vim 的key-binding，可以参考这篇文章，<http://yyq123.blogspot.com/2010/12/vim-map.html>。 `:h key-notation`可以查看键盘符号的详细说明。 

#### vimscript

下面是一些简单的vimscript内容。

```
vim 中定义变量要用

let a=123  空格并不能影响效果，这一点和shell并不一样.
echo a
这样就可以看到效果。

在 vimrc 中可以写简单函数，来做一些想做的事情，比如
根据文件后缀，自动执行脚本程序。

:echo %    这个是获得当前文件的全名，包括后缀的。
:echo %<   和下面的一行作用一样。
:echo %:r  这个是获取当前文件的文件名，除去扩展后缀
```

插入模式下的 vim ， ctrl + j 可以将文本内容下移一行。ctrl + m 我也不知道具体是什么，
我只是通过实验尝试出来的。


#### vim slowstart

vim --startuptime vim.log -c q
sudo vim 启动速度超级慢。
vim 启动速度变慢.在终端中可以这样启动 vim -X 这样是不需要和X挂上勾的,所以会变慢.修改了一下之后
瞬间感觉电脑变快了.vimariline这个插件会明显增加启动时间，加之没什么用，后面就从我的vim插件里面去掉了。

调查之后，发现是我把系统的hosts文件删除了，touch了一个空文件。
后面，总是提示unresolve host 的提示。 
在增加了我的hostname在host中之后，sudo vim 速度就快了。开来和这个也有关系。


#### vim 常用操作

1. vim 记录上次编辑位置。加入这一行` au BufReadPost * if line("'\"") > 0|if line("'\"") <= line("$")|exe("norm '\"")|else|exe "norm $"|endif|endif `到vimrc里面
2. vim 删除重复行 `sort`然后`g/^\(.\+\)$\n\1/d`
3. vim 插入当前时间,在vimrc中加入这个map，在normal模式下，输入,dt就可以在当前位置插入时间了`map ,dt a<C-R>=strftime('%Y-%m-%d %H:%M')<CR>`。
4. vim find 在vimrc中加入如下配置`set path=/home/yourpath`,在vim命令行中查找文件，有了这个配置之后，就会在这个目录下进行搜索。

#### vim 导入其他文件内容
将当前文件的部分内容导入到其他文件
1,20 w>> /path/otherfile.txt
1,20 w /path/otherfile.txt
具体命令就是这样。

同样的，也可以将其他文件的内容读入到当前文件来。命令是这个
r: /path/file.txt

同时，这个命令也可以将外部程序的输出读入到当前文件中。
r !date
这样也是可以插入时间的。将这个命令用map命令映射一下，就可以得到和那个实现的同样的功能了。
设置VIM为shell的默认编辑器
export VISUAL=vim
export EDITOR="$VISUAL"

#### vim和系统共享剪切板

首先需要补充的一点是，+寄存器是只有vim-gtk 或者 vim-gnome 才会有的，不要只安装了
vim，这是不够的啦，在安装的时候需要注意一下，不然是无法使用系统剪切板的啦。
复制单个字符， nyl n 是数字，l和vim的方向键一样，表示向后，就是向后复制n个字符。
同理，nyh 表示向前复制n个字符。这样就可以很自由的复制了。
复制单词 ynw 其中n是数字，表示要复制的单词的个数。
按行为单位复制：
nyy 表示复制n 行，和上面的命令差不多。应该是向下取的。
p 表示粘贴，注意小写，这个是代表粘贴在下面。
P 也表示粘贴，这次是大写啊，这个是代表粘贴在前面。
估计对于字符复制粘贴的内容也是同样的规则啊。
"+y 表示复制到系统剪切板去。这个应该忘不了吧。

vim 有很多的粘贴板，这些东西的用处你自己应该可以理解，一般情况下，都是只用一个粘贴板
的，但是粘贴板多一点也是没有坏处的啊。vim中的复制是用y来完成的，在这之前，你当然可以
决定你的内容是存放在那个粘贴办中，你可以用reg来查看这些粘贴板中都存了什么内容，同时
p是用来复制的，你也可以在复制之前决定你从哪个粘贴板中复制内容，例如"4p表示是从4好粘
贴板中拿东西。如果4好粘贴板中有你存下的内容的话，那么他就可以复制出来了，结合上面的
命令，你当然可以做成你想做的。
复制到第n 个粘贴板的命令: 先选择要复制的内容，然后"ny 就可以将这些内容放到粘贴板了。
然后在你想复制的地方"+p 就可以了。
