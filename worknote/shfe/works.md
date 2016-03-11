### 后端系统部署情况.

works.lehe.com
<http://wiki.inf.meiliworks.com/pages/viewpage.action?pageId=1704324>

#### 商家后台 
> 
> 新商家后台的域名.   b.lehe.com   182111975930430   123456
> 前段代码,前端框架 fe  前段机ip  fe_kernel , fe_biz , fe_tools 
> 10.20.1.50
> 10.20.2.65
> 
> 后端代码 fe  api .     bizbll , phplib , servicelib , userservice , globalconfig
> 10.20.1.54
> 10.20.1.55
> 

#### 新运营后台:

>
>  前段代码:
>  fe_works , fe_kernel , fe_tools, 
>
>  后端代码:
>  worksbll , phplib , servicelib , globalconfig
>
> 

#### 旧运营后台

>
> work@10.20.1.27
> work@10.20.1.28
>


#### hgpusher im推送服务.

>
> work@10.20.1.31
>


### 问题:

>
> globalconfig. 所有上海的后端接口都依赖这个配置.
>
>

### 
pandora cron 服务器
10.20.0.82

hgadmin crontab 服务器.

### mysql

ssh root@10.20.3.111

mysql -h 10.20.252.1 -P2521 -uxxx -pxxx higo_account
mysql -h 10.20.252.1 -P 2524 -uxxx -pxxx higo_goods


### 
191123875420531032  这个商品有121 个sku,导致一些页面很慢.对于一个页面，相应速度很重要．　可以考虑延迟加载的技术．
可以学习一下这方面的技术．
分页只是一部分工




