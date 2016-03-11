### 周报

|任务  | 描述 |  开发 |
|--- | ----|---|
| 1 | 准备脚本检查秒杀活动中的商品的价格问题。|  欧小龙 |
| 2 | 商品上新改造，商品服务化改造。| 欧小龙 ,朱雷  |
| 3 |  图片迁移，最后测试。| 欧小龙,永杰 |
| 4 | 线上配置迁到git管理。 | 永杰 |
| 5 | 4.6 版本需求. | 李瑞恒，冯尚旺,欧小龙 |


### 流控接口


| 接口 | 说明 | (参考上次压测)估计值 |
|---|---|---|
| goods/goods_show | 首页接口  |  800 |
| goods/goods_discover | 首页接口  | 800 |
| goods/get_detail| 单品页详情  | 3500 |
| search/searchGoodsByBrand | 单品页详情  | 100 |
| shop/BullsCircleDetailNew |  群全详情 | 200 |


### 重要流量接口优化

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
