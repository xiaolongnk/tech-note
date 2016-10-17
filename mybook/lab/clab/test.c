#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define xxt 1

#ifdef xxt
#define mmx(x , y) \
    (x>y)?x:y

#define N(x)              \
    do {                  \
        x = x + 1;        \
        printf("%d\n",x); \
    }while(0)
#define hello "xxhh"

#else

#define hello "hello"
#define world "world"
#endif

int tt(int a, int b)
{
    mmx(a,b);
}

int main()
{
    char **s;
    s = malloc(sizeof(char)*8);
    strncpy(s ,"hello worldasdf",8);
    printf("%s\n",s);
    return 0;
}
