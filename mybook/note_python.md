### note for python

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

