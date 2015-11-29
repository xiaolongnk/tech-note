214-12-01 10:41
1: 数据统计。
	1：按照店铺进行统计。
	2：每天0点进行更新。
	3：统计数据中增加IP字段。
	4: ip2long() 函数。
	5: 需要其他的表来辅助实现。这些吧表怎么构建。
	6: 对这几张表的思考。这几个数据都是怎么阳使用的。如何应用这些数据。首先，店铺的数量不会太大，至少在一段时间内
		不会增长太多，所以表的规模不用太担心。首先，表中的数据是和日期成正比的。每天都会有一份新的数据产生。考虑到
		查询和,要考虑建索引。这样可以提高查询效率。
	7: 在实际应用场景中，这几张表会怎样增长，数据会怎样变化。
	8: 能否实现上面这些需求。扩展性如何。
select mfrom,  count(*) as count from t_pandora_statistics where maction = 50000 and mfrom in (50001,50002,50003) group by mfrom;

2014-12-03 11:38
1: 修改商家端注册流程，商家必须上传头像,上传的头像。一个头像id.
html 中table 中的 border属性的设置。如果设置不正确，可能没有边框。下面是正确的设置。
并且 td 的属性会 覆盖 table 的属性。

2014-12-07 17:05
做子查询的时候，必需要给结果集起别名，否则会有语法错误。
mongo 如果要查询的数据是分为几层的话，应该用这总方式查询。用这种方式来写查询条件。 user.user_id 

sql 中将联表出现的 null 替换成 0， 可以用这个方法。
if(tb2.shop_click is null, 0,tb2.shop_click) 


如果 group by 来去重要比 distinct 效率要高很多。
子查询要控制
group by 多个字段。

2014-12-09 15:08

对 sql 的学习更多了，可以写出更长的 sql 了。
可以 set 变量。sql 中的变量是这样set 的。
set @start = curdate();
可以再一个 set 中定义好几个变量，可以用逗号分开。
另外，yii 中执行的sql 也可以包括好几个句子，但是他们的 读写必须是一直的，就是说，要么是执行 queryall ， 要么是执行 execute。
当然query 是从库， execute 是主库，表示写数据。

mysql 中和时间相关的函数用着还是很方便的。date_sub(); date_add(); interval 1 day; 
另外那些mysql 的工具也是很好用的，不用一直对着 cmd ，有时候还是没有必要的，毕竟不够方便。要结合起来才可以。


另外，存储过程是不是也应该掌握一下。
mysql 定义变量是不一样的。和其他语言的不太一样，这个需要注意一下。

Yii
的 那个 button 是可以优化的，可以加上 htmlOptions,可以规定宽度，这个标签很是有用。
用法就和下面这个一样。
http://www.hankcs.com/appos/yii-kong-zhi-dan-yuan-ge-di-kuan-du.html
我希望能掌握一种记东西的比较好的工具，现在直接写html 比较费劲，可以考虑一下用markdown。
或者直接写 blog 也是可以的。但是我不太喜欢上网页编辑的这个步骤。

Yii::app()->createUrl();
$this->render();
$this->renderPartial();
$cmd = Yii::app()->db->createCommand();
$cmd->text = $sql;
$cmd->queryAll();

Yii 的 view 和 action 之间的配合。有时候为了重用一个view，我需要隐藏很多的 input。

input type 可以是 textarea



mysql 可以多表连接查询，也可以 left join 和 right join 。但是要注意表的规模。如果表的规模太大，那么联表的效率就iu不敢恭维了。

所以说队数据的管理还是很重要的。要保证表不会太大。如果有其中一个表太大了，那么联表的结果都是非常可怕的。
如果表中的数据太多的话，那么就要想办法处理这些数据，不要让数据太大。

2014-12-12 14:11

1 举报机制还没有测试。
2 举报对应的后台需要完善
3 对应的推送还需要完善。 群聊的推送。（周一考虑）
4 一键搬家的接口(回调，账户的保护)

2014-12-12 14:38
------------------
聊天类。
收到 IM push。 进入聊天列表。（商家版，用户版。） mtype = 1 value = 0;
群聊推送  mtype = 2   value = shop_id  点击消息进入群聊进入消息列  

==================
订单相关 PUSH。

生成新订单。    订单管理页。（商家版） mtype = 5  value = 0
售罄 PUSH。    进入下架商品列表。（商家版） mtype = 6  value = 0
卖家已发货。    进入订单列表。（用户端） mtype = 7 value = 0
买家已付款。         订单列表 （商家版） mtype = 8  value = 0
买家确认收货。     订单列表 （商家版）  mtype = 9 value = 0
自动确认到货         告诉用户。(商家版)    mtype=10 value = 0;(默认 action)

商家版  推送 告诉商家发货。 mtype=11 value = 0 点击进入订单列表
==================

活动的推送
==================
Android 和 IOS 用户版。 通过 运营后台发送push消息。
活动推送。             进入首页。 mtype = 12  value = event_id
(会自动判断是不是秒杀活动) 如果是秒杀互动，mtype = 13

==================
后台审核通过。      
==================
店铺通过审核。 进入添加商品页。  mtype = 15 value = 0
店铺审核未通过。            mtype = 16  value = 0
商品审核未通过。            mtype = 17  value = 0  
商品被后台下架。            mtype = 18  value = goods_id 点击跳转到商品详情页 商家端
==================
单品分享
mtype = 20
==================
活动分享 URL。
mtype = 12 value = event_id
==================
分享秒杀活动
mtype = 13  value = event_id;


消息举报
mtype = 30  value=0 消息举报被禁言的推送  行为暂时没有规定

微点搬家回调
微店搬家登录成功  mtype = 40 value = 0  行为待确定
微店搬家完成      mtype = 41 value = 0  行为待确定
==================
--------------------------------
php url
$url = 'testurl';
$html = file_get_contents($url);
$content = json_decode($html);
var_dump($content);
http_build_query();



2014-12-15 10:33

如果举报同一个人，那么这个人的禁言时间会被刷新成目前的时间。

perl 形式的正则。
preg_match($mode,  $str, $matches);
preg_replace();

现在API的工作基本上差不多了，我需要着手 群聊消息推送的内容。

群聊需要将新消息推送给群里的每一个人。并且在推送之前，都需要看一下这个人是不是设置成免打扰模式的。
如果是免打扰模式的，那么不给这个人推送消息。
基本上和群相关的所有数据都是在MONgo 里面的。我需要给python 安装mongo组件，并且学习python的mongo组建。
学习队mongo的操作。每一段时间执行一次，将所有的新消息，推送给群里的所有人。

是不是部分是不是离线。

应该是只会推送给离线的朋友们，在线的是要跳过的。
mongo , redis, mysql ;
I need you. 

import pprint

pprint.pprint(yourarray);

easy_install pymongo
easy_install redis

python mongo 构造查询条件的时候需要这样子。构造字典 需要这样。

condition={}
condition['seq'] = {}
condition['seq']['$gt'] = 10
condition['createAt'] = {}
condition['createAt']['$gt'] = '1418634210';

不能直接这样子。
condtion = {'seq':{'$gt':'123123'},'createAt'{'$gt':'21'}}




队面向对象也有了新的认识，还是应该多谢点程序，就算是最简单的 dbo block，尽量写好一点，尽量可以分享出去，能
够给别人带来方便。

所以写的时候要规范一点，虽然我对python了解也比较少，正式因为这个，在学习写得过程中才会有进步。

算是对 mongo 比较熟悉了，但是我不想把学习的过程详细的写出来。
如果我回了，我就懒得去动手谢了，我遇到的问题队我来说已经不是问题了。所以我没有必要写了。
但是这样队别人能带来什么帮助，不是说相和别人共享知识吗，这就是这种共享态度吗？

ret = table.find();
返回的结果是可以 count 的。ret.count() 可以查看条数。

python mongo 学习了不少。
可以用 eval 求值来解决 库和表的选择问题。
但是里面的成员变量要写成 public 的。
python 的public 和 private 是不一样的，要认真思考一下他们的区别。

还没有搞完，明天继续。

2014-12-16 12:31
写伪代码还是很清楚的，有时间可以多写一点，我真是本末倒置。

redis 的connectionPool() 是什么意思，这个是怎么使用的。
有什么好处。

2014-12-17 11:20
alter table t_pandora_statistics add key uuid_index (uuid);

ajax 我根本就不会，jquery 的ajax，还需要联系下。

2015-01-04 14:08

the error may be in a field that is not displayed?
try this after $model->save()
print_r($model->getErrors());
$model->getErrors(); 可以看出上一个错误是什么。
or
in the config/main.php
enable logs for error and trace
and see the file runtime/application.log

今天遇到的问题，通过的时候save 老是不能成功，我只看到了save 的return status is false。
但是我并不知道是什么错误，后面找到了上面的解决方案。看到了原来一个字段是空的，而在model里面
这个字段是 required 的。所以就保存失败了。

不过正因为这个问题，我队 Yii 的了解也多了一些，还需要继续学习。

刚才遇到的问题是 
CGridView 的问题。想要实现 columns 里面的 指定列的自定义，就是不同类型给不同的颜色。但是也找了
好久。
想的是给一个 html 元素。但是刚开始是不会显示的，除非你加上这个选项。 'type'=>'raw';

这个方法并没有解决问题，但是也是有价值的。
'htmlOptions'=>array('style'=>'Convert::shop_change_status_color($data->status)')

array(
	'name'=>'status',
	'value'=>'Convert::shop_change_status($data->status)',
	'htmlOptions'=>array('style'=>'Convert::shop_change_status_color($data->status)')
	//'value'=>'Convert::shop_change_status($data->status)'
),
http://stackoverflow.com/questions/8140613/yii-zii-widgets-grid-cgridview-with-type-html-render-failed

关于 Yii 应该多了解一下。要学着自己定义。在框架的基础商进行自定义。

2015-01-05 10:59

mysql 数据查询。



2015-01-05 15:06
新加表项。
create table t_pandora_home_banner(
	banner_id int(11) unsigned auto_increment primary key,
	banner_status tinyint(4) not null default 1,
	banner_start timestamp not null default '0000-00-00 00:00:00',
	banner_end timestamp not null default '0000-00-00 00:00:00'
)engine = InnoDB, charset = utf8 ,auto_increment = 1, comment '首页banner 主表';



create table t_pandora_home_banner_item(
	banner_id int(11) unsigned not null default 0 primary key,
	position tinyint unsigned not null default 1 comment '排序字段,控制位置',
	mtype tinyint(4) unsigned not null default 1 comment '1群  2 专题 3 单品',
	mvalue bigint(20) unsigned not null default 0 comment '对应的类型的 值 群的shop_id event_id 单品 id',
	banner_item_status tinyint(4) not null default 1,
	banner_pic bigint(20) unsigned not null default 0
)engine = InnoDB, charset = utf8, comment '首页banner明细';



Yii app's application.log is in protected/runtime/application.log; not in main dir's runtime/

给的数据大致是这样，根据里面的type ， 去 分发到不同的接口。
mtype == 1 
	call  group_chat/get_detail  shop_id = mvalue;
mtype == 2
	call  event/get_event_items  event_id = mvalue;
mtype == 3
	call  goods/get_detail 		 goods_id = mvalue;

2015-01-06 14:30


unicodedecodeerror: 'ascii' codec can't decode byte 0xef in position 0: ordinal not in range(128)
import sys
sys.reload()
sys.setdefaultencoding("utf-8")
这个可以解决问题。

step 1
	finished you code.
step 2
	刷数据，所有 token status = 1 的account_id 添加 redis 缓存。

2015-01-09 18:28
div 也有 align 属性，center 就可以。 表示里面的内容在 div 的中间。

"<div align='center'> <a href='index.php?r=homeBanner/admin'> <h3> 返回 </h3> </a></div>"

2015-01-12 10:50
jquery radio 选中事件。
jquery onclick 事件， onchange 事件。我们根据radio 的 name 来选择选中的radio。
jquery 代码如下

<script>
function addSelected(){
	var a = <?php echo $id; ?>;
	// id = 0 表示创建，跳转到 创建的 url
	if(a==0){
		$("#form2").attr("action","<?php echo Yii::app()->createUrl('homeBanner/Create');?>");	
	}else if(a>0) {
		$("#form2").attr("action","<?php echo Yii::app()->createUrl("homeBanner/Update&id=".$id);?>");
	}
	id=$("input[name='mvalue']:checked").val();
	mval = "#event_id"+id;
	ans = $(mval).attr("value");
	$("#event_type_unique").attr("value",ans);
	// 如果不是 跳转到 update 的url
	form2.submit();
}

还需要总结。



form 表单相关的内容。 post 和 get 两种模式。
table 里面的内容可以是 hidden 的。他可以不显示出来。
如果需要想页面传值，那么需要用 input 标签。 input 的 type 可以如下text  radio  checked='checked'
checkbox value='1' checkbox 比较简单，如果选中的话，他的值就是对应的 value 的值。这个值是会被提交的。
所有的 input 控件提交都是通过 name 来指定属性的。在 php 文件中，可以通过$_REQUEST['your_name'] 来获得
对应的属性的值。
<select> <option selected='selected'> </option> <option> </option> </select> 
jquery $("#"); # 表示通过 id 来选择。. 表示通过class 来选择。还有就是上面的选择方式，是通过伪标签来选择。
input[]  [] 里面是这个控件的name属性。冒号后面是 checked 属性的值。.val() 是这个属性的值。这样可以获得值，
当然，里面可以给这个元素设定属性值。

$().attr(); 这个 attr 也是很好用的，和 val() 方法的用法类似，可以拿到属性的值，也可以设置属性的值。
并且 attr 可以是自己定义的属性。 例如 <input type='text' id='only' ccc='hello' > </input> $("#only").attr('ccc');
可以拿到 自定义属性 ccc 的值。
$().text() 有时候这个属性也可以去到自己想要的值。

&nbsp 代表一个空格。

javascript() 的function 。

function() {

}

radio, checkbox , button, 他们都有对应的时间，可以在里面添加对应的 函数。可以带参数的。
checkbox 也可以写成数组。 
name='chk[]'  $_REQUEST ['chk'] 取值的方式是这样的。

mysql 

update , select , 都可以联表操作。 当然，联表的时候都需要指定表的别名。
可以 从一张表选择内容，然后将选择的结果插入指定的表中。
insert into youtable select * from table1 where condition; 当然，表的结构应该要一样才可以。
事物的支持。现在需要事务的支持。
要防止 sql 注入，所以写 sql 的时候要注意，尽量按照规范的写法,实现功能的时候，就要考虑,进行防范。


2015-01-13 10:07

function genJsCode($classid)
{
	$ret = sprintf('<script> 
			var tag%sid = 1;
			function xxx%s()
			{ 
				if(tag%sid&1) {
					$(".xxx%s").attr("checked","checked");
					$("#ssss%s").attr("value","反选");
				}
				else {
					$(".xxx%s").attr("checked","");
					$("#ssss%s").attr("value","全选");
				}
				tag%sid++;
			}
			</script>',$classid,$classid,$classid,$classid,$classid,$classid,$classid,$classid,$classid,$classid);
	return $ret;
}

在一个页面

2015-01-13 17:01
import sys
import os
import re



def work():
	md = '/Users/a2014/Downloads'
	ret = os.listdir(md)
	for i in ret:
		if i.find('Game') !=-1:
			print i,re.findall("S0[14]E[0-9]+",i), re.findall("(\.mkv|\.mp4)$",i)
if __name__=='__main__':
	work()

2015-01-14 12:50

所有的缓存都要加上。并且要重新设置一下过期时间，加上过期时间是很有必要的。

2015-01-15 12:44

活动，商品数据统计，sql。

活动 ID， 活动类型， 活动点击量, 按照时间来统计 按照时间区间进行统计。
拿出活动的统计次数
select mvalue as event_id, count( distinct uuid ) as click_num from t_pandora_statistics where maction='20000' and
	ctime  > '2015-01-1' group by mvalue;

活动详情。
	活动中出现的商品，的点击次数，


给定一个 event_id 就可以得到这个 活动中的所有的商品的点击数量。
这个用来现实 活动详情的显示。
select mvalue as goods_id, parent_id as event_id , count(*) as click_number from t_pandora_statistics 
	where maction='10000' and mfrom in (10004) and ctime > '2015-01-10' group by mvalue;


商品纬度的统计


所有的尖货
select * from t_pandora_statistics where maction = '10000' and mfrom =10002 and ctime > '2015-01-10';

select mvalue as goods_id, count(*) as click_number   from t_pandora_statistics where 
	maction = '10000' and mfrom =10002 and ctime > '2015-01-12' group by mvalue  order by click_number desc limit 10 ;

所有的精选商品

select mvalue as goods_id, count(*) as click_number   from t_pandora_statistics where 
	maction = '10000' and mfrom =10001 and ctime > '2015-01-12' group by mvalue  order by click_number desc limit 10 ;



感觉PHP中日期计算方法太复杂了，应该找个简单点的方法。或者再封装一个方法。


2015-01-16 17:51
MYsql
a 表 字段 c1 和 b 表 c2 , 都有一个字段，这两个字段的类型不同的时候，是没有办法相等的。
按照MYsql 的相等判断是不相等的。所以要谨慎，
可以用 left join 和 right join 来校验这个错误。


checked这个属性不是我理解的那样，好像只要有checked 这个属性就可以起作用了。我应该做一个精确的测试才行。
而不是这样猜测。我的推送的代码还需要我进行测试，而不是像现在这样子。我应该为我的项目代码编写测试用例，
而不是等待QA测试。我们的开发应该有一个统一的网站，而不是像现在这样子，以QQ为主的信息传递。

我有点担心我的 推送程序发起的 redis 连接 和 mongo 的连接太多了。程序本省的性能，有没有内存泄露，能不能正常工作。
要想办法测试自己的程序。而不是全部依赖QA。



其实有好多做法都是没有必要的。比如里面的那个phpserialize 我觉着是没有必要的，完全可以通过jsondumps 来搞定。
应该多用PHP的方法来搞定。

刚才谢了几个 单元测试，找出了两个错误，这些问题只能通过单元测试来解决，没有单元测是的话，在整个流程中
来找出这些问题太费劲了。所以这些地方一定要写单元测试。
这个在整个项目中是很有必要的。

这里是有问题的。

至少这两个方法是有问题的。

/*
 * @author: xiaolongou
 * 新版要加上秒杀活动类型。
 * 获得活动的范围。 (offset, offset+size ]
 * 里面的排序是没有必要的。
 * 如果 ad_position 又重复的话，就用最新的活动(最新修改的)替换以前的。1个位置只现实一个活动
 */
public static function getCurrentPageEvents ( $offset, $size ,$is_new )
{
	...
}

/*
 * @author: xiaolongou
 * 按照升序排列，只有在 商品不足的时候会调用。
 */ 
public static function getEventsList($offset, $limit , $is_new)
{
	...
}

2015-01-20 10:14

程序上线的时候，应该把和配置相关的文件删除掉，这样上线后不用重新配置。
Traceback (most recent call last):                                                           
  File "/usr/local/src/Python-2.7.2/Lib/multiprocessing/process.py", line 258, in _bootstrap 
    self.run()                                                                               
  File "/usr/local/src/Python-2.7.2/Lib/multiprocessing/process.py", line 114, in run        
    self._target(*self._args, **self._kwargs)                                                
  File "hgDistributeStart.py", line 16, in worker                                            
    tmp.run()                                                                                
  File "/opt/web/lehe.com/hgpusher/hgDistribute.py", line 38, in run                         
    ret = m_msg.pre_message(message)                                                         
  File "/opt/web/lehe.com/hgpusher/distribute.py", line 72, in pre_message                   
    self.for_chat(message)                                                                   
  File "/opt/web/lehe.com/hgpusher/distribute.py", line 157, in for_chat                     
    nick_name = m.getfromNickname(from_account_id)                                           
AttributeError: Users instance has no attribute 'getfromNicknam

php 回掉函数的使用。
这是最基本的回掉方法。
call_user_func_array('your function',array());
array() is your params.

php 时间函数。
<?php
//$start = date_create(date("Y-m-d"));
//echo date_format($start,'Y-m-d H:i:s')."\n";
//$interval_d = date_interval_create_from_date_string("1 days");
//date_sub($start, $interval_d);
//echo date_format($start,'Y-m-d H:i:s')."\n";
error_reporting(7);
ini_set('display_errors', 1);
ini_set('date.timezone','Asia/Shanghai');

$start_str = '2015-01-01 23:00:00';
$end_str = '2015-01-30 23:00:00';

for($i = 0; ; $i++){
	$start = date_create($start_str);
	$interval_d = date_interval_create_from_date_string("{$i} days");
	$ans =date_add($start,$interval_d);
	$s = date_format($ans,'Y-m-d H:i:s');
	echo $s."\n";
	if($s >= $end_str){
		echo 'brk'."\n";
		break;
	}
	//echo date_frormat($ans,'Y-m-d H:i:s')."\n";
}
?>

2015-01-28 17:38
mysql 的联表查询的原理我还不是很清楚，只是知道了联表查询并不一定就等于O(n*m) 的复杂度。
和联表的条件是密切相关的。所以，需要多理解，多实践下。

ngix还是没有了解，应该也了解一下。

emulator: ERROR: Unable to load VM from snapshot. The snapshot has been saved for a different hardware configuration.
模拟器：错误：无法从虚拟机上加载快照，快照已被保存为一个不同的硬件配置。（存档错误无法读取)
解决办法：
Android Virtual Device Manager -> delete AVD -> new AVD
重新创建个AVD，解决。

2015-01-31 13:05

Nginx 反响代理，是一个不错的反向代理服务器。

我在学习 nginx 的源码，我下载到了源代码，我在学习比较高级的shell脚本。我可以写一篇比较高级的shell教程。
提高自己的技术能里，我需要一段蛰伏期。总之，是互联网方面相关的知识，都要尽可能的学习。

LC_ALL=c 这到底是什么意思？
LC_ALL=C 是为了去除所有本地化的设置，让命令能正确执行。
C 是 POSIX的别名。是系统默认的语言环境。LOCALE中有一组变量。LANG ，也是很常见的。ALL。
LC_TIME, LC_MONETARY, LC_MESSAGE,  
C是

我对shell 很感兴趣，总是找机会学习能接触到的shell。
配置文件，configure 文件，中的每一行都要追究为什么。

自己安装的时候，那面会装的比较乱。安装 的 configure 文件是需要不少配置参数的。如果都是用默认参数的话，
那么应该注意下对应的文件都放在什么地方了。

我自己的配置算是不太标准，在linux上，应该把一些重要的配置程序都放在制定的目录下，不要按照系统默认的那种
方式放置。我觉着这一点可以借鉴windows 的做法。比如你安装了nginx，那么吧所有的nginx文件都放在一个目录下，
包括自己的 log 什么的，这样管理起来方便一点，虽然linux完全允许你自己定义你的每一个文件，但是在以后的管理
中，我应该不会再向以前那样了吧，我会吧重要的软件都自己编译安装，然后放在制定的闻之，而不是像现在这样。我
所追求的不再是方便，而是简介与高效。

nginx
检测配置文件的正确性，不要加载一个又明显错误的配置文件
nginx -t -c /usr/nginx/conf/nginx.conf 或者向下面这样也可以 nginx -t 
启动  停止  或者重启 nginx 。
nginx  -s reload

如何调试shell。
bash -x your.sh 就可以看你的shell的执行过程了。
或者在shell的开始部分增加一行，set -x。

这个是 nginx 的documention。很不错的文档，应该好好学习一下。
http://nginx.org/en/docs/beginners_guide.html

有关sphinx的知识，我之前了解过一点，但是我并没有完全搞明白，应该找时间研究一下，这些东西都会有用的。
这段时间我可能会闲一点，但是我不应该让这样的安排阻止我进步的
firefox plugin 更新的时候，需要复制连个文件，要知道这个东西存放在什么地方。
/usr/lib/mozilla/plugins

像这种so文件一般都是在lib 目录里面的，这是一个常识，下次直接去对应的地方找，就可以了。

240181391
这是一份不错的试题。
http://www.sijiaomao.com/exam.html

感觉那个题木好难，我只会做几个简单的题。有空也可以找下这方面的试题练习一下。学习一门语言应该
学习得深入一些，这样总是好的。


NGINX
http://nginx.org/en/docs/beginners_guide.html

我可以将一些重要的html内容保存下来，这样可以离线阅读，对于没有网的我来说，这是很好的一个方法。
但是，目前我只能做到离线当前的页面，但是我想实现的功能是多层抓取，比如设计层级是3，那么将这个页面
里所有的链接也抓下来，然后对链接下来的html进行同样的分析，这样总共三层，我需要这样的抓取效果。
刚才搜索了一下，没有找到合适的方法，应该是需要自己动手的功能。


目前真得很需要钱。希望4月份我的薪水可以让自己满意。如果我不能满意，我真得可能要选择其他的地方。
我也没有办法。现在情况对我来说不是很有利，现在处境比较艰难。我应该保持谨慎，以前那种大大咧咧的
性格应该收敛一下，不能继续那样子下去，2014犯了太多错误，那些愚蠢的错误，给我带来了巨大的损失。
2015，我希望我不再重犯2014的那些错误，我希望我可以更快速的成长。我要用成长的速度弥补我犯的过错
2015，我需要改变，我需要更加努力，更加谨慎。
2015, 我应该加强英文的学习，阅读更多的文档，思考更多的问题。

刚才在学习配置nginx 的时候遇到问题了，我是按照上面的文档来配置的，但是出问题了。我应该去error.log
里面找问题，这一天提示很是重要，应该注意提高下自己这方面的能力。

我需要更全面的能里，所以我需要不断的学习。
原来nginx 和 apache 是需要同时实用的。解析php的时候，直接转交给apache就可以了。这就是代理功能的体现
了。

Instead of crearting a new process for each request, FastCGI uses persistent processes to handle
a series of requests. These processes are owned by the FastCGI server, not the web server.
To service an incoming request, the web server sends enviroment information and the page request itself
to a FastCGI process over a socket (in the case of local FastCGI processes on the web server) or TCP
connection (for remote FastCGI processes in a server farm). Responses are returned from the process to
the web server over the same connection, and the web server subsequently delivers that response to the 
end-user. The connection may be closed at the end of a response, but both the web server and the FastCGI 
service processes persist.  Each individual FastCGI process can handle many requests over its lifetime, 
thereby avoiding the overhead of per-request process 
creation and termination. Processing of multiple requests simultaneously can be achieved in serveral ways:
by using a single connection with internal multiplexing (i.e. multiple requests over a single connection);
by using multiple connections; or by a combination of these techniques. Multiple FastCGI servers can be
configured, increasing stability and scalability.
Web site administrators and programmers can find that the separation of web applications from the web 
server in FastCGI has many advantages over embedded interpreters(mod_perl, mod_php, etc). This separation
allows server and application processes to be restarted independently - an important consideration for busy 
web sites. It also enables the implementation of per-application / hosting service security policies, which
is an important requirement for ISPs and web hosting companies. Different types of incoming requests
can be distributed to specific FastCGI servers which have been equipped to handle those particular
types of requests efficiently.
CGI: For many years, the only way to achieve that tgoal was the CGI script: an application using the
Common Gateway Interface to receive and process HTTP requests from the web server. CGI scripts were
typically written in Perl or -- less often -- in C and implemented things like page counters or
guest books.
Soon , the Internet community realize that CGI had drawbacks: Writing a CGI is somewhat
uncomfortable if all you want is to process a few strings and display the results. So some clever
people came up with entirely different solutions like SHTML, ASP, and PHP -- to name a few. The
difference between CGI and say PHP is that CGI is an interface between the web server and the
application. ALL CGI does is to specify how an external application can receive HTTP requests from
the web server; CGI does in no way tell the developer what that application should look like or what
that application should do with the HTTP request.
Thus , it is hardly amazing that PHP and its alike became very popular.

We already mentioned the CGI interface, which defines a way for web servers to delegate HTTP
requests to external applications. This is exactly what web-based-application writes need: a way to
connect their application to the web. The Common Gateway Interface is very well-suited for that
purpose. Actually, though, there is an even better interface readily available: the FastCGI
interface.
The FastCGI interface, as specified in [FastCGISpec], is a packet-oriented communications protocol.
Even though the underlying transport mechanism is connection-oriented, the FastCGI protocol is
not.(YUes, there is a very goods reason for this. Just read on.)Each message consists of a header
and a body. The header contains --among others --the following fields:
The architecture described in this paper uses the C++ programming language. Of course, it is
possible to implement FastCGI applications in any programming language that supports interprocess
communication, be it Perl, TCL, or even shell scruipts. We nonetheless chose C++, because we feel
that "real" programming languages are more appropriate for the implementation of complex
applications. Writing web-based applications in C or C++ gives the developer more control over the
maching. Especially under the UNIX operating system, numerous mechanisms are available only to
software writers who use C.
Another advantage is that writting web-based applications in C or C++ gives y ou access to billions
of lines of code freely available on the Internet, no mwatter whether it is an arbitrary-precision
math library, a library for the creatation and manipulition of images, or a set of routines
implementing strong cryptography. It's all there - just use it!




不错，今天收获不小。对nginx 和 fastcgi 有了不少的了解。遇到了一些问题，明天有时间继续搞，最近
应该闲一段时间，要抓紧时间学习新知识。我要把这块搞得深入一点。加油。

2015-02-02 21:31
为什么我还是更喜欢Linux。
现在商家聊天的时候，用户通过意见商品联系商家的时候，推送过来的小时是一个接json串，这是有问题的。
明天反应一下这个问题，应该是遗留问题，但是需要解决，明天需要加上后台的定时任务。

crontab 的一些常识。

分 时 日 月 星期  执行命令。
* 表示任意的变量

00 23 * * * run-your script  每天23:00 执行你的脚本。其实我需要做的就是一行命令。
crontab l 列出当前的任务。

10 1 * * 6,0 /usr/local/etc/rc.d/lighttpd restart  这个任务表示每周6和周日的1:10重启服务器。
			注意逗号，表示多个的意思。再看下面一个。

* */1 * * * /usr/local/etc/rc.d/lighttpd restart  注意这个符号/ 表示每个一个小时重启一下服务器。

在linux 下，你当前用户的crontab文件存放在 /var/spool/cron/ 目录下，这个文件以你的用户身份 命名。
比如 root， fox 之类的。


如果有很多个input的话，那么尽量让他们的长度保持一致，这样可以是页面表现的比较整齐。如果你是个前段白痴的话，
这也是一个不错的选择。
时间可以让页面变得交互性很好。刚才的错误是很奇怪的，只因为写错了位置。
一个按钮是不是可以点击的，这些常用的时间应该很熟悉才行，要重视程序的交互功能。


刚才在文档里发现了好多东西，原来还是要自己编译才是最好的。才能够了解更多的特性。
./configure --help
其实已经包含了很多信息，只是你还不了解。
要编译安装，这个是很重要的一步。


php 中开启gd，
在编译php的时候，./configure --prefix=/opt/server/php-version/ --enable-gd
这样就 ok 了。

png.h   libpng-dev   you need to install this dev to finished your compilination.

编译php常见的20个错误。
http://crybit.com/20-common-php-compilation-errors-and-fix-unix/
	
编译apache2， configure 的时候提示 APR not found

I solved this problem by this command.

	sudo apt-get build-dep apache2
	I can userstant from the command, In ubuntu , we can install the build-dependencies
	that needed for software we want to compile, this is a goods tools for the build.
	thanks for ubuntu , thanks for linux.

这里有不少帮助。
http://devincharge.com/compiling-apache-2-4-ubuntu-12-04/
sudo apt-get build-dep apache2; 这个命令是做什么的。但是帮助很大。thhanks for ubuntu.

/etc/enviroment 这个文件并不是你看上去的那样简单。
sudo vim /etc/sudoers
apachectl restart  	// 第一个是可以执行的。
sudo apachectl restart   // 这个是不可以执行的。
这是为什么。
第一个是普通用户的 $PATH  第二个是 sudoers 的 $PATH 在严格意义上，这两个变量的值并不是一样的。
并且更多的时候，我们需要将特定的程序的控制权交给 sudoers 而不是我们的普通用户。所以设置 /etc/enviroment
是没有意义的。
我们看这个文件。
sudo vim /etc/sudoers
里面也有一个环境变量。我们可以设置这个变量。
用这个命令

sudo evn 里面列出的就是我们的  sudoer 的 $PATH 的内容。显然和我们的预期是不一样的。

In ubuntu, you can switch to root like this. 
sudo -i
sudo su -

	
Thus whatever is set in the /etc/environment for the path is overridden by sudo.
http://askubuntu.com/questions/128413/setting-the-path-so-it-applies-to-all-users-including-root-sudo

VIRTUALBOX SHARE FOLDER

I can wirte down my note in English only, and I can read it. Ok, solved this problem.
Setting share Folder in you virtualbox, share your mac folders in your Ubuntu in virtualbox.

First: mount  
	you can see this info.
	virtual on /media/sf_virtual type vboxsf (gid=999,rw)
Second:
sudo mount -t vboxsf virtual /mnt/virtual/   ;; content after -t , vboxsf is a file type.
	// virtual is your virtual folder in your main os, and /mnt/virtual is your mount point.

you can find more with this command.

man sudoers
sudo visudo
just edit this line, and your problem solved.
bash if grammer.

it is just and.
if test "$dev" = "0" -a "$devok" = "0" ; then
	echo "your comment"
	echo "your comment"
exit 1
fi


I solved problem for c++

for example your .h file is named head.h and content like this.
#ifndef _HEAD_H_
#define _HEAD_H_

this is your class definition area.

#endif


in your project, there are source file import it.
for example.

#include <iostream>

#include "head.h"
#include "head.h"

if you include "head.h" twice, you find you can compile your file as well.
but if your head.h is writte without #ifndef, #define #endif, then you must
will get an error to stop your working.

also, here the use of,

#ifdef

#else

#endif

this condition definition can save your release code size :).

2015-02-08 23:21
FOR C++;
what is different between static type and dynamic type.
static type: know when program is in compile process. 
dynamic type: know only in the run process.  For pointer type.


2015-02-10 23:23
关于html，前端的这些东西，今天学习到了好多，这要是jquery的this，和parent
还有find方法的实用，好多需求都变的很简单了，jquery确实很强大，我应该多研究
下。在yii中也是可以结合起来的，并不会受到太大的限制。


2015-02-15 00:35
这两天又学习了新的jquery知识，对jquery又了新的认识。我对游戏的认识还是不到位。
我的理解还是不够。如果玩，就要认真玩，一次时间不要太长，应该保证游戏的质量。要
认真对待每一次练习。


2015-02-15 08:18
jquery note.
ajax 是一个异步过程，页面中的一部分代码发出一个网络请求，在里面设置一个回调函数，
如果网络请求得到返回，那么执行回调函数。在回调函数中的上下文和时间触发的上下文会
有所不同，在jquery中的应用需求大多数时候是这样的。比如我点击了一个按钮，这个按钮
是一个 tr 中的 td 中的内容，我可以通过这个点击时间确定当前行的任何属性，或者确定
当前也面中的任何一个属性，只要这个页面的布局是又某种可控的过滤的话。需要实用到this
关键字。还有就是 find() 方法。比如
this.parent().find('tr:eq(3)'); 注意里面的3是从1开始的。或者是从0开始的，我也记不太
清楚了，到时候应该再验证一下。

function openRej()
{
	// 通过jquery找到当前链接同行的其他内容，这里拿到了ID。
	id = $(this).parent().parent('tr').find('td:eq(0)').html();
    $("#TB_overlayBG").css({
        display:"block",height:$(document).height()
    });
    $(".box").css({
            left:($("body").width()-$(".box").width())/2-20+"px",
            top:($(window).height()-$(".box").height())/2+$(window).scrollTop()+"px",
            display:"block"
    });
    current_id = id;
}

// 点击某个时间出发这个函数 来对页面进行局部更
function doReject(){
	var obj = $(".box input:checked");
	var rej_reason = '';
	var other = $("#otherbox #other_reject_reason").val();
	rej_reason +="`"+other;
	if(rej_reason == "`"){
		window.alert('亲，至少要填写一个原因哦！');
		return ;
	}
	url = "/hgadmin/index.php?r=buyerRecruitment/Reject&id="+current_id+"&reject_reason="+rej_reason;
	$.getJSON(url,function(data){
		// data 是从请求获得的数据。
        if(data.msg == true){
			// update data in current line.
			color = get_color(data.status);
			$("#rej_reason"+current_id).text(data.rea);
			status_text = gen_status_text(data.status);
			// 更新页面中对应的内容。
			$("#status"+current_id).text(status_text);
			$("#status"+current_id).css('color',color);
			// 执行其他的操作
			closeCeng();
		}else {
			alert('更新失败');
		}
	});	
}


我想实现的那个功能应该 还是用 ajax 来解决的。把页面重新组织一下就可以了。
将本地创建的分支，push 到 remote 去.实际上，git push ，git 会提示你这么做的。
git push --set-upstream origin dev

发现了一个新插件，但是不知道怎么使用。


This is very goods php docs on php-source code.
This is a great work.
http://www.php-internals.com/


pecl is 
PECL is a repository for PHP Extensions, providing a directory of all known extensions 
and hosting facilities for downloading and development of PHP extensions. 
PECL is very important.

ord 函数是做什么的。应该研究一下。

PHP mongo sort 规则。这个还是空白，应该抓紧补上，我才意识到，现在的问题原来是没有积累导致的。
应该吧自己写过的程序记录下来，并且进厂回顾，这样才不会白费，这和以前是完全一样的。

我的日志也不应该断的，我应该每天都记录一下。

Yii
Yii cgridview 控件的样式也是很重要的，这个控件有一个参数可以调整，htmlOptions 可以设置标签。

```
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'home-banner-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'htmlOptions'=>array('style'=>'table-layout:fixed;word-break:break-all'),
    'columns'=>array(
        'banner_id',
        'event_id',
        'position',
        array(
            'name'=>'mtype',
            'type'=>'raw',
            'value'=>'getmtype($data->mtype)'
        )
))

```
datetime picker 这个控件的格式样式的设置，设置成默认的样式，和标准的时间格式一样。
```
$(document).ready(function(e){
$('#mmm_event_start').datetimepicker({format: 'Y-m-d h:m'});
$('#mmm_event_end').datetimepicker({format: 'Y-m-d h:m'});
});
```

```php
PHP截取数组，实现一个翻页的功能。
PHP 的语法的一些问题，一些看似危险的写法并不会导致错误，对于你，这些应该熟知于心。
```

=======

Yii 里面有重复保存的现象。
我做了一个功能，我选择了修改某个项目，然后保存，之后会创建一个新的，不知道这个是什么意思。这个问题我之前遇到过，
是因为两个 action 调用了同一个form的action，应该更具当前情况更改form，这样才行。

$cmd = Yii::app()->db->createCommand($sql);
this is enough.
https://github.com/xiaolongnk/tablesorter
这是一个不错的控件，有时间可以细心研究一下。

我想实现的效果是，一个浮层类似的东西。 html 浮层，加上 ajax 和后段进行数据交互。这种模式才是比较理想的。
form 的ajax 提交。 这个现在还没有搞清楚，现在可以使用的是 url 形式的请求，可以用ajax的方式请求数据
然后不刷新页面。 总之刷新页面的效果可以搞定。

```

shell 中的 echo 也是可以进行内容替换的。这个很常用，应该记住。
sed 和 awk 常用的功能也不能忘记。需要好好学习下。

shell 中字符串相等的比较。如果一个内容是空的话，那么这个变量会没有，这样，你的表达式可能纠错掉了。
报如下错误.具体的错误类型还需要仔细再研究一下。我要先吧自己的脚本搞出来。
```
gitsync: line 11: [: ==: unary operator expected]

shell
a=$(($i + 1))

shell 中的变量，之前的理解还是有点浅薄啊。什么时候赋值，是什么时候引用。赋值的时候不需要用$ 引用取值的时候需要加上$

mysql 中需要清除一个表中重复的数据，当然这个表中可以设计成用key来约束的，但是如果当初没有这样设计，那么你需要收工来删除重复的数据。
有些场景对这种数据比较忌讳。
select max(id) from tourtable where status = 1 group by ca, cb having count(*) > 1;
然后用程序将这些 id 一起删除掉。这样就可以了。之前忽略了这一步工作，工作并没有做好。
无论如何，script 都是要写的。每天0点都对数据进行校正。

页面中所有的table ，应该都是具备一定的属性的，应该使用封装过的组建，这样构建效率会更好，并且整体效果也会好很多。
所有页面相关的排序都是按照从小到大开始的。 这样唯一的缺点是， 我在初始化值的时候，设置的默认值是1，如果一个分组有
比较多的数据，那么需要运营操作很多，才可以照顾到某一个具体的商家。为了解决这个问题，我应该将默认值设置成一个比较大的数字。
这样，只用改很少的就可以实现了。

电脑卡貌似是 chrome 的关系 chrome 标签少开点应该会好很多。 貌似不是 tmux 的罪过，到时错怪了。一定是chrome，我发现系统 load 和
chrome 的标签数是成正比的。

在 YII 里面，大部分逻辑应该放在 model 里面去实现，而不是所有的都放在 controller 那一层。这样对系统的扩展是很有好处的.现在发现之前
写的代码都好渣。对Yii 的了解太浅薄了,运营后台也可以自成体系。后面一段时间，要加强学习，前端和YII。现在做得这样慢，是因为我对YII了解
太少，所以不能得心应手。如果后面再出去，这样就说不过去了。
对工具不断熟练，对框架不断熟练，对语言掌握不断熟练，过了这些关之后，就会好些。

关于 运营后台为什么这么烂。
Yii 没有log 日志，为什么没有输出，我看到了 db 中的log，应该研究一下log这个模块。什么情况下才会将log输出到文件，什么情况下不会。
要搞清楚为什么行，为什么不行。

```

```javascript
String.prototype.trim = function() {
    //return this.replace(/[(^\s+)(\s+$)]/g,"");//會把字符串中間的空白符也去掉
    //return this.replace(/^\s+|\s+$/g,""); //
    return this.replace(/^\s+/g,"").replace(/\s+$/g,"");
}
function check_data()
{
    val = $("#channel_name").val();
    if(val.trim() == ''){
        alert('纬度名不能为空呦！');
        return false;
    }
    return true;
}
```

如果一个表索引太多，会有什么不好的影响。一个表上索引的上线原则上有么?

2015-06-08 17:08
PHP 断言的使用。需要进行一些基本都饿设置才可以。
```
<?php
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_BAIL, 1);
$a = 'i1.23';
assert(is_numeric($a));
echo $a;
?>
```

2015-06-09 14:28

在小功能上，也可以不断优化，可以不断提高，不要放过细节。

http://blog.sina.com.cn/s/blog_49c6c9b701014p9a.html
php 报错的log，在听云商看到的错误。其实就是变量没有定义。

2015-06-25 15:02
PHP redis hset 的使用。在做缓存的时候 ，有这样一些应用场景，需要对列表进行缓存，如果使用传统的key来保存，那么会
使得维护成本比较高。比如一个列表的存储如下，list01,list02,list03 那么在需要清除缓存的时候就需要清除list为前缀的
的所有list，这样清除比较困难。在redis中要尽量避免使用keys list* 这样的操作。在key 较多的情况下，这样性能很差，
并且有可能拖垮redis。这时候可以使用redis 的hset。 可以如下设置。
```
hset list list01 list01_value
hset list list02 list02_value
hset list list03 list03_value

hget list list03

del list
```
这样在删除的时候会很方便。维护成本会降低很多，所以在对list做redis缓存的时候，最好使用redis的这个数据结构。
需要注意的是redis 的 hash 的ttl，可以调用expire这个方法来设置 hash 的生存周期。并且一个hash就是一个整体，
每一次设置都会设置这个生存周期。这个时候可能出现的问题是一个hash的缓存时间不可控，取决于最后一次更新的时间。

2015-06-26 10:49

todo list:
1. use redis hash to optmize cache system.  done.
2. remove some useless code. done.
3. merge xiaolongou to dev. done.
[test login](http://v.online.killtime.cn/account/login?app=higirl&client_id=1&cver=2.4&mobile=18515615556&password=F200152W&qudaoid=10000&uuid=cdc4f9a8696d8e9bfab8077fab221871&ver=0.7&via=iphone)
[test goods_discover](http://v.online.killtime.cn/goods/goods_discover?app=higo&backup=0&client_id=1&cver=3.1.1&p=1&qudaoid=10000&size=30&uuid=77c04e600d9d9558cd9ce5805c7cf8e4&ver=0.8&via=iphone)
[goods_show](http://v.online.killtime.cn/goods/goods_show?app=higirl&client_id=1&type=3&cver=3.1&mobile=18515615556&password=F200152W&qudaoid=10000&uuid=cdc4f9a8696d8e9bfab8077fab221871&ver=0.7&via=iphone)


2015-06-29 17:01
work list.
1. 研究一下xinge_push 的sdk.研究批量推送的功能。写一个 demo 出来。done
2. 尝试给列表的API 做程序级别的缓存。 

2015-06-30 11:40

1. 研究下那个需求的实现，现在有好多都需要加push，真是感觉没必要。需要设计出这个功能。
2. 研究一下促销的接口的实现。这个基本是一个促销一个接口，真不知道什么时候能停下来。
3. 大促相关的接口的开发。共同商定开发细节。
4. bugfix for category_goods/get_detail . wait to confirm. 似乎 bug 了很久。
5. push 提醒功能的开发。(可以做在运营后台，用新的xinge api，用 cron 的形式来实现。redis mongo)

多表关联的话，一定要想好要让那个表做主表，效果会大大不同。

2015-07-01 11:16
1. 下周的大促页面API。这部分配套的 运营后台怎么做。 done.
2. review 一下代码。done


2015-07-03 14:33
1. 有几个问题需要注意下。
   就是列表的不稳定排序，比如做分页的时候，很可能引起不同页的数据重复的现象。这个时候要想办法让这个列表
   的排序变稳定，就可以了。done .
2. 大促的单独库存。
3. 检查一下秒杀商品的所有的价格，确保明天没有问题。 done.

2015-07-06 14:09

1. 活动期间的 库存 和 销量独立。 
2. 每一个提报商品如果有多个sku，需要选择价格最低的sku，如果这个sku库存为0的话，应该过滤掉。使用 presale_repertory 来过滤吗？
3. 真正不太好做的是一个提报商品多个 sku 的情况。这个时候需要做分组。当一个售罄，需要显示下一个商品。他们的库存和销量都是分开的，这些该如何处理。
4. 

2015-07-07 14:15
git reflog 可以到任何一个版本。 git reset --hard version_nu.
用了git，你的代码不可能丢失。
合错代码也没有关系。可以恢复的。you can do anything you want.

find ./* -name '*.pyc' -exec rm {};

2015-07-10 18:53

```
shell 执行字符串命令。可以这样。
eval $cmd
试了一下，只有上面这种方法是ok的，其他的都不太行。
类似的问，其他语言中也有很多。python中也有不少。
sh exec $cmd
`echo $cmd`

date '+%Y-%m-%d'
httpd -S

ps -ef | grep httpd

shell 脚本中的 空变量。可能是你的程序抱错，所以写判断的时候需要考虑变量为空的情况。
如果出现这样的情况，报的错误可能是这个。
"[: =: unary operator expected"

if [ $pusher_env'X' = 'prodX' ]
then
    workdir='/home/work/hgpusher/'
elif [ $pusher_env'X' = 'devX' ]
then
    workdir='/root/dir_higo/hgpusher/'
elif [ $pusher_env'X' = 'localX' ]
then
    workdir='/code/hgpusher/'
else
    echo '请先设置系统环境变量 pusher_env '
    exit -1
fi
echo "运行配置是"$pusher_env
````

is null  和 is not null 的用法。
mysql null 是不能参与比较的，要注意这种情况。
select * from hellotest where xx is null;


