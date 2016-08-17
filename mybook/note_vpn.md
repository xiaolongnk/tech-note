---
title: Linux VPN 配置
categories:
- VPN
tags:
- VPN MSJNC
---

#### ubuntu14.04 安装vpn

这个是最正确的教程，没有之一。
http://mad-scientist.us/juniper.html
下面是一个简单的总结

```
sudo apt-get install libstdc++6:i386 lib32z1 lib32ncurses5 libxext6:i386 libxrender1:i386 libxtst6:i386 libxi6:i386
sudo apt-get install openjdk-7-jre icedtea-7-plugin openjdk-7-jre:i386
sudo apt-get install  icedtea-plugin
sudo apt-get install libc6-i386 lib32nss-mdns
sudo apt-get install libgtk2-perl libwww-perl
wget -q -O /tmp/msjnc https://raw.github.com/madscientist/msjnc/master/msjnc
chmod 755 /tmp/msjnc
sudo cp /tmp/msjnc /usr/bin
```
http://www.scc.kit.edu/scc/net/juniper-vpn/linux/

还可以参考这个帖子。需要得到realm这个东西，这个东西，去你公司的vpn网站爬一下就可以了。
搜索一下realm这个字，就可以看到这个内容的值。
最终推荐使用哪个客户端,比mac的客户端还好用。
不过如果没有特别的爱好，还是用mac吧,折腾起来，还是有点麻烦的。
