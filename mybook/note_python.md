---
title: Python 学习笔记
categories:
- programming
tags:
- Python
---

#### __call__  __getattr__  

这两个内置函数是非常有用的,首先这两个函数是可以给类定义的.只有在class中才能实现这两个函数.

__call__ 这个方法,可以让对象的实例作为一个无名函数被使用.实际上是给class重定义了`()`运算符.

每次通过实例访问属性,都要经过 `__getattributge__()` 如果属性没有定义,还需要访问 `__get_attr__()`


参考资料  
<http://www.cnblogs.com/btchenguang/archive/2012/09/17/2689146.html>
创建一个类的静态方法,  
```python
def A(object):
@staticmethod
def hello():
    return "hello world"

def world(self):
    return "class instance method"

```

静态方法  
```python
class A(object):
@classmethod
def foo(cls):
    print 'class name is',cls.__name__


def 

```
类似的还有这些方法 `__getitem__, __setitem__, __delitem__`  
这几个方法比较容易理解,就是对一个类的实例,可以按照下标的方式进行访问. 无需过多解释.

#### __get__ , __set__  方法
这两个方法原理,需要研究一下.


#### python REGULAR EXPRESSIOn

正则中的正向引用的问题，其实还是有一定的问题的。
我发现下面的引用并不能成功,不知道是为什么。所以只能放弃\1的写法，重复写前面的那个。
期望可以匹配出字符串中的日期。
这个正向引用的问题，希望以后可以有机会解决。

```python
regex= r"[\d]{4}(-)[\d]{1,2}\1[\d]{1,2}"
ans = re.findall(regex , origin_str)
str = ['nasdfasfd2015-12-31' , 'asdlasdff2015-12-11']

regex= r"[\d]{4}[-|\/|\.][\d]{1,2}[-|\/|\.][\d]{1,2}"
ans = re.findall(regex , origin_str)

```
__file__ 你不知到的。

如果脚本是以相对路径被执行的，返回的是“” ， 并不会返回脚本当前目录。
只有脚本是以绝对路径执行的时候，才会有对应的目录，这个问题需要注意。

shutil 可以操作文件目录，包括复制，移动，删除。比较常用。
os.getcwd() 可以替代 os.path.dirname(__file__) ,   这种方式有时候不如前者可靠。

python 变量不定义之前就使用是会报错的。

Python 还需要进一步学习，现在掌握的还是不够的，需要进一步加强。

我发现上面的说法并不一定正确,getcwd 这个东西要小心使用,应该认真阅读一下这个方法的文档.
它可能并不适用你的场景.在本质上,我需要的事这个东西.

```
Python 获取当前脚本文件路径目录
# -*- coding: cp936 -*-
import sys,os
#获取脚本文件的当前路径
def cur_file_dir():
#获取脚本路径
    path = sys.path[0]
    #判断为脚本文件还是py2exe编译后的文件，如果是脚本文件，则返回的是脚本的目录，如果是py2exe编译后的文件，则返回的是编译后的文件路径
    if os.path.isdir(path):
        return path
    elif os.path.isfile(path):
        return os.path.dirname(path)
        #打印结果
print cur_file_dir()
```

### python excel 操作.
完成了一个python 导入到处数据的功能.用到了这两个module

xlwt, xlrd .  这个仅支持 xls 类型的excel. xlsx部支持.
首先是安装 pip . 

sudo apt-get install python-dev
sudo apt-get install libmysqlclient-dev
sudo apt-get install python-pip
pip install mysql-python
pip install xlwt 
pip install xlrd

数据库操作记得 commit .
插入数据和写入数据的时候注意 转义.

python MySQLdb 也可以绑定变量,这样可以不用关心特殊字符. 类似PHP.

全局变量的引用,应该使用global字段.

├── data_import
│   ├── import.py
│   ├── __init__.py
│   ├── merge_files.py
│   ├── Utils.py
│   └── Utils.pyc
├── files
│   ├── final_brand.txt
│   ├── final_brand.xls
│   └── up1.xls
└── README.md
python 从数据库中取出中文内容乱码.
unicode  需要decode成utf8 的才可以,还需要其他的设置,完了需要一一验证.

下面是示例代码:

今天想到了python的爬虫框架。刚才查了一下，发现了scrappy这个东西。后面要找时间了解一下。
http://www.jianshu.com/p/078ad2067419


2015-01-06 14:30

```python
unicodedecodeerror: 'ascii' codec can't decode byte 0xef in position 0: ordinal not in range(128)
import sys
sys.reload()
sys.setdefaultencoding("utf-8")
```
