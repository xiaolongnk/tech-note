---
title: C学习笔记
date: 2016-08-28 17:39
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

#### C 中的extern关键字

1. 让变量可以在其他文件中也可以使用。只能对全局变量起作用，不在全局作用域会导致编译报错。本质上是为了多个文件中共享变量，在工程中，可以让工程更好维护。
2. 需要注意的是，c语言中的函数原型本身具有外部链接属性，所以对与函数而言，用不用extern都是一样的。所以呢，对于extern来说，用在变量上可能作用更大一些。在C语言中，extern变量的存在改变了变量的链接属性，用extern关键字修饰的变量其定义将在别处，编译器的变量解析将推迟到链接上。
3. 一般来说，C工程的管理方式是将所有的外部函数定义在一个.h文件中。在需要用到这些函数的C文件中，包含这个.h文件就可以了。但是如果没有用.h 文件的话，这个时候就必须在主文件中用extern申明一下用到的函数了，但是这并不是必须的，没有这个extern也是可以的，所以extern对于函数来说，不是必须的，完全可以忽略，对于函数，作用不大。
4. 函数可以申明多次，编译并不会报错，但是只能定义一次。

下面是一个具体的例子:里面函数申明前面的extern关键字都可以没有，函数默认有了这个属性。

```c
/*** main.c ***/

#include <stdio.h>
#include "b.h"

extern void print_hello(char *);
const int TSM = 10000;
int main()
{
    print_hello("hello world");
    return 0;
}


/*** b.h ***/

#ifndef B_H
#define B_H

extern int print_hello(char *);

#endif

/*** b.c ***/

#include <stdio.h>

extern int TSM;
void print_hello(char *s)
{
    printf("\t\t%s\n",s);
    printf("%d\n",TSM);
}

```

#### 一些语言细节

1. malloc 和 calloc的区别。  malloc 可以分配内存，但是不做初始化。calloc也是分配内存，但是给你做初始化，新能比malloc差一点。但是在需要初始化的时候，用calloc可以省去memset的函数调用时间，看需求来定。注意malloc和calloc的参数的不同,malloc 只需要一个参数。`realloc`的使用,比如你给int *a分配了10个空间，现在发现10个不够了，那么你需要realloc以下。realloc的指针必须是没有free的。
2. 使用math.h的时候，在编译的时候需要加上`-lm` 参数。
3. c语言的struct关键字，在定义节点的时候都需要带上，这一点和c++不同，需要注意。可以用typedef来简化这一点。typedef可以出现在结构体定义之前。
