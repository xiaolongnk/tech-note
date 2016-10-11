#include <stdio.h>
#include <math.h>
#include <string.h>

int s1(int A, int B)
{
    if(A < 0 && B < 0) return 0;
    if(A <= 0 && B > 0) {
        return (int) sqrt(B) + 1;
    }
    if(B <= 0 && A > 0) {
        return (int) sqrt(A) + 1;
    }
    return (int) fabs(sqrt(B) - sqrt(A)) + 1;
}

/**
 * solve problem for airplane set arrange.
 */
int solution(int N , char * S)
{
    int map[60][11];
    memset(map , sizeof(map) , 0);
    int a=-1, b=0;
    int lens = strlen(S);
    for(int i =0; i<lens; i++){
        if(S[i] == ' ') {
            map[a-1][b]=1;
            if(i <lens - 1) a = -1;
            continue;
        }
        if(S[i] >= '1' && S[i] <='9'){
            if(a == -1) a = S[i] - '0';
            else {
                a = a*10 + S[i] - '0';
            }
        }else if (S[i] >= 'A' && S[i] <= 'Z'){
            b = S[i] - 'A';
        }
    }
    if(a!=-1) map[a-1][b] = 1;
    for(int i=0; i< N; i++){
        for(int j =0 ; j<10;j++){
            printf("%d ",map[i][j]);
        }
        printf("\n");
    }
    int total = 0;
    for(int i = 0; i<N ; i++){
        if(map[i][0] == 0 && map[i][1] == 0 && map[i][2] == 0) {
            total++;
        }
        if(map[i][3] == 1 && map[i][4]==0 && map[i][5] ==0 && map[i][6] == 0){
            total++;
        }else if(map[i][3] == 0 && map[i][4]==0 && map[i][5] ==0 && map[i][6] == 1){
            total++;
        }else if(map[i][3] == 0 && map[i][4]==0 && map[i][5] ==0 && map[i][6] == 0){
            total++;
        }
        if(map[i][7] == 0 && map[i][8] == 0 && map[i][9] == 0) {
            total++;
        }
    }
    return total;
}

int main()
{
    int a , b;
    char input[1000] = "1A 2F 11C";
    int ans = solution(11,input);
    printf("%d\n",ans);
    return 0;
}
