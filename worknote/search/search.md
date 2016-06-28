###产品规划

创建静态商品集合和动态商品集合的概念，用来替换运营类目的概念。
运营类目，用静态商品集合的概念来替换运营类目的概念。
动态商品集合，用来实现定制动态商品集合的概念。例如new_in 和直播的需求。

可以支持的搜索条件：

价格筛选，商品名，商品描述，品牌，类目，热词，

设计表：

```sql
create table t_pandora_search_condition(
id bigint(20) not null default 0 comment '' primry key,
title varchar(32) not null default '' comment '名称',
conditions text not null default '' comment '条件的json序列'，
ctime timestamp not null default current_timestamp,
mtime timestamp not null default '0000-00-00 00:00:00' ,
status tinyint(4) not null default 1 comment '1:正常 -1 删除',
create_user varchar(32) not null default '' comment '创建人',
)engine = InnoDB , charset=utf8, comment '动态商品集';


```
功能： 增 删 改 查

works 商品搜索改造，
实现一个worksbll 中的搜索接口，从搜索系统获取基本数据，然后扩展需要的信息，在前台展示。

- 复制商品列表的功能，在合格基础上改造。
- 实现搜索接口。商品搜索体系的接口改如何规划，放在那里，如何使用。不同的使用场景需要的接口改如何区分和统一。
- 商品列表
- 提报系统的商品列表。

works后台的接口  worksbll -> search engine

根据商品集合id来获取商品的接口。 pandora -> searchengine

需要搜索支持对如下字段的搜索支持。

goods_id 
brand_id
goods_name
goods_desc   没法用
use_transport
goods_ctime 支持区间
goods_mtime 支持区间
goods_status  [1,2,3]
shop_goods_digest   
shop_id
n_category_id
brand_name
brand_id   
audit_status
hot_word
ungoodsid
price

搜索接口最好可以提供给如下字段。 , 如果不提供也没有关系，可以通过一个sql来搞定下面的这些需求。

shop_id
goods_id
goods_name 
goods_price
goods_desc
goods_repertory
goods_ctime
goods_sales
shipping_fee
use_transport
main_img_id
goods_image
goods_mtime 
n_category_id 
goods_status
characteristic
shop_goods_digest
brand_name
goods_art_no 
brand_id
audit_status

目前的搜索接口支持的搜索条件：

goodsId     商品ID      多个用‘,’隔开
unGoodsId   过滤商品ID  多个用‘,’隔开
goodsName   商品名称
shopId      店铺ID
shopName    (暂时不能用)
brandId     品牌ID
categoryId  品类ID
hotwords    热词
price       价格区间，用‘-’连接

用户侧的接口需要的字段是不是有点区别。

搜索接口的链接：

需要正式的域名，然后提供接口名。
http://wormhole.inf.lehe.com/bdqp/goods/hop/ocategory/list


改造worksbll接口，goodslist的基础数据从search过来。替换原来的sql搜索。
目前系统调用流程如下： 所以新的基础搜索接口会放在goodsservice.但是考虑到works后台和pandora
需要的接口数据可能不一样，要不要将他们分开。pandora严格讲是用户端的接口。goodslist实际上是
运营侧的接口，这两个在搜索那天可能属于不同的领域。


worksbll -> goodsservice -> basic_search
pandora  -> goodsservice -> user_search

具体的业务。

旧业务改造：

1. 提报系统的商品列表搜索。具体指 eventgoods/getGoodsList 接口。
2. 新商品列表。


新业务：

1. 静态商品集合 -> 替换之前的运营类目  (暂时不提供支持，还是利用就得运营类目，等后面有时间再进行优化。)
2. 动态商品集合 -> 支持newin 和 新直播的需求。

