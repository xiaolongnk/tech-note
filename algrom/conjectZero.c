#include <stdio.h>

int solution(int N) {
    // write your code in C99 (gcc 4.8.2)
    int max = 0;
    int latestMax = 0;
    int tmpBit = -1;
    int startFlag = -1;
    while(N){
        tmpBit = N & 1;
        if(tmpBit == 0) {
            if(startFlag == 1){
                latestMax++;
            }
        } else {
            startFlag = 1;
            if(latestMax > max){
                max = latestMax;
            }
            latestMax = 0;
        }
        N = N>>1;
    }
    return max;
}

int main()
{
    int input = 0;
    int ans = 0;
    while(scanf("%d",&input)){
        ans = solution(input);
        printf("%d\n",ans);
    }
    return 0;
}
