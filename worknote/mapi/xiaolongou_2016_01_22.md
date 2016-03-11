## pandora 代码规范梳理

[永杰的分享](https://gitlabserver.meiliworks.com/higo/document/blob/master/uc/%E7%94%A8%E6%88%B7%E4%B8%AD%E5%BF%83%E8%AE%BE%E8%AE%A1.md)

我的想法:  
目前,我们的核心代码pandora,希望对pandora进行一些重构,补充和完善缺失的模块,使pandora变成一个比较完善的框架.  
具体分为下面几步分的工作:  

### 开发工作

1. 接口耗时统计,可以在debug模式下,看到接口的资源消耗,接口总的相应时间,sql查询次数,redis查询响应时间. 默认关闭,用来辅助开发性能分析和线上紧急情况排查       (待开发)  
2. 制定统一的错误码,和错误码描述,编写统一类库.    (待开发)
3. 代码异常监控. 重写Exception.记录日志.    (待开发)  
4. 代码出错,error ,fatal error 发短信.     (因为有现成的,所以暂停开发)  
5. 检查 pandora 的一些基础类库,重新整理,整理到一个指定的目录.   (待开发)  

### pandora项目开发规范

1. class 命名.接口参数全部小写.    
2. 清理一些无效接口,一些难以维护的接口(开发自己维护数据的接口,H5相关的,联系产品,尽快用活动模板页面统一替换).  
3. 代码编写规范,用到的变量请先定义,不要有无效的变量.建议使用统一的(PHPIDE)zendstudio.强制开发环境为E_ALL , 消灭所有的 warning .  
4. package 中分目录管理,不要在package目录下直接创建class文件,这个目录内容太多.    
5. 代码review,提高代码质量.  
6. 代码文件必须使用utf8编码.  
7. 代码中用4个空格代替TAB.  
8. 符号对齐  
>
> ```php
> $this->limit      = intval($this->request->REQUEST['limit']);
> $this->offset     = intval($this->request->REQUEST['offset']);
> $this->start_time = intval($this->request->REQUEST['start_time']);
> $this->end_time   = intval($this->request->REQUEST['end_time']);
> $this->sku_name   = intval($this->request->REQUEST['sku_name']);
> $this->sku_id     = intval($this->request->REQUEST['sku_id']);
> ```

9. 规范代码提交信息,中英文都可以,但是请表述清楚commit的内容.不要出现像fixbugs这种模糊的commit message.可以参考这个[Angular的提交规范](https://docs.google.com/document/d/1QrDFcIiPjSLDn3EL15IJygNPiHORgU1_OOAqWjiDU5Y/edit#heading=h.uci6olwuf96)

10. mob package , library 三层的职能如下.  
>
> ```php
> module
> --- 1. 参数校验,只包含简单的业务逻辑,比如数据组合.对于稍微复杂的逻辑,需要调用package中对应的方法
> ---    不要放在module中实现.
>
> package 
> --- 业务数据组装层,实现比较复杂的逻辑.
> 
> library 
> ---cache
> ------ redis 缓存层分为持久化redisStorage 和 非持久化 redis. 注意设置缓存过期时间,
> ---data
> ------ mysql 获取数据,相当于dao层. 不包含业务逻辑,基本上只是完成sql查询的工作.
> ```
>

11. 代码的注释:

> 
> 对于比较复杂的逻辑,可以简要说明函数的作用,描述下比较核心的思想.
> 如果函数比较简单,可以没有注释.
>

### nginx 层

1. 监测执行时间超过10s,5s的接口.  



