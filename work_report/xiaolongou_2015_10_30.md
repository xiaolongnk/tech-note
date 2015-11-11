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
3. 商家端发版接口。  (转交朱雷)
4. goods_show 接口优化，加缓存。 done
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

###重要流量接口优化
1. goods/goods_show对内部组件进行缓存优化，在高流量的情况下，可以有效缓解服务压力。
    -  home_banner 增加缓存。1min
    -  recommend_category 增加缓存  1min.
	    fashion_most 增加缓存.  1 min.
    	worlds_goods
    	season_sales
    	worlds_brand
        events_total 缓存
        board 信息缓存 1h
2. search/searchByBrand
	增加缓存，搜索结果缓存1分钟
3. shop/BullsCircleDetailNew
	增加缓存，缓存时间。
4. goods/get_detail 优化


###图片

![Alt](http://d02.res.meilishuo.net/pic/_o/34/a4/22ac6ec43eb5c0b01574cd92d471_750_550.cg.jpg)









