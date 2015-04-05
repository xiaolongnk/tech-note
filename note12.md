#this is my blog for mysql
下面是我对mysql实用过程的一些总结.涵盖面基本上比较全，希望能有所帮助。

```sql
如果更新 key 冲突，那么按照指定的规则来更新数据，有时候这样可以方便不少
insert into myblog (id,title,ctime) values(123,'hello',now())on duplicate key update title=values(title),ctime=values(ctime);

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

dent]
default-character-set=utf8

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
