---
title: C/C++ 学习笔记
categories:
- c++
tags:
- c/c++
---

#### C文件的编译过程

编译一个c文件，产生一个可执行文件，这个过程分为四个步骤
1. .c 文件到 .i 文件， `-->` .s 文件 `-->` .o 文件 `-->` 可执行文件
   分别是预处理， 编译， 汇编， 链接

预处理所做的事情。

gcc -o helloworld.i helloworld.c -E

1. 将 include 变成真实的东西
2. 宏替换。 
3. 宏函数的优点。比一些函数要方便，
4. 条件编译，对于程序的移植和调试，非常有用。

#### typedef 和 宏不一样的地方。

给自己自定义的数据类型起一个别名。自定义的数据类型使用起来非常不方便。别名之后可以比较方便。
typedef 是有作用域的。函数中的typedef，只能在函数中起作用。

#### ifndef 用法

for example your .h file is named head.h and content like this.

```c
#ifndef _HEAD_H_
#define _HEAD_H_

this is your class definition area.

#endif
```

in your project, there are source file import it.
for example.

```c
#include <iostream>

#include "head.h"
#include "head.h"

```
if you include "head.h" twice, you find you can compile your file as well.
but if your head.h is writte without #ifndef, #define #endif, then you must
will get an error to stop your working.

also, here the use of,

#ifdef
#else
#endif

this condition definition can save your release code size :).

what is different between static type and dynamic type.
static type: know when program is in compile process.
dynamic type: know only in the run process.  For pointer type.

#### 计算一个数的算术平方根

老师教过我们"牛顿迭代法快速寻找平方根"，或者这种方法可以帮助我们，具体步骤如下
x= x+a/x;
算法的原理其实不复杂，就是牛顿迭代法，用x-f(x)/f'(x)来不断的逼近f(x)=a的根。

```c
float InvSqrt(float x)
{

    float xhalf = 0.5f*x;
    int i = *(int*)&x; // get bits for floating VALUE 
    i = 0x5f375a86- (i>>1); // gives initial guess y0
    x = *(float*)&i; // convert bits BACK to float
    x = x*(1.5f-xhalf*x*x); // Newton step, repeating increases accuracy
    return x;
}
```

#### C++ rand lib

```
#include <stdlib>
srand((usigned)time(NULL));
```
