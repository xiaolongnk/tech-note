---
title: Laravel 学习笔记
date: 2016-08-23 00:41
-categories:
- laravel
tags:
- laravel
---

#### 视图
在laravel中，controller和view都不可避免的要使用多级目录，controller中使用多级目录的时候，要注意在路由中的写法。在路由中的写法`Route::get("/test",'Test/TestController@index')`,要设置resource，view中的多级目录，在controller中对应的目录结构的写法应该这样的`return view(test.test.test)`。laravel也用了namespace，这些和其他的框架基本都是一致的。


