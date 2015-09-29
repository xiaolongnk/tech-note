#hgpusher#

1. 运行环境， python2.7, 必须的扩展， redis , mysql 扩展。
2. 设置环境变量 export push_env=prod
3. 启动方式， ./hgStart

push 有2个版本，一个是master， 已迁至北京。部署服务器为
10.8.6.40 目录为 /home/work/hgpusher/
配置信息。

[higo]
db_host = 10.8.3.11
db_port = 3306
db_user = meiliwork
db_pass = Tqs2nHFn4pvgw
db_database = higo

redis_host_global = 10.8.6.248
redis_port_global = 6379

redis_host_hotdata = 10.8.6.248
redis_port_hotdata = 6379

mongo_host_global = 10.8.6.31
mongo_port_global = 27017
mongo_db = meteor

push的 new_push 分支，是为4.0以后的 新的IM 准备的。目前还未启动，但已经处于ready的状态。可以随时启用。
new_push 部分的代码，接入了新的IM系统，重构了系统代码，代码量减少了3分之一，并且可靠性也有所提升。

如果有相关配置的改动，需要修改改配置文件，并重启服务。
