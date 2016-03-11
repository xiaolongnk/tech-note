上线脚本的机器。 
10.20.3.111

push 的机器. 
10.20.1.31   python 环境

bdp 的down file机器
10.20.0.90

10.20.0.86  mysql pandora

sh work@10.8.6.17
cat conf/mysql/higo.mysql.ini

### 服务情况.

LVS:
10.20.0.78  higolb.meiliworks.com
10.20.252.6:80  对应 10.20.1.50  10.20.2.65
10.20.252.5:80  对应 10.20.3.28
10.20.252.4:80  对应 10.20.1.42  10.20.3.23
115.182.242.21:80对应 10.20.1.77  10.20.1.78

DB:
Pandora:
ssh work@10.20.0.82 ssh work@10.20.0.83 ssh work@10.20.0.84 ssh work@10.20.0.85 ssh work@10.20.0.86

商家后台
fe_biz（b.lehe.com）：10.20.1.50   10.20.2.65
bizbll（biz.api.lehe.com）10.20.1.54  10.20.1.55

运营后台：
fe_works（works.lehe.com）10.20.1.50 10.20.2.65
worksbll 10.20.3.28
hgadmin
10.20.1.27  10.20.1.28

五大金刚：
order.service
10.20.0.94 10.20.0.95
content.service goods.service category.service higo.service user.service shop.service
10.20.1.42 10.20.3.23

脚本机 10.20.3.41：
后台暂停营业的任务
*/5 * * * * /home/service/php/bin/php /home/work/works/host/script.php  ShopClose
*/5 * * * * /home/service/php/bin/php /home/work/works/host/script.php  ShopOpen
#0 1 * * * /home/service/php/bin/php /home/work/works/host/script.php  ShopCleanNotCert
队列
bash /home/work/servicelib/queues/switch.sh  --app works --action start 1>/dev/null 2>/dev/null
bash /home/work/servicelib/queues/switch.sh  --app works --action stop


TMS: 10.20.3.36 10.20.3.37

### 2016-02-16 15:36
mobile 1011111111
passwd 12345678

上海项目部署文档.
http://redmine.meilishuo.com/projects/higo-pc/wiki

ip r a 172.18.2.0/24 via 172.18.4.1

mysql client 10.20.3.36
hgadmin 10.20.1.27 10.20.1.28

2016-03-11 22:05
商家pc后台。
增加参数 可以看到数据。 当前的日期+3
?__cd__=/rb/14


