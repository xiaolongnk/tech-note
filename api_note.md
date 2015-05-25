#后台系统API

###1. 活动说明

`活动 = 基本属性 + 附加属性`
`基本属性` 是指活动的基本属性，包括 `event_pic`, `position`, `event_type`
`附加属性` 扩展活动 所填加的额外信息，由需求决定

活动类型 | 说明 | 详情 | 是否含附加属性  | 
-------|--------|-------|---------------
1 | 普通活动|  由 封面图片+商品列表组成（原则商品不能超过10个）| 否
2 | 秒杀活动 | 封面图片，秒杀商品详情，秒杀有库存限制，后台会对用户的购买数量做严格的限制。 | 否
3 | 街拍活动 | 街拍专题 | 否 
4 | Banner |  如果列表页中出现 banner类型的活动，那么这个活动的数据，包括基本的属性之外，还会有一个 banner 的节点。对这种类型的数据，用户端只会处理数据中的banner节点| 是(banner)
5 | board  | board可以加精到首页，这是什么东西  |  否


###2. Banner 说明
系统中的 `home_banner` 表。以前的 `group_banner` 已经废弃，不再使用。
 
Banner类型 | 说明  | 详情 
-------|----------|------
1 |  群类型|  跳转到指定的群
2 |  专题类型 | 跳转到指定的专题
3 | 单品类型 | 跳转到指定的 单品
4 | 链接  | 展示 url 对应的页面


从这里可以看出，活动可以跳转到banner

###3. 首页说明

接口名  goods/goods_show 除了基本参数。该接口的 type 进行说明如下

type | 说明
---|-------
1 | 商品列表，包括 banner（顶部显示，轮播形式）， 推荐类目（运营后台指定），【 goods， event】二者相互穿插，event位置可以由运营指定。
2 | 上新， 获取最新上架的商品，目前已废弃。
3 | 历史专题， 获取最新的专题列表。这个列表全部是专题，点击专题，进入专题详情。

产品方面要求提高产品展示的多样性。希望在首页的商品列表中加入更多形式的内容，但是从程序实现的角度，首页展示类型过多，成本太高，所以才会
将新加的类型都增加到活动里面，（增加了活动类型，由原来的3中扩展成现在的5中，或者更多）


###4. `H5_520`
这就是 限时促销活动
需要一个商品列表，有一个开始时间和结束时间，在活动期间，商品的价格将变成活动中商品的价格，应该是较低的价格。活动结束之后，APP内商品详情
和购买时候的价格恢复原价。

目前的实现是利用了秒杀来做，没有对应的后台。之后会考虑更加完善的实现方式。