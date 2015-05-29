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

```
