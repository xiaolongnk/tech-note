---
title: 前端笔记 
categories:
- 前端
tags:
- html
- css
---

#### margin

margin: 的4个参数。up ,right, down , left;
如果只有一个参数，那么表示4个都是n px。可以是1--4个参数。

#### some input type

radio, checkbox , button, 他们都有对应的时间，可以在里面添加对应的 函数。可以带参数的。
checkbox 也可以写成数组。
name='chk[]'  $_REQUEST ['chk'] 取值的方式是这样的。


#### fontawesome

学习两个前端页面会使用到的js.

https://www.woothemes.com/flexslider/  这个是用来做轮播图的js。
http://fontawesome.dashgame.com/
这个是用来给页面中显示一些字体用的。还有一些常用的图标，用法也很简单，


####
304 错误. 强制不从本地设备读取内容.

```html
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
```

#### Node基础

http://npm.taobao.org/
首先是npm， node package manager, 这个还相对好理解。可以用淘宝的镜像，速度会快一点。
换一个淘宝镜像。
例外是nvm，这个是node version manager。node 的版本太多了，所以也有了一个manager。
nvm 可以选择安装 node 的版本，也很方便。
nvm可以从这里下载。
https://raw.githubusercontent.com/creationix/nvm/v0.4.0/install.sh

在一个node的项目里，可以通过` cnpm install `来安装项目依赖。
这里推荐一个node的应用[hexo]<https://hexo.io/>.我的blog就是基于这个做的。

在页面中中使让一段文字在一个div中垂直居中？
http://stackoverflow.com/questions/79461/vertical-alignment-of-elements-in-a-div
