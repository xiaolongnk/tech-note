---
title: Mysql笔记
categories:
- 存储
tags:
- Mysql
---

#### 2016-01-07 13:11

mysql 性能测试工具.
对mysql 的深入学习是很有必要的.

[Mysql 自带的性能测试工具.](http://www.ha97.com/5182.html)

Mysql 索引


Mysql 复合索引

http://tech.meituan.com/mysql-index.html
现在只会创建单索引,但是很多情况下,复合索引更有效.
一个表只能使用一个索引,如果单键索引和复合索引都会生效,那么mysql会选择哪个索引.

只要能提出问题,那么解决方案一定会有的.
mysql 索引的最左选择的原则. 上面那篇文章的例子还是不错的.可以深入学习一下.

有些情况下,优化的作用是很有限的,最好还是不要写太复杂的sql.
但是有一个情景,就是需要更具字表的条件去筛选结果,做分页,这种情况如何处理. 
可以内存排序.让排序在mysql中排序比较困难.那么这个分页逻辑如何处理. 

Mysql join 之后的索引使用情况是怎么样的.

order by 的字段是否有必要增加一个索引,如果有必要,是不是所有需要排序的字段都需要增加
上索引. 

索引是在数据库表或者视图上创建的对象，目的是为了加快对表或视图的查询的速度。
按照存储方式分为：聚集与非聚集索引 和B树B+树的关系还是差别挺密切的,要理解好这个，需要认真理解一下B树和B+树.

MySQL如何利用索引优化ORDER BY排序语句
MySQL索引通常是被用于提高WHERE条件的数据行匹配或者执行联结操作时匹配其它表的数据行的搜索速度。
MySQL也能利用索引来快速地执行ORDER BY和GROUP BY语句的排序和分组操作。

mysql一次查询只能使用一个索引。如果要对多个字段使用索引，建立复合索引。

```sql
create table blog_pool
(
id bigint(20) not null auto_increment,
account_id bigint(20) not null default 0 comment 'user id',
blog_id bigint(20) not null default 0 comment 'blog_id',
content varchar(1024) not null default 0 comment 'blog内容',
status tinyint(2) not null default 1 comment '1: 正常 -1: 删除',
primary key (id),
index list_blog_index (account_id,status),
index single_index (account_id)
)engine = Innodb , charset=utf8 , auto_increment=1;

insert into blog_pool (account_id, blog_id, content) values (923232323, );

```


explain 显示mysql如何处理select语句以及连接表,可以帮助写出更好的查询语句和建立更好的索引.

select type  
simple 表示是简单的select , 
primary 表示最外面的select .
union 表示union语句的第二个.

rows 表示mysql执行查询的行数,数值越大说明效果越不好,说明没有用好索引.

using where  , 
要想使查询尽可能的快, 应尽可能得找出 using filesort , using temporary 的extra的值.
我觉这在业务重没有必要禁止连表查询，在不会带来什么压力的情况下，并没有什么必要。
如果两个表，都比较简单，连表也没什么不可以。什么事情都应该分开来看待，没有什么是绝对的。

```
select * from xxx where id in (3,1,5) order by find_in_set(id,'3,1,5') 
```
order by substring_index和order by find_in_set都可以

mysql 中创建用户。

```
CREATE USER 'username'@'host' IDENTIFIED BY 'password'
GRANT privileges ON databasename.tablename TO 'username'@'host' 
```
more detailed info see this link.  http://www.jb51.net/article/31850.htm

mysql 基础。
mysql 中的数据类型

```
tinyint   1 字节    -128 ~ 128
smallint  2 字节   -32768 ~ 32767
mediumint 3字节  
int       4字节  int(11)
bigint    8字节

unsigned   int   0～4294967295   
int   2147483648～2147483647 
unsigned long 0～4294967295
long   2147483648～2147483647
long long的最大值：9223372036854775807
long long的最小值：-9223372036854775808
unsigned long long的最大值：18446744073709551615

__int64的最大值：9223372036854775807
__int64的最小值：-9223372036854775808
unsigned __int64的最大值：18446744073709551615

```

1.首先，对于精度比较高的东西，比如money，我会用decimal类型，不会考虑float,double,因为他们容易产生误差，numeric和decimal同义，numeric将自动转成decimal。

DECIMAL从MySQL 5.1引入，列的声明语法是DECIMAL(M,D)。在MySQL 5.1中，参量的取值范围如下：
·M是数字的最大数（精度）。其范围为1～65（在较旧的MySQL版本中，允许的范围是1～254），M 的默认值是10。
·D是小数点右侧数字的数目（标度）。其范围是0～30，但不得超过M。
说明：float占4个字节，double占8个字节，decimail(M,D)占M+2个字节。
这是一个不错的解释。

>
Although the answers above seems correct, just a simple explanation to give you an idea of how it works.
Suppose that your column is set to be DECIMAL(13,4). This means that the column will have a total size of 13 digits where 4 of these will be used for precision representation.
So, in summary, for that column you would have a max value of: 999999999,9999

引申 为什么floa 和 double 会丢失精度。
1 字节 = 8 bit。 int 一般认为是32位。最长是10位。
float 为4byte。
double 为8btye。
IEEE 754 标准，数的存法。


datetime 4字节  和  timestamp 8字节 的区别。

ctime  datetime => now()
mtime  timestamp ==> CURRENT_TIMESTAMP

1970 ~ 2037

复习mysql 索引。
复合索引。
前缀索引。
order by 索引的使用情况。


设计一个比较完善的表，实践一下各种情况下索引的使用情况，结合实践理解下这些东西。
如果理解不够深入，何以服人。

char 和 varchar 的差别是什么。

```
create table t_student (
id bigint(20) not null comment '';
name varchar(128) not null default '' comment '学生名';
sex char() not null
)engine = Innodb ,charset=utf8 , auto_increment=1;
```




2013-10-21 11:35:36
mysql 学习
foregin key
当初学习的时候不想这些问题,现在才开始想,真是愚昧至极了.
当出学习的时候,就没有好好理解,现在才发现自己什么都没有学会,难怪面试的时候
会表现那么差.所以以后在学习的时候要注意这一点.要用相同的时间学好才算本事,多用
时间只能说明你脑残.

mysql 中是没有 top 关键字的，要想实现类似的功能，我们可以使用 limit 关键字。
举例如下:
	select * from basic group by id limit 1,3;
这里的 1 表示从第 2 条开始，3表示找3条记录返回。

我需要找到一个比较全面的联系题，然后好好练习一下。
最基本的就不说了，主要是几个关键字的使用，如下：
in
not in
exists 和 not exists 关键字。
还有就是多表查询，
综合使用这些个查询条件，可以实现更多的查询需求。

可以用 alter table tablename add primary key(col); 这样可以给一个新建好的表添加一个主键。

同样的，可以用 curdate() 和 curtime() 来找到当前的 日期 和 时间!

mysql 复制旧表数据到新表的方法。详细的见下面的描述.
create table newtable select * from oldtable;

3.复制旧表的数据到新表(假设两个表结构一样)

INSERT INTO 新表SELECT * FROM 旧表

4.复制旧表的数据到新表(假设两个表结构不一样)

INSERT INTO 新表(字段1,字段2,…….)
SELECT 字段1,字段2,…… FROM 旧表
+++++++++++++++++++++++++++++++++++++++++++++++++++


刚才想了一下 having 的用法,我自己不是很清楚,
having 后面可以跟 聚合 函数.他们都具有过滤功能.


可以用 show engines; 来查看 mysql 的数据库引擎. 好像默认的是 MyISAM,但是我的 现在是 InnoDB. 可以支持事务,外键

mysql 的 null 值比较 需要用到 isnull 函数,而不能直接和 var=null ,这样写是错误的.

下面是我对mysql实用过程的一些总结.
如果更新 key 冲突，那么按照指定的规则来更新数据，有时候这样可以方便不少

```mysql
insert into myblog (id,title,ctime) values(123,'hello',now()) on duplicate key update title=values(title),ctime=values(ctime);
//将 blog_bak 表中的所有数据导入到myblog 中，表 blog 和 blog_bak 应该有同样的表结构
insert into myblog( blog,ctime) select * from blog_bak;
```

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

mysqldump 数据导出和数据恢复

```bash
mysqldump -h localhost -ppasswd  -uroot -d database > dump.sql ;            // 只导出数据库的结构
mysqldump -h localhost -ppasswd  -uroot  database  > dump.sql ;             // 导出数据库的结构和所有的数据
mysqldump -h localhost -ppasswd  -uroot -d database tablename > dump.sql ;  // 只导出表结构
mysqldump -h localhost -ppasswd  -uroot  database tablename > dump.sql ;    // 导出表结构和表中的数据
mysql -u root -p yourpasswd -h localhost yourdb < dump.sql                  // 将dump.sql 导出入到你的数据库
```

mysql 中的test 表的使用方法。如果你在数据表中没有数据的到处权限，但是一般的数据库中，test库中的权限你都是
有的，所有可以将需要的数据先导入到test中的临时表中，然后再从临时表中导出去。这样可以绕开权限控制，到处你
需要的数据。sql 大概是这样的。
create table xxx as select * from you_target_table where xxx=xxx;
这样 一张 test 中的临时表就创建好了，你可以用mysqldump将这个表中的数据导出去。

mysql 几个简单的时间处理函数

```mysql
select date_format(now(),"%Y-%m-%d %H:%i:%s") now;
select date_sub(now(), interval 10 day) as yesterday;       // 请不要吧 day 写成 days ，month , hour 同理。
#group by 多个字段 从 col_a -> col_b -> col_c 优先级依次降低。
select * from test_table where status = 1 order by col_a desc, col_b desc, col_c asc limit 100;

set @a = 100;
select @a:=300;  #可以通过 select 给变量赋值,这个变量只在这个链接周期中有效。
```

mysql 存储过程 下面是一个简单的存储过程的例子。

```mysql
delimiter $     # 因为 mysql 默认的 终止符是; 而这个正好是存储过程的语法，所以在编写存储过程之前，先将 delimiter 改成 $
create procedure p()    # 创建存储过程
begin
select * from ttt;
end;
$
delimiter ;     # 将 delimiter 改成默认的; 这样符合我们的习惯
call p();       # 调用这个存储过程
```

sql 中将联表出现的 null 替换成 0， 可以用这个方法。

```sql
if(tb2.shop_click is null, 0,tb2.shop_click)
```

用group by来去重要比 distinct 效率要高很多。

