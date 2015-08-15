2015-04-27 11:59
刚才看见那个 favorite 表已经很大了，如果 做一个全表的 total 大概需要2.5s左右。但是因为表中
做了 account_id 和 goods_id 的索引，所以查某个商品的赞过的人和 赞总数还是不太有压力的。这些
接口是否要考虑坐下优化.对每个商品的赞的个数做缓存，如果点赞了，那么清楚这个商品的这个缓存。
但是这个表会一直增长下去，这个问题改怎么应对。

mysql 分表的事情，我一点都不知道，怎么支撑这个表的增长。
一个是减少对表的访问，这个只能通过缓存来做。另一个是hold住表的增长规模。

2015-05-06 17:57
最近 jquery 的问题遇到的比较多，我升级了运营后台系统的jquery，然后发现好多功能都不能使用了。
并且，yii1 默认的juqery 也是比较老的版本，又遇到了若干问题。还好，通过找资料，基本都解决了。
覆盖YII默认的组建中的jquery。

运营后台还有好多地方可以修改，可以完善，希望可以优化那个图片上传的控件，上传完成之后，将上传的
图片现实出来，这样会改善很多，并且，原生的 view 很难看，可以统一搞成一个table，这样会整齐很多。
有人的代码很乱，乱到我根本都不想看，并且一些功能的设计也很有问题，但是这些需求我都不知道。
做好自己。

对YII的了解还是不够，需要更深入的研究一下。
有些事情应该自己主动一些去推进,不用走太多流程。

vim reload your .vimrc in your vim.
use `:so %` if you are editing your .vimrc, else use `:so $YOURVIMRCFILE`

grep no filename output.
grep -h -o your command.

utf8mb4 兼容 utf8 如果数据库报这个错误，应该尝试将字段改成utf8mb4.
General error: 1366 Incorrect string value: '\xF0\x9F\x8F\xBC' for column 'nick_name' at row 1

2015-07-22 18:31
把一个远程分支拿下来。
git checkout -b test origin/test


