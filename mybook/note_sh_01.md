---
title: shell while loop break
date: 2016-12-03 16:47
tags:
- shell linux
---

####
shell 中的while 循环，也可以和break关键字配合使用，和其他程序语言类似。大体是一个`do...done`的格式。
本文是一个简单的shell while的程序，可以用来检查你的程序是不是还活着。 包括一些简单的算术运算，在实际变成中比较常用。


####代码
```shell
#!/bin/bash

checkstr='redis'
num=1
factor=5
lifetime=1
while :
do
    cnt=`ps aux | grep $checkstr | grep -v grep | wc -l`
    if [ $cnt'0' -lt 1'0' ]
    then
        echo 'die'
        break
    fi
    #sleep 5 seconds
    ((time=$lifetime*$factor))
    echo "live time [ "$time" ] seconds"
    #this is another method for math operator
    lifetime=$((lifetime+1))
    sleep 5
done
```
运行结果如下

<img src='https://img.nofile.cc/images/2016/12/03/14807576040945.png' style="width:500px"></img>

