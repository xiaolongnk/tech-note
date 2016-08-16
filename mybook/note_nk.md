---
title: 杂记
categories:
- 杂技
tags:
- 杂记
---

latex space
1：http://www.cnblogs.com/ysjxw/archive/2009/10/28/1591098.html

latex insert psu-code
http://blog.sina.com.cn/s/blog_704900700100vyky.html
this blog is nice.
http://www.cnblogs.com/visayafan/archive/2012/06/15/2550344.html#sec-21


sysrq-trigger 调试内核相关的代码还是不能少了这些工具的帮忙。
具体的文档在这里。
http://kernel.org/doc/Documentation/sysrq.txt

还是现在这里写东西吧。然后再整理出来，写成论文。平时多眨眼睛，保护眼睛。

2014-3-6
还有这个，我也不知道是什么意思。
#define likely(x)       __builtin_expect(!!(x), 1)
#define unlikely(x)     __builtin_expect(!!(x), 0)

还有下面这个。
#define panic(fmt, args...)         \
    ({                      \
        sd_emerg("PANIC: " fmt, ##args);    \
        abort();                \
     })

现在算是明白一点了，原来这些命令是和 command 相关联起来的。具体请看
subcommand vid_cmd[] 的定义。

struct subcommand {
    const char *name;
    const char *arg;
    const char *opts;
    const char *desc;
    const struct subcommand *sub;
    unsigned long flags;
    int (*fn)(int, char **);    // 这里就是要执行的函数。
    const struct sd_option *options;
};

对 C 的这种属性，我还是不太熟悉，但是很有兴趣。
看来我对C的了解真是太初级了。
抽象一下这种用法，实际上就是在C的结构中添加函数的方法。 在C++中这可以
很方便的实现，但是在C中，这就需要别的方法了。想到了昨天看到：在本质上，
函数名实际上是一个指针，只想要执行的代码快的开始地址。虽然我的汇编比较
水，但是这写还有一点印象的。


extern 我也写一点吧，说下我的理解吧。如果一个变量在一个头文件中，那么你可以
包含这个头文件，然后使用这个变量，但是如果一个变量不再一个头文件中，在另外
一个c文件中，是一个全局变量，你在当前的文件中想用这个东西，那么你可以在使用
这个变量之前用 extern 声明一下这个变量，然后在当前这个文件中，就可以随使用
这个变量了。

extern struct command vdi_command;
extern struct command node_command;
extern struct command cluster_command;

找到了这几个很重要的变量。 基本上所有的命令的入口都在这里了。
#ifdef HAVE_TRACE
  extern struct command trace_command;
#else
  #define trace_command {} #endif /* HAVE_TRACE */ 


把这些重要的代码都在这里贴出来。看着下面的例子，自己去试吧。
printf()可以输出不同颜色的字符呢，你不知道吧，看下面这个例子。

/* colors */
#define TEXT_NORMAL         "\033[0m"
#define TEXT_BOLD           "\033[1m"
#define TEXT_RED            "\033[0;31m"
#define TEXT_BOLD_RED       "\033[1;31m"
#define TEXT_GREEN          "\033[0;32m"
#define TEXT_BOLD_GREEN     "\033[1;32m"
#define TEXT_YELLOW         "\033[0;33m"
#define TEXT_BOLD_YELLOW    "\033[1;33m"
#define TEXT_BLUE           "\033[0;34m"
#define TEXT_BOLD_BLUE      "\033[1;34m"
#define TEXT_MAGENTA        "\033[0;35m"
#define TEXT_BOLD_MAGENTA   "\033[1;35m"
#define TEXT_CYAN           "\033[0;36m"
#define TEXT_BOLD_CYAN      "\033[1;36m"

printf(TEXT_BOLD_RED "** WARNING: shepherd is still only suitable for "
           "testing and review **" TEXT_NORMAL "\n");



#define CLEAR_SCREEN        "\033[2J"
#define RESET_CURSOR        "\033[1;1H"

static inline void clear_screen(void)
{
    printf(CLEAR_SCREEN);
    printf(RESET_CURSOR);
}

有好多东西，现在看来是有用的，但是会慢慢的变得没用的哦。

工作原理究竟是什么。究竟是怎么工作的。不同的节点之间需要通信，可以存储数据，
数据可以维持3副本。

在端口创建 sheep 的命令已经被我抽象出来了。你需要指定具体的目录，一个
sheep 一个。 
sheep /tmp/sheepdog/4 -z 4 -p 7004 -c local -n -y 127.0.0.1 -d
不知道这个 cluster 中会发生什么。随着 sheep 的离开和加入，看看 log 中会发生
什么。如果有一个 sheep 离开了群，所有的 sheep 应该都知道了，但是他们是怎么
知道的呢。应该是这个 要离开的 sheep 提前通知了 cluster 中所有的 sheep 。
离开之后，数据发生了
变化，然后 cluster 中的每一个 sheep 通过一系列操作，将 cluster 中的数据
维护在了一个新的稳定状态。

cat /dev/urandom 这个是系统随即产生一些数据。可以用来做测试。
我从来都没有见过 把函数当作参数的 函数。今天有幸见识了一下。这个项目真是帮了
我的大忙了。从学长那里去了点东西回来，真是太感谢学长了。其实我的实验思路是
没有问题的，问题可能就是处在我的测试数据上。我的数据太小了，所以没有看到这
些 block 。现在可以查看这些 block 了。现在最主要的任务就是仔细阅读相关的代
码了。然后把自己的那些个需求实现。就可以了。

这就是一个例子。
int install_crash_handler(void (*handler)(int))
{
    return install_sighandler(SIGSEGV, handler, true) ||
        install_sighandler(SIGABRT, handler, true) ||
        install_sighandler(SIGBUS, handler, true) ||
        install_sighandler(SIGILL, handler, true) ||
        install_sighandler(SIGFPE, handler, true);
}

无论如何，多看看开源项目的代码还是很有好处的。

系统具有自平衡性，可以智能地调节 block 的存放 node。使得系统的负载均衡。

static void (*try_to_free_routine)(size_t size) = do_nothing;

try_to_free_t set_try_to_free_routine(try_to_free_t routine)
{
    try_to_free_t old = try_to_free_routine;
    if (!routine)
        routine = do_nothing;
    try_to_free_routine = routine;
    return old;
}

真是长见识了，各种奇葩的写法。原来函数是这么个东西。

typedef void (*try_to_free_t)(size_t);
try_to_free_t set_try_to_free_routine(try_to_free_t);


这个函数怎么使用。
sdport = strtol(optarg, &p, 10);

好好理解这些数据结构。这都是很有价值的学习资料。
又找到了一个核心的数据结构。

struct node_id {
    uint8_t addr[16];
    uint16_t port;
    uint8_t io_addr[16];
    uint16_t io_port;
    uint8_t pad[4];
};

enum sd_status {
    SD_STATUS_OK = 1,
    SD_STATUS_WAIT,
    SD_STATUS_SHUTDOWN,
    SD_STATUS_KILLED,
};

好多数据结构中都有  flags 这个变量，这个是干什么的。
其实没什么，就是告诉这个 command 是不是需要 参数。

rbtree.h 里面是什么呢？ 不就是 red black tree 吗，大名鼎鼎的 红黑树啊。
哈哈，高端吗。能让我有机会看红黑树在文件系统中的实现，真是太好了。开源
项目中的东西太好了，有时间要好好学习下，下一个学习的项目就是 Linux 内核
了。先等我搞完这个。
md.c 里面是负责 往磁盘中写东西的模块。

但是，又有一个新的问题，我如何知道一个 vdi 被分割成了哪些 block。也就是
说 一个 vdi 是由那些 block 组成的，这个信息如何知道。

还要同志其他的  node，保存这些个新的 block， 因为实际上你是打破了 副本数
为 N 这样一个规定的，如何让系统在这种情况下正常运行，是我的设计的关键。

|  运算是一个很重要的运算， 比如 1 和 2 ，1|2==3，实际上和文件系统的 umask
是一样的,简单的位运算，在程序中也可以这样用啊。虽然开始会比较困难，但是慢慢
就好了，看得多了，就习惯了，对C语言的这些用法也就熟悉了。这才是学习的最基本
的途径。用 VIM 不要经常 wq，没什么意义，更不要图方便用什么 h,j,k,l 来控制方向，
至少在 insert 模式下 推出 insert 模式来用这些个方向控制键，这样是得不偿失的。
不是这样用的。

这样写确实有很多好处啊，代码紧凑了很多啊。果然是系统级别的代码。


char *strnumber(uint64_t _size);
typedef void (*vdi_parser_func_t)(uint32_t vid, const char *name,
                  const char *tag, uint32_t snapid,
                  uint32_t flags,
                  const struct sd_inode *i, void *data);
实际上我不理解的是这个 typedef 语句，但是你想一下这是什么意思呢。不就是用一个
来代替另一个吗，和简单的 typedef char Eletype; 能有什么区别呢。
所以我的理解是没有问题的，我可以从代码中找到对我的猜想的佐证。


但是我想从网上找资料，而不是从参考书中。

int parse_vdi(vdi_parser_func_t func, size_t size, void *data);

我不用看红黑树，我要继续看这部分源代码，现在不明白的，多看看就明白了,要休息
了，明天继续。

2014-3-7
又是新的一天，今天要看那些内容呢，今天要取得什么突破呢。别辜负了今天的时间啊。
早上起来有点贪玩了，应该早点开始干活的。早做完早工作啊。

好了，继续工作，继续读代码吧。

sheepdog_proto.c 
里面主要做什么工作。
好像这个里面不仅有 rbtree 还有 btree。

一个 vdi 有多少 object 组成的，这个问题怎么解决。这个问题是在哪里解决的。

对于这个数据结构，还是有很多可以考虑的问题的。讨论下这个数据结构还是很有必要的。

我的想法是这里面规定了一个vdi多做有1024个block 组成。
包括一个 parent_vdi_id 和 一堆
child_vdi_id[] 这样就决定了一个 vdi 的maxsize 是 4G。但是感觉我的猜想是不
正确的。不对，我的
猜想貌似是不正确的。那么这个结构是什么意思呢。
对了，我可以这样，看 vdi read 的命令的执行流程。看有那些可以参考的。
in vdi.c 这是 那些 和 vdi 操作相关的函数的入口，我要从这个地方深入下去。
主要的函数就是下面这两个。

2013-3-9
我要看一下这个函数，
dog vdi setattr
dog vdi getattr 
这两个命令的实现过程。

stdint.h
这个头文件中有什么内容，可以用来做什么。
对于 unsigned long a=222;
这样的数据，用printf输出的时候，format 应该是 lu.

似乎明白了一点，在 vdi 中，block是按照 4M 为最小单位存放的。
void *ptr;
char * buf;
可以这样， buf = (char*) ptr;这样是比较规范的。
按照 ansi 标准，可能必须这样写，但是在GNU标准中，默认的 char* 
和 void * 是一样的，那么他们可以直接相等。
buf = ptr; 这样也是没有问题的。

这里是那个 likely 和 unlikely 的用法。是编译器优化的一个功能。

// x 的直为 1 的可能性更大。
#define likely(x)       __builtin_expect(!!(x), 1)
// x 的直为 0 的可能性更大。
#define unlikely(x)     __builtin_expect(!!(x), 0)

这样做的好处是，对于这些经常执行的代码，可以优化编译，产生效率更高的程序。
http://blog.csdn.net/joker0910/article/details/6670436

malloc() function。
On success, a pointer to the memory block allocated by the function.
The type of this pointer is always void*, which can be cast to the desired type
of data pointer in order to be dereferenceable.
If the function failed to allocate the requested block of memory, a null 
pointer is returned.  

calloc() function
Allocate and zero-initialize array
Allocates a block of memory for an array of num elements, each of them size
bytes long, 
and initializes all its bits to zero.

The effective result is the allocation of a zero-initialized memory block of
(num*size) bytes.

If size is zero, the return value depends on the particular library 
implementation 
(it may or may not be a null pointer), but the returned pointer shall not be dereferenced.

// linux 文件系统系统调用，为文件预分配物理空间。
// include <fcntl.h> return 0 on success -1 on failed.
ret = fallocate(fd, mode, offset, len);

很明显，这个就是 unsigned long long 类型。
#define SD_INODE_DATA_INDEX (1ULL << 20)

这个结构是用来做什么的。并没有看到这个变量在那里被初始化过，vdi_cmd_data 
只是在使用，但是从来都没有出现过。

fsync(STDOUT_FILENO);
ret = EXIT_SUCCESS;
fsync函数同步内存中所有已修改的文件数据到储存设备。参数fd是该进程打开来的文件
描述符。函数成功执行时，返回0。失败返回-1，errno被设为以下的某个值
EBADF： 文件描述词无效
EIO ： 读写的过程中发生错误
EROFS, EINVAL：文件所在的文件系统不支持同步
调用 fsync 可以保证文件的修改时间也被更新。fsync 系统调用可以使您精确的强制每
次写入都被更新到磁盘中。您也可以使用同步（synchronous）I/O 操作打开一个文件，
这将引起所有写数据都立刻被提交到磁盘中。通过在 open 中指定 O_SYNC 标志启用同
步I/O。
还是先来看看什么叫 inode 吧，这些是最基本的东西。搞文件系统怎么能不懂这些呢。
http://www.cnblogs.com/itech/archive/2012/05/15/2502284.html
讲的不错。认真读下。
可以用 stat 命令来插卡一个文件的 inode 信息。
http://www.cnblogs.com/itech/archive/2012/05/15/2502284.html
总之，除了文件名以外的所有文件信息，都存在 inode 之中，至于为什么没有文件名，
下面会有解释。

inode 的大小。
inode 也会消耗硬盘的存储空间，所以格式化硬盘的时候，操作系统自动将硬盘分成两
个区域，一个是数据去，存放文件数据；另一个是inode区，（inode table），存放
inode所包含的信息。查看每个硬盘分区的 inode 总数和已经使用的数量，可以使用
df 命令。

ls -i 可以看到文件名对应的 inode 号码：
unix/Linux 系统中，目录 directory 也是一种文件。打开目录，实际上就是打开目录
文件。
目录文件的结构非常简单，就是一系列目录项 dirent 的列表。每个目录项，由两部分
组成：所包含文件的文件名，以及该文件名对应的 inode 号码。

ls -lh 可以查看某个具体的文件的大小。

上面那个问题在这里可以找到解决方案，就是那个变量在这个时候得到 assignment。
vdi_parser();
这个变量 vdi_cmd_data 并不是必须的。

刚才研究了一下 dog vdi read 和 write 这两个命令。对这个命令的说明，有两个这
样的参数，[offset][<len>] 在很多工具的手册中，都有这样的说明，这是两个可选的
参数。对于一个指定的vdi，可以指定数据的存放地点，然后可以从这个 offset 和 
len 来读出原来存放的数据。对于使用者，只要你知道你的数据的 vdiname offset 
len,那么你就可以拿到你的数据。
这个原理和磁盘管理应该有点像，你的磁盘是连续的，你该怎么管理呢。这个应该就
是一个文件系统。多想想这些实际的问题，想想这些东西都是怎么实现的。

2014-3-11
好吧，我都要伤心死了，我不小心把我的文件删除掉了。真是哭的心都有。

alias rm='rm -i'
不要乱删文件，删除文件一定呀小心。
这是一个 alias 命令的使用说明。读一下。
http://www.hndy1688.com/service-107.html
好像还可以用 debugfs 来恢复文件，但是我的目录又被我一顿该，debugfs 也就不回
来了。失足太多无法挽回。
这个办法也不错，将 rm 的文件存放到垃圾箱里。
http://hi.baidu.com/jlusuoya/item/32ae398958088755840fabfb

sigemptyset, sigaddset, sigproc

http://www.cnblogs.com/leaven/archive/2010/12/26/1917280.html
sigemptyset 函数初始化信号集合set，将 set 设置为空。
sigfillset 也是初始化信号集合，只是将信号集合设置为所有信号的集合。
sigaddset 将信号 signo 加入到信号集合之中，sigdelset 是将信号从信号集合中删除。
sigismember 查询信号是否再信号集合 .s 之中。
sigprocmask 是最为关键的一个函数。再使用之前要先设置好信号集合 set。这个
函数的作用是将制定的信号集合 set 加入到进程的信号阻塞集合之中去，如果提
供了 oset 那么当前的进程信号阻塞集合将会保存在oset里面。

signalfd eventfd timerfd 这些都是 Linux 新的 API。看看下面的 blog。
http://blog.csdn.net/gdutliuyun827/article/details/8470529
这个介绍也不错，可以参考。
http://blog.chinaunix.net/uid-20737871-id-3462879.html

what is the epoll part doing, what is the function of these part.

Function: epoll_event, epoll_ctl(); usage of these functions;
This is a blog about these functions.

epoll_ctl() can be used to control events on a specific file descriptor.
SYNOPSIS. 
#include <sys/epoll.h>

IO event notification facility.
http://hi.baidu.com/cpuramdisk/item/9d64ee1e72e566797b5f2535

I find there is a event tree, rbtoot; event_tree -- to store event in a rbtree.

In C pl, you have to add a struct declaration before every structure body.

static struct event_info *lookup_event(int fd)
{
    struct event_info key = { .fd = fd };

    return rb_search(&events_tree, &key, rb, event_cmp);
}


while (sys->nr_outstanding_reqs != 0 ||
       (sys->cinfo.status != SD_STATUS_KILLED &&
    sys->cinfo.status != SD_STATUS_SHUTDOWN))
    // event_loop(-1) means what!
    event_loop(-1);

Here are some paragraphs that contains pthread.

Good example. for this.

#define main_fn __attribute__((section(MAIN_FN_SECTION)))
#define worker_fn __attribute__((section(WORKER_FN_SECTION)))
#else
#define main_fn
#define worker_fn
#endif

What's the client represent for.


>>>This is request  data structure.

Understant these data structure. Most important.
Notice this method, try best to read one copy and read local first.


Now here is another problem, I need to response to every request in the cluster.
But what data structure should I use to fill the needs. If there is need for some
object, How can I transfer these object to specific nodes. 


Haha, I find another useful command. Vim auto write.
add this in your .vimrc, then you don't need to :w all the time.
vim will save it for you all the time when you leave Insert mode. Good.
au InsertLeave * write


2014-3-12
Time flys so fast, day by day, without any sign.

I see the method, and I find the rules between oid and vid, vid is like
vdi id, oid can be change to vid, just by a function, this is very important,

Look at this function.
static inline uint63_t data_oid_to_idx(uint64_t oid)

This may be helpful.
http://biancheng.dnbcw.info/linux/335839.html

sd_inode.c, look at this filename, what is it means, it is short for
sheepdog inode , and the file's content show me the sheepdog_inode is
stored in a B-tree data structure.
learn from it.

the inode of the cluster was stored in a B-tree data structure.
think about this, consistence hash algorithm. Do you know what is this.
think more about this.

sheepdog_vnode virtual node is something part of consistence hash alg.
sd_vnode;

还有这里面的通信，好像是Socket，根据我的socket 的经验，这个连接会保持多久呢。
是 Tcp 还是 Udp。这个应该再 net.c 中有详细的描述。 如果是这样的话，那么我的论文
结构并不是很合理。

what does farm.c do, in this app.
This file is like a rb-tree data structure.
vdi_entry. all vdi_entry are stored on a rb-tree data structure.


Linux socket programming.
This blog is very nice, good learn material. take a careful look at it.
http://www.cnblogs.com/skynet/archive/2010/12/12/1903949.html

This is about Linux multiple process. good , from the same blog. Thanks.

这里面的
http://www.cnblogs.com/skynet/archive/2010/10/30/1865267.html

这里面也有 socket 的部分，这是 net.c 里面的主要任务，这些都是最底层
的模块，所以，要搞明白，虽然这不是我的重点，但是认真的了解，还是有必要
的。今天就这样，明天继续搞。

2014-3-13
又是新的一天，希望今天能有点突破，能写点东西出来。不要放弃啊，平凡的人类。

This is a basic layer function for request process. Learn how it works.

need_retry is a function, which returns a bool pointer function. in some cases,
this parameters will be null value, and some are specific function.

2014-3-14
假设我现在的工作已经完成了，那么我该怎么写。
写我的工作完成的过程吗？
回想一下这几天，我都干了什么，我做了哪些工作。
我好想一直在读代码，我对 sheepdog 也算是有了一些了解。再这个工程中，学习到了一
些C的用法，这也是我自己比较感兴趣的，但是还有什么呢？有没有学到 和 分布式 存储
系统相关的一些东西呢？

现在不是讨论这些东西的时候了，我需要认真分析一下过程。实现你的思路就可以了。
你看了这么久，你想做的工作应该都可以实现了吧。


考虑添加一个新的功能，再 dog 的开始处，比如 

1：
dog list alarmed
这样可以 列举处 cluster 中所有 alaremed 状态的 node。
我觉着这是一个很不错的想法。这个功能我一定要实现。也就是说我们可以查看哪些节
点有 警告盘。这个时候我们的节点就有了几种可能的状态， alarmed 设置成一种状态
健康状态的节点，dead 的节点。


那么 ，dog 是如何启动的呢，首先，你需要启动你的sheep。再你的sheep启动的过程中，
你做了这些事情，你做了什么事情呢。首先要和集群保持联系。因为你们是在一个局域网
内。似乎要注册什么的，把自己注册再 这个 cluster 中。这样，这个新启动的 node 也
就是这个集群的一员了。
然后这个群内发生着什么事情呢，比如别人发现了 新加入的同学A之后，发现他是新来的
这个 并且有 50G 的空间，而别人都的上面都存放了很多数据。这个时候就会一直有数据
从别的node 发送过来。这样A同学上面的空间很快就会占用，这样，同学A也就算是为这
个集群做了一些贡献。 那么上面说的这些过程他们是怎么实现的呢？
让我们先简单的分析一下这个过程需要哪些技术支持呢？首先这个App 要有一个底层的网络
模块，他们可以遵循一些协议来进行通信。

为什么，你只需要启动 sheep 就可以了，在启动的过程中你可以指定一些参数，
当然可以不指定，用默认的就可以。具体的你要找到这些参数再什么地方。
或者如果指定了，你需要看看存放这个位置的变量再什么地方。然后你需要想办法去
扫描这个目录下的 boj 文件的filename。扫描出来之后存放再一个表里。

至于相互通信这个问题，你没有必要完全搞明白，或者说你可以现在不搞明白是为什么
这样写，因为时间有限，你完了可以仔细研究里面的每一行代码为什么这样写，但是现
再你要面临的是毕业的问题，你需要先写完毕业论文。所以对于这些底层的调用，你可
以学习着去应用这些 底层的 API ，但是仅此而已，你可以膜拜系统的开发者，但是请
记住你的时间有限。

为什么要考虑这个问题，

关于 有没有必要进行数据迁移的想法！

我觉着这个完全没有必要啊！你把这个节点完全删除完全没有影响啊！人家本来就是容错
的啊！

2014-3-16
我们再来想想 sheepdog 中命令的执行过程，每一个命令，都被当做成一个网络请求，发
送到 gateway 中，然后由 gateway 广播出去，注意，这里是广播的形式，广播出去之后
应该是 每一个 node 都收到了这个消息，然后每个 node 都有一个监听消息的线程，在
这个线程中负责处理这样的广播消息。 现在，我想知道这样的线程是在什么地方，是如何
工作的。 因为我要加入新的消息，我必须知道消息处理的一个完整的流程。

现在我来看一下 对一个 普通的 read 广播消息，每一个 node 是如何处理的。这个代码
中一定有详细的实现。

这里面线程还是用到了很多。查查资料，再认真看看。
http://blog.sina.com.cn/s/blog_6ffd3b5c0100mc3n.html

似乎真的看到了一线希望，我找到了这个的工作原理，就是 sheepdog 如何处理来气gway
的 request。原来再 local_process_event 这个方法中。对于受到的响应，都是有这个函
数来 process 的。这个函数应该是在一个线程中被调用的，我应该找到这个地方。

local_process_event(){}

called by:

local_handler(){}

called by:

local_init(){}

and local_init is called here:

This is a structure ignored by me for a long time.

好像一直都忽略了这一点， sheepdog 的集群管理是 基于 corosync 的，但是对于 corosync
我还不是很了解，他们如何协调，才达到的现在的这种效果的呢？
corosyc 再 sheepdog 中的作用是什么。

主要的使用是再 corosync.c 这个文件中。

现在分析一下这个函数，这个是什么意思，具体干了什么。当然我需要进入到
send_message() 里去看个究竟。


这里面有一个 poll 函数，下面是对应的解释。这里面还有其他不错的东西，可以看看。
http://www.cnblogs.com/jack204/archive/2011/10/30/2229331.html

我是不是可以写一篇博客，讲一下我这些天的工作。我对 sheepdog 的一些理解。

tatic __inline__ void atomic_add(int i, atomic_t *v)
{
__asm__ __volatile__(
LOCK "addl %1,%0"
:"=m" (v->counter)
:"ir" (i), "m" (v->counter));
}

asm
我还是很想学习汇编的。我要学好汇编。我要写一个说得过去的 编译器，然后放到 git hub
上。参考文献可以 百度一下。有一个 参考文献生成器，到时候可以一用。

2014-3-17
今天打算把sheepdog的工作流程绘制一下，然后依据这个做一个稍微详细的串讲。
这些东西，写出来也就是 画两张图吧，试着画一下吧。

fsync 函数的用法你知道吗？这个函数是将所有的内存数据同步到存储设备中。
Linux 文件系统可以在数据写入磁盘前现在内存中存几秒，以更高效率的处理磁盘IO。


关于 dog 的描述基本已经完成了。结果还算满意。下面就要开始对 sheep 的描述了。

init_event()
{
    ret = epoll_create();
}
这个里面有和 epoll 相关的东西，这个是开发大规模网络程序的热门人选。Epoll 在
Linux 2.6 中正是引入，和 select 相似，其实都是 IO 多路复用而已，也没有什么神秘
的。

具体的 link 是这个，应该还算不错。
http://blog.csdn.net/sparkliang/article/details/4770655

对应的函数 是
epoll_create()
epoll_ctl()
epoll_wait()
srandom(port);

Linux 异步IO 编程实例。
http://www.kuqin.com/linux/20120908/330333.html
here is a better one. 
http://man7.org/linux/man-pages/man2/eventfd.2.html

what is fork in linux means. search more for it.
this code tell me how to exit the thread you created, with 
exit(EXIT_SUCCESS);
code shows everything.
see cppdir/comm_thread/test.c shows.

总之，这些事件模型也是很重要的一部分。
所有的事件都存放在一个 rb tree里面，增加事件是往这个 rb tree 中加东西，
移除事件是 给这个 rb tree 删除元素。

C 语言中 内存分配的几种方式。
http://www.cppblog.com/sandywin/archive/2011/09/14/155746.html
calloc 适合用来给数组分配空间。并且分配后的空间是初始化过的。都是0;
malloc 适合用来给一个变量分配。
realloc 可以重新分配大小。但是再分配之前，最好是用memset初始化一下。
同时，分配的空间都需要用 free 或者 realloc(p,0) 来释放内存。

这是一个不错的教程。可以让 sheepdog 发挥处真正的作用。这里面对 sheepdog 的分析
也是很不错的。好好看下。
http://my.oschina.net/u/989893/blog/113929

2014-3-18

我只是描述了 dog read 的过程，对于 dog write的过程没有描述，虽然说大致上说都是
一样的，但是还是有不少差别的。所以，这个也是需要写一下的。

现在最应该考虑的是 sheep 的作用。这个sheep启动的过程中似乎最多的就是创建了几个
工作线程。还是用这个比较习惯。就用这个吧。我所看到的 dog 的作用，应该就是直接
像 gateway 发出请求，gateway 受到请求后，才像对应的 note 发出请求，然后每一个
node 上都有工作线程来监听不同的请求，这样，在接听到 gateway 的请求之后，就会进
行响应。采取响应的操作，将响应的数据发送过去。

我对 dog 的分析，分析数据的读的过程中，似乎就是再 gateway 这个层面停下了。至于
gateway 下面是怎么做的，我就没有分析了。好像有点明白了，我搞明白了dog 和 
gateway 的交互，但是对于 sheep 和 gateway 确还没有明白。这应该是我的疑惑的根源
吧。

我好像陷入到代码的实现的细节中去了，当然这不是什么坏事，但是对我来说，对于我做
毕业设计来说，确真的不是什么好事，我承认我如果能搞清楚里面的每一个实现细节，对
我会有很大的帮助，但是，眼下我好像真的没有这么多时间来研究这些。我说要完成我的
程序，但是现在我还连一行代码都没有写，这是什么节奏。

这绝对是一个很好的方法，论文让我真是焦虑，我不知道改写什么，也就这最后的一周
时间了，要是还是写不出什么东西，那我还怎么毕业啊。虽然现在我有些细节部分还不
没有搞明白，但是这些东西是搞不明白的吗？给你两天时间，你仍然搞不明白吗？有这
么难的问题吗？

In the function, send_req(); I focus on the do_write() call;

send,sendmsg,sendto, systemcall.

flags：是以下零个或者多个标志的组合体，可通过or操作连在一起
MSG_DONTROUTE：不要使用网关来发送封包，只发送到直接联网的主机。这个标志主
要用于诊断或者路由程序。
MSG_DONTWAIT：操作不会被阻塞。
MSG_EOR：终止一个记录。
MSG_MORE：调用者有更多的数据需要发送。
MSG_NOSIGNAL：当另一端终止连接时，请求在基于流的错误套接字上不要发送
SIGPIPE信号。
MSG_OOB：发送out-of-band数据(需要优先处理的数据)，同时现行协议必须支持此种.
if flag == 0, then send is equavalent to write.

now, this is the client, and where is the server. I need the server part.

what factor deterimine the number of threads that need to be created?
where is the server side in sheepdog.
what is sheep part doing in the sheepdog.

important files in sheep dir.

ops.c
gateway.c
sheep.c
sheepdog_proto.c


2014-3-20

get_sd_op() is called in below func.

what is your understand to your code, what problems you met in your research?
list them and ask for help from your senior fellow apprentice.
But you should know what you want to know first.

now, think about the handler, once you receive a message, you need a handler
to deal with the message, this is called a handler.

data is in a 4M block, I need to send the block out. I was banned from the game
because I disconnected from the game, but I was sutcked from the server, I did't 
mean to do that. 

2014-05-13 21:02
Tag: 文件管理系统
我想实现一个文件管理系统，用来辅助我的文件管理。我对它的功能有如下的期望：
1：将所有的最重要的文件都存放在这个一个目录A下，目录A的容量不能超过10G。
2：设置一个配置文件，用来指定哪些文件是重要的。
3：每3个小时检查一次将源文件和备份文件进行一次同步，使其保持一致，并记录独立
    的系统日志。


2014-05-23
只能在这里写一点东西了。昨天发现我的编程领域还是太窄，设计到界面的话，基本上是没有
应对能力的，我需要掌握一门自己喜欢的界面语言，选择java，swing。我要认真学习一下。
java 也是需要好好学习的。

重新开了一个kde 的配置文件，这个应该会好一点，前一个的配置文件是旧系统的，似乎老是出问题，
这个不知道能不能好一点。可能是配置文件的问题。其实桌面的配置是很简单的，除了壁纸之外，其他
的都很简单的。

Tag: tomcat7

install tomcat7 eclipse-plugin
还是没有搞好 eclipse 这个IDE，我知道这个东西是很有用的，但是我感觉这个确实很麻烦，还是算了吧。
我只是想学习一下 tomcat 这个东西，先学好这个再说吧。里面有个 examples 和 tomcat7-docs。这应该
够我学习了，读下文档就可以了。
其他的东西在说吧，上次写的那个文档算是帮了一点忙。

哈哈，我刚才学会了 怎么部署一个tomcat应用，我使用 tomcat-admin 实现的。我是从文档中读来的。
只需要解释一下文档就可以了。但是我懒得去做。我还要慢慢研究更多的用法。

我又看了下如何创建工程的文档，发现有点繁琐，还需要创建一个 build.xml 有点小怕了。

2014-06-08 15:07

原来这个和konsole 的字体大小都有关系，我需要将字体设置到10才可以正常显示，现在这样的效果是我
最喜欢的。有重装了一下系统，看来我的东西有没法给他了，只能在等7天了。既然我这么频繁的装系统，
看来我真是应该写一个脚本来处理这些工作了，我的win8又无影无踪了，真是太可惜了。

现在发现了一个新的状态栏，哈哈，看起来很不错吧，airline.果然我是孤陋寡闻啊。

我应该整理一下，将所有需要的东西都整理成一个脚本，然后在系统故障时，我就可以很快的恢复出一个
自己的系统了。不过我最希望的还是我的系统永远不要出那个bug。

Tag: boot-repair

sudo add-apt-repository ppa:yannubuntu/boot-repair && sudo apt-get update
sudo apt-get install -y boot-repair && (boot-repair &)

刚才解决了一个java swing 的问题，虽然只是一个小问题，但总算是做出了我想要的效果。写程序就是这样
吧，我觉着做出自己想要的才是最好的。
安装了 sougoupinyin，我觉着这个比 fcitx 的pinyin强了不少，现在还不错，总之，我对现在的系统非常满
意。现在唯一的缺点是，缺少计划，缺少执行，似乎读书的能力已经没有了。
好吧，时间也差不多了，可以休息了。

我应该将我在 sheepdog 中看到的一些c的用法拿出来测试一下，这样才算是学习了，不然，我花的那些读代码
的时间就算是白费了啊。

2014-06-13 07:33
java 匿名类。还是来一段代码比较直观。
HelloWorld frenchGreeting = new HelloWorld() {
    String name = "tout le monde";
        public void greet() {
            greetSomeone("tout le monde");
        }
        public void greetSomeone(String someone) {
            name = someone;
            System.out.println("Salut " + name);
        }
    };
上面这个就是 匿名类。 new + 类的定义。直接跟上类的定义。
还研究了一下闭包这个东西，我的理解是在函数中嵌套函数，这样里面的函数就可以实用上一层函数的局部
变量了，同时，如果返回外部函数，那么这个函数的局部变量在外面都可以访问了，这样可以实现一定程度的
变量共享。

还看了一下 lambda 表达式，只是看了两个例子，真怎么用，我也不是太懂。

http://www.blogjava.net/wash/archive/2005/12/26/25405.html

刚才重装了一下系统，还算比较顺利，就是又走了一些弯路，刚开始系统是没有安装文泉驿字体的，所以
我的系统中文字体有些是显示方块的，而有些正常，就是部分正常显示，部分不正常显示的。我以为这是
我的旧的配置文件有问题，所以就删掉了旧的配置文件，然后才发现问题还是没有消失，这才知道自己并
没有解决问题，所以觉着我自己走了弯路。其实没有必要，安装好那个文泉驿字体就可以了。
其实就是安装一个字体就可以了。
其实我最需要的是那个功能，就是 hibernate 的功能，我只是增加了一个swap分区。另外现在变成pure
的 kubuntu 了。哈哈，我的swap分区正常了，系统可以用 hibernate 功能了。这太好了。好了，我该睡
觉了。

刚才看了一下那些职位，感觉我还是有些差距啊，我觉着我就先当一个前段工程师吧，web这东西一定不会
衰落下去的，我觉着做这个也不错的，并且我有后端处理的优势，再好好研究一下这些方面，应该是一条
不错的出路，至于 java，我也会好好学习的。

我感觉我有必要买一个好一点的键盘，不过这些都不是必需的，掌握好必需的技术就可以了。要想多挣钱，
只有一个方法，那就是学好技术，技术不很多，一定不要泛，现在我的面基本上可以了，剩下的就是
专精了，现在学好css，html，javascript，jquery，ajax，这些东西学习好就可以了，我觉着可以
的，android的东西，我可以后面再考虑，首先要明确方向，这就是我的方向了。现在掌握了浏览器调试，
那么我可以调试网页了，可以尝试做出漂亮的页面了，虽然现在这不是我的工作，但是这也是我必需掌握
的技能。其实需要的是对计算机的整体的理解，所以我的这些工作都是又必要的，这些都是对我的计算机
素养的培养，所以这些功夫是不会白费的。等我对什么东西又了明确的研究之后，我会拿出来分享的，现
在还需要积累，需要谦虚学习。

memcpy memmove 这两个方法的区别是什么，又没有研究过。这个是最基本的API的学习能力，不可能你以
后遇到的都是自己知道的东西，你需要学会学习新的东西，而不是一味的积累，培养应对变化的能力才是
最重要的。

strtok  split string into tokens. This is important too;
I should learn to read English Docs.
are all important methods;
strspn() 
strstr()
看了下和字符串出理相关的这些函数，有些还不错，但是有些还是很不常用的，所以没有什么用处。但是
多了解一些还是好的，这样在又需求的时候，才知道怎么做比较好。c 是我的内功，这是我学习数据结构
和算法的首选语言，所以一定要掌握好。


Hdoj 试题分类。我要好好学习一下算法，学习c语言，这是我的内功，内功不可不强啊。
http://blog.sina.com.cn/s/blog_93294724010163p8.html

今天学习了一个和 KMP 相关的算法，还有人自告奋勇来告诉我他写的总结。我应该多学习一些这方面
的东西，我应该对这些东西保持兴趣才行，又好多优秀的东西我都需要学习的，因为我是专业的。我有
责任让自己在自己的领域更专业一些，我一定会遇到让自己感到棘手的问题，没有足够的只是储备我是
没有办法很好的解决这些问题的。所以我需要学习。有些事情没有必要刻意安排，顺其自然就可以了。
我喜欢优秀的人，我喜欢把自己的事情做好的人，我欣赏能创造出美好事物的人。而我还不满足这些条
件，我还需要努力。

我在学习基本的算法，我突然忘记了二叉树的遍历是怎么样的了，先序 中序 后续 这三个标准都是根据
二叉树中的根节点来说的。 中左右 左中右 左右中
二叉树的非递归遍历。

我还是应该提醒自己，不要做没有准备的事情，不要做计划之外的事情，既然没有计划，就不要去做。
另外，你需要将事情的计划安排的更好一点。

我差不多快要搬家了，我应该将自己的东西计划计划，不然在搬家的时候，我又要拙计了。

早上学习了LCS。
现在又出现了LIS 这两个都是很基础的算法。都是属于DP的范围，应该好好理解一下，之前的理解都
比较片面。现在应该专门再学习下。

#### C堆栈

http://blog.sina.com.cn/s/blog_6fe0d70d0101c7d9.html
具体地说，现代计算机(串行执行机制)，都直接在代码底层支持栈的数据结构。
这体现在，有专门的寄存器指向栈所在的地址，有专门的机器指令完成数据入栈出栈的操作
和栈不同，堆的数据结构并不是由系统(无论是机器系统还是操作系统)支持的，而是由函数库提供的。基本
的malloc/realloc/free函数维护了一套内部的堆数据结构。当程序使用这些函数去获得新的内存空间时
，这套函数首先试图从内部堆中寻找可用的内存空间，如果没有可以使用的内存空间，则试图利用系统调用来
动态增加程序数据段的内存大小，新分配得到的空间首先被组织进内部堆中去，然后再以适当的形式返回给调
用者。当程序释放分配的内存空间时，这片内存空间被返回内部堆结构中，可能会被适当的处理(比如和其他
空闲空间合并成更大的空闲空间)，以更适合下一次内存分配申请。这套复杂的分配机制实际上相当于一个内
存分配的缓冲池(Cache)，使用这套机制有如下若干原因：
    1. 系统调用可能不支持任意大小的内存分配。有些系统的系统调用只支持固定大小及其倍数的内存
    请求(按页分配)；这样的话对于大量的小内存分类来说会造成浪费。

    2. 系统调用申请内存可能是代价昂贵的。系统调用可能涉及用户态和核心态的转换。

    3. 没有管理的内存分配在大量复杂内存的分配释放操作下很容易造成内存碎片
http://kb.cnblogs.com/page/211181/

Linux 虚拟内存
http://www.cnblogs.com/Thriving-Country/archive/2011/09/18/2180149.html
pmap report memory map of a process.


2014-06-30 20:38

最主要的问题是更新 的时候提示的错误。是还源的时候产生的。
hash sum mismatch。 这个问题之前遇到过，用之前的方法没法解决。不过不要紧，不影响使用。

今天拿到了奖金，只有500块钱，虽说和之前的0相比多了500块钱，但是感觉怎么就这么寒碜呢！！！

这可是我的季度奖金啊。
什么彩票，不管了，今晚一定要好好休息。今晚只能睡觉，随便怎么样。

我的键盘应该明天就到了，我也就这么一点追求了，照顾好自己，生活才刚刚开始。

我应该学会学习新东西，做出一点像样的产品。要大量阅读文档，锻炼自己的英文文档的学习能力。
现在的程度太差了，对于Linux系统中的文档，我应该多学一点，尽量多看看。

2014-07-01 07:51
我想买一个阿里云服务器，再买个域名，做点自己的东西。不然的话，我一直这样搞，也没什么劲。
想想自己丢掉的那些钱，都够买两年的时间了。

我也买个服务器,在上面存放我的资料,然后自动同步之类的.我可以建立一个 git 库,然后每天都将自己的
笔记push上去.这不是挺好的吗.所有的文档我都可以这样做啊.现在在本地就显得比较麻烦.如果丢了就没法
恢复了.
