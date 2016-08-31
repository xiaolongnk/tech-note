#!/bin/bash
# 要搜索的路径。
# 找到指定路径下的包含日期格式的所有目录下的log文件，如果以.log 结尾就不重命名，如果不以.log结尾
# 就加上.log后缀。


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


## 下面命令用来统计log文件中出现次数最多的url
## 掌握下最基恩的用法。 awk 和 sort ，类似的用法还有uniq，也是用来文本处理的有力工具。
## 下面这两种写法都是正确的。

cat test.nofile.cc.log |awk '{a[$11]++} END {for (i in a) print i,a[i]}' | sort -k2 -n
cat test.nofile.cc.log |awk '{a[$11]++} end {for (i in a) print i,a[i]|"sort -k2 -nr | head -n 10"}'
