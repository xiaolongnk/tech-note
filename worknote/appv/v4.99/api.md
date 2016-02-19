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
    shop_id  bigint(20) not null default 0 comment '创建者的account_id',
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
   
passw
eu3G8cm9er

content_service life 相关接口

1. 创建
http://content.service.inf.lehe.com/life/create?position=123123&lat=123.23&lon=22.333&text=helloworld&images=123123,1231234&account_id=123123

2. 获取life详情
http://content.service.inf.lehe.com/life/get_detail?id=21
支持批量

3. 获取店铺的Life列表.
http://content.service.inf.lehe.com/life/shop_life_list?account_id=123123


pandora 接口
