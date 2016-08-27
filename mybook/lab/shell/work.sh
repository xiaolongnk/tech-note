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
