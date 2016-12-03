#
# very simple php framework


### some design rules:

1. all class filename are lowercase.



### simple description for the framework

1. index.php , index of this framework.
2. frame/router.class.php   , router class .
3. frame/request.class.php  , request class.
4. frame/config.class.php   , config class .
5. frame/autoload.class.php , autoloader class.
6. frame/logger.class.php   , logger class.

### dao

dao is lib for storage , such as (mysql , redis , memcached).

1. dao/mysql.class.php
2. dao/redis.class.php
3. dao/memcached.class.php
4. dao/mongodb.class.php
