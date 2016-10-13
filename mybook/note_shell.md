---
title: shell 学习笔记
date: 2016-09-09 14:42
tags:
- shell
- awk
- sed
- grep
---

#### awk

the follow command can be used to restart php-fpm in server.
ps aux | grep 'php-fpm' | awk '{print $1}' | xargs kill -USR2 
-F option 是用来改变默认的分隔符的。
awk -F ':' '{print $3}'
awk 的 BEGIN 和 END 语句的功能。
BEGIN 是最开始的部分执行的，然后AWK开始读取文件内容，进行处理。
END 是最后面结束执行的.
`$NR` 是拿到最后一列。
#### sed笔记

```shell
sed 's/xx/ds/' note

[ ! -x result ] && mkdir result
for i in `ls *.grb`
do
    out=`echo $i | sed 's/GLDAS_NOAH10_M.A//' | sed 's/\..*[[:graph:]]//'`
    wgrib $i > result/$out".out"
done

sed -i "This command to use replace the input file"
just a simple example.
sed -i 's/--/-/'
```
**mac 下sed -i 的问题**

```
sed -i 's/a/b'       #linux style
sed -i '' 's/a/b/'   #mac style , mac 上的sed要求给一个备份文件的文件名，会在替换前做一个备份，
#不需要的话给个空参数，就不会备份。  前面的那个空格不能少
```
d 表示是删除的意思。用新文件覆盖旧文件。
sed '/vim/d' ~/.bashrc > ~/.bashrc

#### grep

grep -E   支持扩展的正则 
grep -o   只输出指定内容, only-match 的含义
grep -F   相当于 fgrep
grep -v   不匹配指定正则的指令
grep 输出匹配内容的上下两行内容,输出上下文,记得这个参数.
grep -C 2 'linux'
grep -i 进行大小写无关的搜索
grep -P perl分格的正则

```shell
grep -i -Po "HREF=\".*?\"" bookmarks_4_27_15.html
```

#### find使用的例子

下面这个script结合了find 的regex参数的用法。find regex 和 那么的区别还是挺大的。regex搜索的输出是全名的，name知识一个短的名字。

```shell
#!/bin/bash
# 要搜索的路径。
path="$HOME"

for i in `find $path -regex ".*/[0-9]\{6\}/*" -type d 2>/dev/null`
do 
    echo $i
    for j in `ls $i`
    do
        echo $j
        m=`echo "$j" | cut -d. -f2`
        if [ $m != 'log' ]
        then
            echo "mv for $j"
            mv $i"/"$j $i"/"$j".log"
        fi
    done
done
```

#### shell重定向

来自这个链接 <http://www.cnblogs.com/yangyongzhi/p/3364939.html>

./Test.py 1>normal 2>error 3>&2 2>&1 1>&3  
./Test.py 3>&2 2>&1 1>&3 1>normal 2>error  

可以通过这两个命令看出差别,其实就是从右向左执行的.

具体的执行过程是这样的,一个完整的shell指令的执行是从右往左的.
先执行 1>&3 , 然后执行 2>&1 , 3>&2

nohup的使用
在mac中，在tmux中使用nohup会有问题，会抛出下面这样的错误。所以只能在开一个终端执行。
nohup: can't detach from console: Undefined error: 0
```shell
nohup redis-server & >/dev/null
```
#### git 笔记
一个项目可以添加多个源,origin是默认的一个源.并且也可以跨源合并.这是比较高级的用法.
如果要跨项目合并. git 跨项目合并.

git remote add code "url"
git push code master

git remote add.

将一个远端的项目添加到新的分支上,然后可以合并。
git remote add name git@gitlabserver.meiliworks.com:higo/api.git
删除这个分支。
git remote rm old_pandora
git 将某个分支强制覆盖。比如我想用newpush  的代码完全覆盖 master 的代码。
可以这样做。
git push origin newpush:master -f

git remote add origin url  #这样可以讲自己的git目录添加到远端仓库.很方便.
同一个项目可以添加多个远端仓库,可以一起使用.

git config --global core.editor "vim"
git config core.fileMode false
这样你的git就不会官 fileMode 的变化了，默认的模式是 true 的。

#### shell get your ip

```
ifconfig | grep -E -o "inet ([0-9]{1,3}.){3}([0-9]{1,3})" |  grep -E  -o "([0-9]{1,3}.){3}([0-9]{1,3})" | tail -n 1
ip a| grep -E -o "inet addr:([0-9]{1,3}.){3}([0-9]{1,3})" |  grep -E  -o "([0-9]{1,3}.){3}([0-9]{1,3})" | tail -n 1

```

linux 下 ifconfig | grep 'inet ' | awk '{split($2, ip_cntr, ":"); print ip_cntr[2];}'
netstat --tunlp |grep 90

#### shell functions

函数的返回值,函数的参数.
<http://www.jb51.net/article/33895.htm>
这里看到了一些参考,主要是这两个参数, $@ 和 $* 是一样的,可以将函数的参数当做一个字符串.
如果你仍然利用$1,$#,$0这些而参数,那么你可能得不到你想要的结果.

```shell
shell 执行字符串命令。可以这样。
eval $cmd

date '+%Y-%m-%d'
httpd -S

shell 脚本中的 空变量。可能是你的程序报错，所以写判断的时候需要考虑变量为空的情况。
如果出现这样的情况，报的错误可能是这个。
"[: =: unary operator expected"

a=$(($i + 1))

同时满足2各条件

if test "$dev" = "0" -a "$devok" = "0" ; then
	echo "your comment"
	echo "your comment"
exit 1
fi
```
shell中函数的返回值貌似可以用 $? 变量拿到。
但是 return 是不支持返回非数字类型的。这是不是一个新的约束条件。
对于数值运算，可以实用 expr 这个工具，其实这是另一个简单的工具，可以用 man 手册来查看帮助文档。
shell 中有几个比较特殊的变量。
$0 表示当前脚本的名字
$1 $2 ... $i  第 i 个参数
$# 参数的个数。
$?

如何调试shell。
bash -x your.sh 就可以看你的shell的执行过程了。
或者在shell的开始部分增加一行，set -x。

`crontab l`列出当前的任务。分 时 日 月 星期  执行命令,* 表示任意的变量;
在linux 下，你当前用户的crontab文件存放在 /var/spool/cron/ 目录下，这个文件以你的用户身份命名。

```shell
00 23 * * * run-your script  每天23:00 执行你的脚本。其实我需要做的就是一行命令。
10 1 * * 6,0 /usr/local/etc/rc.d/lighttpd restart  这个任务表示每周6和周日的1:10重启服务器。注意逗号，表示多个的意思。再看下面一个。
* */1 * * * /usr/local/etc/rc.d/lighttpd restart  注意这个符号/ 表示每个一个小时重启一下服务器。
```
