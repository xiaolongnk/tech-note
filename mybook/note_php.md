---
title: PHP 学习笔记
categories:
- programming
tags:
- php
- web
---

#### PHP 回掉函数的使用。
这是最基本的回掉方法。
call_user_func_array('your function',array());
array() is your params.


刚才在文档里发现了好多东西，原来还是要自己编译才是最好的。才能够了解更多的特性。
./configure --help
其实已经包含了很多信息，只是你还不了解。
要编译安装，这个是很重要的一步。

编译php常见的20个错误。
http://crybit.com/20-common-php-compilation-errors-and-fix-unix/

#### PHP 扩展安装 PECL
PECL is a repository for PHP Extensions, providing a directory of all known extensions
and hosting facilities for downloading and development of PHP extensions.
PECL is very important.


PHP 断言的使用。需要进行一些基本都的设置才可以。

```php
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_BAIL, 1);
$a = 'i1.23';
assert(is_numeric($a));
echo $a;
```


#### PHP 正则表达式.
preg_match 有几个关键词需要注意,一个是
界定符 # / 这个可以自己设置的.
preg_match 如果判断整个字符串的话,就要断言. 用 ^$. 
可以带 result 参数，将匹配的内容都放在这个result数组中。这个数组的参数应该是应用类型的。
说到引用类型，我对这个还不是太清楚，没怎么使用过，应该熟悉一下。
类似的函数还有 preg_match_all() , 返回值表示是否匹配.
```php
$name = "hello\\\\\\\\\\\\\\\\\\\\\\\\'sas";
var_dump($name);
$new_name = preg_replace("/\\\*/","",$name);
var_dump($name);
var_dump($new_name);
```
#### PHP urlencode, urldecode, rawurlencode, rawurldecode

他们之间的差别还是比较小的,差别就是对+号的处理,我建议使用 rawurldecode, 而不是
urldecode. 但这个改动不可以贸然,可能一起bug.
在最初的时候设计的时候,就要考虑这一点.


#### curl 参数


curl 带json参数,需要加上-d 参数.没有这个参数是无法访问的.
curl -d {goods_id:123123} "http://sss.ss.xx"


#### PHP array系列函数

下面这个函数里面包含两种用法，一种是array_walk(), 还有一种是 变量的引用。这个和c语言是很相似的。
```php
$test = [1,2,3,5];
array_walk($test , function(&$i) { $i++; });
var_dump($test);
```
##### PHP魔术方法

```
__construct()   构造方法,生命类对象的时候就会调用.
__desctruct()   析构方法,在类对象的生命周期结束之后. 这个和垃圾回收有什么关系吗.
__call()        must be public method.
__callStatic()  for static class method.
get_called_class()  一般是在基类中用到.基础类库中用这个方法.
get_class().  得到当前类的名称.
__autoload().

static::class   和上面的得到同样的结果.
PHP_EOL. 提高代码的可移植性. 换行符. mac windows, linux 下是不一样的.
user_call_func()    这个方法是写自定义函数,利用这个方法,调用的函数会变成一个变量,所以非常灵活.
user_call_func_array()  和上面的额方法类似,区别在于这里的方法的参数是数组.

这些东西被统称为魔术常亮.
__METHOD__    return the name of the function alongwith the class name.
__FUNCTION__  just return the name of the function.
__CLASS__
__FILE__      return filename of current file.
__LINE__      return current line number.
__DIR__       equal dirname(__FILE__).
```
#### PHP SPL 方法 STANDARD PHP LIBRARY
PHP 中spl 开头的一些方法是做什么的,比如spl_autoload_register.
类似的方法还有不少,都是用来做什么的额.刚才调查了一下,确实有好多东西,这些都是PHP的高级语法,应该认真研究下,
用好了,可以写出高效的代码.  对这门语言,我的了解还是不够,还需要认真研究.PHP SPL ==> standard PHP library.


### PHP XHPROF

XHProf是一个分层PHP性能分析工具。它报告函数级别的请求次数和各种指标，包括阻塞时间，CPU时间和内存使用情况。一个函数的开销，可细分成调用者和被调用者的开销，XHProf数据收集阶段，它记录调用次数的追踪和包容性的指标弧在动态callgraph的一个程序。它独有的数据计算的报告/后处理阶段。在数据收集时，XHProfd通过检测循环来处理递归的函数调用，并通过给递归调用中每个深度的调用一个有用的命名来避开死循环。XHProf分析报告有助于理解被执行的代码的结构，它有一个简单的HTML的用户界面（ PHP写成的）。基于浏览器的性能分析用户界面能更容易查看，或是与同行们分享成果。也能绘制调用关系图。


#### PHP composer
http://pkg.phpcomposer.com/

#### PHP 图像操作
```php
   session_start();
   header("Content-type:image/png"); 
   $img_width=100;
   $img_height=20;

   srand(microtime()*100000);
   for($i=0;$i<4;$i++)
   {
        $new_number.=dechex(rand(0,15));
   }

   $_SESSION[check_auth]=$new_number;
   $new_number=imageCreate($img_width,$img_height);//创建图象
   ImageColorAllocate($new_number,255,255,255);  //设置背景色为白色

   for($i=0;$i<strlen($_SESSION[check_auth]);$i++)
   {
       $font=mt_rand(3,5);
       $x=mt_rand(1,8) + $img_width*$i/4;
       $y=mt_rand(1,$img_height/4);
       $color=imageColorAllocate($new_number,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));//设置字符颜色
       imageString($new_number,$font,$x,$y,$_SESSION[check_auth][$i],$color);//输出字符
   }

   ImagePng($new_number);
   ImageDestroy($new_number);
```

#### PHP echo 和 print的区别。
主要掌握echo的下面这两个特性。print更多的是一个函数。

```php
echo "hello", "world";
echo <<<EOT
test
EOT;
```

#### PHP $_SERVER 变量
PHP在命令行模式下的 $_SERVER 变量中的变量可以在shell 中 export 来设置.shell 中的变量会出现在
SERVER 变量中.在web环境中,要通过在服务器中设置才可以. nginx 在 fastcgi_params 中设置.


#### PHP session 和 cookie




#### PHP 配置

那天发现我本地环境速度很慢的原因是 php-fpm.conf 中的maxchildren 数量太少了。
我改成static 的，然后把最大数量变成128； 一下子就不用排队了。
当时的现象是这样的。我看network，显示网络请求在排队，但是我完了单独访问每一个排队排
了很久的接口，速度都很快，所以很疑惑。

#### PHP 显示slowlog

我开了php的slowlog，但是并没有出现slowlog。貌似php的slowlog并不是我理解的那样。
并且slowlog，我自己写了一个sleep都不会打印出slowlog。
