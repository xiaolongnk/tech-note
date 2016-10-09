---
title: mysql enable emoj
date: 2016-08-24 10:47
tags:
- laravel
- mysql
- emoj
---
### Laravel Mysql 支持emoj

#### 1 确保mysql-server是5.5.4+
utf8mb4的最低mysql版本支持版本为5.5.3+，若不是，请升级到较新版本。
用mysql客户端连接进去，最上面会提示你当前的mysql的版本，确保是5.5.3以上的就可以了。

#### 2 修改database、table和column字符集
参考以下语句：

```shell
ALTER DATABASE database_name CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
ALTER TABLE table_name CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE table_name modify column_name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
#### 3 修改mysql配置文件my.cnf

my.cnf一般在etc/mysql/my.cnf位置。找到后请在以下三部分里添加如下内容：

[client]
default-character-set = utf8mb4

[mysql]
default-character-set = utf8mb4

[mysqld]
character-set-client-handshake = FALSE
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
init_connect='SET NAMES utf8mb4'

#### 4. 重启mysql-server
ubuntu 的话可以 `sudo service mysql restart`
进入mysql看一下以下变量。

```shell
SHOW VARIABLES WHERE Variable_name LIKE 'character_set_%' OR Variable_name LIKE 'collation%';
```
+--------------------------+--------------------+
| Variable_name            | Value              |
+--------------------------+--------------------+
| character_set_client    | utf8mb4            |
| character_set_connection | utf8mb4            |
| character_set_database  | utf8mb4            |
| character_set_filesystem | binary            |
| character_set_results    | utf8mb4            |
| character_set_server    | utf8mb4            |
| character_set_system    | utf8              |
| collation_connection    | utf8mb4_unicode_ci |
| collation_database      | utf8mb4_unicode_ci |
| collation_server        | utf8mb4_unicode_ci |
+--------------------------+--------------------+

#### 5. 设置laravel 的配置。

app/config/database.php 中的 mysql 部分的 charset 部分改成 utf8mb4 , collation 改成 'utf8mb4_unicode_ci'
```php
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
```
上面这些之后，重新尝试以下保存emoj，应该就可以成功了。
