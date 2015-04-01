work@172.16.0.159  redis
work@172.16.1.37
work@172.16.1.38
work@172.16.1.39
work@172.16.1.41
work@172.16.1.42
work@172.16.11.67  hgpusher

goods `sssid=1`

```sql
create table t_pandora_goods_limitation
(
    id int(11) not null auto_increment primary key,
    limitation int(10) not null default 1 comment '每人限购次数',
    start_time timestamp default CURRENT_TIMESTAMP comment '开始时间',
    end_time timestamp default '0000-00-00 00:00:00' comment '限购结束时间',
    ctime timestamp default '0000-00-00 00:00:00' comment '创建时间'
)charset=utf8 engine=InnoDB auto_increment=1;

alter table t_pandora_goods add column limitation_id  int(11) not null  default 0 comment '限购明细id'; 

```

delete these useless files.
drop table t_pandora_guider;

library/data/Guilder.class.php
Package/Guilder.class.php
modules/mob/guilder/Get_list.class.php


