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

Yii 里面有重复保存的现象。
我做了一个功能，我选择了修改某个项目，然后保存，之后会创建一个新的，不知道这个是什么意思。这个问题我之前遇到过，是因为两个
action 调用了同一个form的action，应该更具当前情况更改form，这样才行。

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

````
