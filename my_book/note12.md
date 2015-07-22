#this is my blog for mysql
下面是我对mysql实用过程的一些总结.涵盖面基本上比较全，希望能有所帮助。

```sql
如果更新 key 冲突，那么按照指定的规则来更新数据，有时候这样可以方便不少
insert into myblog (id,title,ctime) values(123,'hello',now())on duplicate key update title=values(title),ctime=values(ctime);
问题是，只能在主键重复的时候做应该做得事情。

将 blog_bak 表中的所有数据导入到myblog 中，表 blog 和 blog_bak 应该有同样的表结构
insert into myblog( blog,ctime) select * from blog_bak;

查看全表的信息,可以查到自己表的注释信息
show full fields from your_table;
mysql update

这样可以将 table_b 的 状态同步到 table_a, 本质上和 多表查询是类似的。
update table_a a , table_b b set a.shop_status = b.group_status where a.shop_id = b.shop_id;

给自己的表添加索引，可以给多个字段添加索引,有下面两种方式。
create index index_name on table_name (column_list);
alter table table_name add index index_name (column_list);

对应的，删除索引。
drop index index_name on table;
alter table table_name drop index index_name;

有时候遇到了 warnnings，怎么查看呢，可以用下面的命令。
show warnings;
show errors;
show tables like '%talname%';

清空表中的数据，包括 auto_increment 的字段都会被重置。
truncate table_name;

mysqldump 数据导出

mysqldump -h localhost -ppasswd  -uroot -d database > dump.sql ;            // 只导出数据库的结构
mysqldump -h localhost -ppasswd  -uroot  database  > dump.sql ;             // 导出数据库的结构和所有的数据
mysqldump -h localhost -ppasswd  -uroot -d database tablename > dump.sql ;  // 只导出表结构
mysqldump -h localhost -ppasswd  -uroot  database tablename > dump.sql ;    // 导出表结构和表中的数据

mysql 数据恢复
mysql -u root -p yourpasswd -h localhost yourdb < dump.sql                  // 将dump.sql 导出入到你的数据库

mysql 几个简单的时间处理函数

select date_format(now(),"%Y-%m-%d %H:%i:%s") now;
select date_sub(now(), interval 10 day) as yesterday;                       // 请不要吧 day 写成 days ，month , hour 同理。

group by 多个字段 从 col_a -> col_b -> col_c 优先级依次降低。
select * from test_table where status = 1 order by col_a desc, col_b desc, col_c asc limit 100;

mysql 变量
set @a = 100;
set @a:=100;

select @a:=300;  #可以通过 select 给变量赋值，对，你没有看错。
这两种方式都可以给@a赋值。使用的时候记得用@啊，就像PHP里面的$一样。
这个变量只在这个链接周期中有效。

mysql 存储过程

下面是一个简单的存储过程的例子。
delimiter $     # 因为 mysql 默认的 终止符是; 而这个正好是存储过程的语法，所以在编写存储过程之前，先将 delimiter 改成 $
create procedure p()    # 创建存储过程
begin
select * from ttt;
end;
$
delimiter ;     # 将 delimiter 改成默认的; 这样符合我们的习惯
                # 请注意单词的拼写，写错了我不负责。
call p();       # 调用这个存储过程

```

[如何让自己的博客被搜索到](http://blog.163.com/changying_qiu/blog/static/1229782832010213066873/)
sudo ntpdate 202.120.2.101
sudo ntpdate 210.72.145.44
这是两个时间服务器，可以调整自己的时间。

2015-03-22 22:28

下面是我的 centos 上的mysql 的配置文件，我添加的内容是 
```
[client]
*default_character_set=utf8*

[mysqld]
datadir=/var/lib/mysql
socket=/var/lib/mysql/mysql.sock
user=mysql
# Disabling symbolic-links is recommended to prevent assorted security risks
symbolic-links=0
character_set_server=utf8
init_connect='SET NAMES utf8'


[mysqld_safe]
log-error=/var/log/mysqld.log
pid-file=/var/run/mysqld/mysqld.pid
default-character-set=utf8
```
设置之后，重启mysql 就可以了，里面的中文内容应该就不会显示乱码了。这个时候需要在数据的各个层面
上都保证数据的类型是utf8的。

2015-04-20 21:20
业务场景很重要，记下这些常用的业务场景。


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
jquery 版本冲突的问题。这个应该相办发解决一下。
可以尝试使用两个版本的jquery。想办法查看不同版本的jquery。吧问题彻底搞清除。



2015-04-26 21:09
最近有点不知道干什么了。
最近似乎发生了很多事情，当然是和工作相关的。
如果有问题，我应该把这件事情想明白，然后有条理的记录下来。
其实本质的问题是我对我的工资的疑虑，我的态度会在这月的最后一天决定。
如果我的工资达不到我的期望，我真得会很失望，我有可能会离开。
我的期望也很明确，15k吧。这是最少的了，如果我能受到13k的工资，那么还可以，
如果能受到15k那么更好。现在最关心的貌似就是我的工资了，其实没有什么大不了的，
都是钱的问题。
我之所以担心，是因为我们团队最近出了点问题，技术部门被拆掉了，然后boss貌似很
不开心，感觉我的代码有问题，我感觉会砍掉我的调薪，这是我最担心的问题。如果这
是真得，那么真得没法干下去了。我的选择会很被动，我在这里做了很多，突然让我走。

但其实回过头来，在想想，这也没什么。我毕业一年不到，这些还可以忍受，只要我把技术
积累好，我怎么都不会亏。你给我多，我给你多干活，我会更加负责，你给我少，那么我会
把更多的精力放在自我投资上，我不欠你的，你也不欠我的。

2015-04-27 23:15
今天学习了一些新东西，感觉还是很不错的。用好一些效率工具也是极好的，把自己要做得
事情列出来，效果真的会不一样。
现在的一个问题就是书签同步的问题，或者说是vpn的问题，我想在家里的网络也可以上google
之类的网站。如果可以上，那么也会帮助不少的。

我希望能做一个脚本，分析导出的所有的bookmark。首先可以从各个浏览器上导出书签，然后把这些
书签同步在一个目录下，用分析脚本分析这些文件，把有用的地址和title整理好。这样对我来说
就很有用了。这个应该很简单，就是一个类似文本分析的功能就可以实现了。
刚才学习了一下 chromium 的书签整理，感觉还算可以。现在整齐多了，以后应该用chrome比较多一点
感觉firefox的界面还是不太喜欢的。并且还老出问题。

又是一个贪婪匹配的故事。这次是 grep，本来想用sed搞定的，但是发现用grep就非常足够了。
我还会继续优化这一结果。在这方面，我还可以做的更好。有时候真得不知道打游戏能有什么作用。

我一共想出了2个shell，
一个是利用sed的版本。
`cat bookmarks_4_27_15.html | sed 's/ADD_DATE=\".*\"//g'`
另一个是利用grep的版本，但是grep的并没有达到我想实现的目的。sed的这个基本上是我想要的样子了。
`grep -i -Po "HREF=\".*?\"" bookmarks_4_27_15.html`

