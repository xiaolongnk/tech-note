---
title: PHP 学习笔记
---

2014-12-03 11:38
1: 修改商家端注册流程，商家必须上传头像,上传的头像。一个头像id.
html 中table 中的 border属性的设置。如果设置不正确，可能没有边框。下面是正确的设置。
并且 td 的属性会 覆盖 table 的属性。

2014-12-07 17:05
做子查询的时候，必需要给结果集起别名，否则会有语法错误。
mongo 如果要查询的数据是分为几层的话，应该用这总方式查询。用这种方式来写查询条件。 user.user_id

sql 中将联表出现的 null 替换成 0， 可以用这个方法。

```sql
if(tb2.shop_click is null, 0,tb2.shop_click)
```

用group by来去重要比 distinct 效率要高很多。

2014-12-09 15:08

对 sql 的学习更多了，可以写出更长的 sql 了。
可以再一个 set 中定义好几个变量，可以用逗号分开。

<http://www.hankcs.com/appos/yii-kong-zhi-dan-yuan-ge-di-kuan-du.html>
我希望能掌握一种记东西的比较好的工具，现在直接写html 比较费劲，可以考虑一下用markdown。
或者直接写 blog 也是可以的。但是我不太喜欢上网页编辑的这个步骤。

mysql 可以多表连接查询，也可以 left join 和 right join 。但是要注意表的规模。如果表的规模太大，那么联表的方式就不可取了。
所以说队数据的管理还是很重要的。要保证表不会太大。如果有其中一个表太大了，那么联表的结果都是非常可怕的。
如果表中的数据太多的话，那么就要想办法处理这些数据，不要让数据太大。

php url
$url = 'testurl';
$html = file_get_contents($url);
$content = json_decode($html);
http_build_query();

perl 形式的正则。
preg_match($mode,  $str, $matches);
preg_replace();

python mongo 学习了不少。
可以用 eval 求值来解决 库和表的选择问题。
但是里面的成员变量要写成 public 的。
python 的public 和 private 是不一样的，要认真思考一下他们的区别。

2014-12-16 12:31
写伪代码还是很清楚的，有时间可以多写一点，我真是本末倒置。
redis 的connectionPool() 是什么意思，这个是怎么使用的。
有什么好处。

2015-01-04 14:08

Yii 获得model执行过程序中的错误。

```php
$model->save()
print_r($model->getErrors());
$model->getErrors(); 可以看出上一个错误是什么。
```

刚才遇到的问题是
CGridView 的问题。想要实现 columns 里面的 指定列的自定义，就是不同类型给不同的颜色。但是也找了
好久。 想的是给一个 html 元素。但是刚开始是不会显示的，除非你加上这个选项。 'type'=>'raw';
这个方法并没有解决问题，但是也是有价值的。

```php

'htmlOptions'=>array('style'=>'Convert::shop_change_status_color($data->status)')
array(
	'name'=>'status',
	'value'=>'Convert::shop_change_status($data->status)',
	'htmlOptions'=>array('style'=>'Convert::shop_change_status_color($data->status)')
	//'value'=>'Convert::shop_change_status($data->status)'
),
```

这个可以解决问题。

radio, checkbox , button, 他们都有对应的时间，可以在里面添加对应的 函数。可以带参数的。
checkbox 也可以写成数组。
name='chk[]'  $_REQUEST ['chk'] 取值的方式是这样的。

mysql

update , select , 都可以联表操作。 当然，联表的时候都需要指定表的别名。
可以 从一张表选择内容，然后将选择的结果插入指定的表中。
insert into youtable select * from table1 where condition; 当然，表的结构应该要一样才可以。
要防止 sql 注入，所以写 sql 的时候要注意，尽量按照规范的写法,实现功能的时候，就要考虑,进行防范。

2015-01-13 17:01

```
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
```

2015-01-16 17:51
MYsql
a 表 字段 c1 和 b 表 c2 , 都有一个字段，这两个字段的类型不同的时候，是没有办法相等的。
按照MYsql 的相等判断是不相等的。所以要谨慎，
可以用 left join 和 right join 来校验这个错误。

checked这个属性不是我理解的那样，好像只要有checked 这个属性就可以起作用了。我应该做一个精确的测试才行。
而不是这样猜测。我的推送的代码还需要我进行测试，而不是像现在这样子。我应该为我的项目代码编写测试用例，
而不是等待QA测试。
我们的开发应该有一个统一的网站，而不是像现在这样子，以QQ为主的信息传递。

我有点担心我的 推送程序发起的 redis 连接 和 mongo 的连接太多了。程序本省的性能，有没有内存泄露，能不能正常工作。
要想办法测试自己的程序。而不是全部依赖QA。

其实有好多做法都是没有必要的。比如里面的那个phpserialize 我觉着是没有必要的，完全可以通过jsondumps 来搞定。
应该多用PHP的方法来搞定。

刚才谢了几个 单元测试，找出了两个错误，这些问题只能通过单元测试来解决，没有单元测是的话，在整个流程中
来找出这些问题太费劲了。所以这些地方一定要写单元测试。
这个在整个项目中是很有必要的。

这里是有问题的。

至少这两个方法是有问题的。

2015-01-20 10:14

程序上线的时候，应该把和配置相关的文件删除掉，这样上线后不用重新配置。

php 回掉函数的使用。
这是最基本的回掉方法。
call_user_func_array('your function',array());
array() is your params.

2015-01-28 17:38
mysql 的联表查询的原理我还不是很清楚，只是知道了联表查询并不一定就等于O(n*m) 的复杂度。
和联表的条件是密切相关的。所以，需要多理解，多实践下。

ngix还是没有了解，应该也了解一下。
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

有关sphinx的知识，我之前了解过一点，但是我并没有完全搞明白，应该找时间研究一下，这些东西都会有用的。
这段时间我可能会闲一点，但是我不应该让这样的安排阻止我进步的

我可以将一些重要的html内容保存下来，这样可以离线阅读，对于没有网的我来说，这是很好的一个方法。
但是，目前我只能做到离线当前的页面，但是我想实现的功能是多层抓取，比如设计层级是3，那么将这个页面
里所有的链接也抓下来，然后对链接下来的html进行同样的分析，这样总共三层，我需要这样的抓取效果。
刚才搜索了一下，没有找到合适的方法，应该是需要自己动手的功能。


刚才在学习配置nginx 的时候遇到问题了，我是按照上面的文档来配置的，但是出问题了。我应该去error.log
里面找问题，这一天提示很是重要，应该注意提高下自己这方面的能力。

不错，今天收获不小。对nginx 和 fastcgi 有了不少的了解。遇到了一些问题，明天有时间继续搞，最近
应该闲一段时间，要抓紧时间学习新知识。我要把这块搞得深入一点。加油。

2015-02-02 21:31
为什么我还是更喜欢Linux。
现在商家聊天的时候，用户通过意见商品联系商家的时候，推送过来的小时是一个接json串，这是有问题的。
明天反应一下这个问题，应该是遗留问题，但是需要解决，明天需要加上后台的定时任务。

crontab 的一些常识。
crontab l 列出当前的任务。分 时 日 月 星期  执行命令,* 表示任意的变量;
```shell
00 23 * * * run-your script  每天23:00 执行你的脚本。其实我需要做的就是一行命令。
10 1 * * 6,0 /usr/local/etc/rc.d/lighttpd restart  这个任务表示每周6和周日的1:10重启服务器。注意逗号，表示多个的意思。再看下面一个。
* */1 * * * /usr/local/etc/rc.d/lighttpd restart  注意这个符号/ 表示每个一个小时重启一下服务器。
```

在linux 下，你当前用户的crontab文件存放在 /var/spool/cron/ 目录下，这个文件以你的用户身份 命名。
比如 root， fox 之类的。

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

you can find more with this command.

```bash
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
```

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

```javascript
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
```

pecl is
PECL is a repository for PHP Extensions, providing a directory of all known extensions
and hosting facilities for downloading and development of PHP extensions.
PECL is very important.
ord 函数是做什么的。应该研究一下。

PHP mongo sort 规则。这个还是空白，应该抓紧补上，我才意识到，现在的问题原来是没有积累导致的。
应该吧自己写过的程序记录下来，并且经常回顾，这样才不会白费，这和以前是完全一样的。

我的日志也不应该断的，我应该每天都记录一下。

Yii cgridview 控件的样式也是很重要的，这个控件有一个参数可以调整，htmlOptions 可以设置标签。
datetime picker 这个控件的格式样式的设置，设置成默认的样式，和标准的时间格式一样。
```
$(document).ready(function(e){
$('#mmm_event_start').datetimepicker({format: 'Y-m-d h:m'});
$('#mmm_event_end').datetimepicker({format: 'Y-m-d h:m'});
});
```

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

shell 中的 echo 也是可以进行内容替换的。这个很常用，应该记住。
sed 和 awk 常用的功能也不能忘记。需要好好学习下。

shell 中字符串相等的比较。如果一个内容是空的话，那么这个变量会没有，这样，你的表达式可能纠错掉了。
报如下错误.具体的错误类型还需要仔细再研究一下。我要先吧自己的脚本搞出来。

``` shell
a=$(($i + 1))
```
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

http://blog.sina.com.cn/s/blog_49c6c9b701014p9a.html
php 报错的log，在听云商看到的错误。其实就是变量没有定义。

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
```
is null  和 is not null 的用法。
mysql null 是不能参与比较的，要注意这种情况。


php preg_replace example. learn this example.

```php
<?php
$name = "hello\\\\\\\\\\\\\\\\\\\\\\\\'sas";
var_dump($name);
$new_name = preg_replace("/\\\*/","",$name);
var_dump($name);
var_dump($new_name);
?>

```
### PHP urlencode, urldecode, rawurlencode, rawurldecode
- .2015-12-12 15:59

他们之间的差别还是比较小的,差别就是对+号的处理,我建议使用 rawurldecode, 而不是
urldecode. 但这个改动不可以贸然,可能一起bug.
在最初的时候设计的时候,就要考虑这一点.


### 2016-01-01 00:01

php 正则表达式.
preg_match 有几个关键词需要注意,一个是
界定符 # / 这个可以自己设置的.
preg_match 如果判断整个字符串的话,就要断言. 用 ^$. 
可以带 result 参数，将匹配的内容都放在这个result数组中。这个数组的参数应该是应用类型的。
说到引用类型，我对这个还不是太清楚，没怎么使用过，应该熟悉一下。
类似的函数还有 preg_match_all() , 返回值表示是否匹配.

curl 带json参数,需要加上-d 参数.没有这个参数是无法访问的.
curl -d {goods_id:123123} "http://sss.ss.xx"


### 2016-01-01 18:23

下面这个函数里面包含两种用法，一种是array_walk(), 还有一种是 变量的引用。这个和c语言是很相似的。
```php
$test = [1,2,3,5];
array_walk($test , function(&$i) { $i++; });
var_dump($test);
```
##### PHP 的几个比较重要的方法:

```
__construct()   构造方法,生命类对象的时候就会调用.
__desctruct()   析构方法,在类对象的生命周期结束之后. 这个和垃圾回收有什么关系吗.
__call()        must be public method.
__callStatic()  for static class method.
get_called_class()  一般是在基类中用到.基础类库中用这个方法.
get_class().  得到当前类的名称.
__autoload().

static::class   和上面的得到同样的结果.
PHP_EOL. 提高代码的可移植性. 换行符. mac windows, linux 下是不一样的.
user_call_func()    这个方法是写自定义函数,利用这个方法,调用的函数会变成一个变量,所以非常灵活.
user_call_func_array()  和上面的额方法类似,区别在于这里的方法的参数是数组.

这些东西被统称为魔术常亮.
__METHOD__    return the name of the function alongwith the class name.
__FUNCTION__  just return the name of the function.
__CLASS__
__FILE__      return filename of current file.
__LINE__      return current line number.
__DIR__       equal dirname(__FILE__).
```

PHP 中spl 开头的一些方法是做什么的,比如spl_autoload_register.
类似的方法还有不少,都是用来做什么的额.刚才调查了一下,确实有好多东西,这些都是PHP的高级语法,应该认真研究下,用好了,可以写出高效的代码.
对这门语言,我的了解还是不够,还需要认真研究.PHP SPL ==> standard PHP library.


### 2016-03-16 19:53
PHP 参数值引用。在一个函数里面改变数组参数的内容。改变数组的长度。
array_splice()

XHProf是一个分层PHP性能分析工具。它报告函数级别的请求次数和各种指标，包括阻塞时间，CPU时间和内存使用情况。一个函数的开销，可细分成调用者和被调用者的开销，XHProf数据收集阶段，它记录调用次数的追踪和包容性的指标弧在动态callgraph的一个程序。它独有的数据计算的报告/后处理阶段。在数据收集时，XHProfd通过检测循环来处理递归的函数调用，并通过给递归调用中每个深度的调用一个有用的命名来避开死循环。XHProf分析报告有助于理解被执行的代码的结构，它有一个简单的HTML的用户界面（ PHP写成的）。基于浏览器的性能分析用户界面能更容易查看，或是与同行们分享成果。也能绘制调用关系图。



PHP.ini 

```
[PHP]
engine = On
short_open_tag = Off
asp_tags = Off
precision = 14
y2k_compliance = On
output_buffering = 4096
zlib.output_compression = Off
implicit_flush = Off
unserialize_callback_func =
serialize_precision = 17
allow_call_time_pass_reference = Off
safe_mode = Off
safe_mode_gid = Off
safe_mode_include_dir =
safe_mode_exec_dir =
safe_mode_allowed_env_vars = PHP_
safe_mode_protected_env_vars = LD_LIBRARY_PATH
disable_functions =
disable_classes =
zend.enable_gc = On
expose_php = Off
max_execution_time = 10
max_input_time = 60
memory_limit = 512M
error_reporting = E_ALL & ~E_NOTICE | E_STRICT
display_errors = Off
display_startup_errors = On
log_errors = On
log_errors_max_len = 1024
ignore_repeated_errors = Off
ignore_repeated_source = Off
report_memleaks = On
track_errors = On
html_errors = On
error_log = "/home/work/webdata/logs/php.log"
variables_order = "GPCS"
request_order = "GP"
register_globals = Off
register_long_arrays = Off
register_argc_argv = Off
auto_globals_jit = On
post_max_size = 8M
magic_quotes_gpc = Off
magic_quotes_runtime = Off
magic_quotes_sybase = Off
auto_prepend_file =
auto_append_file =
default_mimetype = "text/html"
doc_root =
user_dir =
enable_dl = Off
file_uploads = On
upload_max_filesize = 6M
max_file_uploads = 20
allow_url_fopen = On
allow_url_include = Off
default_socket_timeout = 60
include_path = ".:/home/service/php/lib/php"
rlimit_core = unlimited
[DATE]
date.timezone = "Asia/Shanghai"
date.default_latitude = 31.5167
date.default_longitude = 121.4500
[Pdo_mysql]
pdo_mysql.cache_size = 2000
pdo_mysql.default_socket=
[Syslog]
define_syslog_variables  = Off
[mail function]
SMTP = localhost
smtp_port = 25
mail.add_x_header = On
[SQL]
sql.safe_mode = Off
[MySQL]
mysql.allow_local_infile = On
mysql.allow_persistent = On
mysql.cache_size = 2000
mysql.max_persistent = -1
mysql.max_links = -1
mysql.default_port =
mysql.default_socket =
mysql.default_host =
mysql.default_user =
mysql.default_password =
mysql.connect_timeout = 60
mysql.trace_mode = Off
[mysqlnd]
mysqlnd.collect_statistics = On
mysqlnd.collect_memory_statistics = Off
mysqlnd.net_cmd_buffer_size = 2048
mysqlnd.net_read_buffer_size = 32768
[bcmath]
bcmath.scale = 0
[Session]
;session.save_handler = memcached
;;session.save_path = "memproxy.meilishuo.com:1221"
session.save_handler = files
session.save_path = /tmp
session.use_cookies = 1
session.use_only_cookies = 1
session.name = PHPSESSID
session.auto_start = 0
session.cookie_lifetime = 0
session.cookie_path = /
session.cookie_domain =
session.cookie_httponly =
session.serialize_handler = php
session.gc_probability = 1
session.gc_divisor = 1000
session.gc_maxlifetime = 1440
session.bug_compat_42 = Off
session.bug_compat_warn = Off
session.referer_check =
session.entropy_length = 0
session.cache_limiter = nocache
session.cache_expire = 180
session.use_trans_sid = 0
session.hash_function = 0
session.hash_bits_per_character = 5
url_rewriter.tags = "a=href,area=href,frame=src,input=src,form=fakeentry"
;scws.default.charset = utf8
;scws.default.fpath = /home/service/scws/etc
extension=raphf.so
extension=propro.so
extension=redis.so
extension=imagick.so
extension=mongo.so
extension=xhprof.so
[memcache]
memcache.allow_failover = 0
;Memcache.hash_strategy =consistent
;;Memcache.hash_function =crc32
;[Tidy]
;tidy.clean_output = Off
[soap]
soap.wsdl_cache_enabled=1
soap.wsdl_cache_dir="/tmp"
soap.wsdl_cache_ttl=86400
soap.wsdl_cache_limit = 5
[ldap]
ldap.max_links = -1
[xsl]
xsl.security_prefs = 44
;; Local Variables:
;; tab-width: 4
;; End:
;;
extension=yaf.so
extension=seaslog.so
[yaf]
;yaf.environ = stage
yaf.use_spl_autoload = On
[seaslog]
seaslog.default_basepath = /opt/logs/higo      ;默认log根目录
seaslog.default_logger = higo                   ;默认logger目录
seaslog.disting_type = 1                        ;是否以type分文件 1是 0否(默认)
seaslog.disting_by_hour = 0                     ;是否每小时划分一个文件 1是 0否(默认)
seaslog.use_buffer = 1                          ;是否启用buffer 1是 0否(默认)
seaslog.buffer_size = 1024                      ;buffer中缓冲数量 默认0(不使用buffer_size)
seaslog.level = 0                               ;记录日志级别 默认0(所有日志)
[opcache]
zend_extension=opcache.so
opcache.memory_consumption=512
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
opcache.enable_cli=1

```


安装composer
http://pkg.phpcomposer.com/


```php
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
```

PHP echo 和 print的区别。
主要掌握echo的下面这两个特性。print更多的是一个函数。

```php
echo "hello", "world";
echo <<<EOT
test
EOT;
```



