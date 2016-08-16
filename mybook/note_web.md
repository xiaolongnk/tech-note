---
title: 前端笔记 
categories:
- 前端
tags:
- html
- css
---

2015--01-31 17:51 
margin: 的4个参数。up ,right, down , left;
如果只有一个参数，那么表示4个都是n px。可以是1--4个参数。

radio, checkbox , button, 他们都有对应的时间，可以在里面添加对应的 函数。可以带参数的。
checkbox 也可以写成数组。
name='chk[]'  $_REQUEST ['chk'] 取值的方式是这样的。


### 2016-01-10 23:41
学习两个前端页面会使用到的js.

https://www.woothemes.com/flexslider/  这个是用来做轮播图的js。
http://fontawesome.dashgame.com/   这个是用来给页面中显示一些字体用的。还有一些常用的图标，用法也很简单，
可以参考官网。功能很全，应该系统学习一下。
http://www.cnblogs.com/lhb25/p/flexslider-responsive-content-slider.html  这里是一个使用案例,可以参考。

并不是所有的东西都需要自己来写，好多东西都已经写好了，你只要会拿来用就可以了。

304 错误. 强制不从本地设备读取内容.
```html
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
```

linux nodejs cnpm.
http://npm.taobao.org/

cnpm 比npm 速度块很多，用alias比较靠谱。 换一个淘宝镜像。
nvm 可以选择安装 node 的版本，也很方便。

这里下载。
https://raw.githubusercontent.com/creationix/nvm/v0.4.0/install.sh

cnpm install
那天发现我本地环境速度很慢的原因是 php-fpm.conf 中的maxchildren 数量太少了。
我改成static 的，然后把最大数量变成128； 一下子就不用排队了。
当时的现象是这样的。我看network，显示网络请求在排队，但是我完了单独访问每一个排队排了很久的接口，速度都很快，所以很疑惑。
我开了php的slowlog，但是并没有出现slowlog。貌似php的slowlog并不是我理解的那样。
并且slowlog，我自己写了一个sleep都不会打印出slowlog。

https://www.google.com/ncr 


2016-04-27 19:12
这几天写了一点js。感觉有什么收获吗？
在这种框架下写了一点新功能，发现开发确实挺慢的。

angular 中的浮层，请求模块。

其实，一个页面中常用的请求也就那些，浮层，ajax网络请求,gridlist , gridlist search.
把这些常用的东西封装一下，就可以比较方便的开发了.
写一点js，是必须的。无论如何，jquery，underscore，都可以加速开发效率。

#### 在lavarel中使用静态图片。

q1: 在页面中中使让一段字体在一个div中垂直居中？
http://stackoverflow.com/questions/79461/vertical-alignment-of-elements-in-a-div

**几个常用的 搜索引擎**

|   搜索引擎| 地址   |
|:----:|:---:|
|    百度|   <http://zhanzhang.baidu.com/sitesubmit/index> |
|    谷歌  |  <http://www.sogou.com/feedback/urlfeedback.php> |
| 谷歌  |    <http://www.google.com/intl/zh-CN/add_url.html>  |
