### 一、理论知识
本文主要介绍一下mysql 的简单应用。首先介绍一些sql的基本语法，然后创建一个示例数据库，设计了一个学校系统的数据库，创建了数据表。第三部分以这个数据库为基础，示例了一些sql的简单查询语法。 

#### 一、install mysql-server

1. **[download mysql-server with this link]**(https://cdn.mysql.com//Downloads/MySQLInstaller/mysql-installer-community-5.7.17.0.msi)
2. start your mysql-server , connect to your mysql server.

#### 二、mysql关键字和基本的命令.

1. mysql数据类型 ` int , bigint , char , varchar , text , float , double , decimal , datetime ， timestamp`
2. 关键字 ( `select`,`from`,`where`, `order by`,`desc`,`asc`,`group by`,`+`,`-`,`*`,`/`,`left join`,`right join`,`on`,`in`,`between`, `insert`,`drop`, `delete` ,`alter`)
3. show commands;
[shell]
show databases; 
show tables;
show create table;
desc command;
[/shell]

4. 创建数据库.
5. 创建数据表。
6. 单列插入，批量插入。
7. 删除操作。

#### 三、常用的mysql query:

[shell]
select * from table where xxx	//single table select ; 
select * from a , b where a.xx = b.xx and a.xx = '123' order by a.xx; //join table select; 
select * from a left join b on a.x = b.x and a.c = b.c where a.x = 'xx' and b.c='eee'; left join;	// left join table select; 
//	聚合操作：max min avg  having 
//	order by , group by , limit , count
select * from A where A.x in (select B.x from b.xxx = '1231' )	//sub query; 
select id,salary,if(salary>300,'high','low') from salary	//if (grade > 70 , 'low', 'small');  if(value,t,f);
select id,salary,ifnull(salary,0) from salary	//ifnull(t,f)
[/shell]

#### 四、mysql中的内置函数

[shell]
now()
date_add , date_sub();  interval 8 days; select date_add(now() , interval 3 day); select date_sub(now() , interval 1 day); month;
upper , lower , left (name , 3) , right (name , 3);lenght(name) , SubString
curdate()		// 返回当前日期
curtime() 		//返回当前时间
datediff() 		//计算两个日期之差
date_add() 		//高度灵活的日期运算函数
date_format() 	//返回一个格式化的日期或时间串
[/shell]

### 二、创建数据表

#### 1. 创建数据表

[shell]
create table we_student (
id bigint(20) auto_increment,
group_id bigint(20) not null default 0 comment 'group_id for the student',
name varchar(64) not null default '' comment 'name of the student',
email varchar(64) not null default '' comment 'email for the student',
sex char not null default 'F' comment 'sex of the student',
address varchar(64) not null default '' comment 'address of the student',
parents_phone varchar(32) not null default '' comment 'parents mobile',
school_grade smallint not null default 1 comment '1-6 for 初一 ~ 高三',
	birthday datetime not null default '1990-01-01 00:00:00',
	ctime datetime not null default CURRENT_TIMESTAMP ,
	mtime datetime not null default CURRENT_TIMESTAMP ,
	status smallint not null default 1 comment '1:normal , -1: delete',
	primary key (id)
) engine = InnoDB , charset=utf8 , comment 'student table' ;

create table we_class (
	id bigint(20) auto_increment comment 'class id for this class',
	name varchar(64) not null default '' comment 'name for this class.',
	class_description varchar(2048)  not null default '' comment 'class description',
	price int(11) not null default 3000 comment 'price for this class',
	price_description varchar(2048) not null default '' comment 'description for price',
	ctime datetime not null default CURRENT_TIMESTAMP comment 'create time',
	primary key (id)
) engine = InnoDB , charset=utf8 , comment 'all class table';

create table we_worker(
	id bigint(20) auto_increment comment 'id for teacher',
	name varchar(64) not null default '' comment 'teacher name',
	sex char not null default 'M' comment 'M for man , female for woman',
	mobile varchar(32) not null default '' comment 'mobile',
	birthday datetime not null default CURRENT_TIMESTAMP,
	card_id varchar(32) not null default '' comment 'wage card id',
	wage int(10) not null default 0 comment 'wage for the teacher',
	department bigint(20) not null default 0 comment 'depart id for this worker',
	in_time datetime not null default  CURRENT_TIMESTAMP comment '入职时间',
	out_time datetime not null default CURRENT_TIMESTAMP comment '离职时间',
	status smallint not null default 1 comment '1: 在职 , -1:离职',
	primary key (id)
) engine = InnoDB , charset=utf8 , comment 'table for teacher';

create table we_department
(
	id bigint(20) AUTO_INCREMENT comment '',
	name varchar(32) not null default '' comment 'department name',
	description varchar(2048) not null default '' comment 'description for this department',
	ctime datetime not null default CURRENT_TIMESTAMP,
	primary key (id)
) engine = InnoDB , charset =utf8 , comment 'table for departments';

create table we_group
(
	id bigint(20) auto_increment comment '',
	class_id smallint not null default 1 comment 'class id for this group',
	starttime datetime not null default CURRENT_TIMESTAMP comment 'start time for this group',
	endtime datetime not null default  CURRENT_TIMESTAMP comment 'end time for this group',
	teacher_id bigint(20) not null default 0 comment 'worker id',
	status smallint not null default 0 comment '0: planning , 1:in process , 2: finished , -1: canceled',
	primary key (id)
) engine = InnoDB , charset =utf8 , comment 'table for student groups';
[/shell]

#### 2. 插入测试数据
[shell]
insert into we_worker ( name , sex , mobile , birthday , card_id , wage , department , in_time , out_time) values ('王小二' , 'M' , '182329938823' ,'1993-10-18' , '18201176525' ,  10000 , 1 , '2017-07-13 00:00:00' , '0001-01-01 00:00:00');
insert into we_group (class_id , starttime , endtime , teacher_id) values (1 , '2017-07-14 09:00:00' , '2017-08-14 00:00:00' , 1);
insert into we_group (class_id , starttime , endtime , teacher_id) values (1 , '2017-07-14 09:00:00' , '2017-08-14 00:00:00' , 1);
insert into we_group (class_id , starttime , endtime , teacher_id) values (1 , '2017-07-14 09:00:00' , '2017-08-14 00:00:00' , 1);
insert into we_group (class_id , starttime , endtime , teacher_id) values (1 , '2017-07-14 09:00:00' , '2017-08-14 00:00:00' , 1);
insert into we_department ( name , description ) values ('teacher' , '教工部' );
insert into we_department ( name , description ) values ('adminstration' , '行政部' );
insert into we_department ( name , description ) values ('finacial' , '财务部' );
insert into we_department ( name , description ) values ('human resource' , '人力资源' );
insert into we_class (name  , class_description , price , price_description ) values ('c语言入门' , 'test ' , 30 , 'test');
[/shell]


### 三、SQL习题

1. 数据库操作，查看库和表结构
[shell]
/** show database structure **/
show databases;
/** show tables **/
show tables;
/** select database **/
use learning_sql;
/** show table structure **/
desc we_student;
desc we_department;
desc we_class;
desc we_group;
desc we_worker;
[/shell]

2. 工资最高的worker，输出姓名和工资，按照工资从小到大排序 `select ` , `order by` , `limit`
[shell]
select name , wage from we_worker order by wage desc limit 10;  /**[ offset , size] **/
select name , wage from we_worker order by wage desc limit 10 , 10;
select name , wage from we_worker where wage = (select max(wage) from we_worker);
[/shell]

3. 找出所有的员工的部门名称，输出 老师姓名和部门名称 `left join`
[shell]
select a.name  as teacher_name , b.name as department_name 
from we_worker as a  left join we_department b on a.department = b.id;
select * from we_worker a left join we_department b  on a.department = b.id;
[/shell]

4. 找出每个老师带课的数量 `group by` , `count`
[shell]
select teacher_id , count(*) as class_num from we_group group by teacher_id order by class_num desc;
[/shell]

5. 每个老师的id,工资， 带课数量 `left join`
[shell]
select a.name , a.id , b.class_num from we_worker a left join (select teacher_id , count(*) as class_num from we_group group by teacher_id) b on a.id = b.teacher_id  where a.department = 1;
[/shell]

6. 还没带班级的老师, 以及所有带班的老师 `子查询`，聚合函数 `count`，`exists`
[shell]
select * from we_worker where department = 1 and id not in (select distinct teacher_id from we_group);
select * from we_worker where department = 1 and id in (select distinct teacher_id from we_group);
select * from we_worker where department = 1 and not exists (select * from we_group where teacher_id = we_worker.id);
select * from we_worker where department = 1 and exists (select * from we_group where teacher_id = we_worker.id);
[/shell]

7. mysql 内置函数 `date_add` and `date_sub`, 以及数据 `update`
[shell]
update we_worker set in_time=date_add(in_time , interval 2 day) where id = 1;
update we_worker set in_time=date_sub(in_time , interval 3 month) where id = 10;
[/shell]

8. 入职满一年的员工
[shell]
select * from we_worker where in_time <= date_sub(now() , interval 1 year) ;
[/shell]

9. 每个课程的开课数量
[shell]
select class_id , count(*) as count from we_group group by class_id;
[/shell]

10. 每门课程的 课程id , 开课数量，课程名称
[shell]
select a.id , r.total, a.name , a.class_description  
from we_class as a left join 
(select class_id , count(*) as total from we_group group by class_id) r 
on a.id  = r.class_id;

select a.id , r.total, a.name , a.class_description 
from we_class as a left join 
(select class_id , count(*) as total from we_group group by class_id) r 
on a.id  = r.class_id where r.total is not null;
[/shell]

11. 找出还没开班的课程 , 多表 `left join` , 4 个表
[shell]
select a.id from we_class a left join we_group b on a.id = b.class_id where b.id is null;
select * from we_class a , we_group b where a.id = b.class_id;
[/shell]

12. 这出一个  学生的姓名,班级开课时间,班级节课时间,课程名称，带课老师名称,下面是输出示例
[shell]
select a.name , b.id as group_id  , c.name, c.class_description , d.name  from we_student a 
left join we_group b on a.group_id = b.id left join we_class c on b.class_id = c.id 
left join we_worker d on b.teacher_id = d.id;
[/shell]

