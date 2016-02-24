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


