```
总数
cat normal_send_service.log2016-01-12 | grep -o -E "\([0-9]*," | wc -l

成功的个数 
cat normal_send_service.log2016-01-12 | grep -o -E "\(0," | wc -l

失败的个数

信鸽服务器繁忙
cat normal_send_service.log2016-01-12 | grep -o -E "\(15," | wc -l


APNS 服务器繁忙。
cat normal_send_service.log2016-01-12 | grep -o -E "\(71," | wc -l


字符超限
cat normal_send_service.log2016-01-12 | grep -o -E "\(73," | wc -l

请求过于频繁
cat normal_send_service.log2016-01-12 | grep -o -E "\(76," | wc -l

APNS 证书错误
cat normal_send_service.log2016-01-12 | grep -o -E "\(76," | wc -l

```
利用这些数据基本可以凑出一个报表出来，可以分析出历史数据的情况。

