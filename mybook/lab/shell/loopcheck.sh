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
