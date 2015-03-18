这两个jquery表达式就是所有功能的精髓。我已经掌握了这里的核心，给我jquery，我可以随意游走，随意更改。
jquery 中常用的标签还有 text(),value() 函数, attr() 函数也很有用。
常用的还有$(this).data(), $(this).attr()。

```javascript
$("#163370613505072036").parent().parent().find('td:eq(9)').html("<font color='blue'>下架</font>")
$("#163370613505072036").parent().parent().find('td:eq(17)').find('div:eq(2)').find('a:eq(0)').text('查查')
```

[vim markdown 插件](https://github.com/plasticboy/vim-markdown)可以让vim支持markdown语法。
vim marks 的用法，很不错的，应该收藏。vimimum 可以用 yy 将当前也的地址copy下来,这一点是和 firefox 一样的。
[vim mark 功能](http://blog.163.com/lgh_2002/blog/static/44017526201081154512135/)
[xmind -official site](http://www.xmind.net/share/)

####sql for sweet_i
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

2015-03-10 13:31

```php
array_slice();
array_splice();
```

这两个函数是不同的。 array\_splice\(\)不用返回结果，直接对参数进行处理。
array\_slice\(\) 的结果是返回的结果。

```sql
alter table t_pandora_account_group add column week_gmv double(11,3) not null default  0.0 comment '最近一周的gmv';
alter table t_pandora_account_group add column two_hour_gmv double(11,3) not null default 0.0 comment '近2个小时的gmv';
alter table t_pandora_account_group add column week_order int(10) not null default 0 comment '上一周的订单数量';
alter table t_pandora_account_group add column week_people int(10) not null default 0 comment '上一周加群的人数';

将新店铺插入到最多好货圈。

更新上周 订单数量 的sql。
update t_pandora_account_group a,
(
select a.group_id, count(*) as week_order from t_pandora_account_group a, t_pandora_order b 
	where a.shop_id = b.shop_id and a.group_status = 1 and b.order_status = 2 and b.order_ctime > date_sub(now(), interval 1 week)
	group by a.group_id 
) b set a.week_order = b.week_order where a.group_id = b.group_id;
```


2015-03-12 11:01

Yii 如果没有 primary key 会报错，遇到了这个问题。
http://bbs.csdn.net/topics/390103199 
原来只是内网没有这个primary key。

```sql
alter table t_pandora_dimension modify id int(11) not null auto_increment primary key comment '自增ID';
alter table  t_pandora_dimension_shop modify column position int(10) not null default 1 comment '商铺位置';

```

```php
// 默认生成的代码CGridView的dataProvider是$model->search();
// 我们找到模型类的search方法：设置默认排序的字段，可以做一些自定义。
public function search()
{
	// Warning: Please modify the following code to remove attributes that
	// should not be searched.

	$criteria=new CDbCriteria;
	$criteria->compare('title',$this->title,true);
	return new CActiveDataProvider(get_class($this), array(
		'pagination'=>array(
			'pageSize'=>20,//设置每页显示20条
		),
		'sort'=>array(
			'defaultOrder'=>'createTime DESC', //设置默认排序是createTime倒序
		),
		'criteria'=>$criteria,
	));
}

public static function getWeekNewPeople($group_id,$start_time)
{
	$server = Constant::MONGODB_SERVER;
	$conn = new Mongodb($server);
	$conn->selectDb("meteor");
	$mongo_date = new \MongoDate(strtotime($start_time));
	$condition = array("group_id"=>$group_id,"join_time"=>array('$gt'=>$mongo_date));
	$ret = $conn->find('group_user_lists',$condition);
	return $ret;
}

```

**crontab \-e **  <http://www.cnblogs.com/cocowool/archive/2009/04/22/1441291.html>

2015-03-13 21:56

要考虑一下系统的缓存问题。首页，和群圈首页都需要进行缓存，减小系统的访问压力,提供更好的用户体验。
那些东西是真正有有价值的。
抽奖系统，秒杀系统 的实现过程。这些我都没有参与，如果独立设计，怎么实现？

目前，系统是零散的
不能为

目前需要从哪里提高。

SQL 的总结什么时候出来。

PHP 的总结什么时候出来。

SPHINX 什么时候搞出来。

BOOTSTRAP ？CI？
YII 何时优化？
我会把我的这部分工作做好。
**几个常用的 搜索引擎**

|   搜索引擎| 地址   |
|:----:|:---:|
|    百度|   <http://zhanzhang.baidu.com/sitesubmit/index> |
|    谷歌  |  <http://www.sogou.com/feedback/urlfeedback.php>          |
| 谷歌  |    <http://www.google.com/intl/zh-CN/add_url.html>  |

2015-03-16 18:16
功能的设计很重要，好得设计应该是灵活的，应该可以应对绝大部分的需求变更。
不要认为功能小，不要去认为的估计，要做长远的设计。


2015-03-17 16:47

Yii 用array 来作为 cgridview 的数据源。
http://stackoverflow.com/questions/9538777/using-an-array-as-the-data-source-for-cgridview
应该深入学习，学习自由定制显示。
YII 中假如全选框，提供全选功能。

CActiveDataProvider
it must be used in the following way;

$dataProvider=new CActiveDataProvider('Post', array(
    'criteria'=>array(
        'condition'=>'status=1',
        'order'=>'create_time DESC',
        'with'=>array('author'),
    ),
    'countCriteria'=>array(
        'condition'=>'status=1',
        // 'order' and 'with' clauses have no meaning for the count query
    ),
    'pagination'=>array(
        'pageSize'=>20,
    ),
));
// $dataProvider->getData() will return a list of Post objects


https://github.com/phpredis/phpredis
https://github.com/mongodb/mongo-php-driver
/usr/lib64/php/modules/

注意基础工具的开发。

mongodb connection pool .要认真研究一下
缓存可以很有用，应该好好研究一下， nginx可以做静态页面的缓存。可以从log分析访问流量。

python 中有很多异常，应该怎么处理.

