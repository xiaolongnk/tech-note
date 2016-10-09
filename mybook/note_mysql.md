---
title: mysql笔记
date: 2016-08-24 14:40
tags:
- 存储
- mysql
---

#### mysql 性能测试工具.

[Mysqlslap 自带的性能测试工具.](http://www.ha97.com/5182.html)


#### Mysql 基本知识

一些mysql基本的操作
```sql
show global variables like '%%datadir%' //看MySql数据库物理文件存放位置
show variables like 'innodb_data%';
set autocommit = 0
lock table file_text write
unlock tables

create table newtable select * from oldtable;
INSERT INTO newTable SELECT * FROM oldTable;
INSERT INTO newTable (col1,col2,…….) SELECT col1,col2,…… FROM old_table


insert into myblog (id,title,ctime) values(123,'hello',now()) on duplicate key update title=values(title),ctime=values(ctime);
//将 blog_bak 表中的所有数据导入到myblog 中，表 blog 和 blog_bak 应该有同样的表结构
insert into myblog( blog,ctime) select * from blog_bak;

if(tb2.shop_click is null, 0,tb2.shop_click) // mysql if
update table_a a , table_b b set a.shop_status = b.group_status where a.shop_id = b.shop_id; 
//这样可以将 table_b 的 状态同步到 table_a, 本质上和 多表查询是类似的。

select * from xxx where id in (3,1,5) order by find_in_set(id,'3,1,5') 
order by substring_index和order by find_in_set都可以
//select 按指定顺序排
```

#### Mysql 锁

MysIsma, Memory 支持表锁。Innodb 支持表锁和行锁,默认是行锁。 BerkelyDB 支持页锁,页锁的粒度和成本在表锁和行锁之间,不知道是什么鬼。

##### 乐观锁
乐观锁可以通过增加一个version来实现。在提交的时候，带着version作为条件去更新，如果发现version不一致了，那么就不更新，如果和当时读取到的version一直才更新数据。

[悲观锁的介绍](http://chenzhou123520.iteye.com/blog/1860954)，用到了select for update。要实现悲观锁，必须将数据库的autocommit属性置成0
`select status from t_goods where id=1 for update;`与普通查询不一样的是，我们使用了select…for update的方式，这样就通过数据库实现了悲观锁。此时在`t_goods`表中，id为1的那条数据就被我们锁定了，其它的事务必须等本次事务提交之后才能执行。这样我们可以保证当前的数据不会被其它事务修改。`select for update`，现在使用select for update来查询数据，以达到排他读的目的。但是发现，在有正常结果数据时造成的锁表对系统性能有明显地影响。select for update的条件不是主键所以id，所以造成锁表。尽可能让所有数据检索都通过索引来完成，从而避免InnoDB因为无法通过索引键加锁而升级为表级锁定。

##### 读锁和写锁
1. 共享锁(S锁)又称读锁,若事务T对数据对象A加上S锁,则事务T可以读A但不能修改A,其他事务只能再对A加S锁,而不能加X锁,直到T释放A上的S 锁.这保证了其他事务可以读A,但在T释放A上的S锁之前不能对A做任何修改.
2. 排他锁(X锁)又称写锁.若事务T对数据对象A加上X锁,事务T可以读A也可以修改A,其他事务不能再对A加任何锁,直到T释放A上的锁.这保证了其他事务在T释放A上的锁之前不能再读取和修改A.


##### 并发事务处理带来的问题
相对于串行处理来说，并发事务处理能大大增加数据库资源的利用率，提高数据库系统的事务吞吐量，从而可以支持更多的用户。但并发事务处理也会带来一些问题，主要包括以下几种情况。
1. 更新丢失（Lost Update）：当两个或多个事务选择同一行，然后基于最初选定的值更新该行时，由于每个事务都不知道其他事务的存在，就会发生丢失更新问题－－最后的更新覆盖了由其他事务所做的更新。例如，两个编辑人员制作了同一文档的电子副本。每个编辑人员独立地更改其副本，然后保存更改后的副本，这样就覆盖了原始文档。最后保存其更改副本的编辑人员覆盖另一个编辑人员所做的更改。如果在一个编辑人员完成并提交事务之前，另一个编辑人员不能访问同一文件，则可避免此问题。
2. 脏读（Dirty Reads）：一个事务正在对一条记录做修改，在这个事务完成并提交前，这条记录的数据就处于不一致状态；这时，另一个事务也来读取同一条记录，如果不加控制，第二个事务读取了这些“脏”数据，并据此做进一步的处理，就会产生未提交的数据依赖关系。这种现象被形象地叫做"脏读"。
3. 不可重复读（Non-Repeatable Reads）：一个事务在读取某些数据后的某个时间，再次读取以前读过的数据，却发现其读出的数据已经发生了改变、或某些记录已经被删除了！这种现象就叫做“不可重复读”。
4. 幻读（Phantom Reads）：一个事务按相同的查询条件重新读取以前检索过的数据，却发现其他事务插入了满足其查询条件的新数据，这种现象就称为“幻读”。

#### Mysql 索引
Mysql 索引

每次查询只能使用一个索引，所以如果在字段比较多的查询中，就算每个字段都创建了索引，也只能使用一个。但是如果创建了复合索引，这样能够走索引的内容就多了，效率会更高，所以复合索引的使用也很重要，是sql优化的一个很关键的点。

http://tech.meituan.com/mysql-index.html
现在只会创建单索引,但是很多情况下,复合索引更有效. 一个表只能使用一个索引,如果单键索引和复合索引都会生效,那么mysql会选择哪个索引。mysql索引的最左选择的原则。

*Mysql 优化器。*在有很多个索引的情况下，mysql优化器会选择一个比较好的索引。可以利用mysql索引的运算符。索引可用于`<`、`<=`、`=`、`>=`、`>` 和BETWEEN运算。在模式具有一个直接量前缀时，索引也用于 LIKE 运算。

有些情况下,优化的作用是很有限的,最好还是不要写太复杂的sql.  但是有一个情景,就是需要更具字表的条件去筛选结果,做分页,这种情况如何处理，可以内存排序.让排序在mysql中排序比较困难.那么这个分页逻辑如何处理. 

Mysql join之后的索引使用情况是怎么样的，索引可以减少join语句的总共需要扫描的行数，提高join查询的效率。join的时候有个原则就是小标join大表。如果 不会选择，可以不指定join，让mysql自己去选择。order by 的字段是否有必要增加一个索引,如果有必要,是不是所有需要排序的字段都需要增加上索引?这个明显是不可取的。每个query只能利用一个索引,如果where种的字段用到了索引，并且where中的query和order by的字段不是一个，那么只能选择其中的一个索引，所以在一个quer中创建多个单键索引是没有意义的。

索引是在数据库表或者视图上创建的对象，目的是为了加快对表或视图的查询的速度。按照存储方式分为：聚集与非聚集索引; explain 显示mysql如何处理select语句以及连接表,可以帮助写出更好的查询语句和建立更好的索引。rows 表示mysql执行查询的行数,数值越大说明效果越不好,说明没有用好索引.`using where` :要想使查询尽可能的快, 应尽可能得找出 using filesort , using temporary 的extra的值.我觉这在业务重没有必要禁止连表查询，在不会带来什么压力的情况下，并没有什么必要。如果两个表，都比较简单，连表也没什么不可以。什么事情都应该分开来看待，没有什么是绝对的。

Mysql 复合索引
符合索引的表现效率和索引顺序是密切相关的。创建复合索引的时候要仔细考虑顺序。符合索引上是可以增加排序的，查询中的排序必须和索引中的排序一直或者相反才可以用到索引。符合索引引只有一棵树，如果是a,b,c的索引，那么先a，后b，再c，如果a相等，则按照b的顺序排，如果ab都相等，那么按照c的书序排。查找的时候，如果是a，b，c三个都能用到索引的情况，会先按照a确定出一个大概范围，然后在用b来进一步缩小范围，再用c来最后确定查找范围。但是符合索引的顺序怎么设置比较好呢，我觉着这个应该由具体的业务决定。

阻止复合索引使用的情况
1. 范围查找会中断符合索引。
2. 使用计算函数无法使用索引。
3. `<> !=`无法使用索引。

```sql
CREATE INDEX idx_example ON table1 (col1 ASC, col2 DESC, col3 ASC)
```

#### Mysql 翻页的方式
不要以为翻页只有简单的limit。limit是最简单直接的方法，但是他的缺点也很明显，对于销量数据，千级别的，用这个来翻页取数据还勉强可以，但是如果数据量更大，那么久会很慢。这个时候只能采取其他的方式来设计。所以，对于limit的方式，最好做一个限制数量的翻页，不要做成无限制的翻页。具体参见这个[mysql翻页](http://www.admin10000.com/document/5796.html)


#### mysql 中创建用户。

```
CREATE USER 'username'@'host' IDENTIFIED BY 'password'
GRANT privileges ON databasename.tablename TO 'username'@'host' 
GRANT ALL ON *.* TO 'pig'@'%'; 
SET PASSWORD FOR 'username'@'host' = PASSWORD('newpassword');
SET PASSWORD = PASSWORD("newpassword");  如果是当前登陆用户
```
more detailed info see this link.  http://www.jb51.net/article/31850.htm

#### mysql 中的数据类型

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

#### Mysql decimal

对于精度比较高的东西，比如money，我会用decimal类型，不会考虑float,double,因为他们容易产生误
差，numeric和decimal同义，numeric将自动转成decimal。
DECIMAL从MySQL 5.1引入，列的声明语法是DECIMAL(M,D)。在MySQL 5.1中，参量的取值范围如下：
·M是数字的最大数（精度）。其范围为1～65（在较旧的MySQL版本中，允许的范围是1～254），
M 的默认值是10。
·D是小数点右侧数字的数目（标度）。其范围是0～30，但不得超过M。
说明：float占4个字节，double占8个字节，decimail(M,D)占M+2个字节。

关于decimal范围的判断，下面这是一个不错的解释。

    Although the answers above seems correct, just a simple explanation to give you an idea of how it works.
    Suppose that your column is set to be DECIMAL(13,4). This means that the column will have a total size of 13 
    digits where 4 of these will be used for precision representation.
    So, in summary, for that column you would have a max value of: 999999999,9999

引申 为什么floa 和 double 会丢失精度。
1 字节 = 8 bit。 int 一般认为是32位。最长是10位。
float 为4byte。
double 为8btye。
IEEE 754 标准，数的存法。


#### datetime 和 timestamp 的区别。

    ctime  datetime => now()  4字节
    mtime  timestamp ==> CURRENT_TIMESTAMP  8字节
    1970 ~ 2037
    alter table user add column mtime timestamp  not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP;
    alter table user add column ctime timestamp  not null default CURRENT_TIMESTAMP;

1970 1.1 00:00:00 标准时间，一般情况，mysql需要2个字段，一个是ctime，一个是mtime，mysql中这两个字段一般都是not null 的，timestamp如果是2个默认值都是CURRENT_TIMESTAMP的话，sql会报错，可以像上面那样写。


#### Mysql 索引操作 mysqldump 数据导出和数据恢复

```sql
create index index_name on table_name (column_list);
alter table table_name add index index_name (column_list);

对应的，删除索引。
drop index index_name on table;
alter table table_name drop index index_name;
清空表中的数据，包括 auto_increment 的字段都会被重置。
truncate table_name;


mysqldump -h localhost -ppasswd  -uroot -d database > dump.sql ;            // 只导出数据库的结构
mysqldump -h localhost -ppasswd  -uroot  database  > dump.sql ;             // 导出数据库的结构和所有的数据
mysqldump -h localhost -ppasswd  -uroot -d database tablename > dump.sql ;  // 只导出表结构
mysqldump -h localhost -ppasswd  -uroot  database tablename > dump.sql ;    // 导出表结构和表中的数据
mysql -u root -p yourpasswd -h localhost yourdb < dump.sql                  // 将dump.sql 导出入到你的数据库
```

mysql 中的test 表的使用方法。如果你在数据表中没有数据的到处权限，但是一般的数据库中，test库中的权限你都是
有的，所有可以将需要的数据先导入到test中的临时表中，然后再从临时表中导出去。这样可以绕开权限控制，到处你
需要的数据。sql如下
create table xxx as select * from `you_target_table` where xxx=xxx;
这样 一张 test 中的临时表就创建好了，你可以用mysqldump将这个表中的数据导出去。

#### mysql时间处理函数

```sql
select date_format(now(),"%Y-%m-%d %H:%i:%s") now;
select date_sub(now(), interval 10 day) as yesterday;       // 请不要吧 day 写成 days ，month , hour 同理。
group by 多个字段 从 col_a -> col_b -> col_c 优先级依次降低。
select * from test_table where status = 1 order by col_a desc, col_b desc, col_c asc limit 100;
set @a = 100;
select @a:=300;  #可以通过 select 给变量赋值,这个变量只在这个链接周期中有效。
```

#### mysql 存储过程
下面是一个简单的存储过程的例子。

```sql
delimiter $     # 因为 mysql 默认的 终止符是; 而这个正好是存储过程的语法，所以在编写存储过程之前，先将 delimiter 改成 $
create procedure p()    # 创建存储过程
begin
select * from ttt;
end;
$
delimiter ;     # 将 delimiter 改成默认的; 这样符合我们的习惯
call p();       # 调用这个存储过程
```
