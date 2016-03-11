### 商家后台开发记录

商家是否是保税区商家的数据库字段 t_pandora_account_group  中的 is_support_bounded  1

```

商家后台的测试库的账号

617471517
12345678
喔喔海购
182615169596909971

61430529684
12345678
爬爬在澳洲
160844237481309969

测试环境的部署.

前端nginx 代理.
10.20.2.67
对大部分inf 域名进行了代理

server {
    listen         80;
    server_name    biz.api.inf.lehe.com;
    access_log     logs/biz.api.access.log;
    error_log      logs/biz.api.error.log ;
    location / {
        proxy_pass http://10.20.3.30:80/;
        proxy_set_header Host "biz.api.lehe.com";
    }
}
```

商品上是否也有保税区标记.
store_type 1, 2,3 1 表示国内发货, 2 表示海外, 3表示保税区.
