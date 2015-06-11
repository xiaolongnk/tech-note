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

```shell
iplist="10.7.0.23 120.7.12.43 10.7.23.55 10.7.44.59"
path="/home/work/higo/"
for ip in $iplist;do
    echo $ip
    rsync -avz --exclude='*.log' $path $ip::higo/
done
echo "===done==="


pid file = /var/run/rsyncd.pid
port = 873
address = 10.7.0.21
uid = root
gid = root
use chroot = yes
read only = yes
hosts allow=10.7.0.0/24
max connections = 5
motd file = /etc/rsyncd/rsyncd.motd
log file = /var/log/rsync.log
transfer logging = yes
timeout = 300

[higo]
path = /opt/upload/pic/higo
auth users = root
list=yes
ignore errors
secrets file = /etc/rsyncd/rsyncd.secrets
comment = linuxsir home  data
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

2015-04-26 22:39

今天用ci实现了图片的一些简单处理，加上了水印，包括文字水印和图片水印，没有什么难度，但是感觉还是
很有必要学习的.


想到一个问题，就是在开发的过程中，比如你写了一个方法，为了保证你的代码质量，你很希望能单独测试一下
这个方法，这个就是目前我所理解的单元测试，在开发的过程中，我们应该准备好这个环境，并且在开发过程中，
应该尽可能的让系统保持独立。对于测试，这样或许更加方便。这样的代码耦合性更低，或许更利于维护，开发
过程中配套对应的test案例，应该是一个不错的习惯。

2015-05-01 15:45
jquery 版本冲突的问题。这个应该相伴发解决一下。
可以尝试使用两个版本的jquery。想办法查看不同版本的jquery。吧问题彻底搞清除。
