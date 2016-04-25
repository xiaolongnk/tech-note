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
  `utime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `batch_type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1: 普通 2: 夜场',
  PRIMARY KEY (`batch_id`),
  KEY `batch_id` (`batch_id`,`batch_status`),
  KEY `event_id` (`event_id`,`batch_status`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='提报商品批次';


CREATE TABLE `t_pandora_report_event_batch_goods` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `batch_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '分组(批次)编号，预留',
  `event_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动编号',
  `goods_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '关联的商品ID',
  `goods_sort` tinyint(4) NOT NULL DEFAULT '99' COMMENT '商品排序[1-99]',
  `goods_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1.正常；2.删除；',
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `mtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `test_index` (`batch_id`,`goods_status`,`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='提报商品批次商品表'


alter table t_pandora_report_event_shop_goods add column `first_judge_status` tinyint(4) not null default 0 comment '运营审核状态 0 待审 1审核通过 2审核未通过 ';
alter table t_pandora_report_event_shop_goods add column  `second_judge_status` tinyint(4) not null default 0 comment '营销组审核状态 0 待审 1审核通过 2审核未通过 3: 驳回(可以重新提报)';
alter table t_pandora_report_event_shop_goods add column batch_id bigint(20) not null default 0 comment '批次ID';
alter table t_pandora_report_event_shop_goods add batch_sort int(10) not null default 1 comment '批次内商品排序';


```
