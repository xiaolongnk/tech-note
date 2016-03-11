#### chage price api.

Get goods list that can change price.    
<http://midian.lehe.com/event/change_goods_list?access_token=99e4fee62e067989c6fed079b3b8b8b3&p=1&size=10>

| params | necessary | default value  |
|---|---|---|
| `access_token` |  1 |   |
| `p` | 0  | default value is 0  |
| `size` |  0 | default value is 10 |



<http://midian.lehe.com/event/change_price?access_token=99e4fee62e067989c6fed079b3b8b8b3&price=123.3&sku_id=123123&report_id=123>

| params | necessary | default value  |
|---|---|---|
| `access_token` |  1 |   |
| `report_id` | 1  | |
| `price` |  1 |  |
| `sku_id` |  1 |  |



获得 higo board 瀑布流.

| 字段 | 说明 |
|---|---|
| `board_type` | 0 自建 1 热销  2 上新 |
| `members_count` |  赞的数量 |
| `ctime` | 创建时间  |


<http://midian.lehe.com/huodong/board_flow?p=1&size=10>

| params | necessary | default value  |
|---|---|---|
| `p` |  1 |  1 |
| `size` | 1  | 10 |


HIGO 瀑布流  
<http://midian.lehe.com/content_contentservice/homepage/Main_page?p=1&size=10>

| params | necessary  | default value | 说明  |
|---|---|---|----|
| p  |  0 | 1 | 当前页数  |
|size | 0 | 10 | 当前的页容量  |
| account_id  | 0   |  0  |有就传,没有就不传   |

item_type说明如下:
```php
 1 : goods ; 2 : board ; 4 : banners ;
 6 : 秒杀 ; 7 :  品牌团 ; 8 : 折扣季 ;
 9 : 全球好物 ; 10 : 全球最前沿; 11 : 爆品推荐 ;
```

[维度群圈相关的API](xiaolongou_dimension)
