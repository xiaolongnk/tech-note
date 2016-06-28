策划活动


1. 活动提报 ｛《＝ 运营 《＝＝商家提报 ｝

2. 活


提报系统 （包括审核  ）

（
提报规则
提报审核
）

直播和提报。

提报条件。


秒杀进度条算法优化。

1. 当库存为0时进度条为100%
2. 进度条的和在售商品库存相关。
3. 商品的虚拟进度条是商品的一个属性，由系统随机生成，和商品库存相关。
4. 商品进度条随时间变化，变化的单位和变化的时间间隔，和变化的幅度和商品库存相关。
5.



提报相关的表如下，基本和现有表保持一致。
其中，活动批次 和 批次商品表重新设计。可以通过数据迁移来保持就数据，迁移成本较低，并且可控。
其余表基本沿用原来的数据表。考虑到数据迁移和系统过度的复杂性，并且原有表基本可以满足新需求。


```sql

t_pandora_report_event;
t_pandora_report_event_shop;
t_pandora_report_event_shop_goods;
t_pandora_report_event_batch;
t_pandora_report_event_batch_goods;

CREATE TABLE `t_pandora_report_event` (
  `report_event_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_event_title` varchar(128) NOT NULL DEFAULT '' COMMENT '活动名称',
  `report_event_desc` text NOT NULL COMMENT '活动说明',
  `reporting_conditions` varchar(500) NOT NULL DEFAULT '' COMMENT '提报条件',
  `registration_starttime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '报名开始时间',
  `registration_endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '报名结束时间',
  `report_event_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动开始时间',
  `report_event_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '活动结束时间',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `ctime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `report_event_image` bigint(20) DEFAULT '0' COMMENT '图片ID',
  `report_event_banner` bigint(20) NOT NULL DEFAULT '0' COMMENT 'banner图ID',   /// useless
  `report_event_tag` varchar(64) NOT NULL DEFAULT '' COMMENT '提报标签',		/// modify comment
  `report_event_sort` tinyint(1) NOT NULL DEFAULT '0' COMMENT '活动排序(0-99)',  
  `report_event_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '提报活动类型 1.大促, 2.秒杀 ... 支持扩展其他类型',
  PRIMARY KEY (`report_event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=705 DEFAULT CHARSET=utf8 COMMENT='提报活动';


CREATE TABLE `t_pandora_report_event_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '提报活动id',
  `shop_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `eligibility_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '活动资格 0:未提报 1:待审核  2:审核完成 3:取消资格',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `ctime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `push_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '推送状态 0.未推送,1.完成报名推送,2.完成活动推送',
  `message_flag` tinyint(2) NOT NULL DEFAULT '0' COMMENT '商家端活动数目标识（0:未查看 1:已查看）',
  PRIMARY KEY (`id`),
  KEY `report_event_id` (`report_event_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1409264 DEFAULT CHARSET=utf8 COMMENT='提报活动参与的店铺';


CREATE TABLE `t_pandora_report_event_shop_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '提报活动id',
  `shop_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `goods_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '商品id',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '商品状态 0:待审 1:审核通过 -1:删除 -2审核不通过',
  `report_event_goods_price` double(11,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '活动商品价格',
  `buyer_buy_limit` int(11) NOT NULL DEFAULT '0' COMMENT '单个用户购买数量限制',
  `mtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `ctime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `sku_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '单品id',
  `reject_reason` varchar(128) NOT NULL DEFAULT '' COMMENT '商品拒绝原因',
  `goods_image` varchar(128) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL DEFAULT '0' COMMENT '提报商品图片',
  `store_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.国内货仓,2.国外货仓,3.海外直邮,',
  `presale_repertory` int(11) NOT NULL DEFAULT '0' COMMENT '预售库存',
  `event_goods_name` varchar(64) NOT NULL DEFAULT '' COMMENT '活动商品名',
  `event_goods_desc` varchar(64) NOT NULL DEFAULT '' COMMENT '活动商品描述',
  `sku_sales` int(11) NOT NULL DEFAULT '0' COMMENT '大促商品销量',
  `update_repertory_stat` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0正常，1待处理，2处理成功，3审核失败',
  `report_repertory` int(10) NOT NULL DEFAULT '0' COMMENT '提报的库存',
  `first_judge_status` tinyint(4) not null default 0 comment '运营审核状态 0 待审 1审核通过 2审核未通过 ',
  `second_judge_status` tinyint(4) not null default 0 comment '营销组审核状态 0 待审 1审核通过 2审核未通过 ',
  PRIMARY KEY (`id`),
  KEY `report_event_id` (`report_event_id`,`status`),
  KEY `shop_id` (`shop_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=353904 DEFAULT CHARSET=utf8 COMMENT='提报活动参与的店铺的商品';


CREATE TABLE `t_pandora_report_event_batch` (
  `batch_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '分组编号',
  `batch_name` varchar(100) NOT NULL DEFAULT '' COMMENT '分组名称',
  `batch_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '分组备注',
  `batch_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1.正常；2.删除；',
  `event_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动编号',
  `start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `mtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `batch_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1: 普通 2: 夜场',
  PRIMARY KEY (`batch_id`),
  KEY `batch_id` (`batch_id`,`batch_status`),
  KEY `event_id` (`event_id`,`batch_status`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='提报商品批次';


alter table t_pandora_report_event_shop_goods add column `first_judge_status` tinyint(4) not null default 0 comment '运营审核状态 0 待审 1审核通过 2审核未通过 ';
alter table t_pandora_report_event_shop_goods add column  `second_judge_status` tinyint(4) not null default 0 comment '营销组审核状态 0 待审 1审核通过 2审核未通过 3: 驳回(可以重新提报)';
alter table t_pandora_report_event_shop_goods add column batch_id bigint(20) not null default 0 comment '批次ID';
alter table t_pandora_report_event_shop_goods add batch_sort int(10) not null default 1 comment '批次内商品排序';


```

接口改造。
pandora 接口改造，计算价格接口抽象到promoservice。
goodsservice 中调用t_pandora_promo_events 表。

一. works 后台的相关功能。



二.promoservice 中增加如下接口,为pandora 和 bizbll 提供服务。

1. 价格及计算服务 pandora
2. 提报库存增减服务。 pandora
3. 商品提报接口。 pandora
4. 商家可以提报的商品列表。 (shopservice)
5. 商家参加活动的商品列表。 (shopservice)

三. 提报功能提报相关功能的开发。
febiz
bizbll

pandora  ()


四. 提报相关功能的H5页面。


确认下客户端现在用哪个价格。
最完美的解决方案是讲价格逻辑放在 goodservice里面。将pandora的价格逻辑废弃。将pandora的计算逻辑逐渐弱化。相关功能前移到对应的
基础服务里面。




1. 写一个新的goods_getsku 方法。可以通过不同的条件获得sku的信息。这样可以解决价格计算和订单相关的问题。
2. 购物车处对wrap_higo_sku 的影响。 通过研究，发现所有依赖wrap_higo_sku 的地方，都可以通过调用sku来影响。
所以，只要将这部分逻辑放在获取sku的地方，就可以无缝替代。

1 . 更具skuid查询。 根据条件查询。 
2 . crossorder需要修改一下。

3. 查询促销库存的逻辑取消。
4. 删除了若干 查询sku的方法，统一为一个。
5. move all logic related to report_event to promo service;
6. 秒杀模块数据源切换。
7. 秒杀接口的切换。

8. 制造假数据，调试接口功能。 提报id 是 709



### 上线流程

1. sql 改动

higo_goods 库
t_pandora_report_evnets 需要增加几个字段。 需要和运营确认。
```
alter table t_pandora_report_event add column `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1:正常，-1:删除';
alter table t_pandora_report_event add column `create_user` varchar(11) DEFAULT '' COMMENT '创建者';
alter table t_pandora_report_event add column `attach_info` text COMMENT '模板文件json';
alter table t_pandora_report_event add column `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父活动ID，-1主活动，0普通活动， >0存在主活动';
alter table t_pandora_report_event add column  delivery_free tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包邮 1包邮 0 不包邮';
alter table t_pandora_report_event add column `pay_timeout` int(11) NOT NULL DEFAULT '10' COMMENT '订单未支付超时关闭时间';
alter table t_pandora_report_event add column `promo_type` int(10) NOT NULL DEFAULT '1' COMMENT '1.秒杀专用 2.其他';
alter table t_pandora_report_event modify column `reporting_conditions` text NOT NULL COMMENT '提报条件';

```

t_pandora_report_event_shop_goods 中需要增加几个字段
```
alter table t_pandora_report_event_shop_goods add column batch_id bigint(20) not null default '0' comment '批次id';
alter table t_pandora_report_event_shop_goods add column batch_sort int(4) not null default 1' comment '商品在批次内的排序';
```

t_pandora_reprot_event_batch  增加表
```
CREATE TABLE `t_pandora_report_event_batch` (
`batch_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '分组编号',
`batch_name` varchar(100) NOT NULL DEFAULT '' COMMENT '分组名称',
`batch_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '分组备注',
`batch_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1.正常；2.删除；',
`event_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动编号',
`start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
`end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
`ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
`mtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
`batch_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1: 普通 2: 夜场',
PRIMARY KEY (`batch_id`),
KEY `batch_id` (`batch_id`,`batch_status`),
KEY `event_id` (`event_id`,`batch_status`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='提报商品批次' 

```
增加提报商品表。
```
create table t_pandora_report_event_shop_goods_main (
id bigint(20) not null auto_increment,
report_event_id bigint(20) not null default 0 comment '提报活动id',
shop_id bigint(20) not null default 0 comment '店铺id',
goods_id bigint(20) not null default 0 comment  '提报商品id',
event_goods_name bigint(20) not null default 0 comment '提报商品名称',
event_goods_desc bigint(20) not null default 0 comment '提报商品描述',
event_goods_image bigint(20) not null default 0 comment '提报商品图片',
status int(4)  not null default 0 comment '-1:删除,0:待审,1:审核通过 -2:驳回可以再次提报 -3:拒绝无法再次提报',
batch_id bigint(20) not null default 0 comment '批次id',
batch_sort int(10) not null default 0 comment '批次内排序',
goods_repertory int(10) not null default 0 comment '提报商品总库存',
goods_sales int(10) not null default 0 comment '提报商品总销量',
ctime timestamp not null default '0000-00-00 00:00:00' comment '创建时间',
mtime timestamp not null default current_timestamp comment '修改时间',
primary key (id),
key batch_id_key (batch_id),
key goods_id_key (goods_id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='提报商品表';


alter table t_pandora_report_event_shop_goods_main modify column event_goods_name  varchar(256) not null default '' comment '提报商品名称';
alter table t_pandora_report_event_shop_goods_main modify column event_goods_desc  varchar(256) not null default '' comment '提报商品描述';
alter table t_pandora_report_event_shop_goods_main modify column event_goods_image  varchar(256) not null default '' comment '提报商品图片';
alter table t_pandora_report_event_shop_goods_main add column reject_reason varchar(256) not null default '' comment '审核拒绝原因';


```

### 数据库已经创建。  done

### works后台增加功能入口 

### promo service 上线。  done

部署在 goods serivce 的机器上。  done
增加域名解析。 promo.service.lehe.api  done
增加globalconfig的配置。  done


问题：

1. 旧系统设置的数据，新系统不支持。如何让系统能正确兼容旧系统(hgadmin过来的数据。)

分析：讲批次，和商品在新系统中重新处理一下，来过渡，一旦过渡成功，就废弃旧的运营后台。

就系统中的 大促 和 秒杀类型的，和价格变化相关的活动。

1. 确保系统可以正常下单。可以正常支付。
2. 找出现在所有的变价的商品。


1. 批次数据， 秒杀价格的变化依赖于 批次的时间。但是现在的批次依赖就得活动，所以没法生效。
2. 大促批次，以往的大促活动价格变化依赖于大促表，现在是依赖提报表。所以时间需要同步。

上线前数据迁移的解决方案。

1. 找出所有的正在参加变价的商品，找出正在进行的，和还没有开始的秒杀活动，和大促活动。
   创建对应的提报活动，这些提报活动是虚拟的，但是关键的信息，价格对应的信息是正确的，这样就可以将数据
   做一次平滑迁移了。

   秒杀和大促都比较乱。都不能一一对应. 经大促活动的时间同步到提报活动表里面。现在是这个字段没有用，但是
   字段已经存在，只要利用起来就可以了。




迁移一些线上数据，用来测试。

works后台上线，测试。

hgadmin的数据迁移。 () 

pandora 上线。   5-24

老后台停用。     

diy页面数据。

老diy接口调整。


手机提报(东杰) 2016-05-21
提报接口数据结构修改(东杰)  2016-05-23 
类目筛选。 (东杰)


和glk打通。 支持批次ID。  (欧小龙)
增加审核的备注,首页位置。(欧小龙)
添加提报活动类型。(source_type)
旧后台功能完善。  (欧小龙) (2016-05-19)

增加提报页面逻辑,恢复为现有模式。 (给面向运营的会场灌商品) (欧小龙)  (2016-05-20)
数据迁移的问题。 (欧小龙 2016-05-21）

测试 (2016-05-23)

2016-05-19 23:18

works 后台前端，接口 
1. report_event_type 的类型；1 大促  2 秒杀 3 4 5 6 7(待扩展)   10 秒杀会场
2. 秒杀会场给所有 秒杀页面使用。 包括首页模块的数据，秒杀页面的数据。
3. 


```
alter table t_pandora_report_event add column source_type tinyint(4) not null default 1 comment '1：面向商家 2:面向运营';
alter table t_pandora_report_event_shop_goods_main add column remark varchar(128) not null default '' comment '备注';
```

2016-05-23 23:02
需要和glk系统一起测试一下。唯一的一个遗漏。

测试了秒杀页面，首页。 价格变化逻辑，均没有发现问题。
购物车，下单支付，库存的变化。

等待明天上线观察。

抽查了三个最新的 diy页面，也没有发现异常。

数据同步脚本功能ok ，已经使用了多次，明天可以直接使用。

/home/service/php/bin/php /home/work/pandora/public/script/index.php test/Test

works 后台的功能，使用较少，没有进行太多测试，感觉应该ok。
works 后台问题，出问题立刻修改。

明天的主要工作。
继续测试works后台，以及所有相关的功能，尽量确保上线不出bug。
写一个简单的wiki。


明天晚上上线步骤。

用数据同步脚本，先同步数据;
bizbll ;
febiz ; 
商家后台pc biz ;
提报的H5页.
上线后再同步一次数据，确保所有的老数据都被同步到新表里面。面.

问题：
首页模块的数据源需要修复，其他秒杀张创建批次会导致首页数据乱套。


2016-05-24 11:53
1. 创建提报活动
2. 审核商品， 备注
3. 推送商品
4. 管理商品分组
5. 编辑商品信息（广告语，名称，排序，图片）
6. 批次生效功能



TODO:
下午搞定。

1. 批次商品增加排序功能  wo
2. 提报审核中显示推送信息  wo 
3. 批次管理中批次类型显示名称 wo 
4. 增加批次生效，失效功能   wo


5. 可提报商家数   dongjie
6. 商家后台发送上线公告   dongjie
7. 图片放大   dongjie
8. 提报默认排序设置999 dongjie
9. group 走 service   dongjie
H5 提报上线。 


alter table t_pandora_report_event_batch modify column batch_status tinyint(4) not null default 2 comment '状态 1:正常 2.失效 -1:删除';
alter table t_pandora_report_event_shop_goods_main modify column batch_sort int(10) not null default 999 comment '批次内商品排序，默认999';


2016-05-24 21:02


status 增加状态   status 2:进入排期 3：排期中， 4:排期结束

