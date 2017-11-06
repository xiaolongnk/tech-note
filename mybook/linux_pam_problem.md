# Linux chsh problems :'chsh: PAM: Authentication failure'

在Linux上安装zsh 的时候，需要将$USER的shell换成zsh。我们一般都会使用chsh这个工具来操作。
但是操作的时候，遇到了这个问题。当时的案发现场，我保存下来了，如下图。
!(problem)[https://omssgfgqf.qnssl.com/images/2017/11/06/15099394435634.jpeg]

尝试了各种操作，问题还是无法解决，stackoverflow上找遍了，说最多的是要在/etc/shells 中添加
zsh 的路径，但是如上图，我已经尝试过很多遍了，问题仍然无解。

后面无意发现，我的/etc/passwd 文件里root的
>   root:x:0:0:root:/root:zsh

这个说明root的默认shell是zsh，但是这里面的shell应该都写成全路径的，只这样写一个zsh是找不到的。
修改成全路径之后，发现可以正常chsh了。
>   root:x:0:0:root:/root:/usr/bin/zsh

结论：如果你遇到这个问题，可以检查一下/etc/passwd 里面是否有这种无效配置，如果有，改正之后可能会好。
