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
是用nohub命令,完了这个命令就没有办法停止了,就会一直运行,除非用kill命令讲这些命令kill调.

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

    bin/ 过滤所有bin文件夹
    obj/ 过滤所有obj文件夹
    ValorNAV_deploy/ 过滤所有ValorNAV_deploy文件夹
    *.dll 过滤所有dll文件，这个最好不要使用dll，因为项目中像lib文件夹我们会放一些dll包。

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
