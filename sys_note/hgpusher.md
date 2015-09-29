#HIGO 消息推送

简介 系统通过 python 构建，python2.7 , 用到的python 扩展 包括 redis , pymongo, MySQLdb, mlogging , xinge sdk 运行系统为 cenos 6.5. 推送包括内容包括 系统消息推送，群聊推送，私聊推送。

##1. 系统push
	
推送类型如下

类型 | 说明
----|----------------------------
PUSH\_TYPE\_CHAT = 1  |  1v1 聊天 XMPP
PUSH\_TYPE\_NEW\_ORDER = 5  |  新订单
PUSH\_TYPE\_GOODS\_SOLDOUT = 6  | 售罄
PUSH\_TYPE\_GOODS\_SENT = 7  | 商品已发货
PUSH\_TYPE\_BUYER\_PAID = 8  | 买家付款   
PUSH\_TYPE\_BUYER\_CONFIRM = 9  | 买家确认收货
PUSH\_TYPE\_SYS\_CONFIRM = 10  | 还有2天系统就要确认收货了，告知用户
PUSH\_TYPE\_SHOP\_SENDGOODS = 11 | 买家付款24小时内，没有发货，提醒商家给买家发货
PUSH\_TYPE\_SHOP\_OK = 15   |  店铺 审核通过
PUSH\_TYPE\_SHOP\_REJ = 16  |  店铺 审核未通过
PUSH\_TYPE\_GOODS\_OFFSALE = 17  | 被后台下架
PUSH\_TYPE\_BUYER\_PERMIT = 18  |  买手认证通过
PUSH\_TYPE\_BUYER\_DENY = 19    |  买手认证拒绝
PUSH\_TYPE\_GOODS\_DETAIL = 20   | 单品分享的类型
PUSH\_TYPE\_REPORTED = 30  | 用户被举报推送
PUSH\_TYPE\_DEFAULT = 55  | 默认类型的推送，不执行任何客户端操作

推送模式为 `消息体 => redis_queue =>  xinge_distribute  => xinge_sending  => xinge`

系统的主要文件如下：

启动脚本 | 说明
-------------|-------------
hgDistributeStart | 启动 HGDistribion 中的run方法,
hgDistribution.py | 系统消息 主循环
distribute.py | 系统消息的预处理 逻辑模块 从 `hg_message_queue` 中拿数据，进行预处理，处理完成之后，放入 `hg_xinge_queue`
hgXingeStart | 启动 XingeSending 中的run方法，
hgXingeSending | 从`hg_xinge_queue `中那数据，调用 HgXinge 进行处理，推送至xinge平台。 
hgXinge | 将消息提发送给 xinge ，推送处理 结束

##2. 群聊push
每隔10s从mongo 的 chats 表读取最新的聊天消息，对每一条消息，推送给不在线的群主。整个主流程如下：

```python
def doWork(self):
    newchats = self.getNewChats()
    for i in newchats:
    	if self.message_ok(i)
    		self.semd_message_to_group_owner(i)
```

如果有上次取消息的时间，返回上次取消息的时间，如果没有，返回库里消息的最大时间戳。

```python
def getTime(self):
    ret = self.redis_conn.get(self.redis_key_time_stamp);
    cur_max_time = self.get_max_time()
    self.redis_conn.set(self.redis_key_time_stamp,cur_max_time)
    if ret :
        return ret
    else :
        return cur_max_time
```

系统启动时，会拿到 chats 表中最大的时间戳，记录在redis中，作为初始时间。从 mongo 中根据时间戳那时间，时间戳是上次拿数据时记录的时间。

```python
def getNewChats(self):
    mongo_table = 'chats'
    condition = {}
    condition['createAt'] = {}
    #获取上次的时间戳
    cur_push_time = self.getTime()
    condition['createAt']['$gt'] = str(cur_push_time)
    #设定时间
    retcond = {'_id':1,'seq':1,'group_id':1,'createAt':1,'type.':1,'data':1,'user.user_id':1}
    self.mongo_conn.setTable(mongo_table)
    ret = self.mongo_conn.query_all(condition,retcond)
    ans = []
    for i in ret:
        ans.append(i)
    return ans
```

判断条件的方法如下, 如果用户退出登录，用户在线，用户的消息接受模式为 消息免打扰。就不发送推送。

```python
def accept_push(self, to_id):
    login_status = self.user.get_login_status(to_id)
    if login_status is None or int(login_status) != 1:
        return False
    # 如果在线，不推送消息
    online_status = self.user.getOnlineStatus(to_id)
    if online_status:
        return False
    account_info = self.user.get_account_info(to_id)
    if account_info == None:
        return False
    push_status = account_info['push_status']
    if push_status == None or int(push_status) != 1:
        return False

    return True

```
系统设置了 queue_max 个队列来进行消息的处理。

拿到需要推送的消息之后，每个消息的处理流程如下。

为了避免队列的读取资源竞争，程序中设置了 `queue_max` 个队列来接受消息，将扫描到的消息遍历分布在 `queue_max` 个队列中，
在消息处理端，分别处理 `redis_key_global + key+_num` 队列中的消息，每个处理进程负责一个队列。 `higo_group_chat_message`
例如 一次遇到5 条消息，那么他们分布在 `higo_group_chat_message1 ... higo_group_chat_message5`中,每个队列中有一条消息。
处理过程如下：

```python
def send_group_chat_message(self, user_id, group_id, message, group_name):
    mess_body = self.get_message_body(user_id, group_id, message, group_name)    
    redis_key = self.redis_key_global + str(self.key_num);
    ret = self.redis_conn.rpush(redis_key, phpserialize.dumps(mess_body))
    if self.key_num == queue_max:
        self.key_num = 1
    else:
        self.key_num += 1 
    return ret
```

`GroupHGDistribution`  从 `higo_group_chat_message$num{ $num >=1 && $num <= queue_max}`中pop出一条消息, 对这个消息进行处理，包括找到消息接收人的 `xinge_token` 封装出对应的消息体，最后将这个消息放到另一个队列`higo_group_xinge_queue`
    调用`group_distribute.GroupDistribute`

`GroupXingeSending` 从 `higo_group_xinge_queue$num{$num >=1 && $num <= queue_max}`中pop出一条消息, 调用 `HgXinge` 将完整的消息根据 via (android, iphone), app（higo, higirl）调用对应的配置，推送给信鸽. 
    其中 `GroupHGDistribution` 和 `GroupXingeSending` 有相同个数的实例，每个work进程处理一个消息队列中的消息。

```python
def run(self):
    cache = lehe_redis(self.app, self.g_params)
    redis_key = self.g_params[self.conf]['hg_group_xg']+str(self.key_num)
    while True:
        message = cache.lpop(redis_key)
        if message == False or message == None:
            time.sleep(5)
            continue
        message = phpserialize.loads(message)
        ret = self.m_xinge.hg_send_message(message)
```

主要文件 | 说明
--------|--------------
groupChatStart.py | 启动 扫描消息进程
group_pusher.py | 启动`group_pusher`中的run方法，从 chats 中拿到需要推送的新消息，放入 `higo_group_chat_message` 中
group_hgDistributeStart.py | 启动 GroupHGDistributionstribution 的 run 方法，处理 `higo_group_chat_message` 
group_hgDistribe.py | 处理群聊消息 的住循环模块 
group_distribute.py | 消息预处理逻辑模块，从`higo_group_chat_message`队列中拿到消息，按照预处理逻辑进行处理，并将处理后的消息发送到`higo_group_xinge_queue`中
group_hgXingeStart.py  | 启动 `GroupXingeSending`的run 方法， 处理`higo_group_xinge_queue` 中的消息。
group_xingeSending | 发送群聊消息的住循环
hgXinge | 将消息发送给信鸽，推送结束

##3. 私聊push  
私聊推送和群聊推送基本原理基本相同。改变了基本的配置。

主要文件  | 说明
--------|------------
privateChatStart.py | 启动 扫描消息进程
private_pusher.py | 从私聊表中获取需要推送的消息，push 到 私聊队列 `higo_private_chat_message`
private_hgDistributeStart.py | 私聊消息预处理模块的启动脚本
private_hgDistribute.py | 私聊消息预处理模块的主循环模块
private_distribute.py | 从`higo_private_chat_message`中拿到消息，按照预处理逻辑进行处理，并将处理后的消息发送到 `higo_private_xinge_queue`中
private_hgXingeStart | 启动进程 从`higo_private_xinge_queue`中拿到消息，推送至 xinge 平台
private_hgXingeSending | 私聊消息发送主循环
hgXinge | 将消息发送给信鸽，推送结束

#4 相关配置

重要的配置是下面几项，上线前请确认下面的配置和客户端是一致的。

```
;应用配置参数
android_higo_appid = 2100047733
android_higo_skey =   ee059d135ccb97688d67c725c71adb2a

;android 商家端 push key
android_higirl_appid = 2100064514
android_higirl_skey = 2a8e2cbca09591f3e64909d97ac588ad

;;线上环境
ios_higo_appid = 2200047738
ios_higo_skey = 1e646be1b36b11a88ab0400fd8bda77b
;;
ios_higirl_appid = 2200047734
ios_higirl_skey = 94a2cee5ddc68832f972846717123568

;;内网测试用例 
local_ios_higirl_appid = 2200052868 
local_ios_higirl_skey = 331d11bf4732c4edf34c5bb524b1105f 
;;
local_ios_higo_appid = 2200052867
local_ios_higo_skey = f7706ac90eb5e9dbbd3c7f5447e4011c

```

#5 系统启动脚本

```shell
#!/bin/bash
param=restart
if [ $# = 1 ]; then
	param=$1
fi
if [ $param = 'start' ]; then
	/usr/bin/python2.7 hgDistributeStart.py 2>>logs/err.log &
	/usr/bin/python2.7 hgXingeStart.py 2>>logs/err.log &
	/usr/bin/python2.7 group_hgDistributeStart.py 2>logs/err.log &
	/usr/bin/python2.7 group_hgXingeStart.py 2>>logs/err.log &
	/usr/bin/python2.7 groupChatStart.py 2>>logs/err.log &
	/usr/bin/python2.7 private_hgDistributeStart.py 2>logs/err.log &
	/usr/bin/python2.7 private_hgXingeStart.py 2>>logs/err.log &
	/usr/bin/python2.7 privateChatStart.py 2>>logs/err.log &
	echo "start success"
	exit
elif [ $param = 'stop' ]; then
	for i in `ps aux | grep py | grep -v grep | awk {'print $2'}`;
	do
		kill $i;
	done 
	echo "stop success"
	sleep 1
	exit
elif [ $param = 'restart' ]; then
	for i in `ps aux | grep py | grep -v grep | awk {'print $2'}`;
	do
		kill $i;
	done 
	echo "stop success"
	sleep 1
	/usr/bin/python2.7 hgDistributeStart.py  2>>logs/err.log  &
	/usr/bin/python2.7 hgXingeStart.py 2>>logs/err.log &
	/usr/bin/python2.7 group_hgDistributeStart.py  2>>logs/err.log &
	/usr/bin/python2.7 group_hgXingeStart.py 2>>logs/err.log &
	/usr/bin/python2.7 groupChatStart.py 2>>logs/err.log &
	/usr/bin/python2.7 private_hgDistributeStart.py 2>logs/err.log &
	/usr/bin/python2.7 private_hgXingeStart.py 2>>logs/err.log &
	/usr/bin/python2.7 privateChatStart.py 2>>logs/err.log &
	echo "start success"
	exit
else
	echo "use xxx.sh {start|stop|restart}"
fi
```

#6 优化空间

1. 群聊推送，考虑到发送给所有成员，消息太多，延迟太长，目前只发送给群主。后期可以研究下超时原因，分析出瓶颈，进行全员push。
2. 每天定时重启 系统。08:00 start， 23：00 stop.
