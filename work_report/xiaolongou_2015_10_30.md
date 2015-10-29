### 周报

#### 1. 本周计划

|任务  | 描述 |  开发 |
|--- | ----|---|
| 1 | 准备脚本检查秒杀活动中的商品的价格问题。|  欧小龙, done |
| 2 | 商品上新改造，商品服务化改造。| 欧小龙 ,朱雷  |
| 3 | 图片迁移，最后测试。| 欧小龙,永杰 |
| 4 | 线上配置迁到git管理。 | 永杰 |
| 5 | 4.6 版本需求. | 李瑞恒，冯尚旺, 欧小龙 |
| 6 | 活动模板 | 张振胜，张鑫 |

###2015-10-28 10:33

1. 运营后台board取消群信息冗余表。 done
2. 跑男签到项目排期。 done
3. 商家端发版接口。
4. goods_show 接口优化，加缓存。
5. 单品详情接口优化。
6. 流控接口。


###流控接口

| 接口 | 说明 | (参考上次压测)估计值 |
|--|--|--|
| goods/goods_show | 首页接口  |  800 |
| goods/goods_discover | 首页接口  | 800 |
| goods/get_detail| 单品页详情  | 3500 |
| search/searchGoodsByBrand | 单品页详情  | 100 |
| shop/BullsCircleDetailNew |  群全详情 | 200 |

2015-10-29 11:36


1. 优化接口。
   goods/goods_show
    优化点 
    1. home_banner 增加缓存。1min
    2. recommend_category 增加缓存  1min.
    fashion_most 增加缓存.  1 min.
    worlds_goods
    season_sales
    events_total 缓存
   goods/get_detail

   higo.api/search/searchGoodsByBrand?cver=4.5&ver=0.8&brand_id=
    1. 增加缓存,1min.

2. 运营后台图片优化。运营后台图片上传迁移主站。上线完成。

