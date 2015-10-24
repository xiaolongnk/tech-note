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
sed 用得最多的就是替换了。很多时候，grep旧足够了。


grep
就是一个简化了的 sed 。

find

这四兄弟，简直就是 linux 的 什么一样。
