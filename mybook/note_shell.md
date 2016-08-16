---
title: shell 学习笔记
---
#this file is use to log shell skills .

awk

simple awk skill is necessary.

the follow command can be used to restart php-fpm in server.

ps aux | grep 'php-fpm' | awk '{print $1}' | xargs kill -USR2 

-F option 是用来改变默认的分隔符的。
awk -F ':' '{print $3}'

awk 的 BEGIN 和 END 语句的功能。
BEGIN 是最开始的部分执行的，然后AWK开始读取文件内容，进行处理。
END 是最后面结束执行的.


sed
sed 用得最多的就是替换了。很多时候，grep就足够了。

sed -i "This command to use replace the input file"
just a simple example.
sed -i 's/--/-/'


sed 
下面是一点关于 sed 的东西。刚才写的一个脚本，主要是用来处理字符串的。当然 for 循环也是值得学习的。
还有判断一个目录是否存在。

其中s是用来做替换用的。
sed 's/xx/ds/' note

[ ! -x result ] && mkdir result
for i in `ls *.grb`
do
    out=`echo $i | sed 's/GLDAS_NOAH10_M.A//' | sed 's/\..*[[:graph:]]//'`
    wgrib $i > result/$out".out"
done

d 表示是删除的意思。用新文件覆盖旧文件。
sed '/vim/d' ~/.bashrc > ~/.bashrc
刚才才发现原来 shell 的字符串判断相等是 = 左右两天加个空格就可以了。如果不加空格就是赋值。
这种语法还是有点诡异的啊。
并且现在很少写 if 这个东西了，自从我发现了 if 语句可以简写之后。
字符串操作还是又必要掌握一下的。
果然shell python 相比来说直截了当多了。正是因为 shell 在字符串处理上的缺陷，所以才有了sed这样
的工具来补充吧。
当然还有awk。


grep

find

这四兄弟，简直就是 linux 的 什么一样。

### 2015-12-04 11:39

来自这个链接 <http://www.cnblogs.com/yangyongzhi/p/3364939.html>

./Test.py 1>normal 2>error 3>&2 2>&1 1>&3  
./Test.py 3>&2 2>&1 1>&3 1>normal 2>error  

可以通过这两个命令看出差别,其实就是从右向左执行的.

具体的执行过程是这样的,一个完整的shell指令的执行是从右往左的.
先执行 1>&3 , 然后执行 2>&1 , 3>&2


一个项目可以添加多个源,origin是默认的一个源.并且也可以跨源合并.这是比较高级的用法.
如果要跨项目合并. git 跨项目合并.

git remote add code "url"
git push code master

grep get yourip.

ifconfig | grep -E -o "inet addr:([0-9]{1,3}.){3}([0-9]{1,3})" |  grep -E  -o "([0-9]{1,3}.){3}([0-9]{1,3})"
ip a| grep -E -o "inet addr:([0-9]{1,3}.){3}([0-9]{1,3})" |  grep -E  -o "([0-9]{1,3}.){3}([0-9]{1,3})"

linux 下 ifconfig | grep 'inet ' | awk '{split($2, ip_cntr, ":"); print ip_cntr[2];}'

tmux.conf
想在tmux.conf中添加一些shell脚本,可以获取到我自己的IP地址.
这样我在连接代理的时候,就不用是自己查了.我把自己的tmux的status line 搞成了1s刷新一次.用了这个命令.

set status-interval 1

egrep grep -E
fgrep grep -F 只支持简单的全部匹配,部支持正则匹配.

nohup command > out.txt 2>&1 & 这样是将所有的输出,包括错误都重定向到out.txt中.

grep 输出匹配内容的上下两行内容,输出上下文,记得这个参数.
grep -C 2 'linux'
是用nohup命令,完了这个命令就没有办法停止了,就会一直运行,除非用kill命令讲这些命令kill调.

### 2015-12-12 23:35
git remote add.

将一个远端的项目添加到新的分支上,然后可以合并。
git remote add name git@gitlabserver.meiliworks.com:higo/api.git
删除这个分支。
git remote rm old_pandora
git 将某个分支强制覆盖。比如我想用newpush  的代码完全覆盖 master 的代码。
可以这样做。
git push origin newpush:master -f

shell_function;

函数的返回值,函数的参数.
<http://www.jb51.net/article/33895.htm>
这里看到了一些参考,主要是这两个参数, $@ 和 $* 是一样的,可以将函数的参数当做一个字符串.
如果你仍然利用$1,$#,$0这些而参数,那么你可能得不到你想要的结果.
并且,我在shell下添加了一些常用的颜色的变量,只要. ~/.colorful 就可以使用这些变量了.
可以进行一些彩色的输出,是得程序更加明确.
其他的就是对shell更加熟悉了,大小的比较,相等的比较.还有if else elif 这样的语句,也好多了.
我的那个启动脚本更加明确了.
同时,我还发现了,vim中也可以做一些在insert mode下的快捷键绑定,这样可以方便很多.
Goods job.


第一步：添加".gitignore"文件
往项目根目录添加一个文件".gitignore"。这文件和".git"文件夹同级。
但是在windows下无法创建".gitignore"文件名，必须把文件名改成这样".gitignore.",
在文件名最后加一个英文句号就可以了。
第二步：设置过滤条件

1.如果新建一个空的Git仓库。直接拉取就可以了。
git rm --cached <文件名> 删除文件的缓存
git rm --cached -r <目录名> 删除目录下的所有文件的缓存
通过上面的命令把缓存删除后，commit后再push到服务器。
其它的团队成员可以直接pull，过滤功能就能正常使用了。

主要是会发生这种情况,就是一个git里面套了一层子git项目.这时候,要么是忽略子项目,要么是
添加ignore文件.也可以讲子项目的git删除,这样就好了.如果要中途修复这种情况,需要使用
上面的命令.

git remote add origin url  #这样可以讲自己的git目录添加到远端仓库.很方便.
同一个项目可以添加多个远端仓库,可以一起使用.


### mount 命令  fstab
Linux mount 可以讲一块磁盘挂在一个目录下.挂载之后,这个目录原来的内容就不存在了.
如果umount 之后,这个目录下面的空间就出现了,这一定和底层的实现有关系.操作系统究竟
是如何管理存储空间的,这些问题都是需要研究的.目前,所指导的可以解决这些基本问题了,
我可以很好的扩展我的系统空间不足的问题,但是我觉着对于

如果要解决这个问题,还需要一些挂载的知识,我需要讲自己的磁盘挂在系统上,让系统启动的时候自动
帮我挂上.而不是每次都让我自己去挂.
mount 里面也有很多.


fstab 的编写,其实还可以,就是将最前面的盘符换成具体的磁盘设备就可以了.
可以像下面这样,把你的磁盘随便挂上去.这就是 home分区分开使用的好处,单独挂载一个
磁盘之后,就具备比较好的扩展性了.只要内容没有损坏,就可以随便安装到任何一个新系统
上去.大部分内容都是放在/home里面的,或者可以把自己常用的软件都安装在一个指定的目录
下,这个目录可以


```shell
UUID=684e471c-215b-4520-b3d6-09c6e5316ee2 /               ext4    errors=remount-ro 0       1
# swap was on /dev/sda6 during installation
UUID=08488fed-d6f4-4fa2-b935-dd599851d98d none            swap    sw                0       0
/dev/sda5                               /home             ext4    defaults,noatime  0       0
```

刚才遇到的问题好奇怪
1. 挂在分区之后,输入密码进不来系统,我发现是我的新的home目录没有权限,把owner 改成我自己,然后就可以
利用图形界面进来了.
2. 我进来之后,发现我的steam 用不了了,我拷贝了所有的文件,发现还是不行,再后来发现是我的home中的所有
的二进制文件都没有办法执行,上网找,发现是我的挂在参数有问题,用了defaults,noatime 之后就好了.真是神奇.
后面遇到这样的问题就不会慌了.解决问题才是王道.


2016-08-07 00:05
utf8mb4 兼容 utf8 如果数据库报这个错误，应该尝试将字段改成utf8mb4.
General error: 1366 Incorrect string value: '\xF0\x9F\x8F\xBC' for column 'nick_name' at row 1

ssh-agent
to start your ssh-agent, you need to eval this command.
eval `ssh-agent -s`


又是一个贪婪匹配的故事。这次是 grep，本来想用sed搞定的，但是发现用grep就非常足够了。
我还会继续优化这一结果。在这方面，我还可以做的更好。有时候真得不知道打游戏能有什么作用。

我一共想出了2个shell，
一个是利用sed的版本。
`cat bookmarks_4_27_15.html | sed 's/ADD_DATE=\".*\"//g'`
另一个是利用grep的版本，但是grep的并没有达到我想实现的目的。sed的这个基本上是我想要的样子了。
`grep -i -Po "HREF=\".*?\"" bookmarks_4_27_15.html`


sudo ntpdate 202.120.2.101
sudo ntpdate 210.72.145.44
这是两个时间服务器，可以调整自己的时间。

```shell
shell 执行字符串命令。可以这样。
eval $cmd
试了一下，只有上面这种方法是ok的，其他的都不太行。
类似的问，其他语言中也有很多。python中也有不少。
sh exec $cmd
`echo $cmd`

date '+%Y-%m-%d'
httpd -S

shell 脚本中的 空变量。可能是你的程序报错，所以写判断的时候需要考虑变量为空的情况。
如果出现这样的情况，报的错误可能是这个。
"[: =: unary operator expected"

if [ $pusher_env'X' = 'prodX' ]
then
    workdir='/home/work/hgpusher/'
elif [ $pusher_env'X' = 'devX' ]
then
    workdir='/root/dir_higo/hgpusher/'
elif [ $pusher_env'X' = 'localX' ]
then
    workdir='/code/hgpusher/'
else
    echo '请先设置系统环境变量 pusher_env '
    exit -1
fi
echo "运行配置是"$pusher_env

a=$(($i + 1))

```


```bash
man sudoers
sudo visudo
just edit this line, and your problem solved.
bash if grammer.

it is just and.
if test "$dev" = "0" -a "$devok" = "0" ; then
	echo "your comment"
	echo "your comment"
exit 1
fi
```
