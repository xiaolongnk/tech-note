### 强制商家同意协议。

```sql

create table t_pandora_agreement
(
    id bigint(20) not null auto_increment primary key comment '协议id',
    content text not null default '' comment '协议内容',
    ctime timestamp not null default '0000-00-00 00:00:00' comment '创建时间',
    mtime timestamp not null default current_timestamp on update current_timestamp,
    status tinyint(2) not null default 1 comment '1正常 -1 删除'
)engine = innodb , charset=utf8 , auto_increment = 1;


create table t_pandora_group_agreement_status
(
    id bigint(20) not null auto_increment primary key comment '',
    shop_id bigint(20) not null default 0 comment '',
    agreement_id bigint(20) not null default 0 comment '协议id',
    ctime timestamp not null default '0000-00-00 00:00:00' comment '创建时间',
    mtime timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP comment '修改时间',
    index shop_id_index (shop_id)
)engine = InnoDB , charset=utf8 , auto_increment = 1;

```


### 提现强制商家同意协议。
<http://v.inf.lehe.com/order_pay/withdraw?access_token=684c7020792189e7e89bc1a35c8f7ded&withdraw_amount_sum=100>

0 表示未同意协议，1表示已经同意协议。
```
"code": 0,
"data": 
{
    "agreement_status":0
},
"message": "请先同意协议！"
```
