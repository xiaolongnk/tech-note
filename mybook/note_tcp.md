---
title: tcp简介
date: 2016-10-18 15:21
tags:
- tcp
- network
---

#### tcp简介
TCP协议在不可靠的传输基础上实现了可靠的传输方案。一个tcp连接其实不是一个连接，它也是一个断断续续传输数据的过程，只不过给我们的感觉是有一个连接。要解决可靠传输和数据乱序的问题。

1. 计算机网络四层模型
    1. 应用层(DNS , FTP , SMTP ,HTTP , SSH , TELNET)。
    2. 运输层(tcp,udp)。
    3. 网络层(ip,rip,icmp),路由器，rip协议，路由选择算法。ip地址，子网掩码。
    4. 链路层(arp , rarp)设备驱动程序,以太网协议，以太网,光纤。

2. tcp 协议。
    1. tcp数据报头格式。ack , syn , window , src-port , dest-port.
    2. tcp三次握手，建立链接
    3. 断开链接

3. tcp 的可靠传输的实现原理。
    1. 数据重传机制,数据重传策略。(ACK , SYN , FIN)(SACK selective Acknowledgment)，需要在tcp头部加入新的字段，sack，sack和ack不一样,sack 的含义是，汇报收到的数据碎片,这个协议要求两边都支持sack,linux 下可以通过tcp_sack 来打开这个功能，linux2.4以后默认打开的。超时重传，接收端给发送端的ack确认只会确认最后一个连续的包。快速重传机制。D-SACK(duplicate).
    2. 数据校验，checksum。
    3. tcp 的 rtt(round trip time) 算法， 超时时间。超时时间是根据网络情况，动态变化的。设长了，重发就慢，丢了老半天才重发，没有效率，性能差；设短了，会导致可能并没有丢就重发。于是重发的就快，会增加网络拥塞，导致更多的超时，更多的超时导致更多的重发。所以这个的选择算法也很是重要。

4. tcp拥塞控制和流量控制
    1. tcp 的滑动窗口。tcp 需要知道实际的网络数据处理带宽或是数据处理速度，这样才不会引起网络拥塞，导致丢包。这个window的作用是告诉发送端自己还有多少缓冲区可以用来接收数据,而不会导致接收端处理不过来。所以tcp会根据这个接收方的window来判断接收方可以接受多少数据，不会发送太多的数据，send window 一般是20个字节。滑动窗口一般会被分成4部分，@1已收到ack确认的数据@2已经发送但是还没有收到ack的数据@3在窗口中还没有发出的@4窗口以外的数据。工作过程是，接收端通过窗口滑动机制来控制发送端。发送方的window size 是由接收方告知的。
    2. zero window 客户端的window会被server端给降成0，接收方有了window size之后会通过zwp包来通知发送。



#### 一些关键词

MTU 总共是1500字节。
TCP 头部的内容大概是40个字节，出去头部，一个tcp可以运输的内容大概是1460字节的内容。这就是MSS(max segment size)。
window size
sliding window 
