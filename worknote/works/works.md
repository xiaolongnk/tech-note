###接口设计
1. 需要重启服务。 框架是纯html的。借用了angular的一些东西。
    
2. 

系统设计 

promoservice
promo/judge

需要的接口如下

接口 | 参数  | 说明  
---|---|---
report/create | 各种条件 | 创建提报活动 
report/update | 各种参数 | 编辑提报活动
report/setstatus |  report_id , status| 修改提报活动状态，启用，停用，同时要管理相关的子元素。
report/goods\_list    | report\_id ， 各种搜索条件    |  提报活动中的上品列表。   
report/judge    | id , type    |  审核提报活动中的商品, 0: 待审 1:审核通过，2:拒绝 3:驳回 
report/batch  |  event_id  | 查看提报活动的批次列表   
report/edit_goods_info   |  event\_goods\_name , even\_goods\_desc ,event_goods_image  |  编辑活动商品的广告语和描述语,活动图片。   
report/send\_to\_batch | batch_id , goods_ids(1123,23,12)| 设置商品批次。将goods_id的batch_id设置成batch_id
batch/batch_goods |batch_id | 批次下的所有商品  
batch/remove_godos | batch_id , goods_id | 删除批次商品
batch/create  |  batch_name , batch_type ,event_id |  创建批次 
batch/set_status | batch_id , to_status | 删除批次，2 ， 3 失效，生效1
promo/sku_price | sku_id ，支持批量。| 获取sku的提报价格信息。 



###
