---
title: 多说插件支持站点https
date:  2016-11-26 17:28
tags: 
- https 
- 多说 
- javascript
- web
---

#### 问题
hexo 集成多说插件之后，对站点做了https 。https之后，要求页面里所有的引用资源都是htts协议的。但是多说的的官方js中的第三
三方平台的头像没有做https，现在多说官方貌似没怎么维护了，去论坛逛了几圈，有人提问，但是官方没有回应。
大概2个月前做了https改造的时候就发现这个问题了，当时没找到解决方案。当时简单尝试了一下，没有成功，加上我的blog也没设么
评论，于是就放弃了。

### 解决方案

今天浏览我的[这篇文章](https://blog.nofile.cc/posts/2016/10/11/note-linux.html)
发现竟然有一个评论，并且另外一篇文章也有。然后感觉没有那个绿色的锁很不舒服，于是再次长草了。
打开浏览器，再次分析了下这个页面。发现页面中加载了多说的一个js ，embed.js，warning直接告诉我，是这个js有问题。
查看站点请求的网络资源，发现相关的还有一个http接口。
<img src="https://img.nofile.cc/images/2016/12/03/14807622255019.png" style="width:600px"> </img>

embed.js 是压缩过的，整个页面只有2行，根本没法看，也没法调试。所以，先想办法将这个js替换掉，用一个格式化好的替换掉
之后，可以给调试带来很多方便。

利用`工具1`我们可以将embed.js 处理一下，基本上可以看了。虽然变量被换成没意义的了，但是并不是太影响。
处理之后的代码大概就是我们[src](https://github.com/xiaolongnk/duoshuo-js-http-patch/blob/master/embed-https.js)中的样子。
这个代码读起来会方便很多。先看了下这个代码，看了一会也没太看明白。于是再次回到console中。


从这个接口出发，在embed.js 中可以找到一些信息。用我们的格式化的js替换官方js。刷新页面，发现功能没有变化，说明替换js并
不会影响功能。继续在浏览器中调试。这次可以试下浏览器的断点功能，在embed.js 中打一个断点。要在报出warning之前。
然后单步调试，很快发现了浏览器出现warning的位置，发现这个之后，可以加一个更精确的断点。经过几次观察之后，我们可以定位到这个内容
<img src='https://img.nofile.cc/images/2016/12/03/14807622396074.png' style="width:600px"></img>


在前面，js从api接口中获取到了数据，但是数据里面的图像是http的，而不是https的，我们猜想可以把里面的http强行换成https以了。按照我们的想法，在server上修改一下，并且加上log，发现还是不行，但是warning 变少了。

```
n.replace('http:','https:')
```
后面发现，原来javascript的replace就是只替换一个。于是找了replaceall的方法。
用chrome的debug的过程如下。
![chrome debug](https://img.nofile.cc/images/2016/12/03/14807628131313.png)
```
n.replace(/http:/g , 'https');
```
刷新页面，发现页面上的所有数据都变成了https 的了，锁变绿了，开心。

[https站点](https://blog.nofile.cc/posts/2016/08/19/note-https.htm://blog.nofile.cc/posts/2016/08/19/note-https.html) 
的方法，可以参考我之前的blog.

### Github repo

最终修改后的结果在我的[xiaolongnk](https://github.com/xiaolongnk/duoshuo-js-http-patch/blob/master/embed-https.js)上.
喜欢的可以star一下我。

### 参考资料：

1. [javascript beautifer](http://jsbeautifier.org/)
2. chrome 单步调试

