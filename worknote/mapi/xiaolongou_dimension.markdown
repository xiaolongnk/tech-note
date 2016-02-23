说明,请先绑定
hosts 172.17.30.58 service.higo.meilishuo.com  hgadmin.higo.lehe.com worksapi.dev1.higo.meilishuo.com  
相关文档参见 <http://redmine.meilishuo.com/projects/higo-pc/wiki>  

#### 1 HIGO 创建群圈维度  
<http://worksapi.dev1.higo.meilishuo.com/dimension/create>  
1: 国家纬度 2: 全民最爱 3: 运营纬度 4: 品牌买手 5: 个性买手 6: 其他群圈

| params | necessary  | default value | 说明  |
|---|---|---|----|
| name  |  1 |  | 全球最热  |
| position  | 1 |  | 200  |
| type | 1   |  | 1: 国家纬度 2: 全民最爱 3: 运营纬度 4: 品牌买手 5: 个性买手 6: 其他群圈 |
| country | 1   |    | 中国   |

#### 2 HIGO 更新群圈维度  
<http://worksapi.dev1.higo.meilishuo.com/dimension/update>

| params | necessary  | default value | 说明  |
|---|---|---|----|
| id | 1 |  | 要修改的维度的id |
| name  |  1 |  | 全球最热  |
| position  | 1 |  | 200  |
| type | 1   |    | 1  |
| country | 1   |    | 中国   |


#### 3 HIGO 删除群圈维度  
<http://worksapi.dev1.higo.meilishuo.com/dimension/delete>

| params | necessary  | default value | 说明  |
|---|---|---|----|
| id   |  1 | 83 | 要删除的维度的id |

#### 4 HIGO 获取维度列表  
<http://worksapi.dev1.higo.meilishuo.com/dimension/get_list>  

| params | necessary  | default value | 说明  |
|---|---|---|----|
| page |  0 | 1 | 当前页数  |
| page_size | 0 | 10 | 当前的页容量  |
```json
{
"id": "19",                 维度id
"type": "5",        维度类型
"country": "",         国家名
"position": "20",           位置
"name": "达人说",   维度名
}
```

#### 5 获取维度下的群圈列表.
<http://worksapi.dev1.higo.meilishuo.com/dimension/shop_list>  

| params | necessary  | default value | 说明  |
|---|---|---|----|
| id  |  1 | 1 | 当前的维度id  |
|page | 0 | 1 | 当前的页码  |
|page_size | 0 | 10 | 当前的页容量  |



##### 6 给群圈维度中添加店铺
<http://worksapi.dev1.higo.meilishuo.com/dimension/add_shops>  

| params | necessary  | default value | 说明  |
|---|---|---|----|
| id  |  1 | 1 | 当前的维度id  |
|shop_ids | 1 | 123123,123123,1231 | 字符串,格式是逗号连接的数字  |


#### 7 从群圈纬度中删除店铺
<http://worksapi.dev1.higo.meilishuo.com/dimension/get_list>  

| params | necessary  | default value | 说明  |
|---|---|---|----|
| id  |  1 | 1 | 当前的维度id  |
| shop_ids  | 1 | 12312,3123,12312 | 字符串,格式是逗号连接的数字  |

#### 8 群圈纬度中可添加的商铺
<http://worksapi.dev1.higo.meilishuo.com/dimension/avaliable_shops>  

| params | necessary  | default value | 说明  |
|---|---|---|----|
| page  |  0 | 1 | 当前页  |
| page_size| 0 | 10 | 页容量  |
| keyword | 0 | "" | 字符串,格式是逗号连接的数字  |

```json
"group_name": "穿CHANEL的老太婆",                                群圈名称
"two_hour_gmv": "0.000",                                        昨天gmv
"group_desc": "英国伦敦在读大学生，时尚买手，多次出入平拍发布会，价格公道，诚信经营",   群圈描述
"group_header": "http://pic.higo.meilishuo.com/higo/orig/2015-04-21/081952221fadf5c52978c36cbb409e4e.jpg",   群圈头像
"group_id": "373d83811fcf37de1",                                    群圈id 
"members_count": "26",                                              群圈人数
"group_tags": "奢侈品小天后,高街装扮,高跟鞋狂热爱好者,爱健身也爱吃,最低价代购",   群圈标签
"city": "英格兰",                                                   城市名
"country": "英国",                                                  国家名
"shop_id": "167354971274737985"                                     shop_id
```


#### 9 更新群圈维度的权重
<http://worksapi.dev1.higo.meilishuo.com/dimension/update_position>  

| params | necessary  | default value | 说明  |
|---|---|---|----|
| id |  1 | 1 | 维度id  |
|`update_str` | 1 | 12312:3,3423423:4 | 跟新内容字符串,用逗号拼接,单元格式是 `shop_id`:position,`shop_id`:position ...|



#### 10 获取国家列表 麻烦调用这个接口

http://worksapi.dev1.higo.meilishuo.com/expresscompany/countryList?page=1&page_size=250<>
