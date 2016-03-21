### note for js

$() () 里面是一个dom元素的话，这个东西就是一个jquery对象。
jquery 的方法，on ，可以绑定事件，each可以循环便利数组。
同事js自己的array也是一个对象，有foreach方法。要注意和jquery的each
方法区分。

js 的事件包括如下几个
这是几个常用的事件。
keyup
onchange
click

js 的闭包函数，这几天php中也用了不少，一个是array_walk, usort()
有些场景中用这些函数是很方便的，这些函数都有自己适合的场景，要在
合适场景使用,才能体现出这些函数的作用。

关键的步骤要加上日志记录，系统的关键步骤一定要记录下log。

nginx 的log_format , log 需要几下post参数。记得上次查问题，我只能定位到url，并不能定位
到参数，这导致有些问题没有办法追查。 所以这个问题要想办法避免下，要了解下nginx的log_format.


js 正则.
这些常用的方法，需要熟练使用.

js localStorage.
localStorage.getItem();
localStorage.setItem();
underscore.js 
jquery
$.each();
_.findWhere();
