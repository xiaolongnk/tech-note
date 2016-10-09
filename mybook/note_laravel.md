---
title: Laravel 学习笔记
date: 2016-08-23 00:41
tags:
- laravel
---

#### 视图
在laravel中，controller和view都不可避免的要使用多级目录，controller中使用多级目录的时候，要注意在路由中的写法。在路由中的写法`Route::get("/test",'Test/TestController@index')`,要设置resource，view中的多级目录，在controller中对应的目录结构的写法应该这样的`return view(test.test.test)`。laravel也用了namespace，这些和其他的框架基本都是一致的。


#### laravel phphub5时间笔记

    laravel 的这个错误，可以在这里找到答案。
    http://stackoverflow.com/questions/31512970/laravel-no-supported-encrypter-found-the-cipher-and-or-key-length-are-invalid

```shell
php artisan key:generate
```


因为用mac,开发环境我是自己配置的,大概包括下面这些内容,nginx(1.9) ， mysql(5.5.3) ， php(5.6) ,redis(3.2) 都是自己装好了的，版本都是比较新的,应该满足需要。还有就是安装composer，之前对这个不怎么了解，但是最近学习laravel，发现这个东西真是太好了，不知道composer只能说明你比较古董，还在几年前的php开发水平上，新技术里没有这个是谈不上高效的，因为好多东西大家都已经写好了，并且都相当稳定了，你再自己去找其他的，就比较没效率了吧,所以composer也是我们的必不可少的。node相关的环境，需要下面这些，node ，npm ，cnpm ,cnpm ,gulp 的安装最好使用alias的那种命令，最好再有nvm，方便安装node。 我本地安装了4.5的node,有了nvm之后，node的版本都是随便选择，随便切换，很方便的。

首先clone phphub5 的官方包。

```shell
composer install --prefer-dist
cnpm install
```

最好能顺便了解一下package.json , gulp , gulpfile.js这些东西，现在是学习使用，后面可能需要自己开发。cnpm init 可以生成自己的package.json，但是这个只是生成的一个默认的，内容还需要自己扩展进去。通过上面的composer install，安装好了项目依赖的所有的php的扩展包。cnpm install安装好了前端需要的扩展包。这样，项目依赖的内容基本上就ok了，然后配置基本的配置文件。将.env.enviroment 该成 .env 然后将对应的内容修改成自己的db配置。记得打开 config/app.php 的调试信息，这样可以自己方便找出错误。然后在确认下config/database.php 中mysql的配置。和自己本地的db一致就可以了。最后需要修改storage目录的权限，可以 `sudo chown www:www -R storage` 修改用户组就可以了。改成nginx配置文件中的那个用户组和用户，我的配置里面的是www.www 。通过上面的这些工作，基本上我们的phphub基本上就运行起来了。然后可以根据自己的需求进行定制了。

感觉最近学西最大的收获就是这个项目了，虽然还没有详细研究，但是一个简单的入门，就让我了解到了laravel的高效，之前得开发是效率低并且质量差，并且水平低。这才是正确的做法。当你想做一个产品时，并不是让你从头开始做，你应该对自己所在的领域足够了解，知道有哪些东西已经有了，哪些东西没有，我相信能做好这个判断，会给你的项目节省不少成本，我觉着，这个才是一个技术leader最应该做的事情。


