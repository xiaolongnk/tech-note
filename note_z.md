2015-04-13 11:43

1.  review 自己的代码, 包括 API 和后台，仅限自己的。
2.  认真研究 YII 中的一些功能，研究一下 mysql 和 mongo 和 redis 的功能,做一些研究性的工作。
3.  做一些常用的脚本。
4.  在删除的时候也可以使用 limit 字段，来限制删除的数量,对某些重复的数据，我们不希望它们重复，
但是当他们重复的时候，我们需要自己去矫正这些数据，这些数据如何矫正，这些数据是如何来的。
5.  开发一些常用的功能，并将他们积累，经常回顾。


Collation mysql 中的这个是干什么的，如果不设置的话，看到的是 NULL。


Yii 中设置默认的排序。代码如下
```PHP
return new CActiveDataProvider($this, array(
'criteria'=>$criteria,
'pagination'=>array('pageSize'=>20),
'sort'=>array('defaultOrder'=>'position asc')
));
```


