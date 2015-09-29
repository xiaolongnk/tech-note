#!/bin/bash
num=$#
if [ $num -lt 1 ]
then
    echo "参数不全"
fi
keyword=${1}"*"
echo $keyword
cmd='redis-cli -h 10.7.0.240  -p 6379 -n 4 keys '$keyword' | xargs redis-cli -h 10.7.0.240  -p 6379 -n  4 del'
eval $cmd
