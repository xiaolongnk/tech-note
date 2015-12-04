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

