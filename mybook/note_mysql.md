#### 2016-01-07 13:11
Mysql 学习.


mysql 性能测试工具.
对mysql 的深入学习是很有必要的.
对正则表达式的深入学习也很有必要.

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
按照存储方式分为：聚集与非聚集索引

和B树B+树的关系还是差别挺密切的,所以需要认真理解一下B树和B+树.

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

