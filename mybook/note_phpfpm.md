---
title: PHP 与 FPM 的区别
date: 2016-08-25 23:47
tags:
- php
- php-fpm
- fastcgi
---
#### PHP与FPM的区别

nginx , fastcgi , php-fpm , php-cgi , cgi , php.ini , master process , work process , php kernel.
这个[问答](https://segmentfault.com/q/1010000000256516)写得很好,推荐参考。

首先nginx处理不了php这类的脚本程序，只能扔给php去做。
最早的时候，php并没有php-fpm这个东西，后面php把fpm收进了内核，编译的时候，只需要enablefpm就可以了。php-fpm是一个实现了fastcgi的程序，后来被php收了。
cgi 是一个协议，php-fpm 实现了这个协议。就可以和nginx通信了。cgi 的全写，common gateway interface 。为了保证web server 传递过来的参数都是标准格式的，方便cgi程序的编写，本质上是一个标准。

    web server（比如说nginx）只是内容的分发者。比如，如果请求/index.html，那么web server会去文件系统中找到这个文件，发送给浏览器，这里分发的是静态数据。好了，如果现在请求的是/index.php，根据配置文件，nginx知道这个不是静态文件，需要去找PHP解析器来处理，那么他会把这个请求简单处理后交给PHP解析器。Nginx会传哪些数据给PHP解析器呢？url要有吧，查询字符串也得有吧，POST数据也要有，HTTP header不能少吧，好的，CGI就是规定要传哪些数据、以什么样的格式传递给后方处理这个请求的协议。仔细想想，你在PHP代码中使用的用户从哪里来的。

    当web server收到/index.php这个请求后，会启动对应的CGI程序，这里就是PHP的解析器。接下来PHP解析器会解析php.ini文件，初始化执行环境，然后处理请求，再以规定CGI规定的格式返回处理后的结果，退出进程。web server再把结果返回给浏览器。

php-cgi 是php的解释器

    大家都知道，PHP的解释器是php-cgi。php-cgi只是个CGI程序，他自己本身只能解析请求，返回结果，不会进程管理（皇上，臣妾真的做不到啊！）所以就出现了一些能够调度php-cgi进程的程序，比如说由lighthttpd分离出来的spawn-fcgi。好了PHP-FPM也是这么个东东，在长时间的发展后，逐渐得到了大家的认可（要知道，前几年大家可是抱怨PHP-FPM稳定性太差的），也越来越流行。

fastcgi是cgi的改进版，cgi每次都需要解析php.ini，这样做效率很低，后面就有了fastcgi，它有一个master进程，只有master进程中会load php.ini，然后后面有请求都只会fork一个child process去处理。可以实现平滑重启。


