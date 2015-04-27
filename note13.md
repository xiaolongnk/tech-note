

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

