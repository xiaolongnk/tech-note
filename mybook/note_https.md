### 让NGINX支持SSL
需要编译时支持ssl，可以sbin/nginx -V 来查看confiture参数，如果当时没有支持，那么需要重新编译安装。 编译参数前面已经有一篇文章了。[nginx编译参数](https://blog.nofile.cc/posts/nginx/2016/08/17/note-ng.html),也不用全加，用`--with-http_ssl_module` 就可以了。

### 生成证书
主要参考这个[letsencrypty](https://letsencrypt.org/getting-started/)，可以生成免费证书。 生成方式也很简单，读上面的文章基本就能明白。[ubuntu+nginx](https://certbot.eff.org/#ubuntutrusty-nginx).

1. ubuntu 用户的大致步骤如下：
[shell]
sudo apt-get install software-properties-common
sudo add-apt-repository ppa:certbot/certbot
sudo apt-get update
sudo apt-get install certbot
[/shell]
		
2. 给自己的服务器生成对应的认证文件,需要给每个域名都生成一下，下面指的是3个域名，将里面的`yourpath1.2.3`换成你自己的代码目录就可以。
[shell]
certbot certonly --webroot  -w /yourpath1 -d yourdomain1.com
certbot certonly --webroot  -w /yourpath2 -d yourdomain2.com
certbot certonly --webroot  -w /yourpath3  -d yourdomain3.com
[/shell]

### Automating renewal

1. 上面生成的证书，有效期好像是90天，所以需要到期自己重新renewal一下。方法如下：
[shell]
sudo certbot renew                 // 只有过期才会生成
sudo certbot renew --force-renewal   // 强制重新生成
[/shell]
执行完之后系统中会生成这些文件。
![系统中生成的文件](https://omssgfgqf.qnssl.com/images/2017/05/11/14944638279557.png)

2. 加密文件分析
    每个域名的文件都会放在一个目录里面。live目录中的只是archive目录总文件的一个软链，没重新renew一次，archive中的文件都会多一个，表现为数字后缀的增加。同时live中的软链也会变成最新的有效的文件，软连名称不变，只是指向变成了较新的内容。如果感觉自己的renew有问题，或者renew过程中遇到了问题，可以直接将`/etc/letsencrypt` 这个目录直接删除，重新用上面的步骤重新设置一下我们的域名，然后对应的文件都会重新生成。执行完之后，我们可以通过`sudo certbot certificates` 查看我们的证书的详情，包括证书的存放位置，证书还有多少天过期等信息。
[shell]
sudo certbot certificates
[/shell]
![证书详情](https://omssgfgqf.qnssl.com/images/2017/05/11/14944643659616.png)

### 配置NGINX

1. nginx 配置说明
    配置就不多说了.首先需要配置2个server，监听2个端口。这样可以强制将80端口的请求重定向至443端口。https本身监听的是443端口。最主要的是ssl中间那3行。将步骤2中生成的对应key写在nginx的配置文件里。注意改成你的具体路径。
2. nginx 配置文件示例
[shell]
server {
    listen       443;
    server_name  blog.nofile.cc;

    ssl                  on;
    ssl_certificate      /xxxx/letsencrypt/live/yoursite/fullchain.pem;
    ssl_certificate_key  /xxxx/letsencrypt/live/yoursite/privkey.pem;
   
     location / {
        #这个地方指定被访问的文件夹位置
        root   /your/webroot/;
        index  index.html;
    }
}
server {
    listen      80;
    server_name blog.nofile.cc;
    return 301 https://blog.nofile.cc$request_uri; 
}
[/shell]
配置好之后，重启nginx，应该就可以看到绿色的锁了。

### 参考资料
1. [letsencrypt](https://letsencrypt.org/getting-started/)
