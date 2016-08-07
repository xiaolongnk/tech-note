Tag: old

latex space
1：http://www.cnblogs.com/ysjxw/archive/2009/10/28/1591098.html

shell use function in other scripts.
source file or do like this; . otherscripts;

commands with sheepdog. 
test/functional/ is a test dir. Containing many useful test scripts.
goog understanding to them will help you to understant the whole system.

latex insert psu-code
http://blog.sina.com.cn/s/blog_704900700100vyky.html
this blog is nice.
http://www.cnblogs.com/visayafan/archive/2012/06/15/2550344.html#sec-21


sysrq-trigger 调试内核相关的代码还是不能少了这些工具的帮忙。
具体的文档在这里。
http://kernel.org/doc/Documentation/sysrq.txt

还是现在这里写东西吧。然后再整理出来，写成论文。平时多眨眼睛，保护眼睛。

下面这样的写法，我真没有见过，也不知道C代码可以写成这样。
/*
 * Functions that update global info must be called in the main
 * thread.  Add main_fn markers to such functions.
 *
 * Functions that can sleep (e.g. disk I/Os or network I/Os) must be
 * called in the worker threads.  Add worker_fn markers to such
 * functions.
 */
#ifdef HAVE_TRACE
#define MAIN_FN_SECTION ".sd_main"
#define WORKER_FN_SECTION ".sd_worker"

#define main_fn __attribute__((section(MAIN_FN_SECTION)))
#define worker_fn __attribute__((section(WORKER_FN_SECTION)))
#else
#define main_fn
#define worker_fn
#endif

This is an example.

main_fn void sd_accept_handler(const struct sd_node *joined,
                   const struct rb_root *nroot, size_t nr_nodes,
                   const void *opaque)
{
    const struct cluster_info *cinfo = opaque;
    struct sd_node *n;

    if (node_is_local(joined) && !cluster_join_check(cinfo)) {
        sd_err("failed to join Sheepdog");
        exit(1);
    }

    cluster_info_copy(&sys->cinfo, cinfo);

    sd_debug("join %s", node_to_str(joined));
    rb_for_each_entry(n, nroot, rb) {
        sd_debug("%s", node_to_str(n));
    }

    if (sys->cinfo.status == SD_STATUS_SHUTDOWN)
        return;

    update_cluster_info(cinfo, joined, nroot, nr_nodes);

    if (node_is_local(joined))
        /* this output is used for testing */
        sd_debug("join Sheepdog cluster");
}

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
sys/stat.h
mkdir

/* Return EEXIST when path exists but not a directory */
int xmkdir(const char *pathname, mode_t mode)
{
    if (mkdir(pathname, mode) < 0) {
        struct stat st;

        if (errno != EEXIST)
            return -1;

        if (stat(pathname, &st) < 0)
            return -1;

        if (!S_ISDIR(st.st_mode)) {
            errno = EEXIST;
            return -1;
        }
    }
  return 0;
}


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

static void do_nothing(size_t size)
{
}

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

这是一个 非常基本的数据结构，但是是用来干什么的呢。
struct sd_inode {
    char name[SD_MAX_VDI_LEN];
    char tag[SD_MAX_VDI_TAG_LEN];
    uint64_t create_time;
    uint64_t snap_ctime;
    uint64_t vm_clock_nsec;
    uint64_t vdi_size;
    uint64_t vm_state_size;
    uint8_t  copy_policy;
    uint8_t  store_policy;
    uint8_t  nr_copies;
    uint8_t  block_size_shift;
    uint32_t snap_id;
    uint32_t vdi_id;
    uint32_t parent_vdi_id;
    uint32_t child_vdi_id[MAX_CHILDREN];
    uint32_t data_vdi_id[SD_INODE_DATA_INDEX];
    uint32_t btree_counter;
};

我的想法是这里面规定了一个vdi多做有1024个block 组成。
包括一个 parent_vdi_id 和 一堆
child_vdi_id[] 这样就决定了一个 vdi 的maxsize 是 4G。但是感觉我的猜想是不
正确的。不对，我的
猜想貌似是不正确的。那么这个结构是什么意思呢。
对了，我可以这样，看 vdi read 的命令的执行流程。看有那些可以参考的。

in vdi.c 这是 那些 和 vdi 操作相关的函数的入口，我要从这个地方深入下去。

static struct subcommand vdi_cmd[] = {
    {"check", "<vdiname>", "saph", "check and repair image's consistency",
     NULL, CMD_NEED_NODELIST|CMD_NEED_ARG,
     vdi_check, vdi_options},
    {"create", "<vdiname> <size>", "Pycaphrv", "create an image",
     NULL, CMD_NEED_NODELIST|CMD_NEED_ARG,
     vdi_create, vdi_options},
    {"snapshot", "<vdiname>", "saphrv", "create a snapshot",
     NULL, CMD_NEED_ARG,
     vdi_snapshot, vdi_options},
    {"clone", "<src vdi> <dst vdi>", "sPcaphrv", "clone an image",
     NULL, CMD_NEED_ARG,
     vdi_clone, vdi_options},
    {"delete", "<vdiname>", "saph", "delete an image",
     NULL, CMD_NEED_ARG,
     vdi_delete, vdi_options},
    {"rollback", "<vdiname>", "saphfrv", "rollback to a snapshot",
     NULL, CMD_NEED_ARG,
     vdi_rollback, vdi_options},
    {"list", "[vdiname]", "aprh", "list images",
     NULL, 0, vdi_list, vdi_options},
    {"tree", NULL, "aph", "show images in tree view format",
     NULL, 0, vdi_tree, vdi_options},
    {"graph", NULL, "aph", "show images in Graphviz dot format",
     NULL, 0, vdi_graph, vdi_options},
    {"object", "<vdiname>", "isaph", "show object information in the image",
     NULL, CMD_NEED_NODELIST|CMD_NEED_ARG,
     vdi_object, vdi_options},
    {"track", "<vdiname>", "isaph", "show the object epoch trace in the image",
     NULL, CMD_NEED_NODELIST|CMD_NEED_ARG,
     vdi_track, vdi_options},
    {"setattr", "<vdiname> <key> [value]", "dxaph", "set a VDI attribute",
     NULL, CMD_NEED_ARG,
     vdi_setattr, vdi_options},
    {"getattr", "<vdiname> <key>", "aph", "get a VDI attribute",
     NULL, CMD_NEED_ARG,
     vdi_getattr, vdi_options},
    {"resize", "<vdiname> <new size>", "aph", "resize an image",
     NULL, CMD_NEED_ARG,
     vdi_resize, vdi_options},
    {"read", "<vdiname> [<offset> [<len>]]", "saph", "read data from an image",
     NULL, CMD_NEED_ARG,
     vdi_read, vdi_options},
    {"write", "<vdiname> [<offset> [<len>]]", "apwh", "write data to an image",
     NULL, CMD_NEED_ARG,
     vdi_write, vdi_options},
    {"backup", "<vdiname> <backup>", "sFaph", "create an incremental backup between two snapshots",
     NULL, CMD_NEED_NODELIST|CMD_NEED_ARG,
     vdi_backup, vdi_options},
    {"restore", "<vdiname> <backup>", "saph", "restore snapshot images from a backup",
     NULL, CMD_NEED_NODELIST|CMD_NEED_ARG,
     vdi_restore, vdi_options},
    {"cache", "<vdiname>", "saph", "Run 'dog vdi cache' for more information",
     vdi_cache_cmd, CMD_NEED_ARG,
     vdi_cache, vdi_options},
    {NULL,},
};

主要的函数就是下面这两个。

static int vdi_read(int argc, char **argv)
{
}
static int vdi_write(int argc, char **argv)
{
}

今天的主要任务就是 吃透这两个函数。

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
static struct vdi_cmd_data {
    unsigned int index;
    int snapshot_id;
    char snapshot_tag[SD_MAX_VDI_TAG_LEN];
    bool exclusive;
    bool delete;
    bool prealloc;
    int nr_copies;
    bool writeback;
    int from_snapshot_id;
    char from_snapshot_tag[SD_MAX_VDI_TAG_LEN];
    bool force;
    uint8_t copy_policy;
    uint8_t store_policy;
} vdi_cmd_data = { ~0, };



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

这些是系统中规定的信号。这些信号是干什么用的。
/* Signals.  */
#define SIGHUP      1   /* Hangup (POSIX).  */
#define SIGINT      2   /* Interrupt (ANSI).  */
#define SIGQUIT     3   /* Quit (POSIX).  */
#define SIGILL      4   /* Illegal instruction (ANSI).  */
#define SIGTRAP     5   /* Trace trap (POSIX).  */
#define SIGABRT     6   /* Abort (ANSI).  */
#define SIGIOT      6   /* IOT trap (4.2 BSD).  */
#define SIGBUS      7   /* BUS error (4.2 BSD).  */
#define SIGFPE      8   /* Floating-point exception (ANSI).  */
#define SIGKILL     9   /* Kill, unblockable (POSIX).  */
#define SIGUSR1     10  /* User-defined signal 1 (POSIX).  */
#define SIGSEGV     11  /* Segmentation violation (ANSI).  */
#define SIGUSR2     12  /* User-defined signal 2 (POSIX).  */
#define SIGPIPE     13  /* Broken pipe (POSIX).  */
#define SIGALRM     14  /* Alarm clock (POSIX).  */
#define SIGTERM     15  /* Termination (ANSI).  */
#define SIGSTKFLT   16  /* Stack fault.  */
#define SIGCLD      SIGCHLD /* Same as SIGCHLD (System V).  */
#define SIGCHLD     17  /* Child status has changed (POSIX).  */
#define SIGCONT     18  /* Continue (POSIX).  */
#define SIGSTOP     19  /* Stop, unblockable (POSIX).  */
#define SIGTSTP     20  /* Keyboard stop (POSIX).  */
#define SIGTTIN     21  /* Background read from tty (POSIX).  */
#define SIGTTOU     22  /* Background write to tty (POSIX).  */
#define SIGURG      23  /* Urgent condition on socket (4.2 BSD).  */
#define SIGXCPU     24  /* CPU limit exceeded (4.2 BSD).  */
#define SIGXFSZ     25  /* File size limit exceeded (4.2 BSD).  */
#define SIGVTALRM   26  /* Virtual alarm clock (4.2 BSD).  */
#define SIGPROF     27  /* Profiling alarm clock (4.2 BSD).  */
#define SIGWINCH    28  /* Window size change (4.3 BSD, Sun).  */
#define SIGPOLL     SIGIO   /* Pollable event occurred (System V).  */
#define SIGIO       29  /* I/O now possible (4.2 BSD).  */
#define SIGPWR      30  /* Power failure restart (System V).  */
#define SIGSYS      31  /* Bad system call.  */
#define SIGUNUSED   31

sigemptyset(&mask);
sigaddset(&mask, SIGTERM);
sigprocmask(SIG_BLOCK, &mask, NULL);

How does this function work.

Avoid chinese in my documentation.
static inline int register_event(int fd, event_handler_t h, void *data)
{
    return register_event_prio(fd, h, data, EVENT_PRIO_DEFAULT);
}

How does this work.

int register_event_prio(int fd, event_handler_t h, void *data, int prio)
{
    int ret;
    struct epoll_event ev;
    struct event_info *ei;

    ei = xzalloc(sizeof(*ei));
    ei->fd = fd;
    ei->handler = h;
    ei->data = data;
    ei->prio = prio;

    memset(&ev, 0, sizeof(ev));
    ev.events = EPOLLIN;
    ev.data.ptr = ei;

    ret = epoll_ctl(efd, EPOLL_CTL_ADD, fd, &ev);
    if (ret) {
        sd_err("failed to add epoll event: %m");
        free(ei);
    } else
        rb_insert(&events_tree, ei, rb, event_cmp);

    return ret;
}

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

struct request {
    struct sd_req rq;
    struct sd_rsp rp;

    const struct sd_op_template *op;

    void *data;
    unsigned int data_length;

    struct client_info *ci;
    struct list_node request_list;
    struct list_node pending_list;

    refcnt_t refcnt;
    bool local;
    int local_req_efd;

    uint64_t local_oid;

    struct vnode_info *vinfo;

    struct work work;
    enum REQUST_STATUS status;
    bool stat; /* true if this request is during stat */
};

Understant these data structure. Most important.

struct system_info {
    struct cluster_driver *cdrv;
    const char *cdrv_option;

    struct sd_node this_node;

    struct cluster_info cinfo;

    uint64_t disk_space;

    DECLARE_BITMAP(vdi_inuse, SD_NR_VDIS);

    int local_req_efd;

    pthread_mutex_t local_req_lock;
    struct list_head local_req_queue;
    struct list_head req_wait_queue;
    int nr_outstanding_reqs;

    bool gateway_only;
    bool nosync;

    struct work_queue *net_wqueue;
    struct work_queue *gateway_wqueue;
    struct work_queue *io_wqueue;
    struct work_queue *deletion_wqueue;
    struct work_queue *recovery_wqueue;
    struct work_queue *recovery_notify_wqueue;
    struct work_queue *block_wqueue;
    struct work_queue *oc_reclaim_wqueue;
    struct work_queue *oc_push_wqueue;
    struct work_queue *md_wqueue;
#ifdef HAVE_HTTP
    struct work_queue *http_wqueue;
#endif

    bool enable_object_cache;

    uint32_t object_cache_size;
    bool object_cache_directio;

    uatomic_bool use_journal;
    bool backend_dio;
    /* upgrade data layout before starting service if necessary*/
    bool upgrade;
    struct sd_stat stat;
};

struct siocb {
    uint32_t epoch;
    void *buf;
    uint32_t length;
    uint32_t offset;
    uint8_t ec_index;
    uint8_t copy_policy;
};

/* This structure is used to pass parameters to vdi_* functions. */
struct vdi_iocb {
    const char *name;
    const char *tag;
    uint32_t data_len;
    uint64_t size;
    uint32_t base_vid;
    uint32_t snapid;
    bool create_snapshot;
    uint8_t copy_policy;
    uint8_t store_policy;
    uint8_t nr_copies;
    uint64_t time;
};

/* This structure is used to get information from sheepdog. */
struct vdi_info {
    uint32_t vid;
    uint32_t snapid;
    uint32_t free_bit;
    uint64_t create_time;
};

struct vdi_state {
    uint32_t vid;
    uint8_t nr_copies;
    uint8_t snapshot;
    uint8_t copy_policy;
    uint8_t _pad;
};

struct store_driver {
    struct list_node list;
    const char *name;
    int (*init)(void);
    bool (*exist)(uint64_t oid);
    /* create_and_write must be an atomic operation*/
    int (*create_and_write)(uint64_t oid, const struct siocb *);
    int (*write)(uint64_t oid, const struct siocb *);
    int (*read)(uint64_t oid, const struct siocb *);
    int (*format)(void);
    int (*remove_object)(uint64_t oid);
    int (*get_hash)(uint64_t oid, uint32_t epoch, uint8_t *sha1);
    /* Operations in recovery */
    int (*link)(uint64_t oid, uint32_t tgt_epoch);
    int (*update_epoch)(uint32_t epoch);
    int (*purge_obj)(void);
    /* Operations for snapshot */
    int (*cleanup)(void);
};

This local_req_handler, this may what I want for a long time.
static void local_req_handler(int listen_fd, int events, void *data)

This function is part of this function.

void local_req_init(void)
{
    ....
    register_event(sys->local_req_efd, local_req_handler,NULL);
}

Notice this method, try best to read one copy and read local first.

/*
 * Try our best to read one copy and read local first.
 * Return success if any read succeed. We don't call gateway_forward_request()
 * because we only read once.
 */
static int gateway_replication_read(struct request *req)
{
    int i, ret = SD_RES_SUCCESS;
    struct sd_req fwd_hdr;
    struct sd_rsp *rsp = (struct sd_rsp *)&fwd_hdr;
    const struct sd_vnode *v;
    const struct sd_vnode *obj_vnodes[SD_MAX_COPIES];
    uint64_t oid = req->rq.obj.oid;
    int nr_copies, j;

    nr_copies = get_req_copy_number(req);

    oid_to_vnodes(oid, &req->vinfo->vroot, nr_copies, obj_vnodes);
    for (i = 0; i < nr_copies; i++) {
        v = obj_vnodes[i];
        if (!vnode_is_local(v))
            continue;
        ret = peer_read_obj(req);
        if (ret == SD_RES_SUCCESS)
            goto out;

        sd_err("local read %"PRIx64" failed, %s", oid,
               sd_strerror(ret));
        break;
    }

    /*
     * Read random copy from cluster for better load balance, useful for
     * reading base VM's COW objects
     */
    j = random();
    for (i = 0; i < nr_copies; i++) {
        int idx = (i + j) % nr_copies;

        v = obj_vnodes[idx];
        if (vnode_is_local(v))
            continue;
        /*
         * We need to re-init it because rsp and req share the same
         * structure.
         */
        gateway_init_fwd_hdr(&fwd_hdr, &req->rq);
        ret = sheep_exec_req(&v->node->nid, &fwd_hdr, req->data);
        if (ret != SD_RES_SUCCESS)
            continue;

        /* Read success */
        memcpy(&req->rp, rsp, sizeof(*rsp));
        break;
    }
out:
    return ret;
}

Now here is another problem, I need to response to every request in the cluster.
But what data structure should I use to fill the needs. If there is need for some
object, How can I transfer these object to specific nodes. 


Haha, I find another useful command. Vim auto write.
add this in your .vimrc, then you don't need to :w all the time.
vim will save it for you all the time when you leave Insert mode. Good.
au InsertLeave * write


How to use this design type.
/*
 * Object ID rules
 *
 *  0 - 31 (32 bits): data object space
 * 32 - 55 (24 bits): VDI object space
 * 56 - 59 ( 4 bits): reserved VDI object space
 * 60 - 63 ( 4 bits): object type indentifier space
 */

These methods may be helpful. Master them.
int gateway_read_obj(struct request *req)
{
    uint64_t oid = req->rq.obj.oid;

    if (!bypass_object_cache(req))
        return object_cache_handle_request(req);

    if (is_erasure_oid(oid))
        return gateway_forward_request(req);
    else
        return gateway_replication_read(req);
}

int gateway_write_obj(struct request *req)
{
    uint64_t oid = req->rq.obj.oid;

    if (oid_is_readonly(oid))
        return SD_RES_READONLY;

    if (!bypass_object_cache(req))
        return object_cache_handle_request(req);

    return gateway_forward_request(req);
}

The gateway part is very useful, but how.

This is wonderful. Great tools. Like a Greate IDE.

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

static inline const struct sd_vnode *
oid_to_vnode(uint64_t oid, struct rb_root *root, int copy_idx)
{
    const struct sd_vnode *vnodes[SD_MAX_COPIES];

    oid_to_vnodes(oid, root, copy_idx + 1, vnodes);

    return vnodes[copy_idx];
}

static inline const struct sd_node *
oid_to_node(uint64_t oid, struct rb_root *root, int copy_idx)
{
    const struct sd_vnode *vnode;

    vnode = oid_to_vnode(oid, root, copy_idx);

    return vnode->node;
}

static inline void oid_to_nodes(uint64_t oid, struct rb_root *root,
                int nr_copies,
                const struct sd_node **nodes)
{
    const struct sd_vnode *vnodes[SD_MAX_COPIES];

    oid_to_vnodes(oid, root, nr_copies, vnodes);
    for (int i = 0; i < nr_copies; i++)
        nodes[i] = vnodes[i]->node;
}

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


int exec_req(int sockfd, struct sd_req *hdr, void *data,
         bool (*need_retry)(uint32_t epoch), uint32_t epoch,
         uint32_t max_count)
{
    int ret;
    struct sd_rsp *rsp = (struct sd_rsp *)hdr;
    unsigned int wlen, rlen;

    if (hdr->flags & SD_FLAG_CMD_WRITE) {
        wlen = hdr->data_length;
        rlen = 0;
    } else {
        wlen = 0;
        rlen = hdr->data_length;
    }

    // 发送消息，正常返回0；
    if (send_req(sockfd, hdr, data, wlen, need_retry, epoch, max_count))
        return 1;
    // 接收消息响应，真长返回0;
    // 所有的 int 的返回状态都遵循这个规定，0 为正常，非零表示异常。
    // 再 C 中是一个一般性的规定。
    ret = do_read(sockfd, rsp, sizeof(*rsp), need_retry, epoch, max_count);
    if (ret) {
        sd_err("failed to read a response");
        return 1;
    }

    if (rlen > rsp->data_length)
        rlen = rsp->data_length;

    if (rlen) {
        ret = do_read(sockfd, data, rlen, need_retry, epoch, max_count);
        if (ret) {
            sd_err("failed to read the response data");
            return 1;
        }
    }

    return 0;
}

bool sheep_need_retry(uint32_t epoch)
{
        return sys_epoch() == epoch;
}

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

static struct cluster_driver cdrv_local = {
    .name       = "local",
    .init       = local_init,
    .get_local_addr = local_get_local_addr,
    .join       = local_join,
    .leave      = local_leave,
    .notify     = local_notify,
    .block      = local_block,
    .unblock    = local_unblock,
    .init_lock  = local_init_lock,
    .lock       = local_lock,
    .unlock     = local_unlock,
    .update_node    = local_update_node,
};

Below is the structure in detail.

struct cluster_driver {
    const char *name;

    /*
     * Initialize the cluster driver
     *
     * Returns zero on success, -1 on error.
     */
    int (*init)(const char *option);

    /*
     * Get a node ID for this sheep.
     *
     * Gets and ID that is used in all communication with other sheep,
     * which normally would be a string formatted IP address.
     *
     * Returns zero on success, -1 on error.
     */
    int (*get_local_addr)(uint8_t *myaddr);

    /*
     * Join the cluster
     *
     * This function is used to join the cluster, and notifies a join
     * event to all the nodes.  The copy of 'opaque' is passed to
     * sd_join_handler() and sd_accept_handler().
     *
     * sd_join_handler() must be called on at least one node which already
     * paticipates in the cluster.  If the content of 'opaque' is changed in
     * sd_join_handler(), the updated 'opaque' must be passed to
     * sd_accept_handler().
     *
     * Returns zero on success, -1 on error
     */
    int (*join)(const struct sd_node *myself, void *opaque,
            size_t opaque_len);

    /*
     * Leave the cluster
     *
     * This function is used to leave the cluster, and notifies a
     * leave event to all the nodes.  The cluster driver calls event
     * handlers even after this function is called, so the left node can
     * work as a gateway.
     *
     * Returns zero on success, -1 on error
     */
    int (*leave)(void);

    /*
     * Notify a message to all nodes in the cluster
     *
     * This function sends 'msg' to all the nodes.  The notified messages
     * can be read through sd_notify_handler() and totally ordered with
     * node change events.
     *
     * Returns SD_RES_XXX
     */
    int (*notify)(void *msg, size_t msg_len);

    /*
     * Send a message to all nodes to block further events.
     *
     * Once the cluster driver has ensured that events are blocked on all
     * nodes it needs to call sd_block_handler() on the node where ->block
     * was called.
     *
     * Returns SD_RES_XXX
     */
    int (*block)(void);

    /*
     * Unblock events on all nodes, and send a total order message
     * to all nodes.
     *
     * Returns SD_RES_XXX
     */
    int (*unblock)(void *msg, size_t msg_len);

    /*
     * Init a distributed mutually exclusive lock to avoid race condition
     * when the whole sheepdog cluster process one exclusive resource.
     *
     * This function use 'lock_id' as the id of this distributed lock.
     * A thread can create many locks in one sheep daemon.
     *
     * Returns SD_RES_XXX
     */
    int (*init_lock)(struct cluster_lock *lock, uint64_t lock_id);

    /*
     * Acquire the distributed lock.
     *
     * The cluster_lock referenced by 'lock' shall be locked by calling
     * cluster->lock(). If the cluster_lock is already locked, the calling
     * thread shall block until the cluster_lock becomes available.
     */
    void (*lock)(struct cluster_lock *lock);

    /*
     * Release the distributed lock.
     *
     * If the owner of the cluster_lock release it (or the owner is
     * killed by accident), zookeeper will trigger zk_watch() which will
     * wake up all waiting threads to compete new owner of the lock
     */
    void (*unlock)(struct cluster_lock *lock);

    /*
     * Update the specific node in the driver's private copy of nodes
     *
     * Returns SD_RES_XXX
     */
    int (*update_node)(struct sd_node *);

    struct list_node list;
};


好像一直都忽略了这一点， sheepdog 的集群管理是 基于 corosync 的，但是对于 corosync
我还不是很了解，他们如何协调，才达到的现在的这种效果的呢？
corosyc 再 sheepdog 中的作用是什么。

主要的使用是再 corosync.c 这个文件中。

现在分析一下这个函数，这个是什么意思，具体干了什么。当然我需要进入到
send_message() 里去看个究竟。

static int corosync_notify(void *msg, size_t msg_len)
{
    return send_message(COROSYNC_MSG_TYPE_NOTIFY, &this_node, NULL, 0, msg,
                msg_len);
}


static void cdrv_cpg_deliver(cpg_handle_t handle,
                 const struct cpg_name *group_name,
                 uint32_t nodeid, uint32_t pid,
                 void *msg, size_t msg_len)
{
    struct corosync_event *cevent;
    struct corosync_message *cmsg = msg;

    sd_debug("%d", cmsg->type);

    switch (cmsg->type) {
    case COROSYNC_MSG_TYPE_JOIN:
        cevent = update_event(COROSYNC_EVENT_TYPE_JOIN, &cmsg->sender,
                      cmsg->msg, cmsg->msg_len);
        if (!cevent)
            break;

        cevent->sender = cmsg->sender;
        cevent->msg_len = cmsg->msg_len;
        break;
    case COROSYNC_MSG_TYPE_UNBLOCK:
        cevent = update_event(COROSYNC_EVENT_TYPE_BLOCK, &cmsg->sender,
                      cmsg->msg, cmsg->msg_len);
        if (cevent) {
            list_del(&cevent->list);
            free(cevent->msg);
            free(cevent);
        }
        /* fall through */
    case COROSYNC_MSG_TYPE_BLOCK:
    case COROSYNC_MSG_TYPE_NOTIFY:
    case COROSYNC_MSG_TYPE_UPDATE_NODE:
        cevent = xzalloc(sizeof(*cevent));
        switch (cmsg->type) {
        case COROSYNC_MSG_TYPE_BLOCK:
            cevent->type = COROSYNC_EVENT_TYPE_BLOCK;
            break;
        case COROSYNC_MSG_TYPE_UPDATE_NODE:
            cevent->type = COROSYNC_EVENT_TYPE_UPDATE_NODE;
            break;
        default:
            cevent->type = COROSYNC_EVENT_TYPE_NOTIFY;
            break;
        }

        cevent->sender = cmsg->sender;
        cevent->msg_len = cmsg->msg_len;
        if (cmsg->msg_len) {
            cevent->msg = xzalloc(cmsg->msg_len);
            memcpy(cevent->msg, cmsg->msg, cmsg->msg_len);
        } else
            cevent->msg = NULL;

        queue_event(cevent);
        break;
    case COROSYNC_MSG_TYPE_LEAVE:
        cevent = xzalloc(sizeof(*cevent));
        cevent->type = COROSYNC_EVENT_TYPE_LEAVE;
        cevent->sender = cmsg->sender;
        cevent->msg_len = cmsg->msg_len;
        if (cmsg->msg_len) {
            cevent->msg = xzalloc(cmsg->msg_len);
            memcpy(cevent->msg, cmsg->msg, cmsg->msg_len);
        } else
            cevent->msg = NULL;

        queue_event(cevent);
        break;
    case COROSYNC_MSG_TYPE_ACCEPT:
        cevent = update_event(COROSYNC_EVENT_TYPE_JOIN, &cmsg->sender,
                      cmsg->msg, cmsg->msg_len);
        if (!cevent)
            break;

        cevent->type = COROSYNC_EVENT_TYPE_ACCEPT;
        cevent->nr_nodes = cmsg->nr_nodes;
        memcpy(cevent->nodes, cmsg->nodes,
               sizeof(*cmsg->nodes) * cmsg->nr_nodes);

        break;
    }

    __corosync_dispatch();
}

上面这个问题中，其实最终的处理还是交给一系列的 handler 来处理的。最终解决问题的
应该是这个过程。

The next process, they call a serious important processes.

static void cdrv_cpg_deliver(cpg_handle_t handle,
                 const struct cpg_name *group_name,
                 uint32_t nodeid, uint32_t pid,
                 void *msg, size_t msg_len)
{
    struct corosync_event *cevent;
    struct corosync_message *cmsg = msg;

    sd_debug("%d", cmsg->type);

    switch (cmsg->type) {
    case COROSYNC_MSG_TYPE_JOIN:
        cevent = update_event(COROSYNC_EVENT_TYPE_JOIN, &cmsg->sender,
                      cmsg->msg, cmsg->msg_len);
        if (!cevent)
            break;

        cevent->sender = cmsg->sender;
        cevent->msg_len = cmsg->msg_len;
        break;
    case COROSYNC_MSG_TYPE_UNBLOCK:
        cevent = update_event(COROSYNC_EVENT_TYPE_BLOCK, &cmsg->sender,
                      cmsg->msg, cmsg->msg_len);
        if (cevent) {
            list_del(&cevent->list);
            free(cevent->msg);
            free(cevent);
        }
        /* fall through */
    case COROSYNC_MSG_TYPE_BLOCK:
    case COROSYNC_MSG_TYPE_NOTIFY:
    case COROSYNC_MSG_TYPE_UPDATE_NODE:
        cevent = xzalloc(sizeof(*cevent));
        switch (cmsg->type) {
        case COROSYNC_MSG_TYPE_BLOCK:
            cevent->type = COROSYNC_EVENT_TYPE_BLOCK;
            break;
        case COROSYNC_MSG_TYPE_UPDATE_NODE:
            cevent->type = COROSYNC_EVENT_TYPE_UPDATE_NODE;
            break;
        default:
            cevent->type = COROSYNC_EVENT_TYPE_NOTIFY;
            break;
        }

        cevent->sender = cmsg->sender;
        cevent->msg_len = cmsg->msg_len;
        if (cmsg->msg_len) {
            cevent->msg = xzalloc(cmsg->msg_len);
            memcpy(cevent->msg, cmsg->msg, cmsg->msg_len);
        } else
            cevent->msg = NULL;

        queue_event(cevent);
        break;
    case COROSYNC_MSG_TYPE_LEAVE:
        cevent = xzalloc(sizeof(*cevent));
        cevent->type = COROSYNC_EVENT_TYPE_LEAVE;
        cevent->sender = cmsg->sender;
        cevent->msg_len = cmsg->msg_len;
        if (cmsg->msg_len) {
            cevent->msg = xzalloc(cmsg->msg_len);
            memcpy(cevent->msg, cmsg->msg, cmsg->msg_len);
        } else
            cevent->msg = NULL;

        queue_event(cevent);
        break;
    case COROSYNC_MSG_TYPE_ACCEPT:
        cevent = update_event(COROSYNC_EVENT_TYPE_JOIN, &cmsg->sender,
                      cmsg->msg, cmsg->msg_len);
        if (!cevent)
            break;

        cevent->type = COROSYNC_EVENT_TYPE_ACCEPT;
        cevent->nr_nodes = cmsg->nr_nodes;
        memcpy(cevent->nodes, cmsg->nodes,
               sizeof(*cmsg->nodes) * cmsg->nr_nodes);

        break;
    }

    __corosync_dispatch();
}


static void __corosync_dispatch(void)
{
    struct corosync_event *cevent;
    struct pollfd pfd = {
        .fd = cpg_fd,
        .events = POLLIN,
    };

    if (poll(&pfd, 1, 0)) {
        /*
         * Corosync dispatches leave events one by one even
         * when network partition has occured.  To count the
         * number of alive nodes correctly, we postpone
         * processsing events if there are incoming ones.
         */
        sd_debug("wait for a next dispatch event");
        return;
    }

    nr_majority = 0;

    while (!list_empty(&corosync_block_event_list) ||
           !list_empty(&corosync_nonblock_event_list)) {
        if (!list_empty(&corosync_nonblock_event_list))
            cevent = list_first_entry(&corosync_nonblock_event_list,
                          typeof(*cevent), list);
        else
            cevent = list_first_entry(&corosync_block_event_list,
                          typeof(*cevent), list);

        join_finished = update_join_status(cevent);

        if (join_finished) {
            if (!__corosync_dispatch_one(cevent))
                return;
        } else {
            switch (cevent->type) {
            case COROSYNC_MSG_TYPE_JOIN:
            case COROSYNC_MSG_TYPE_BLOCK:
                return;
            default:
                break;
            }
        }

        list_del(&cevent->list);
        free(cevent->msg);
        free(cevent);
    }
}
This is one important handler. in corosync.c Good.
/*
 * Process one dispatch event
 * Returns true if the event is processed
 */
static bool __corosync_dispatch_one(struct corosync_event *cevent)
{
    struct sd_node *node;
    struct cpg_node *n;
    struct rb_root nroot = RB_ROOT;
    int idx;

    switch (cevent->type) {
    case COROSYNC_EVENT_TYPE_JOIN:
        if (!cevent->msg)
            /* we haven't receive JOIN yet */
            return false;

        if (cevent->callbacked)
            /* sd_join_handler() must be called only once */
            return false;

        build_node_list(cpg_nodes, nr_cpg_nodes, &nroot);
        if (sd_join_handler(&cevent->sender.node, &nroot,
                    nr_cpg_nodes, cevent->msg)) {
            send_message(COROSYNC_MSG_TYPE_ACCEPT, &cevent->sender,
                     cpg_nodes, nr_cpg_nodes, cevent->msg,
                     cevent->msg_len);

            cevent->callbacked = true;
        }
        return false;
    case COROSYNC_EVENT_TYPE_ACCEPT:
        add_cpg_node(cpg_nodes, nr_cpg_nodes, &cevent->sender);
        nr_cpg_nodes++;

        build_node_list(cpg_nodes, nr_cpg_nodes, &nroot);
        sd_accept_handler(&cevent->sender.node, &nroot, nr_cpg_nodes,
                  cevent->msg);
        break;
    case COROSYNC_EVENT_TYPE_LEAVE:
        n = xlfind(&cevent->sender, cpg_nodes, nr_cpg_nodes,
               cpg_node_cmp);
        if (n == NULL)
            break;
        cevent->sender.node = n->node;

        del_cpg_node(cpg_nodes, nr_cpg_nodes, &cevent->sender);
        nr_cpg_nodes--;
        build_node_list(cpg_nodes, nr_cpg_nodes, &nroot);
        sd_leave_handler(&cevent->sender.node, &nroot, nr_cpg_nodes);
        break;
    case COROSYNC_EVENT_TYPE_BLOCK:
        if (cevent->callbacked)
            /*
             * block events until the unblock message
             * removes this event
             */
            return false;
        cevent->callbacked = sd_block_handler(&cevent->sender.node);
        return false;
    case COROSYNC_EVENT_TYPE_NOTIFY:
        sd_notify_handler(&cevent->sender.node, cevent->msg,
                         cevent->msg_len);
        break;
    case COROSYNC_EVENT_TYPE_UPDATE_NODE:
        node = &cevent->sender.node;

        if (cpg_node_equal(&cevent->sender, &this_node))
            this_node = cevent->sender;

        idx = find_sd_node(cpg_nodes, nr_cpg_nodes, node);
        assert(idx >= 0);
        cpg_nodes[idx].node = *node;
        sd_update_node_handler(node);
        break;
    }

    return true;
}

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

realpath  headerfile is stdlib.h
Now easy to understand.
A call to realpath where the resolved parameter is NULL behaves exactly like 
canonicalize_file_name. The function allocates a buffer for the file name and
returns a pointer to it. If resolved is not NULL it points to a buffer into 
which the result is copied. It is the callers responsibility to allocate a 
buffer which is large enough. On systems which define PATH_MAX this means
the buffer must be large enough for a pathname of this size. For systems 
without limitations on the pathname length the requirement cannot be met and 
programs should not call realpath with anything but NULL for the second 
parameter. 

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

Go to base level of send_req(), I find this data structure. Good.


/* Structure describing messages sent by
   `sendmsg' and received by `recvmsg'.  */
struct msghdr
  {
    void *msg_name;     /* Address to send to/receive from.  */
    socklen_t msg_namelen;  /* Length of address data.  */

    struct iovec *msg_iov;  /* Vector of data to send/receive into.  */
    size_t msg_iovlen;      /* Number of elements in the vector.  */

    void *msg_control;      /* Ancillary data (eg BSD filedesc passing). */
    size_t msg_controllen;  /* Ancillary data buffer length.
           !! The type should be socklen_t but the
                   definition of the kernel is incompatible
                   with this.  */
}

  
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

last ten days.

static struct sd_op_template sd_ops[] = {

    /* cluster operations */
    [SD_OP_NEW_VDI] = {
        .name = "NEW_VDI",
        .type = SD_OP_TYPE_CLUSTER,
        .process_work = cluster_new_vdi,
        .process_main = post_cluster_new_vdi,
    },

    [SD_OP_DEL_VDI] = {
        .name = "DEL_VDI",
        .type = SD_OP_TYPE_CLUSTER,
        .process_work = cluster_del_vdi,
        .process_main = post_cluster_del_vdi,
    },

    [SD_OP_MAKE_FS] = {
        .name = "MAKE_FS",
        .type = SD_OP_TYPE_CLUSTER,
        .force = true,
        .process_main = cluster_make_fs,
    },

    [SD_OP_SHUTDOWN] = {
        .name = "SHUTDOWN",
        .type = SD_OP_TYPE_CLUSTER,
        .force = true,
        .process_main = cluster_shutdown,
    },

    [SD_OP_GET_VDI_ATTR] = {
        .name = "GET_VDI_ATTR",
        .type = SD_OP_TYPE_CLUSTER,
        .process_work = cluster_get_vdi_attr,
    },

    [SD_OP_FORCE_RECOVER] = {
        .name = "FORCE_RECOVER",
        .type = SD_OP_TYPE_CLUSTER,
        .force = true,
        .process_work = cluster_force_recover_work,
        .process_main = cluster_force_recover_main,
    },

    [SD_OP_CLEANUP] = {
        .name = "CLEANUP",
        .type = SD_OP_TYPE_CLUSTER,
        .force = true,
        .process_main = cluster_cleanup,
    },

    [SD_OP_NOTIFY_VDI_DEL] = {
        .name = "NOTIFY_VDI_DEL",
        .type = SD_OP_TYPE_CLUSTER,
        .force = true,
        .process_main = cluster_notify_vdi_del,
    },

    [SD_OP_NOTIFY_VDI_ADD] = {
        .name = "NOTIFY_VDI_ADD",
        .type = SD_OP_TYPE_CLUSTER,
        .force = true,
        .process_main = cluster_notify_vdi_add,
    },

    [SD_OP_DELETE_CACHE] = {
        .name = "DELETE_CACHE",
        .type = SD_OP_TYPE_CLUSTER,
        .process_main = cluster_delete_cache,
    },

    [SD_OP_COMPLETE_RECOVERY] = {
        .name = "COMPLETE_RECOVERY",
        .type = SD_OP_TYPE_CLUSTER,
        .force = true,
        .process_main = cluster_recovery_completion,
    },

    [SD_OP_GET_VDI_INFO] = {
        .name = "GET_VDI_INFO",
        .type = SD_OP_TYPE_CLUSTER,
        .process_work = cluster_get_vdi_info,
    },

    [SD_OP_LOCK_VDI] = {
        .name = "LOCK_VDI",
        .type = SD_OP_TYPE_CLUSTER,
        .process_work = cluster_get_vdi_info,
    },

    [SD_OP_REWEIGHT] = {
        .name = "REWEIGHT",
        .type = SD_OP_TYPE_CLUSTER,
        .process_main = cluster_reweight,
    },

    [SD_OP_ENABLE_RECOVER] = {
        .name = "ENABLE_RECOVER",
        .type = SD_OP_TYPE_CLUSTER,
        .process_main = cluster_enable_recover,
    },

    [SD_OP_DISABLE_RECOVER] = {
        .name = "DISABLE_RECOVER",
        .type = SD_OP_TYPE_CLUSTER,
        .process_main = cluster_disable_recover,
    },

    /* local operations */
    [SD_OP_RELEASE_VDI] = {
        .name = "RELEASE_VDI",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_release_vdi,
    },

    [SD_OP_GET_STORE_LIST] = {
        .name = "GET_STORE_LIST",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_work = local_get_store_list,
    },

    [SD_OP_READ_VDIS] = {
        .name = "READ_VDIS",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_main = local_read_vdis,
    },

    [SD_OP_GET_VDI_COPIES] = {
        .name = "GET_VDI_COPIES",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_main = local_get_vdi_copies,
    },

    [SD_OP_GET_NODE_LIST] = {
        .name = "GET_NODE_LIST",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_main = local_get_node_list,
    },

    [SD_OP_STAT_SHEEP] = {
        .name = "STAT_SHEEP",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_stat_sheep,
    },

    [SD_OP_STAT_RECOVERY] = {
        .name = "STAT_RECOVERY",
        .type = SD_OP_TYPE_LOCAL,
        .process_main = local_stat_recovery,
    },

    [SD_OP_STAT_CLUSTER] = {
        .name = "STAT_CLUSTER",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_work = local_stat_cluster,
    },

    [SD_OP_GET_OBJ_LIST] = {
        .name = "GET_OBJ_LIST",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_get_obj_list,
    },

    [SD_OP_GET_EPOCH] = {
        .name = "GET_EPOCH",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_get_epoch,
    },

    [SD_OP_FLUSH_VDI] = {
        .name = "FLUSH_VDI",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_flush_vdi,
    },

    [SD_OP_DISCARD_OBJ] = {
        .name = "DISCARD_OBJ",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_discard_obj,
    },

    [SD_OP_FLUSH_DEL_CACHE] = {
        .name = "DEL_CACHE",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_flush_and_del,
    },

    [SD_OP_TRACE_ENABLE] = {
        .name = "TRACE_ENABLE",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_main = local_trace_enable,
    },

    [SD_OP_TRACE_DISABLE] = {
        .name = "TRACE_DISABLE",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_main = local_trace_disable,
    },

    [SD_OP_TRACE_STATUS] = {
        .name = "TRACE_STATUS",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_main = local_trace_status,
    },

    [SD_OP_TRACE_READ_BUF] = {
        .name = "TRACE_READ_BUF",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_work = local_trace_read_buf,
    },

    [SD_OP_KILL_NODE] = {
        .name = "KILL_NODE",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_main = local_kill_node,
    },

    [SD_OP_MD_INFO] = {
        .name = "MD_INFO",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_md_info,
    },

    [SD_OP_MD_PLUG] = {
        .name = "MD_PLUG_DISKS",
        .type = SD_OP_TYPE_LOCAL,
        .process_main = local_md_plug,
    },

    [SD_OP_MD_UNPLUG] = {
        .name = "MD_UNPLUG_DISKS",
        .type = SD_OP_TYPE_LOCAL,
        .process_main = local_md_unplug,
    },

    [SD_OP_GET_HASH] = {
        .name = "GET_HASH",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_get_hash,
    },

    [SD_OP_GET_CACHE_INFO] = {
        .name = "GET_CACHE_INFO",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_get_cache_info,
    },

    [SD_OP_CACHE_PURGE] = {
        .name = "CACHE_PURGE",
        .type = SD_OP_TYPE_LOCAL,
        .process_work = local_cache_purge,
    },

    [SD_OP_STAT] = {
        .name = "STAT",
        .type = SD_OP_TYPE_LOCAL,
        .process_main = local_sd_stat,
    },

    [SD_OP_GET_LOGLEVEL] = {
        .name = "GET_LOGLEVEL",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_work = local_get_loglevel,
    },

    [SD_OP_SET_LOGLEVEL] = {
        .name = "SET_LOGLEVEL",
        .type = SD_OP_TYPE_LOCAL,
        .force = true,
        .process_work = local_set_loglevel,
    },

    /* gateway I/O operations */
    [SD_OP_CREATE_AND_WRITE_OBJ] = {
        .name = "CREATE_AND_WRITE_OBJ",
        .type = SD_OP_TYPE_GATEWAY,
        .process_work = gateway_create_and_write_obj,
    },

    [SD_OP_READ_OBJ] = {
        .name = "READ_OBJ",
        .type = SD_OP_TYPE_GATEWAY,
        .process_work = gateway_read_obj,
    },

    [SD_OP_WRITE_OBJ] = {
        .name = "WRITE_OBJ",
        .type = SD_OP_TYPE_GATEWAY,
        .process_work = gateway_write_obj,
    },

    [SD_OP_REMOVE_OBJ] = {
        .name = "REMOVE_OBJ",
        .type = SD_OP_TYPE_GATEWAY,
        .process_work = gateway_remove_obj,
    },

    /* peer I/O operations */
    [SD_OP_CREATE_AND_WRITE_PEER] = {
        .name = "CREATE_AND_WRITE_PEER",
        .type = SD_OP_TYPE_PEER,
        .process_work = peer_create_and_write_obj,
    },

    [SD_OP_READ_PEER] = {
        .name = "READ_PEER",
        .type = SD_OP_TYPE_PEER,
        .process_work = peer_read_obj,
    },

    [SD_OP_WRITE_PEER] = {
        .name = "WRITE_PEER",
        .type = SD_OP_TYPE_PEER,
        .process_work = peer_write_obj,
    },

    [SD_OP_REMOVE_PEER] = {
        .name = "REMOVE_PEER",
        .type = SD_OP_TYPE_PEER,
        .process_work = peer_remove_obj,
    },
};

const struct sd_op_template *get_sd_op(uint8_t opcode)
{
    if (sd_ops[opcode].type == 0)
        return NULL;

    return sd_ops + opcode;
}

sd_op_template from 
ops.c

get_sd_op() is called in below func.

/*
 * Pass on a notification message from the cluster driver.
 * Must run in the main thread as it accesses unlocked state like
 * sys->pending_list.
 */

main_fn void sd_notify_handler(const struct sd_node *sender, void *data,
                   size_t data_len)
{
    struct vdi_op_message *msg = data;
    const struct sd_op_template *op = get_sd_op(msg->req.opcode);
    int ret = msg->rsp.result;
    struct request *req = NULL;

    sd_debug("op %s, size: %zu, from: %s", op_name(op), data_len,
         node_to_str(sender));

    if (node_is_local(sender)) {
        if (has_process_work(op))
            req = list_first_entry(
                main_thread_get(pending_block_list),
                struct request, pending_list);
        else
            req = list_first_entry(
                main_thread_get(pending_notify_list),
                struct request, pending_list);
        list_del(&req->pending_list);
    }

    if (ret == SD_RES_SUCCESS && has_process_main(op))
        ret = do_process_main(op, &msg->req, &msg->rsp, msg->data);

    if (req) {
        msg->rsp.result = ret;
        if (has_process_main(req->op) &&
            !(req->rq.flags & SD_FLAG_CMD_WRITE))
            memcpy(req->data, msg->data, msg->rsp.data_length);
        memcpy(&req->rp, &msg->rsp, sizeof(req->rp));

        put_request(req);
    }

    if (has_process_work(op))
        cluster_op_running = false;
}

know more about the 
has_process_work();

int do_process_main(const struct sd_op_template *op, const struct sd_req *req,
            struct sd_rsp *rsp, void *data)
{
    return op->process_main(req, rsp, data);
}

this is also important.
look op->process_main();
and you know the sd_op_tempate datastructure. it is clear.

I don't know this grammer well, learn it more. Just test for it.

static int map_table[] = {
    [SD_OP_CREATE_AND_WRITE_OBJ] = SD_OP_CREATE_AND_WRITE_PEER,
    [SD_OP_READ_OBJ] = SD_OP_READ_PEER,
    [SD_OP_WRITE_OBJ] = SD_OP_WRITE_PEER,
    [SD_OP_REMOVE_OBJ] = SD_OP_REMOVE_PEER,
};

I asked problem about this, and found the solution, thanks for the solver,thanks for 
group.

#include <stdio.h>
const static map_table[] = {
    [1] = 10,
    [2] = 20,
    [3] = 30,
};
int main()
{
    int i=0;
    for(i=0; i<3;i++)
    {
        printf("%d\n",map_table[i]);
    }
    return 0;
}

In this test, the value of map_table = {0,10,20,30};
You should know about the reason. specific the initialize sequence. and 0 was
skipped. just inilization the specific elements in map_table[]; Great.

int gateway_to_peer_opcode(int opcode)
{
    assert(opcode < ARRAY_SIZE(map_table));
    return map_table[opcode];
}
Do you know , your map_table[] only be used here. in the function above,
gateway_to_peer_opcode();

find this func's position.

in gateway.c

static inline void gateway_init_fwd_hdr(struct sd_req *fwd, struct sd_req *hdr)
{
    memcpy(fwd, hdr, sizeof(*fwd));
    fwd->opcode = gateway_to_peer_opcode(hdr->opcode);
    fwd->proto_ver = SD_SHEEP_PROTO_VER;
}

internal_proto.c is also an important file. just protocol.
like sheepdog_proto.c.



static int gateway_forward_request(struct request *req)
{
    int i, err_ret = SD_RES_SUCCESS, ret;
    unsigned wlen;
    uint64_t oid = req->rq.obj.oid;
    struct forward_info fi;
    struct sd_req hdr;
    const struct sd_node *target_nodes[SD_MAX_NODES];
    int nr_copies = get_req_copy_number(req), nr_to_send = 0;
    struct req_iter *reqs = NULL;

    sd_debug("%"PRIx64, oid);

    gateway_init_fwd_hdr(&hdr, &req->rq);
    oid_to_nodes(oid, &req->vinfo->vroot, nr_copies, target_nodes);
    forward_info_init(&fi, nr_copies);
    reqs = prepare_requests(req, &nr_to_send);
    if (!reqs)
        return SD_RES_NETWORK_ERROR;

    /* avoid out range of target_nodes[] */
    if (nr_to_send > nr_copies) {
        sd_err("There isn't enough copies(%d) to send out (%d)",
               nr_copies, nr_to_send);
        return SD_RES_SYSTEM_ERROR;
    }

    for (i = 0; i < nr_to_send; i++) {
        struct sockfd *sfd;
        const struct node_id *nid;

        nid = &target_nodes[i]->nid;
        sfd = sockfd_cache_get(nid);
        if (!sfd) {
            err_ret = SD_RES_NETWORK_ERROR;
            break;
        }

        hdr.data_length = reqs[i].dlen;
        wlen = reqs[i].wlen;
        hdr.obj.offset = reqs[i].off;
        hdr.obj.ec_index = i;
        hdr.obj.copy_policy = req->rq.obj.copy_policy;
        ret = send_req(sfd->fd, &hdr, reqs[i].buf, wlen,
                   sheep_need_retry, req->rq.epoch,
                   MAX_RETRY_COUNT);
        if (ret) {
            sockfd_cache_del_node(nid);
            err_ret = SD_RES_NETWORK_ERROR;
            sd_debug("fail %d", ret);
            break;
        }
        forward_info_advance(&fi, nid, sfd, reqs[i].buf);
    }

    sd_debug("nr_sent %d, err %x", fi.nr_sent, err_ret);
    if (fi.nr_sent > 0) {
        ret = wait_forward_request(&fi, req);
        if (ret != SD_RES_SUCCESS)
            err_ret = ret;
    }

    finish_requests(req, reqs, nr_to_send);
    return err_ret;
}

what is your understand to your code, what problems you met in your research?
list them and ask for help from your senior fellow apprentice.
But you should know what you want to know first.

now, think about the handler, once you receive a message, you need a handler
to deal with the message, this is called a handler.


data is in a 4M block, I need to send the block out. I was banned from the game
because I disconnected from the game, but I was sutcked from the server, I did't 
mean to do that. 

2014-3-22

Do something about your graduate paper.
In file ops.c, there are these two functions:
peer_read_obj()
peer_write_obj()
peer_remove_obj()

I search the relevant part, 
    [SD_OP_WRITE_PEER] = {
        .name = "WRITE_PEER",
        .type = SD_OP_TYPE_PEER,
        .process_work = peer_write_obj,
    },  

    [SD_OP_REMOVE_PEER] = {
        .name = "REMOVE_PEER",
        .type = SD_OP_TYPE_PEER,
        .process_work = peer_remove_obj,
    },
this type appeared in this func:

vdi.c
sd_init_req(&hdr,SD_OP_READ_PEER)
also, in recovery.c also appeared in the same way:
sd_init_req(&hdr, SD_OP_READ_PEER)

but what is this func doing, what's the meaning of this call init.

This data structure is also important. check please.

struct corosync_event {
    enum corosync_event_type type;

    struct cpg_node sender;
    void *msg;
    size_t msg_len;

    uint32_t nr_nodes;
    struct cpg_node nodes[COROSYNC_MAX_NODES];

    bool callbacked;

    struct list_node list;
};

struct corosync_message {
    struct cpg_node sender;
    enum corosync_message_type type:16;
    uint16_t nr_nodes;
    uint32_t msg_len;
    struct cpg_node nodes[COROSYNC_MAX_NODES];
    uint8_t msg[0];
};

struct cpg_node {
    uint32_t nodeid;
    uint32_t pid;
    struct sd_node node;
};

these data structure are connected with each other.

I met this in my program, how does this marco work, I don't know, so I test it in a 
single c file. conclude the conclusion below.

the key point is "__attribute__((constructor))", with this attribute, the content
of the marco will be executed once it was called.
Just show(what); not just give a chance to call showwhat() func in main func.
but the showwhat() has been executed once.

next key_point is :
if your skip "__attribute__((constructor))", with the same code, show(what), the 
content of the marco will not be executed. that's all.

#define show(driver)\
    static void __attribute__((constructor)) show ## driver()\
    { printf("hello world!\n");}

show(what)
show(hello)

now , it seems that I don't know what I want, I just want to read code os sheepdog
but not construction a paper from it. this is not what suit me now. What I should do
is find points from sheepdog and gen a paper for my graduation's end. I hate this 
work, but I have no way to avoid this, I have to earn my deploma, so I have to finish
my graduation paper.this is not negotiable.

cluster.h

## This file contain some sd_handlers in sheepdog.
/* callbacks back into sheepdog from the cluster drivers */
void sd_accept_handler(const struct sd_node *joined,
               const struct rb_root *nroot, size_t nr_members,
               const void *opaque);
void sd_leave_handler(const struct sd_node *left, const struct rb_root *nroot,
              size_t nr_members);
void sd_notify_handler(const struct sd_node *sender, void *msg, size_t msg_len);
bool sd_block_handler(const struct sd_node *sender);
int sd_reconnect_handler(void);
void sd_update_node_handler(struct sd_node *);
bool sd_join_handler(const struct sd_node *joining,
             const struct rb_root *nroot, size_t nr_nodes,
             void *opaque);

2014-3-23
Every handler was called from other places. Just several related files.
corosync.c
local.c
sherpherd.c
group.c

these two line are form log file.

do_process_work(1394) a3,8d2ccd0000005f
default_create_and_write(351) 8deccd0000005f

/*
 * Perform a blocked cluster operation if we were the node requesting it
 * and do not have any other operation pending.
 *
 * If this method returns false the caller must call the method again for
 * the same event once it gets notified again.
 *
 * Must run in the main thread as it accesses unlocked state like
 * sys->pending_list.
 */
main_fn bool sd_block_handler(const struct sd_node *sender)
{
    struct request *req;

    if (!node_is_local(sender))
        return false;
    if (cluster_op_running)
        return false;

    cluster_op_running = true;

    req = list_first_entry(main_thread_get(pending_block_list),
                struct request, pending_list);
    req->work.fn = do_process_work;
    req->work.done = cluster_op_done;

    queue_work(sys->block_wqueue, &req->work);
    req->status = REQUEST_QUEUED;
    return true;
}

void do_process_work(struct work *work)
{
    struct request *req = container_of(work, struct request, work);
    int ret = SD_RES_SUCCESS;

    sd_debug("%x, %" PRIx64", %"PRIu32, req->rq.opcode, req->rq.obj.oid,
         req->rq.epoch);

    if (req->op->process_work)
        ret = req->op->process_work(req);

    if (ret != SD_RES_SUCCESS) {
        sd_debug("failed: %x, %" PRIx64" , %u, %s", req->rq.opcode,
             req->rq.obj.oid, req->rq.epoch, sd_strerror(ret));
    }

    req->rp.result = ret;
}

int do_process_main(const struct sd_op_template *op, const struct sd_req *req,
{
    return op->process_main(req, rsp, data);
}

this comes from plain_store.c


int default_create_and_write(uint64_t oid, const struct siocb *iocb)
{
    char path[PATH_MAX], tmp_path[PATH_MAX];
    int flags = prepare_iocb(oid, iocb, true);
    int ret, fd;
    uint32_t len = iocb->length;
    bool ec = is_erasure_obj(oid, iocb->copy_policy);
    size_t obj_size;

    sd_debug("%"PRIx64, oid);
    get_obj_path(oid, path, sizeof(path));
    get_tmp_obj_path(oid, tmp_path, sizeof(tmp_path));

    if (uatomic_is_true(&sys->use_journal) &&
        journal_write_store(oid, iocb->buf, iocb->length,
                iocb->offset, true)
        != SD_RES_SUCCESS) {
        sd_err("turn off journaling");
        uatomic_set_false(&sys->use_journal);
        flags |= O_DSYNC;
        sync();
    }

    fd = open(tmp_path, flags, sd_def_fmode);
    if (fd < 0) {
        if (errno == EEXIST) {
            /*
             * This happens if node membership changes during object
             * creation; while gateway retries a CREATE request,
             * recovery process could also recover the object at the
             * same time.  They should try to write the same date,
             * so it is okay to simply return success here.
             */
            sd_debug("%s exists", tmp_path);
            return SD_RES_SUCCESS;
        }

        sd_err("failed to open %s: %m", tmp_path);
        return err_to_sderr(path, oid, errno);
    }

    if (ec) {
        uint8_t policy = iocb->copy_policy ?:
            get_vdi_copy_policy(oid_to_vid(oid));
        int d;
        ec_policy_to_dp(policy, &d, NULL);
        obj_size = SD_DATA_OBJ_SIZE / d;
    } else
        obj_size = get_objsize(oid);

    ret = prealloc(fd, obj_size);
    if (ret < 0) {
        ret = err_to_sderr(path, oid, errno);
        goto out;
    }

    ret = xpwrite(fd, iocb->buf, len, iocb->offset);
    if (ret != len) {
        sd_err("failed to write object. %m");
        ret = err_to_sderr(path, oid, errno);
        goto out;
    }

    ret = rename(tmp_path, path);
    if (ret < 0) {
        sd_err("failed to rename %s to %s: %m", tmp_path, path);
        ret = err_to_sderr(path, oid, errno);
        goto out;
    }
    if (ec && set_erasure_index(path, iocb->ec_index) < 0) {
        ret = err_to_sderr(path, oid, errno);
        goto out;
    }
    ret = SD_RES_SUCCESS;
    objlist_cache_insert(oid);
out:
    if (ret != SD_RES_SUCCESS)
        unlink(tmp_path);
    close(fd);
    return ret;
}

plain_store.c is a file I don't know too much. I should learn more about the
file.

Also I find this from logfile.
queue_request(392) CREATE_AND_WRITE_PEER 1

static void queue_request(struct request *req)
{
    struct sd_req *hdr = &req->rq;
    struct sd_rsp *rsp = &req->rp;

    /*
     * Check the protocol version for all internal commands, and public
     * commands that have it set.  We can't enforce it on all public
     * ones as it isn't a mandatory part of the public protocol.
     */
    if (hdr->opcode >= 0x80) {
        if (hdr->proto_ver != SD_SHEEP_PROTO_VER) {
            rsp->result = SD_RES_VER_MISMATCH;
            goto done;
        }
    } else if (hdr->proto_ver) {
        if (hdr->proto_ver > SD_PROTO_VER) {
            rsp->result = SD_RES_VER_MISMATCH;
            goto done;
        }
    }

    req->op = get_sd_op(hdr->opcode);
    if (!req->op) {
        sd_err("invalid opcode %d", hdr->opcode);
        rsp->result = SD_RES_INVALID_PARMS;
        goto done;
    }

    sd_debug("%s, %d", op_name(req->op), sys->cinfo.status);

    switch (sys->cinfo.status) {
    case SD_STATUS_KILLED:
        rsp->result = SD_RES_KILLED;
        goto done;
    case SD_STATUS_SHUTDOWN:
        rsp->result = SD_RES_SHUTDOWN;
        goto done;
    case SD_STATUS_WAIT:
        if (!is_force_op(req->op)) {
            if (sys->cinfo.ctime == 0)
                rsp->result = SD_RES_WAIT_FOR_FORMAT;
            else
                rsp->result = SD_RES_WAIT_FOR_JOIN;
            goto done;
        }
        break;
    default:
        break;
    }

    req->vinfo = get_vnode_info();

    if (is_peer_op(req->op)) {
        queue_peer_request(req);
    } else if (is_gateway_op(req->op)) {
        hdr->epoch = sys->cinfo.epoch;
        queue_gateway_request(req);
    } else if (is_local_op(req->op)) {
        hdr->epoch = sys->cinfo.epoch;
        queue_local_request(req);
    } else if (is_cluster_op(req->op)) {
        hdr->epoch = sys->cinfo.epoch;
        queue_cluster_request(req);
    } else {
        sd_err("unknown operation %d", hdr->opcode);
        rsp->result = SD_RES_SYSTEM_ERROR;
        goto done;
    }
    stat_request_begin(req);

    return;
done:
    put_request(req);
}

I don't know what's the function means, but it appears in the log file, So I
need to see it in detailed.

static void rx_main(struct work *work)
{
    struct client_info *ci = container_of(work, struct client_info,
                          rx_work);
    struct request *req = ci->rx_req;

    ci->rx_req = NULL;

    refcount_dec(&ci->refcnt);

    if (ci->conn.dead) {
        if (req)
            free_request(req);

        clear_client_info(ci);
        return;
    }

    conn_rx_on(&ci->conn);

    sd_debug("%d, %s:%d", ci->conn.fd, ci->conn.ipstr, ci->conn.port);
    queue_request(req);
}

Also, I found client_handler:

static void client_handler(int fd, int events, void *data)
{
    struct client_info *ci = (struct client_info *)data;

    sd_debug("%x, %d", events, ci->conn.dead);

    if (events & (EPOLLERR | EPOLLHUP) || ci->conn.dead)
        return clear_client_info(ci);

    if (events & EPOLLIN) {
        if (conn_rx_off(&ci->conn) != 0)
            return;

        /*
         * Increment refcnt so that the client_info isn't freed while
         * rx_work uses it.
         */
        refcount_inc(&ci->refcnt);
        ci->rx_work.fn = rx_work;
        ci->rx_work.done = rx_main;
        queue_work(sys->net_wqueue, &ci->rx_work);
    }

    if (events & EPOLLOUT) {
        if (conn_tx_off(&ci->conn) != 0)
            return;

        assert(ci->tx_req == NULL);
        ci->tx_req = list_first_entry(&ci->done_reqs, struct request,
                          request_list);
        list_del(&ci->tx_req->request_list);

        /*
         * Increment refcnt so that the client_info isn't freed while
         * tx_work uses it.
         */
        refcount_inc(&ci->refcnt);
        ci->tx_work.fn = tx_work;
        ci->tx_work.done = tx_main;
        queue_work(sys->net_wqueue, &ci->tx_work);
    }
}

and here is listen_handler

static void listen_handler(int listen_fd, int events, void *data)
{
    struct sockaddr_storage from;
    socklen_t namesize;
    int fd, ret;
    struct client_info *ci;
    bool is_inet_socket = *(bool *)data;

    if (sys->cinfo.status == SD_STATUS_SHUTDOWN) {
        sd_debug("unregistering connection %d", listen_fd);
        unregister_event(listen_fd);
        return;
    }

    namesize = sizeof(from);
    fd = accept(listen_fd, (struct sockaddr *)&from, &namesize);
    if (fd < 0) {
        sd_err("failed to accept a new connection: %m");
        return;
    }

    if (is_inet_socket) {
        ret = set_nodelay(fd);
        if (ret) {
            close(fd);
            return;
        }
    }

    ci = create_client(fd, data);
    if (!ci) {
        close(fd);
        return;
    }

    ret = register_event(fd, client_handler, ci);
    if (ret) {
        destroy_client(ci);
        return;
    }
    sd_debug("accepted a new connection: %d", fd);
}

In this func listen_handler, I met the accept part, this may be what I what most
In a client server module, what server doing is listen a port, and response to
request from client.

static int create_listen_port_fn(int fd, void *data)
{
    return register_event(fd, listen_handler, data);
}

I find the upcall of the listen_handler, then I find above:
create_listen_port_fn();

then upcall it again, I find this.

int create_listen_port(const char *bindaddr, int port)
{
    static bool is_inet_socket = true;

    return create_listen_ports(bindaddr, port, create_listen_port_fn,
                   &is_inet_socket);
}

upcall this func, I find sheep: main. yes, this is finally upcall.They are here.

    ret = create_listen_port(bindaddr, port);
    if (ret)
        exit(1);

    if (io_addr && create_listen_port(io_addr, io_port))
        exit(1);


register_event is an important call: but is simply.

static inline int register_event(int fd, event_handler_t h, void *data)
{
    return register_event_prio(fd, h, data, EVENT_PRIO_DEFAULT);
}

but what is func doing, I don't know it clearly.
int register_event_prio(int fd, event_handler_t h, void *data, int prio)
{
    int ret;
    struct epoll_event ev;
    struct event_info *ei;

    ei = xzalloc(sizeof(*ei));
    ei->fd = fd;
    ei->handler = h;
    ei->data = data;
    ei->prio = prio;

    memset(&ev, 0, sizeof(ev));
    ev.events = EPOLLIN;
    ev.data.ptr = ei;

    ret = epoll_ctl(efd, EPOLL_CTL_ADD, fd, &ev);
    if (ret) {
        sd_err("failed to add epoll event: %m");
        free(ei);
    } else
        rb_insert(&events_tree, ei, rb, event_cmp);

    return ret;
}

I see, there is an event system in sheepdog, what what type is it, how the 
system run, I am not sure about it.

I can see destory_client(682) connection from: 127.0.0.1:41971 In log file.
This is definition of destroy_client();

static void destroy_client(struct client_info *ci)
{
    sd_debug("connection from: %s:%d", ci->conn.ipstr, ci->conn.port);
    close(ci->conn.fd);
    free(ci);
}

static void clear_client_info(struct client_info *ci)
{
    struct request *req;

    sd_debug("connection seems to be dead");

    list_for_each_entry(req, &ci->done_reqs, request_list) {
        list_del(&req->request_list);
        free_request(req);
    }

    unregister_event(ci->conn.fd);

    sd_debug("refcnt:%d, fd:%d, %s:%d", refcount_read(&ci->refcnt),
         ci->conn.fd, ci->conn.ipstr, ci->conn.port);

    if (refcount_read(&ci->refcnt))
        return;

    destroy_client(ci);
}

what's this func doing.
static void tx_work(struct work *work)
{
    struct client_info *ci = container_of(work, struct client_info,
                          tx_work);
    int ret;
    struct connection *conn = &ci->conn;
    struct sd_rsp rsp;
    struct request *req = ci->tx_req;
    void *data = NULL;

    /* use cpu_to_le */
    memcpy(&rsp, &req->rp, sizeof(rsp));

    rsp.epoch = sys->cinfo.epoch;
    rsp.opcode = req->rq.opcode;
    rsp.id = req->rq.id;

    if (rsp.data_length)
        data = req->data;

    ret = send_req(conn->fd, (struct sd_req *)&rsp, data, rsp.data_length,
               NULL, 0, UINT32_MAX);
    if (ret != 0) {
        sd_err("failed to send a request");
        conn->dead = true;
    }
}

what rx and tx means, what this function does.
I searched, but find nothing meaningfully.
static void rx_work(struct work *work)
{
    struct client_info *ci = container_of(work, struct client_info,
                          rx_work);
    int ret;
    struct connection *conn = &ci->conn;
    struct sd_req hdr;
    struct request *req;

    ret = do_read(conn->fd, &hdr, sizeof(hdr), NULL, 0, UINT32_MAX);
    if (ret) {
        sd_err("failed to read a header");
        conn->dead = true;
        return;
    }

    req = alloc_request(ci, hdr.data_length);
    if (!req) {
        sd_err("failed to allocate request");
        conn->dead = true;
        return;
    }
    ci->rx_req = req;

    /* use le_to_cpu */
    memcpy(&req->rq, &hdr, sizeof(req->rq));

    if (hdr.data_length && hdr.flags & SD_FLAG_CMD_WRITE) {
        ret = do_read(conn->fd, req->data, hdr.data_length, NULL, 0,
                  UINT32_MAX);
        if (ret) {
            sd_err("failed to read data");
            conn->dead = true;
        }
    }
}

I know, the rx_work and rx_main was not called in a specific function, it is 
part of client_info, which data structure is:


struct client_info {
    struct connection conn;

    struct request *rx_req;
    struct work rx_work;

    struct request *tx_req;
    struct work tx_work;

    struct list_head done_reqs;

    refcnt_t refcnt;
};

struct work {
    struct list_node w_list;
    work_func_t fn;
    work_func_t done;
};

typedef void (*work_func_t)(struct work *);

this is just a function-pointer. So, this can be clearly, this usage is so
many in sheepdog, you can see almost anywhere.
and you can go back to client_handler to see this part again.

I think this is a hard marco to understand.

#define container_of(ptr, type, member) ({          \
    const typeof(((type *)0)->member) *__mptr = (ptr);  \
    (type *)((char *)__mptr - offsetof(type, member)); })

Here is one blog that have detailed information about container_of marco.
Thanks for that.
http://hi.baidu.com/holinux/item/af2e32c9dcbd3953ac00ef49


I know that, wi is short for work_info, this is parameter of work_routine,
work_routine will be executed in the thread, but different threads want to 
do different things, and to achieve this, this parameter was set.

static int create_worker_threads(struct worker_info *wi, size_t nr_threads)
{
    pthread_t thread;
    int ret;

    pthread_mutex_lock(&wi->startup_lock);
    while (wi->nr_threads < nr_threads) {
        ret = pthread_create(&thread, NULL, worker_routine, wi);
        if (ret != 0) {
            sd_err("failed to create worker thread: %m");
            pthread_mutex_unlock(&wi->startup_lock);
            return -1;
        }
        wi->nr_threads++;
        sd_debug("create thread %s %zu", wi->name, wi->nr_threads);
    }
    pthread_mutex_unlock(&wi->startup_lock);

    return 0;
}

Understant this work, what's it means,just queue the job.

void queue_work(struct work_queue *q, struct work *work)
{
    struct worker_info *wi = container_of(q, struct worker_info, q);

    uatomic_inc(&wi->nr_workers);
    pthread_mutex_lock(&wi->pending_lock);

    if (wq_need_grow(wi))
        /* double the thread pool size */
        create_worker_threads(wi, wi->nr_threads * 2);

    list_add_tail(&work->w_list, &wi->q.pending_list);
    pthread_mutex_unlock(&wi->pending_lock);
    pthread_cond_signal(&wi->pending_cond);
}
work is also an important datastructure here.

struct work;
typedef void (*work_func_t)(struct work *);

struct work {
    struct list_node w_list;
    work_func_t fn;
    work_func_t done;
};

struct work_queue {
    int wq_state;
    struct list_head pending_list;
};

static void worker_thread_request_done(int fd, int events, void *data)
{
    struct worker_info *wi;
    struct work *work;
    LIST_HEAD(list);

    if (wq_get_nr_nodes)
        nr_nodes = wq_get_nr_nodes();

    eventfd_xread(fd);

    list_for_each_entry(wi, &worker_info_list, worker_info_siblings) {
        pthread_mutex_lock(&wi->finished_lock);
        list_splice_init(&wi->finished_list, &list);
        pthread_mutex_unlock(&wi->finished_lock);

        while (!list_empty(&list)) {
            work = list_first_entry(&list, struct work, w_list);
            list_del(&work->w_list);

            work->done(work);
            uatomic_dec(&wi->nr_workers);
        }
    }
}

I don't know what is the meaning of this datastructure.

struct list_node {
    struct list_node *next;
    struct list_node *prev;
};

struct list_head {
    struct list_node n;
};

I asked problems in the qq-group, I find the solution below:
list in linux kernel, implemented depature of data and operation.just add the empty
list into data-structure you want to list of. Then your data will be listed with a 
d-list. But my understand about is just a few, I need to search for more info.
And here is a line.
https://www.kernel.org/pub/linux/kernel/people/rusty/kernel-locking/c326.html

Maybe this is the one that focused on the linux-kernel.
https://www.kernel.org/pub/linux/kernel/people/rusty/kernel-locking/index.html

know, how to use them will ok,That' engouth.

static void worker_thread_request_done(int fd, int events, void *data)
{
    struct worker_info *wi;
    struct work *work;
    LIST_HEAD(list);

    if (wq_get_nr_nodes)
        nr_nodes = wq_get_nr_nodes();

    eventfd_xread(fd);

    list_for_each_entry(wi, &worker_info_list, worker_info_siblings) {
        pthread_mutex_lock(&wi->finished_lock);
        list_splice_init(&wi->finished_list, &list);
        pthread_mutex_unlock(&wi->finished_lock);

        while (!list_empty(&list)) {
            work = list_first_entry(&list, struct work, w_list);
            list_del(&work->w_list);

            work->done(work);
            uatomic_dec(&wi->nr_workers);
        }
    }
}

The worker_thread_request_done was called in this init function.
I don't know much about the event mechnism,I don't know much about 
register_event is doing,how does it work, and what it want to do.

eventfd, create a file descriptor for event notification.

int init_work_queue(size_t (*get_nr_nodes)(void))
{
    int ret;

    wq_get_nr_nodes = get_nr_nodes;

    if (wq_get_nr_nodes)
        nr_nodes = wq_get_nr_nodes();

    tid_max = TID_MAX_DEFAULT;
    tid_map = alloc_bitmap(NULL, 0, tid_max);

    resume_efd = eventfd(0, EFD_SEMAPHORE);
    ack_efd = eventfd(0, EFD_SEMAPHORE);
    efd = eventfd(0, EFD_NONBLOCK);
    if (resume_efd < 0 || ack_efd < 0 || efd < 0) {
        sd_err("failed to create event fds: %m");
        return 1;
    }

    /* trace uses this signal to suspend the worker threads */
    if (install_sighandler(SIGUSR2, suspend, false) < 0) {
        sd_debug("%m");
        return -1;
    }

    ret = register_event(efd, worker_thread_request_done, NULL);
    if (ret) {
        sd_err("failed to register event fd %m");
        close(efd);
        return 1;
    }

    return 0;
}

the list and the rbtree seems to be same, the rbtree is also en empty 
data structure Linux use this techonology to depature data and structure. 
but I need to check more to verify this.
Also, there are methods like this.

/* Iterate over a rbtree safe against removal of rbnode */
#define rb_for_each(pos, root)                      \
    for (struct rb_node *LOCAL(n) = (pos = rb_first(root), NULL);   \
         pos && (LOCAL(n) = rb_next(pos), 1);           \
         pos = LOCAL(n))

/* Iterate over a rbtree of given type safe against removal of rbnode */
#define rb_for_each_entry(pos, root, member)                \
    for (struct rb_node *LOCAL(p) = rb_first(root), *LOCAL(n);  \
         LOCAL(p) && (LOCAL(n) = rb_next(LOCAL(p)), 1) &&       \
             (pos = rb_entry(LOCAL(p), typeof(*pos), member), 1); \
         LOCAL(p) = LOCAL(n))

2014-3-24

I went to lab, asked some problems from my senior. He is very busy, he gave me
his code, and give me a detailed description to his design. I have no time to
understand the sheepdog systematically. So , just understand the key point is
ok,just give a description about his design, then grab some other parts from
references--bibliography, then your work will be done. That's what you should
to do.


so, Just try to describe the work flow of sheepdog, there is a must for you to

grab some articles about sheepdog system, and it's usage. giva a brief desc
about in your paper is ok.

I learned about the sheep.c main function.
I track the root of the create_listen_port() function.
Finally , I found the listen_handler, and client_handler. And I find the
EPOLLIN and EOPLLOUT. I googleed it, and I find the link below. thks.
http://www.cnblogs.com/moodlxs/archive/2011/12/16/2290288.html

I should learn something about Epoll programming, I don't understand what the
epoll is, I should learn to take a good care of it.
here is a link that contain a damo, just see it in your free time.
http://www.cnblogs.com/ggjucheng/archive/2012/01/17/2324974.html

note them:

static void listen_handler(int listen_fd, int events, void *data)
{
    struct sockaddr_storage from;
    socklen_t namesize;
    int fd, ret;
    struct client_info *ci;
    bool is_inet_socket = *(bool *)data;

    if (sys->cinfo.status == SD_STATUS_SHUTDOWN) {
        sd_debug("unregistering connection %d", listen_fd);
        unregister_event(listen_fd);
        return;
    }

    namesize = sizeof(from);
    fd = accept(listen_fd, (struct sockaddr *)&from, &namesize);
    if (fd < 0) {
        sd_err("failed to accept a new connection: %m");
        return;
    }

    if (is_inet_socket) {
        ret = set_nodelay(fd);
        if (ret) {
            close(fd);
            return;
        }
    }

    ci = create_client(fd, data);
    if (!ci) {
        close(fd);
        return;
    }

    ret = register_event(fd, client_handler, ci);
    if (ret) {
        destroy_client(ci);
        return;
    }

    sd_debug("accepted a new connection: %d", fd);
}

static void client_handler(int fd, int events, void *data)
{
    struct client_info *ci = (struct client_info *)data;

    sd_debug("%x, %d", events, ci->conn.dead);

    if (events & (EPOLLERR | EPOLLHUP) || ci->conn.dead)
        return clear_client_info(ci);

    if (events & EPOLLIN) {
        if (conn_rx_off(&ci->conn) != 0)
            return;

        /*
         * Increment refcnt so that the client_info isn't freed while
         * rx_work uses it.
         */
        refcount_inc(&ci->refcnt);
        ci->rx_work.fn = rx_work;
        ci->rx_work.done = rx_main;
        queue_work(sys->net_wqueue, &ci->rx_work);
    }

    if (events & EPOLLOUT) {
        if (conn_tx_off(&ci->conn) != 0)
            return;

        assert(ci->tx_req == NULL);
        ci->tx_req = list_first_entry(&ci->done_reqs, struct request,
                          request_list);
        list_del(&ci->tx_req->request_list);

        /*
         * Increment refcnt so that the client_info isn't freed while
         * tx_work uses it.
         */
        refcount_inc(&ci->refcnt);
        ci->tx_work.fn = tx_work;
        ci->tx_work.done = tx_main;
        queue_work(sys->net_wqueue, &ci->tx_work);
    }
}


int init_unix_domain_socket(const char *dir)
{
    static bool is_inet_socket;
    char unix_path[PATH_MAX];

    snprintf(unix_path, sizeof(unix_path), "%s/sock", dir);
    unlink(unix_path);

    return create_unix_domain_socket(unix_path, create_listen_port_fn,
                     &is_inet_socket);
}

int create_unix_domain_socket(const char *unix_path,
                  int (*callback)(int, void *), void *data)
{
    int fd, ret;
    struct sockaddr_un addr;

    addr.sun_family = AF_UNIX;
    pstrcpy(addr.sun_path, sizeof(addr.sun_path), unix_path);

    fd = socket(addr.sun_family, SOCK_STREAM, 0);
    if (fd < 0) {
        sd_err("failed to create socket, %m");
        return -1;
    }

    ret = bind(fd, &addr, sizeof(addr));
    if (ret) {
        sd_err("failed to bind socket: %m");
        goto err;
    }

    ret = listen(fd, SOMAXCONN);
    if (ret) {
        sd_err("failed to listen on socket: %m");
        goto err;
    }

    ret = callback(fd, data);
    if (ret)
        goto err;

    return 0;
err:
    close(fd);

    return -1;
}

    ret = create_listen_port(bindaddr, port);
    if (ret)
        exit(1);

    if (io_addr && create_listen_port(io_addr, io_port))
        exit(1);

    ret = init_unix_domain_socket(dir);

look the diff of them.

2014-3-27
I know, those are unix socket part, I should learned them systemcally to
grab a better understand of them. But time is limited, I should learn to finish
my paper first.

in fetch_object_list(uint32_t epoch, size_t *nr_oids){}

sd_init_req(&hdr,SD_OP_GET_OBJ_LIST);
first initialize the request, then exec the requset.
ret = exec_local_req(&hdr,buf);
buf is container to store response data. and length of response can be get from
rsp->header section. just like this, rep->data_length.

before this, you should definite two variable like this,
*nr_oids = rsp->data_length / sizeof(uint64_t);

struct sd_req hdr;
struct sd_rsp *rsp = (struct sd_rsp *)&hdr;

sd_store->exist(); can check if the object is exist in the store_driver
structure.

sys->this_node.nid is the id of current node.
uint8_t nidx = search_alarm_node(sys->obj_info_map,&sys->this_node.nid);


we create a obj_info_map data structure.

struct obj_info_map {
    struct obj_info **list;
    uint64_t nr;
    struct node_id alarm_node[SD_MAX_ALARM_DISK_NODES];
    struct sd_lock nid_lock;
    struct sd_lock list_locks[OBJ_INFO_TABLE_SIZE];
};

struct sd_lock {
    pthread_rwlock_t rwlock;
};

And this is obj_info.

struct obj_info {
    uint8_t nr_copies;
    uint8_t idx; // what is the idx to do.
    uint64_t oid; // this is object id. nothing to say
    struct obj_info *next;  
    // this is next block info, the datastructure is a link list.
};

struct work_queue *disk_alarm_wqueue;
And we have to add q work_queue for disk_alarm_wqueue;

tell a node to read a block from the alarmed_disk.

struct system_info {
    struct cluster_driver *cdrv;
    const char *cdrv_option;

    struct sd_node this_node;

    struct cluster_info cinfo;

    uint64_t disk_space;

    DECLARE_BITMAP(vdi_inuse, SD_NR_VDIS);
    
    struct obj_info_map *obj_info_map;
    uint32_t alarm_disk_count;
    char *warn_mark;

    int local_req_efd;

    pthread_mutex_t local_req_lock;
    struct list_head local_req_queue;
    struct list_head req_wait_queue;
    int nr_outstanding_reqs;

    bool gateway_only;
    bool nosync;

    struct work_queue *net_wqueue;
    struct work_queue *gateway_wqueue;
    struct work_queue *io_wqueue;
    struct work_queue *deletion_wqueue;
    struct work_queue *recovery_wqueue;
    struct work_queue *recovery_notify_wqueue;
    struct work_queue *block_wqueue;
    struct work_queue *oc_reclaim_wqueue;
    struct work_queue *oc_push_wqueue;
    struct work_queue *md_wqueue;
    struct work_queue *disk_alarm_wqueue;
#ifdef HAVE_HTTP
    struct work_queue *http_wqueue;
#endif

    bool enable_object_cache;

    uint32_t object_cache_size;
    bool object_cache_directio;

    uatomic_bool use_journal;
    bool backend_dio;
    /* upgrade data layout before starting service if necessary*/
    bool upgrade;
    struct sd_stat stat;
};
we have to modify the system_info structure.

int search_alarm_node(struct obj_info_map *map, const struct node_id *nid) {
    int i;
    sd_read_lock(&map->nid_lock);
    for (i = 0; i < sys->alarm_disk_count; i++) {
        if (!node_id_cmp(&map->alarm_node[i], nid)) {
            sd_unlock(&map->nid_lock);
            return ++i;
        }
    }
    sd_unlock(&map->nid_lock);
    return SD_RES_SUCCESS;
}

what the function does.
static inline uint64_t parse_oid(uint64_t oid, uint8_t idx)
{
    uint64_t pavl = (uint64_t)idx << SD_OBJ_INFO_SHIFT;
    pavl |= oid;
    return pavl;
}

But what this line does.
struct vnode_info *vinfo = get_vnode_info();

This should be rep_migrate method. learn it.

int warned_rep_migrate(struct sd_req *req, struct sd_rsp *rsp, void *data) {
    struct sd_req *hdr = req;
    int ret = SD_RES_SUCCESS;
    if (hdr->epoch < sys_epoch())
        return SD_RES_OLD_NODE_VER;
    uatomic_set(&curr_mig_oid, hdr->obj.oid);
    sd_debug("%"PRIx64"", hdr->obj.oid);
    hdr->opcode = SD_OP_WARNED_REPADD;
    ret = exec_local_req(hdr, data);

    uatomic_set(&curr_mig_oid, 0);
    return ret;
}


void update_obj_info_map(void) {
    for_each_obj_info(check_obj_info, sys->obj_info_map);
}

bool oid_in_migration(uint64_t oid) {
    if (uatomic_read(&curr_mig_oid) == oid)
        return true;
    return false;
}

[SD_OP_WARNED_REPADD] = {
    .name = "WARNED_REPADD",
    .type = SD_OP_TYPE_CLUSTER,
    .process_work = cluster_warned_repadd,
    .process_main = post_cluster_warned_repadd,
},

All the operation can be found here.

static int cluster_warned_repadd(struct request *req)
{
    uint64_t oid = req->rq.obj.oid;
    uint64_t  ret = SD_RES_SUCCESS;
    int nr_copies;
    req->rp.data_length = req->rq.data_length;

    struct vnode_info *vinfo = get_vnode_info();
    nr_copies = get_obj_copy_number(oid, vinfo->nr_zones);

    void *obj_buf;

    if (req->rq.flags == SD_FLAG_CMD_NMIGRATE )
    {/*return SD_RES_NMIGRATE;*/
        sd_debug("create obj %"PRIx64" without migration", oid);
        put_vnode_info(vinfo);
        return SD_RES_SUCCESS;
    }

    const struct sd_node *node = oid_to_node(oid, &vinfo->vroot, nr_copies);
    obj_buf = read_obj_data(oid);
    
    if (!obj_buf)
        sd_err("read obj %"PRIx64" data failed", oid);
    ret = write_obj_data(node->nid, oid, obj_buf, req->rq.epoch);
    if (ret != SD_RES_SUCCESS)
        sd_err("write the replication %"PRIx64" failed", oid);


    put_vnode_info(vinfo);
    return SD_RES_SUCCESS;

}

static int post_cluster_warned_repadd(const struct sd_req *req, struct sd_rsp  *rsp, void *data )
{
    size_t  ret = SD_RES_SUCCESS;
    uint64_t oid;
    char *buf = xmalloc(req->data_length);
    memcpy(buf, data, req->data_length);
    /*memcpy(&oid, buf+sizeof(struct node_id), sizeof(uint64_t));*/
    oid = req->obj.oid;
    int nr_copies;
    struct vnode_info *vinfo = get_vnode_info();
    ret = rsp->result;

    struct node_id *nid = xmalloc(sizeof(struct node_id));
    memcpy(nid, buf, sizeof(struct node_id));

    insert_alarm_node(sys->obj_info_map, nid);

    uint8_t idx = search_alarm_node(sys->obj_info_map, nid);
    oid = parse_oid(oid, idx);
    ret = insert_obj_info(sys->obj_info_map, oid, OBJ_INFO_TABLE_SIZE);
    oid = parse_to_oid(oid);
    nr_copies = get_obj_copy_number(oid, vinfo->nr_zones);
    sd_debug("oid : %"PRIx64", nr_copies: %d", oid, nr_copies);
    /*sd_info("obj_info_map size %"PRIu64"",sys->obj_info_map->nr);*/
    
    put_vnode_info(vinfo);

    return ret;
}

Follow your rules, and it will never hurt you.


static inline const struct sd_node *
oid_to_node(uint64_t oid, struct rb_root *root, int copy_idx)
{
    const struct sd_vnode *vnode;

    vnode = oid_to_vnode(oid, root, copy_idx);

    return vnode->node;
}

struct sd_vnode {
    struct rb_node rb;
    const struct sd_node *node;
    uint64_t hash;
};

struct vnode_info {
    struct rb_root vroot;
    struct rb_root nroot;
    int nr_nodes;
    int nr_zones;
}

I know little about this, but this is really important.
 reference to the currently active vnode information structure,
 * this must only be called from the main thread.
 * This can return NULL if cluster is not started yet.
 */
main_fn struct vnode_info *get_vnode_info(void)
{
    struct vnode_info *cur_vinfo = main_thread_get(current_vnode_info);

    if (cur_vinfo == NULL)
        return NULL;

    return grab_vnode_info(cur_vinfo);
}

/* Release a reference to the current vnode information. */
void put_vnode_info(struct vnode_info *vnode_info)
{
    if (vnode_info) {
        if (refcount_dec(&vnode_info->refcnt) == 0) {
            rb_destroy(&vnode_info->vroot, struct sd_vnode, rb);
            rb_destroy(&vnode_info->nroot, struct sd_node, rb);
            free(vnode_info);
        }
    }
}

And they are a pair. use one and should use another.


I want to know , if I know a oid, then I want to know node that store this oid's
replication, how can I know about this. How to caculate this node id.
Also, I want to know, how to determine the node, that to store the replication
of the object. and what is the meaning of the vnode in the system.

I expriemented my guess, and my guess is right. If my cluster have only
3 node, and I have a vdi, and the vdi is stored with 3 copies, then in three
nodes, all the oids in obj path should be the same. I see the log, and them
are true. And you have to make a dir that: /tmp/sheepdog/ if the path not exist,
the the default path of sheep is /, then it will be troublesome to process with
the exrpiement.

When you write 500M data in sheepdog, then you use command
dog vdi list;
you will see, used space in your vdi is 524, why is 524 but not 500;
because the 24M is used to store sd_inode data, it use space too.

2014-3-28

It seems that I finished my reading to the code.
I should write with my paper. Just now, begin. Finished it quickly.

here show a detailed information for sheepdog.
http://www.blogjava.net/shenh062326/archive/2011/08/28/shenhong.html



2014-05-13 21:02
Tag: 文件管理系统
我想实现一个文件管理系统，用来辅助我的文件管理。我对它的功能有如下的期望：
1：将所有的最重要的文件都存放在这个一个目录A下，目录A的容量不能超过10G。
2：设置一个配置文件，用来指定哪些文件是重要的。
3：每3个小时检查一次将源文件和备份文件进行一次同步，使其保持一致，并记录独立
    的系统日志。


Tag: Sheepdog
所有的event是通过rbtree来组织的。

Tag: Epoll, Sheepdog;
需要对没一个链接建立一个文件描述符fd，当文件描述符太多的时候，为了提高系统
性能，引入了这个。用来替代以前的select poll模型。

2014-05-14 21:38
Tag: wps ubuntu;
首先是下载官方的安装包，因为我的ubuntu，下载deb的包即可。
dpkg -i *.deb
发现没办法安装。看到了提示信息，好像无法解析依赖关系，说要执行
sudo apt-get -f install
执行完了，然后会发现自动给你安装了一些库文件，之后你会发现，你的
wps已经装好了。

Tag: qq ubuntu;
之前安装了wineqq，但是启动不了，上网找了一下，原来是某些库没有安装。
sudo apt-get install  libgtk2.0-0:i386
执行上面的这个命令安装就可以了。

Tag: work
我想帮着管理这个网站。
http://glature.com/member.php?mod=register

2014-05-15 08:29
Tag: grub background
应该是修改这个文件。/etc/default/grub 在里面添加这个内容。
第一行是对应的分辨率。第二行是图片的位置。注意，这个时候系统还没有挂home分区，
所以这个图片必须放在boot分区。而不是随便一个什么位置都行。
GRUB_GFXMODE=1366x768
GRUB_BACKGROUND=/boot/grub/images/fotowall.jpg
之后是更新 grub.cfg 文件
sudo grub-mdconfig -o /boot/grub/grub.cfg
在你重启的时候，应该就可以看到你设置的背景图片了。

需要从性能方面进行描述。
首先并不是和原先想的一样，对读写没有影响。
实验如下：
计划从下面几个角度来分析：

应该是需要一个图标。列举出原系统的写入时间和读取时间。
然后列举出新系统的写入数据时间和读取时间。不用把图贴上去。
同时还要修改一些格式问题。需要加入一些过程的代码。和原风格
要想符合。

写入883M数据。
新系统
1：没有预警节点的系统。  1m37s
2：设置了预警节点的系统。 2m38s
3：关闭预警节点。 系统的读写时间。2m15s

这里对上面这个算法进行描述。在系统写入数据的入口方法，gateway_forward_request()方法中加入这个方法。
init_target_nodes,在这个方法中判断要写入数据的节点是否被与预警过，如果被预警过，对这个数据块执行增
加副本操作，如果没有被预警过，直接返回这个数据块在集群中的副本数。
gateway_forward_request() 
下一个方法的实现过程如下：首先找到这个oid的副本数目，然后在将这个obj写入到指定节点上。所以，为了实现
对预警节点被预警之后，写入到预警节点上的数据进行副本增加副本操作，就需要在这里进行判断，如果写入数据
节点是预警节点，那么对这个obj进行local_warned_repadd()操作。
在这个方法中需要

我的问题来自这个方法我没有办法理解。我不知道这个方法中的实现细节。
现在还是有些疑惑的。这些预警机制添加的副本。和系统自己创建的副本在本质上是一样的。
那么从根本上讲，需要修改获得副本的那个方法，如果添加了副本，就需要修改oid对应的copies。
但是我好像没有修改。obj_info_map是和nrcopies分开的。

Gateway: Gateway 从QEMU的块设备驱动上接收IO请求，对象ID，偏移量。长度，操作
类型等，通过哈系算法计算出目标节点，并且将该IO请求发送到目标节点上。
Object Manager：对象管理器接受网管发来的IO请求，并更具该请求对本地磁盘
执行读写操作。整个系统只有storage node 一个角色，不区分元数据和数据块。
sheepdog用corosync的多播和一致性hash算法来替代metadata server，
实现fully symmetric。gateway 是个数据对象读写的路由，根据一致性哈系算法，
定位被分割对象在节点集群的读写位置。obj manager 是本地存储的管理器。
这个地方有一些介绍。

现在可以解释为什么只有在本地的0号节点才可以看到这个debug信息。
因为我是在一个节点上开了5个sheep进程。如果分开了就不是了吧。应该
这几个节点都是在一个集群中的吧。
http://www.sheepdog-project.org/doc/more_concepts.html#

2014-5-20
https://www.ibm.com/developerworks/cn/java/j-gui/
http://www.javabeginner.com/java-swing/java-swing-tutorial
ok, my fcitx can not work with tilda, I can only use English. These are some useful
demos, I should write my own.
http://docs.oracle.com/javase/tutorial/uiswing/examples/components/index.html#TextFieldDemo

2014-05-23
只能在这里写一点东西了。昨天发现我的编程领域还是太窄，设计到界面的话，基本上是没有
应对能力的，我需要掌握一门自己喜欢的界面语言，选择java，swing。我要认真学习一下。
java 也是需要好好学习的。

2014-05-27
http://www.cnblogs.com/taoweiji/archive/2012/12/10/2812221.html


2014-05-31 13:49
Tag:vim find vim-copy

哈哈，现在可以很好的应用vim了，原来是我的了解还不够深啊，多看看就可以用得更好。
首先是插入时间，这个应该说是很方便的，但是我并不懂这个命令是怎么实现的。应该好好研究
一下哈。今天刚学到的是 find 命令，这个是用来打开文件用的，可以智能补全。之需要
设置一下路径就可以了。可以看我的配置文件啊。
set path=/home/fox
这样就不用到处找了。同时我加入了当前的路径.。还是用 konsole吧，之前遇到的问题是那个konsole
模式选错了，应该选 default的，而我选了linux的。就出现问题了，现在好了，一切正常，还是很不错
的。现在觉得这个命令真是很强大啊，对与打开文件方便了很多呢，再也不用挨个去找了啊，知道的
多办事效率也会不一样啊。

将当前文件的部分内容导入到其他文件
1,20 w>> /path/otherfile.txt
1,20 w /path/otherfile.txt
具体命令就是这样。

同样的，也可以将其他文件的内容读入到当前文件来。命令是这个
r: /path/file.txt

Sat May 31 14:06:03 CST 2014
同时，这个命令也可以将外部程序的输出读入到当前文件中。
r !date
这样也是可以插入时间的。将这个命令用map命令映射一下，就可以得到和那个实现的同样的功能
了。只不过对map什么的，我不知道怎么用。
还有之前了解过的 排版方面的功能，也都是很有用的，不过我不怎么用。用多了就好了。

vim 内容复制我还不太清楚，需要认真学习下。不只是复制当前行，还应该学会自由复制。这个才
能赶上实际需要。

首先需要补充的一点是，+寄存器是只有vim-gtk 或者 vim-gnome 才会有的，不要只安装了
vim，这是不够的啦，在安装的时候需要注意一下，不然是无法使用系统剪切板的啦。
复制单个字符， nyl n 是数字，l和vim的方向键一样，表示向后，就是向后复制n个字符。
同理，nyh 表示向前复制n个字符。这样就可以很自由的复制了。
复制单词 ynw 其中n是数字，表示要复制的单词的个数。
按行为单位复制：
nyy 表示复制n 行，和上面的命令差不多。应该是向下取的。
p 表示粘贴，注意小写，这个是代表粘贴在下面。
P 也表示粘贴，这次是大写啊，这个是代表粘贴在前面。
估计对于字符复制粘贴的内容也是同样的规则啊。
"+y 表示复制到系统剪切板去。这个应该忘不了吧。

vim 有很多的粘贴板，这些东西的用处你自己应该可以理解，一般情况下，都是只用一个粘贴板
的，但是粘贴板多一点也是没有坏处的啊。vim中的复制是用y来完成的，在这之前，你当然可以
决定你的内容是存放在那个粘贴办中，你可以用reg来查看这些粘贴板中都存了什么内容，同时
p是用来复制的，你也可以在复制之前决定你从哪个粘贴板中复制内容，例如"4p表示是从4好粘
贴板中拿东西。如果4好粘贴板中有你存下的内容的话，那么他就可以复制出来了，结合上面的
命令，你当然可以做成你想做的。
复制到第n 个粘贴板的命令: 先选择要复制的内容，然后"ny 就可以将这些内容放到粘贴板了。
然后在你想复制的地方"+p 就可以了。


Tag: grep
其实也没什么。对于每个系统版本不一样的问题，可以多用用grep命令，按照内容查找。-n -r 参数
来个通配查找基本就可以搞定了，如果出现了 某某文件没有找到的情况，请将这个文件暂时搬走，然
后尝试，估计就差不多了。这样就可以比较容易的找到你需要的信息了。
grep -nr note/*
命令是和这个类似的。
并且从这个角度出发，在你记笔记的时候加上Tag还是很有必要的。
Tag: dpkg apt-get
这个是包管理的，这方面我也马马虎虎的，不是很清楚，不知道是不是我的缺点。
http://www.cnblogs.com/balaamwe/archive/2011/10/27/2225919.html

dpkg -l | grep steam
然后就可以用dpkg -r 对应的包将它删掉了。

Tag: find
find . -name dota2 这个命令是用来查找哦啊对应文件的，按照文件进行搜索。
收拾下自己的心情，开始奋斗吧，生活还要继续，你也没有多少时间用来浪费，你只有努力才可以给
自己增值，你的价值是自己给自己的，而不是别人。只有作出贡献，才可以赢得别人的尊敬。
还是原理windows吧，学习一点有用的东西，我需要学习更多的东西。

重新开了一个kde 的配置文件，这个应该会好一点，前一个的配置文件是旧系统的，似乎老是出问题，
这个不知道能不能好一点。可能是配置文件的问题。其实桌面的配置是很简单的，除了壁纸之外，其他
的都很简单的。


Tag: kde
KDE 设置.
字体的抗拒齿。
将壁纸保存。复制在对应的目录下。 .kde/share/wallpapers/
快捷键设置。
desktop-themes 目录中的内容。
themes  .kde/share/apps/aurorae/themes/* 这个里面是和窗口主题相关的文件，可以留下来。
注意保存.vim中的文件。为了方便管理，插件什么的还是放在这个目录下吧/home/user/.vim。
.fonts 目录需要带走。
日期显示的格式 在 local 中选择日期的格式。

我发现我的kde老是出现bug和我的系统没有关系，只是和我的 .kde 有关系，用了这个新的kde之后，
就没有那个bug了。所以，听吴说的Linux坏了只需要换一下配置文件就好了，没有必要重装。而windows
烂了就只能重装了。所以说保存配置还是没有什么必要的。在新系统下去配置吧。

其实玩Linux，在很大程度上是玩配置文件。

konsole 的配置，你需要选择keyboard为 default，这样可以更顺利的使用 tmux。主要是里面的快捷键。
这也是我探索出来的。

如果你发现你喜欢的窗口主题无法很好的适配tmux和 vim，就是在最底下有一部分空的，那么你可以选择
configure decoration 来调整，选择normal一般就可以了，如果不行，选其他的试试，应该可以解决这个
问题。

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


Tag: for my backup tools;

我需要告诉程序，我需要备份那些内容，或者我的程序知道我需要备份什么内容，这些内容是我可以通过
某种方式来告诉备份程序的，我让程序备份，程序就执行备份程序。我让程序恢复，程序会将备份文件恢复
到对应的地方。
这就是我最初的构想。话说我的 Mysql 又没有了，我存入的数据又不见了，所以这样频繁的更换系统是很
不好的。

2014-06-10 01:12

刚才解决了一个java swing 的问题，虽然只是一个小问题，但总算是做出了我想要的效果。写程序就是这样
吧，我觉着做出自己想要的才是最好的。
安装了 sougoupinyin，我觉着这个比 fcitx 的pinyin强了不少，现在还不错，总之，我对现在的系统非常满
意。现在唯一的缺点是，缺少计划，缺少执行，似乎读书的能力已经没有了。
好吧，时间也差不多了，可以休息了。

2014-06-10 20:10
我应该多写一点程序什么的，而不是在这里乱敲。
sudo apt-get install libgtk2.0-0:i386
winqq 安装好无法启动，应该是少东西了，装上上面的这个包就可以了。
刚才看了看 IRC，貌似可以实用，但是我说话没人理我，还需要再研究下。

我应该将我在 sheepdog 中看到的一些c的用法拿出来测试一下，这样才算是学习了，不然，我花的那些读代码
的时间就算是白费了啊。

刚才看到，这个，blkid 可以知道一个分区的具体的 UUID。这应该是又用的，我发现我的pm-hibernate命令
没有作用，找到原因是因为我没有 swap 分区。安装一个 swap 分区就可以了。

2014-06-11 23:09

我应该继续学习sheepdog 的具体实现，学习代码是怎么实现的，这是我学习C语言的一个重要过程。
关于 struct 这个关键子还是随时带上比较好。我可以学习一下数的实现。

2014-06-12 02:22
Tag: qtcreator swap hibernate  fstab ia32libs
刚才看了下qt的东西，其实之前早已搞过，系统重装了，这又重新搞了一下啊。毕竟多学一点还是有好处的。
我想为linux做一点贡献，懂一点 qt 还是必需的啊。主要是觉着qtcreator这个东西不够人性化，我搞了好
半天才搞定。我还以为是我的 qtdesigner没有装好，原来是我把该显示的东西给关掉了，然后又不小心摸索
出来了，终于对了，其实也简单。好了，就记录这些，有空再进一步研究它的用法，争取做点有用的东西。

sudo pm-hibernate 
swap
sudo swapon /dev/sda3

/dev/sda3 swap swap defaults 0 0

ia32libs 这个东西已经deprecated 了，可以用这个来代替。lib32z1 这些东西放在我的脚本里就可以了。
这次有点失败，主要是我的swap分区没有加上，估计加上后我就可以用 pm-hibernate 了。
只有不断地练习，才能进步。

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

2014-06-13 23:39
今天将项目做出了一个比较完整的 demo，还算可以吧，我吧项目带回来了，我可以在这里看看。

2014-06-14 08:34
这是一个不错，关于 cherrypy 的配置，我之前学过，但是忘记了，现在需要重新找回来。
我擦，终于搞定了，真是不容易啊。
上次的笔记倒是找到了，不过就是用不了，可能是版本不对了，写法不一样了，由于google，被墙，现在看文档
也变的困难了，主要是配置文件，一个最简单的demo足以。


http://www.blogjava.net/wash/archive/2005/12/26/25405.html

2014-06-18 21:58
最近感觉很累，可能是休息太少吧。好好休息。把事情安排好，处理事情应该又个限度才行。

2014-06-19 08:19
应该是营养不良吧，最近在日常饮食这方面也太马虎了，感觉精神很差，上班也很费劲。看来在生活中，
对任何一方面都不能马虎。想想我的日常饮食中，除了淀粉，好像的确没什么有营养的东西，应该吃点
蛋白质什么的，早晚都喝点牛奶吧。这或许是我唯一能做的了，还可以吃点豆奶。总之，在身体着一块，
还是需要注意下。

今天基本上完成我了我的任务，老板还是比较满意的，我也觉着我的程序不错，但是还有很多要改进的
地方。我的程序能里还需要好好磨练，这一切才刚刚开始。总之，我的目标是年薪20w，现在就是向这个
目标靠近。最近状态不好，我觉着是我的日常饮食出了问题，最近确实没怎么注意这方面，我已经好久
没有喝牛奶的习惯了，我觉着这些投入是不能消减的，我应该保持对自己的投入，少吃零食，多一些在
营养方面的花费，这样对我的学习应该会有帮助吧。
其实和学校是差不多的，在上班的时候我也需要保证自己的效率。利用好自己的空闲时间来学习自己需
要掌握的知识。

Tag: c sscanf
2014-06-20 00:29
看来c 还是要不断的学习才行啊。好多东西都是慢慢理解的。
如果我是面试官，我就用这个来面试求职者，我觉着者肯定是个很好的饿问题。这完全看你是不是喜欢
编程，如果你喜欢，我觉着知道这个也不是困难的事情，应该是很容易的。

刚才重装了一下系统，还算比较顺利，就是又走了一些弯路，刚开始系统是没有安装文泉驿字体的，所以
我的系统中文字体有些是显示方块的，而有些正常，就是部分正常显示，部分不正常显示的。我以为这是
我的旧的配置文件有问题，所以就删掉了旧的配置文件，然后才发现问题还是没有消失，这才知道自己并
没有解决问题，所以觉着我自己走了弯路。其实没有必要，安装好那个文泉驿字体就可以了。
其实就是安装一个字体就可以了。
其实我最需要的是那个功能，就是 hibernate 的功能，我只是增加了一个swap分区。另外现在变成pure
的 kubuntu 了。哈哈，我的swap分区正常了，系统可以用 hibernate 功能了。这太好了。好了，我该睡
觉了。

2014-06-20 20:32
哈哈，周五了，明天休息了。这个周末要好好安排一下，不要这么随便过去。要好好休息下。
1 请人吃饭
2 中行柜台留电话号码
3 休息
4 读书
5 写一些基本算法。
大概就是这几项了。

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

2014-06-24 00:48
散伙饭。

2014-06-25 20:29

还好啦，事情还算顺利。时间也不是很多，我需要将这些东西寄回去让家里人帮我办理。

2014-06-28 23:31
好好学习啊。今天没有做出那道题，实在是很不爽啊。刷了一点基础题，还是开着我的 console 做
的呢，都没有刷到450，看来我的基础的确是差啊。学长都去腾讯了，我的压力有点大啊，我要去阿里
但我却看不到一点希望。工作好像并不能让我学到我想要的东西，是不是我要考虑辞职啊。
哎，没有办法啊，我的基础很差啊。要学会积累啊，学过的不要忘记啊，记得做笔记啊，好记性不如
烂笔头啊。

学习了一点vimscript，其实那些 .vim 插件都是可以自己写的，可以用这个脚本语言自己扩展脚本。
au InsertLeave *.cc write
调用write 在 InertLeave的时候将内容保存。这样就不用自己保存了。


2014-06-29 22:26

Tags: C 堆栈

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

老师教过我们“牛顿迭代法快速寻找平方根”，或者这种方法可以帮助我们，具体步骤如下
x= x+a/x;
算法的原理其实不复杂，就是牛顿迭代法，用x-f(x)/f'(x)来不断的逼近f(x)=a的根。

float InvSqrt(float x)
{

    float xhalf = 0.5f*x;
    int i = *(int*)&x; // get bits for floating VALUE 
    i = 0x5f375a86- (i>>1); // gives initial guess y0
    x = *(float*)&i; // convert bits BACK to float
    x = x*(1.5f-xhalf*x*x); // Newton step, repeating increases accuracy
    return x;
}

2014-06-30 20:38

最主要的问题是更新 的时候提示的错误。是还源的时候产生的。
hash sum mismatch。 这个问题之前遇到过，用之前的方法没法解决。不过不要紧，不影响使用。


学习一点 vimscript 的东西，找了半天，发现其实找到的都是从 docs 中来的，所以要学习阅读文档。
马悦说的极是啊。
今天拿到了奖金，只有500块钱，虽说和之前的0相比多了500块钱，但是感觉怎么就这么寒碜呢！！！

这可是我的季度奖金啊。
什么彩票，不管了，今晚一定要好好休息。今晚只能睡觉，随便怎么样。

我的键盘应该明天就到了，我也就这么一点追求了，照顾好自己，生活才刚刚开始。

我应该学会学习新东西，做出一点像样的产品。要大量阅读文档，锻炼自己的英文文档的学习能力。
现在的程度太差了，对于Linux系统中的文档，我应该多学一点，尽量多看看。

果然输了个精光。我觉着这个比赛就是被操控的，比赛我看了，前面没有一点要进球的迹象。
加时赛2分钟就进球了，绝对都是演员。我还想回本，但是我要不要继续投资呢，要投资可能
继续输下去。1000块钱，也不容易啊。并且还要配上好多担心，晚上觉都睡不好。

2014-07-01 07:51
我想买一个阿里云服务器，再买个域名，做点自己的东西。不然的话，我一直这样搞，也没什么劲。
想想自己丢掉的那些钱，都够买两年的时间了。

Tags: qt docs
http://www.kuqin.com/qtdocument/

LBS += -ltoxav -ltoxcore -lsodium

我也买个服务器,在上面存放我的资料,然后自动同步之类的.我可以建立一个 git 库,然后每天都将自己的
笔记push上去.这不是挺好的吗.所有的文档我都可以这样做啊.现在在本地就显得比较麻烦.如果丢了就没法
恢复了.
