### 2016-02-14 15:08  系统优化点

1. 首页瀑布刘过滤商品数较少的board.

> 1. 推荐系统增加board推荐条件.
> 2. 首页接口数据返回时做过滤. 过滤成本较低. 第三项可以暂时不考虑.
> 3. board商品删除时主动删除首页board.

2. 秒杀页面优化.

> 1. 秒杀页面优化,响应速度太慢.10s+.
> 2. 秒杀会场商品添加时过滤无效商品.避免运营出错.
>

### hgadmin 预发布环境.
临时使用.
hgadmin.test.lehe.com  10.8.6.59
v.online.killtime.cn   10.8.6.28


用新的环境重新部一套服务.
10.20.3.30

数据查询
db.bizfe.meilishuo.com

### 服务情况.

LVS:
10.20.0.78  higolb.meiliworks.com
10.20.252.6:80  对应 10.20.1.50  10.20.2.65
10.20.252.5:80  对应 10.20.3.28
10.20.252.4:80  对应 10.20.1.42  10.20.3.23
115.182.242.21:80对应 10.20.1.77  10.20.1.78

DB:
ssh work@10.8.6.17
cat conf/mysql/higo.mysql.ini

Pandora:
ssh work@10.20.0.82
ssh work@10.20.0.83
ssh work@10.20.0.84
ssh work@10.20.0.85
ssh work@10.20.0.86


商家后台
新
fe_biz（b.lehe.com）：
10.20.1.50
10.20.2.65
bizbll（biz.api.lehe.com）
10.20.1.54
10.20.1.55
老


运营后台：
新
fe_works（works.lehe.com）
10.20.1.50
10.20.2.65
worksbll
10.20.3.28
老
10.20.1.77（nginx） => 10.20.1.27（hgadmin）
10.20.1.78（nginx） => 10.20.1.27（hgadmin）

五大金刚：
order.service
10.20.0.94
10.20.0.95
content.service
goods.service
category.service
higo.service
user.service
shop.service
10.20.1.42
10.20.3.23

脚本机 10.20.3.41：
后台暂停营业的任务
*/5 * * * * /home/service/php/bin/php /home/work/works/host/script.php  ShopClose
*/5 * * * * /home/service/php/bin/php /home/work/works/host/script.php  ShopOpen
#0 1 * * * /home/service/php/bin/php /home/work/works/host/script.php  ShopCleanNotCert
队列
bash /home/work/servicelib/queues/switch.sh  --app works --action start 1>/dev/null 2>/dev/null
bash /home/work/servicelib/queues/switch.sh  --app works --action stop


TMS:
10.20.3.36
10.20.3.37


BI：
10.20.1.40 商家后台的hornbill调用的（b2c）
旧的IP调用 grep -rP "\d+\.\d+\." /home/work/higo_b2c_api/config/bj


### 2016-02-16 15:36

164200812702070917  1011111111  25d55ad283aa400af464c76d713c07ad    01096961015 164200812715084903  2 
mobile 1011111111
passwd 12345678

上海项目部署文档.
http://redmine.meilishuo.com/projects/higo-pc/wiki

ip r a 172.18.2.0/24 via 172.18.4.1

eu3G8cm9er
