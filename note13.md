```php

<?php
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
?>

```

2015-04-05 14:54

PHP imagick 和 php gmagick 这两个扩展还没有怎么使用过，也没有怎么研究过。应该花些时间在这些
上面，应该积累自己的代码。
诚然，又QA 只会让开发变得更懒和更烂,这一点我还是比较赞同的。我更应该自己测试自己的代码。

连这样一个简单的规范都建立不起来，以后还能指望你做什么大事。现在对电脑又一些抵触情绪了，很不
愿意花时间在这个上面，当然我的眼睛很累。

3月似乎没有发生什么大事，我也似乎没有什么成长。上一周开始打dota了，
貌似线上的代码在一个劲的报异常，我知道，但是我却懒得去修理，我是不是很不敬业，不，这样是不对
的，我应该立马去修，对，就是现在。
