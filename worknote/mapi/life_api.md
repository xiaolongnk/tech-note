###

发life.
开发在content_service 里面.

相关接口.
1. 创建LIFE 
   文字、多个图片id、位置｛名称，经纬度｝
   text {长度300} string
   image_id{300} string
   position {256}  string
   lat  string
   lon  string
   access_token 
```sql

create table t_pandora_life (
    life_id bigint(20) not null primary key,
    account_id bigint(20) not null default 0 comment '创建者的account_id',
    text varchar(320) not null default  '' comment '文本',
    images varchar(320) not null default '' comment '图片id,逗号分开',
    position varchar(256) not null default '' comment '地理位置',
    lat varchar(64) not null default '' comment '经度',
    lon varchar(64) not null default '' comment '维度',
    ctime timestamp not null default current_timestamp comment '创建时间', 
    mtime timestamp not null default '0000-00-00 00:00:00' comment '修改时间',
    status tinyint(2) not null default 1 comment '1:正常,-1:删除',
    remark tinyint(2) not null default 0 comment '0:未加精,1:加精',
    remark_time timestamp not null default '0000-00-00 00:00:00'
) engine = Innodb , charset = utf8;


```

2. 点赞 , 取消赞
    life_id
    access_token
    type

3. 详情, 摘要. softtoken 分开接口
    id
    access_token 

4. LIEF详情列表.
    shop_id ,
    p
    size

5. 查看更多life


187963526143160041,183579689387552021,183579788207554072

获取详情。
http://v.inf.lehe.com/life/get_detail?ids=28
创建接口
http://v.inf.lehe.com/life/create?text=123123&images=187963526143160041&position=%E6%97%A7%E9%87%91%E5%B1%B1&lat=33.3&lon=54.3&access_token=684c7020792189e7e89bc1a35c8f7ded

获取店铺的life
http://v.inf.lehe.com/life/shop_life_list?shop_id=188057690748420053

### 点赞的新接口。
旧接口 favorite/create , favorite/delete 逻辑比较乱，整理了一套新的，逻辑比较清楚，
我们这版本替换下，后面逐渐取消旧接口。

favorite/create_favo

参数 |  说明 | 是否必需  | 默认值 
----|----|----|----|----
action_type | 点赞数据的类型，1 商品 2 足迹 3 life。 | 是 | 1  
target_id | 点赞的值，随着action_type 变化,是字符串类型的值。值类型随着 action_type 和 from_board 变化。  | 是    |     
access_token | token | 是 |   
batch_flag  | 批量收藏的标记，是1，否0, 在值为1的时候，target_id 是json化的id数组,并且需要传递额外的参数name 和 shop_id |  否 |  0
name | board 名称,  |  只有batch_flag = 1 的时候需要。 |  '' 
shop_id |  board 的店铺id |   只有batch_flag = 1 的时候需要 | ''  

favorite/delete_favo

参数 |  说明 | 是否必需  | 默认值 
----|----|----|----
action_type | 取消赞数据的类型，1 商品 2 足迹 3 life。 | 是 | 1  
target_id  |  传递的参数内容和action_type 相关，1 表示商品id ， 2 表示足迹id ， 3 表示life id |  是 | 

返回值
```
code = 0 操作成功。
code ！= 0 ， 表示发生异常。
```
