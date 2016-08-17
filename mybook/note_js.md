---
title: javascript 学习笔记
categories:
- javascript

tags:
- programming
- javascript
- web
---

#### jquery常识

如果`$()` 里面的`()`里面是一个dom元素的话，这个东西就是一个jquery对象。
jquery 的方法，on ，可以绑定事件，each可以循环遍历数组。
同事js自己的array也是一个对象，有foreach方法。要注意和jquery的each 方法区分。
js 几个常用的事件。
`keyup onchange click`

js 的闭包函数，这几天php中也用了不少，一个是array_walk, usort()
有些场景中用这些函数是很方便的，这些函数都有自己适合的场景，要在
合适场景使用,才能体现出这些函数的作用。

#### js 正则.

#### js localstorage
```javascript
js localStorage.
localStorage.getItem();
localStorage.setItem();
```
#### underscore

####jquery on 的代理实现

记得有这样一个场景。
一个页面里面会使用到弹层，弹层上面有一些按钮，需要给这些按钮绑定事件。
可以使用on方法绑定。但是在js代码执行的时候，这个坦层并没有出现，页面中并没有
这个dom对象。这个时候，需要用到on的另一种使用方法。在他的父元素上绑定。
parent.on('click','selector',function(){})
是一种类似这样的用法，当时这个解决了个很重要的问题。
