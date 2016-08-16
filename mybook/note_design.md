---
title: 数据库设计案例
categories:
- 数据库设计
tags:
- 数据库设计
---

#### sql for sweet_i

```sql

create table t_sweet_account
(
	account_id bigint(20) not null default 0 primary key,
	passwd varchar(64) not null default '' ,
	nickname varchar(64) not null default 0 comment '昵称',
	portrait_id varchar(32) not null default '',
	status tinyint(4) not null default 1,
	ctime timestamp default CURRENT_TIMESTAMP,
	mtime timestamp default 0
)engine = InnoDB charset = utf8 comment '帐号信息';

create table t_sweet_account_token
(
	acccount_id bigint(20) not null default 0 primary key,
	token varchar(64) not null default '' comment '账户的 token ',
	ctime timestamp default CURRENT_TIMESTAMP
)engine = InnoDB charset = utf8 comment '帐号 token 表';

create table t_sweet_image
(
	image_id bigint(20) not null default 0 primary key,
	image_path varchar(64) not null default '' comment '图片路径',
	status tinyint(4) not null default 1,
	ctime timestamp default CURRENT_TIMESTAMP,
	mtime timestamp default 0
)engine = InnoDB charset = utf8 comment '图片表';

insert into t_sweet_account(account_id, passwd, nickname, portrait_id, status, ctime, mtime) values(
3,'asdflerwer','xiaoya',23,1,now(),now()
),(),();
insert into t_sweet_book(book_id, book_faces, book_from, book_path, book_name, book_desc, status, ctime , mtime ) values();

create table t_sweet_book
(
	book_id bigint(20) not null default 0 primary key,
	book_faces varchar(512) not null default  '书的封面图片',
	book_from varchar(16) not null default '' comment '书的来源',
	book_path varchar(128) not null default '' comment '书资源的路径',
	book_name varchar(64) not null default '' comment '书名',
	book_desc varchar(128) not null default '' comment '描述',
	status tinyint(4) not null default 1,
	ctime timestamp default CURRENT_TIMESTAMP,
	mtime timestamp default 0
)engine = InnoDB charset = utf8 comment '';

create table t_sweet_user_book
(
	id bigint(20) not null auto_increment primary key,
	account_id bigint(20) not null default 0,
	book_id bigint(20) not null default 0,
	status tinyint(2) not null default 1,
	ctime timestamp default CURRENT_TIMESTAMP,
	mtime timestamp default 0
)engine = InnoDB charset = utf8 auto_increment =1 comment '用户下载记录';

create table t_sweet_user_read_info
(
	id bigint(20) not null auto_increment primary key,
	account_id bigint(20) not null default 0,
	book_id bigint(20) not null default 0,
	last_page int(10) not null default 1 comment '阅读页数',
	book_pages int(10) not null default 0 comment '书的总页数',
	ctime timestamp default CURRENT_TIMESTAMP,
	mtime timestamp default 0
)engine = InnoDB charset = utf8 auto_increment=1 comment '用户阅读记录';

```
