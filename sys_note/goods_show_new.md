### goods_show 的改进

1. 将首页的数据重新抽象。设想如下。抽象之后，首页只有两种数据，一种是 goods， 一种是position.

container

```
定义：
create t_pandora_container
(
    id int(20) not null auto_increment  ,
    position bigint(20) not null default 0 comment '在首页列表展示的位置，不包括banner',
    container_pic bingint(20) not null default 0 comment '当前容器的图片',
    start_time timestamp not null default '0000-00-00 00:00:00',
    end_time timestamp not null default '0000-00-00 00:00:00',
    type tinyint(4) not null default 1 comment '容器的类型，类型不同，对应值不同',
    value bigint(20) not null default 0 comment '容器对应的值',
    status tinyint(2) not null default 1 comment '1:正常 -1:删除',
    ctime timestamp  not null default CURREMT_TIMESTAMP ,
    ctime timestamp not null default '0000-00-00 00:00:00'
)engine =InnoDB, charset=utf8, auto_increment=1;


应用场景分析

1. 活动  event_id = value
2. banner  banner_id = value
3. 秒杀专题  seckill_event_id = value
4. 街拍专题  event_id = value
5. 商家board board_id = value

if(type == 1){
    do_expand(value)
}else if(type == 2){
    do_expand(value)
}else if(type == 3){
    do_expand(value)
}else if(type == 4){
    do_expand(value)
}

container 表中有几个冗余几字段，这是为了在首页展示不引入额外查询的折衷策略。他们是`container_pic `
和 `start_time` 和 `end_time`.

创建是流程。
1. 创建活动
    活动的数据，在提交时，如果要在首页显示，提示输入首页展示位置，并检测出当前位置的当前内容，
    提示操作人，是否要覆盖，如果有的话。这样，所有的内容都和首页没有关系，所有的内容都可以推送到首页显示。

2. 目前流程的弊病。
    从定义上来讲，给整个系统带来了混乱，很难理解。
    events 表目前结构混乱，从刚开始到现在，已经扩展过很多次，但是现在仍然有力不从心的感觉。
    虽然扩展了多次，但仍然感觉有些不足。但对另一些新增类型则显得过于臃肿。
    
推到首页容器中的类型，必须要有一张图片，开始时间和结束时间（展示的最基本需求）。不打算做历史记录，比如说
1 这个位置，原来存放的是 内容A，一段时间以后，现在B要放在1这个位置，那么contaner还是旧的，只不过B的内容
覆盖了A的内容。以为位置，只能存放一种类型，可能会导致覆盖的问题。 对应的运营后台也会发生变化。

升级的影响太大。

运营后台创建了一个活动，怎么处理呢。
```

##提报活动
```
提报系统最大的方便之处就是提供了一个从商家端收集活动商品的途径。只需要运营人员审核组织即可。
提报活动开始，相当于是秒杀开始，秒杀期间商品价格按照提报价格，相当于我们现在的秒杀价。活动
结束，商品自动恢复原价。这些要求完全符合，需要做的就是给H5提供接口。这部分开发量很小。

对提报活动，只会出现在H5中，如果活动结束了，把H5下掉就可以了，当然活动中的商品价格只能在活
动完全结束之后才恢复原价。如果在运营后台中可以把这个信息显示出来，对整个系统的交互会有比较大
的改进。

如果需要组织一个类似我们的520秒杀的活动，我觉着用这个系统是完全可以的。实现如下:

1. 组织活动，通知商家，商家上报商品。
2. 运营选品，
3. 根据UE设计，提供对应的接口和H5来展现数据。
4. 可能出现的问题，如果商家提报上来的商品不够，要能支持运营自己添加商品来保证活动的正常进行。这个问
   题可以转换为现在的提报系统是否支持运营自己添加商品，如果可以支持，那么这个需求就不需要工作。现在
   这里只能由运营审核，并不能自己操作，添加或这删除什么的。如果加上这些功能，那么可以完全胜任促销的
   需求。

这里有一个想法，就是在商品中的单品详情，或者商品列表中，如果该商品正在参加某个活的那个，
那么给这个商品一个tag，在UI商显示出来。这样不管是商家还是用户都会明白是怎么回事。

```


##商家board
```

1. board并没有图片，如果推荐到首页，这张图片从哪里来。


```

