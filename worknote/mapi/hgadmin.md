### hgadmin 短信相关内容整理

这个redis队列中存在定时任务发送的短信， 
key  message_send_main

```
protected/commands/SendMessageCommand.php:                $messageData = $LeheRedis->lpop("message_send_main");
protected/controllers/HigoFairyController.php:            LeheRedis::lpush("message_send_main",json_encode($value));
protected/controllers/HigoFairyController.php:            LeheRedis::lpush("message_send_main",json_encode($value));
protected/controllers/HigoFairyController.php:            LeheRedis::lpush("message_send_main",json_encode($value));
protected/controllers/HigoFairyController.php:            LeheRedis::lpush("message_send_main",json_encode($sendmessage));
protected/controllers/HigoFairyController.php:            LeheRedis::lpush("message_send_main",json_encode($value));
```
消息内容是未知的，是用户输入的变量。


### life 加精后台。
hgadmin 里面。
接口访问来自 content_service ;
页面交互采取 ajax +  浮层。

需要content_service 提供的接口
```
mark 加精操作。根据参数来判断是加精还是取消加精。参数是life_id.专门记录log，存放在专门的log里面。核心操作记录log。 
log 格式  admin_name
页面支持操作， 支持精确匹配，按照shop_id和精确的shop_name .

```


### 商家后台保税区备货
```

```

运营后台 提报审核bug的修复.
前面提到的bug,调查如下:
运营后台提报审核页面,对商品sku信息展示不全,导致运营审核时候将已经不符合条件的商品审核通过了,导致在后续在秒杀会场组货时会发现好多没有正常sku的商品.
下午case的调查原因.
现在对审核功能进行了修复,审核操作会自动过滤已经不符合条件的商品,避免审核后续过程出错.
系统默认的审核条件是, 提报库存大于0 并且sku状态正常. 不符合此条件的商品,系统会自动审核不通过.
以上,如有问题,请反馈给我,我会尽快修复.

### 2016-03-03 11:29
运营后台,提报的限制,如果商家提报过一个提报活动,只有在这个提报活动结束之后才可以进行下一次提报.
如果删除这个商家的提报商品,商家也可以进行提报.
有一个问题,pc后台没有过滤已经删除的提报条目.运营后台删除后,还会出现在商家端,这个问题需要修复.



### 2016-03-11 22:02
运营后台优化。

PC后台增加新功能，上传图片。增加字段。
bizbll接口中传递这些字段。
pandora 创建接口增加限制。
hgadmin 做一些优化。商品导入。
提报活动增加条件限制。选择商品是否必需填加白底图，和广告语。

