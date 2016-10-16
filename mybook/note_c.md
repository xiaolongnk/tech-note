---
title: C学习笔记
tags:
- c
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



#### C语言中的宏

1. 条件宏

		#include <iostream>
		#include "head.h"
		#include "head.h"
		if you include "head.h" twice, you find you can compile your file
		 as well.but if your head.h is writte without #ifndef, #define #endif, then you must will get an error to stop your working.also, here the use of,

		#ifdef
		#else
		#endif
		this condition definition can save your release code size :).what is different between static type and dynamic type.static type: know when program is in compile process.dynamic type: know only in the run process.  For pointer type.
		
2. 宏函数,宏可以实现一个函数的功能，这样可以减少函数调用的消耗。函数中可以有参数，宏的功能也比较强大，远远不止是定义一个常亮那么简单,线面是一个简单的例子。并且宏中也可以调用另一个宏，就像函数调用那样,但是必须保证顺序。

		注意使用do-while的格式。这样会比较安全（可以避免在宏后面增加一个；而带来的语法问题）。	
		例如下面的代码
        #define swap(a , b)                 \
            *(a) = (*(a)) ^ (*(b));         \
            *(b) = (*(a)) ^ (*(b));         \
            *(a) = (*(a)) ^ (*(b));   

		#define msort(a , n )               \
    	do{                                 \
        	for(int i = 0; i < n; i++){     \
            	for(int j =0 ; j < i ;j++){ \
                	if(a[i] < a[j]) {       \
                   		swap(a+i , a+j);    \
                	}                       \
            	}                           \
        	}                               \
    	}while(0)                           

#### C 指针(函数指针)

1. `int (*) p[10]` 本质上是一个指针，指向一个有10个元素的数组。指针数组。
2. `int * p[10]` 本质上是一个数组，数组里面的每一个元素都是一个`int*`类型的指针。数组指针。
3. 函数指针，函数指针可以作为一个普通的指针，既然它是一个指针，就可以通过参数来传递。下面是作为参数。可以参考下面的例子。

```c
#include <stdio.h>
#include <stdlib.h>

typedef int (* funcType) (int); /*定义一个函数指针的类型*/

int func (int);  /*函数指针*/
int func_test(funcType fp , int); /*用函数指针作为参数*/


int func(int a)
{
    return a+1;
}

int func_test(funcType fp , int a)
{
    return fp(a);
}

int main()
{
    int abc = 100;
    /*定义一个函数指针，指向一个函数。函数名本质上是一个指针常量*/
    funcType hello = func;
    int dd = (*hello)(abc);
    printf("value of variable dd  is %d\n",dd);
    abc = func_test(func , abc);
    printf("%d\n",abc);
    return 0;
}
```

#### 一些语言细节

1. malloc 和 calloc的区别。  malloc 可以分配内存，但是不做初始化。calloc也是分配内存，但是给你做初始化，新能比malloc差一点。但是在需要初始化的时候，用calloc可以省去memset的函数调用时间，看需求来定。注意malloc和calloc的参数的不同,malloc 只需要一个参数。`realloc`的使用,比如你给int *a分配了10个空间，现在发现10个不够了，那么你需要realloc以下。realloc的指针必须是没有free的。
2. 使用math.h的时候，在编译的时候需要加上`-lm` 参数。
