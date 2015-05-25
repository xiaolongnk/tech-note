#API缓存系统

>介绍目前API系统中的缓存机制。
对于不经常改变的数据，访问频率又比较高的API，为了减少系统压力，需要加入缓存优化。系统依赖缓存加速，但是缓存中的数据是不可靠的，程序在拿不到缓存数据的情况下应该可以具备修复缓存数据的能力，而不能因为缓存中数据丢失就失效。

举例如下：

```php
/**
 * 添加 Group 信息
 * 要求 data 必须包含 shop_id 。
 * */
public static function addGroupInfo($goods)
{
	$where = array('shop_id'=>$goods->shop_id,'group_status'=>1);
	$ret = \Pandora\Library\Cache\AccountGroup::account_group_get($goods->shop_id);
	if($ret){
		$group_info = unserialize($ret);
	}else {
		$group_info = \Pandora\Library\Data\Account_Group::getDetailInfo($where);
		if(empty($group_info)){
			$group_info = new \stdClass();
		} else{
			\Pandora\Library\Cache\AccountGroup::account_group_save($goods->shop_id, serialize($group_info));                            
		}
	}
	$goods->group_info = $group_info;
}

/*
 * 缓存层的代码逻辑
 */
public static function account_group_save($shop_id, $group_info) {
	$redis_key = "account_group" . $shop_id;
	return self::getConnection ( self::SECTION )->set ( $redis_key, $group_info, 3600 );
}
public static function account_group_get($shop_id) {
	$redis_key = "account_group" . $shop_id;
	return self::getConnection ( self::SECTION )->get ( $redis_key );
}
public static function account_group_invalidate($shop_id) {
	$redis_key = "account_group" . $shop_id;
	return self::getConnection ( self::SECTION )->delete ( $redis_key );
}

/*
清除缓存
api       accoung_group 的所有接口中调用 account_group_invalidate($shop_id) 方法来清除缓存。
hgadmin   中修改群圈信息时，清除对应的缓存。
pc后台    pc后台大部分功能都是通过API来完成，但是也有一部分独立的逻辑。
*/
```
加入缓存最可能引入的问题就是修改不能即时生效。为了解决这个问题，要在所有可以修改群圈数据的入口处都加入清除缓存的逻辑。这样，缓存会在下次查询时被重置，从而保证数据的即时性。在HIGO系统中，数据的更改包括API和运营后台，所以在开发新功能时，必须要考虑数据的入口，如果有缓存，那么要在`API`和`hgadmin`两个系统中都加入缓存清除机制。
原则上所有的 key 都应该设置一个过期时间。

目前HIGO系统中程序级别中引入缓存的接口包括下面这些。
我们的促销系统中，会有一组活动，这组活动是有运营后台指定的，那么这些信息录入在哪里。如果这些信息没有被录入，这个活动怎么组织呢。并且，现在的活动的添加形式太过复杂，我们怎么样实现
才能提高运营组织活动的效率呢。

对于缓存问题，我们从API中用到的这些 `redis_key` 入手，将这些key和其在API中对应的功能列举出来，单独作为一个模块由大家来共同维护，在开发新功能是，如果需要用到缓存，应该检查下是否有和自己业务相关的key，如果有，就要在对应的地方假如对这个缓存信息(维护和删除)

 redis缓存key |  描述  | 是否和运营后台相关
------ | --------- | ---------
`dimension_id.$dimension_id` | 纬度商铺 | 相关，运营后台操作纬度商铺的时候，应该将这个缓存清除。
`account_group.$shop_id` | 群圈详情 | `API` `HGADMIN` 凡是操作群圈基本属性的地方，都应该清除这个缓存。
`event_detail.$event_id` | 活动详情 | 主要在 `HGADMIN` 修改活动的属性，清除缓存
`higo_sale_events_status` | 是否有提报活动正在进行 | 由cron来决定是否打开，如果关闭，说明当前没有活动在举行。不进行价格的处理，如果开启，会对商品进行进一个的价格策略。
`higo_sale_sku_price.$sku_id` | 查看当前的sku的会场价格 |`HGADMIN` 中有任何对商品的操作，都要将这个缓存进行同步。


