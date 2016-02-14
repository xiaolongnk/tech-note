
###类目接口
<http://midian.lehe.com/goods_service/category/get_category_list>

|参数名	| 参数值   | 是否必须 |
---------|-------------|------------
|cid       |      int  |  必须 |
|is_parent |  0  或者 1 |	必须 |


###属性值
<http://midian.lehe.com/goods_service/category/get_property_value_tree?cid=11851>

|参数名	| 参数值   | 是否必须 |
---------|-------------|------------
|from       |      int  |  必须 |
|cid |  int |	必须 |

###创建商品
<http://midian.lehe.com/goods_service/goods/create_goods>

|参数名	| 参数值   | 是否必须 |
---------|-------------|------------
| access_token | string |  必需 |
|maidian  |     string |   非必需|
|name  |    string  |  必需 |
|desc   |   string  |  必需  |
|main\_image\_id  | number | 必需  |
|detail\_image\_ids  | string  | 必需 |
|brand\_name     |  string  |  必需 |
|brand\_id  |   int |  必需 |
|quality  | string  | 必需 |
|quality\_unit | int | 必需 |
|category\_id  |  int |  必需 |
|use\_transport |  int  | 必需 |
|store\_type  |  int  |  必需 |
|area  | string  | 必需 |
|props  | string | 必需 |
|props\_str | string | 必需 |
|sku  |    string  | 必需 |
|sku\_str |  string | 必需 |
|sku\_prices | string | 必需 |
|sku\_quantities | string | 必需|


###获取商品详情
<http://midian.lehe.com/goods_service/goods/detail>

|参数名	| 参数值   | 是否必须 |
---------|-------------|------------
|from       |      int  |  必须 |
|cid |  int |	必须 |


###更新单品
<http://midian.lehe.com/goods_service/goods/update_goods>

|参数名	| 参数值   | 是否必须 |
---------|-------------|------------
| access_token | string |  必需 |
|goods_id  |     string |  必需|
|maidian  |     string |   非必需|
|name  |    string  |  必需 |
|desc   |   string  |  必需  |
|main\_image\_id  | number | 必需  |
|detail\_image\_ids  | string  | 必需 |
|brand\_name     |  string  |  必需 |
|brand\_id  |   int |  必需 |
|quality  | string  | 必需 |
|quality\_unit | int | 必需 |
|category\_id  |  int |  必需 |
|use\_transport |  int  | 必需 |
|store\_type  |  int  |  必需 |
|area  | string  | 必需 |
|props  | string | 必需 |
|props\_str | string | 必需 |
|sku\_ids  | string | 必需 |
|sku  |    string  | 必需 |
|sku\_str |  string | 必需 |
|sku\_prices | string | 必需 |
|sku\_quantities | string | 必需|



### TOKEN验证接口
<http://midian.lehe.com/account/validation?access_token=000005633dc5b707f2f049ea13a81504>

###参数说明

|参数名	| 参数值   | 是否必须 |
---------|-------------|------------
|access_token  |      string  |  必须 |

####返回结果

| code |  message |
----|----|----
| 0  |  token有效   |
| 40001   |  登录令牌无效     |