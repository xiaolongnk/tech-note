/***
 * some test code for fread and fwrite.
 * fscanf , fprintf
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>


void from_stdin()
{
    int a , b , sum;
    while(scanf("%d%d" , &a , &b)!=EOF)
    {
        sum = a + b;
        printf("sum of %d  +  %d  =  %d\n" , a , b , sum);
    }
}

void getinput()
{
    const char * int_file_name = "in.txt";
    const char * output_file_name = "out.txt";
    const char *mode = "r";
    FILE * fp = fopen(int_file_name , mode);
    FILE * opt = fopen(output_file_name , "w");
    int a , b , sum;
    while(fscanf(fp , "%d%d" , &a , &b)!=EOF)
    {
        sum = a + b;
        fprintf(opt , "sum of %d  +  %d  =  %d\n" , a , b , sum);
    }
}

void read_from_file()
{
    const char *s = "n.bin";
    const char *mode = "rb";
    FILE *fp = fopen(s , mode);
    char * buffer;
    buffer = (char *) malloc(10000* sizeof(char));
    // read data from text to buffer , read the whole text file
    fread(buffer , sizeof(char), sizeof(buffer) , fp);
    printf("content from file : %s\n" , buffer);
    fclose(fp);
}

/***
 * usually , fwrite is used to write binary data to a binary file.
 * The same , fread is used to read a binary data.
 * So , you may need to choose these function seriously by your need.
 */
void write_data_file()
{
    // fwrite can only write binary data to file. so not the text mode.
    // it is a binary file.
    const char * n_file = "n.bin";
    FILE *fp1 = fopen(n_file , "wb");
    char buf[100];
    strcpy(buf , "100 200");
    printf("content in buf: [ %s ]\n" , buf);
    fwrite(buf ,sizeof(char), sizeof(buf) ,fp1);
    fclose(fp1);
}
/***
 * for string read and write , you may need these two functions.
 * fgets  and fputs
 */
void str_puts()
{
    const char * tmp_file = "tmp.txt";
    FILE *tmp = fopen(tmp_file , "a");
    char words[256];
    // simple fgets use.
    fgets(words , 256 , stdin);
    fputs(words , tmp);
    fclose(tmp);
}

int main()
{
    write_data_file();
    read_from_file();
    printf("Last is the printf for fputs\n");
    str_puts();
//    op_with_file();
    //getinput();
    //from_stdin();
    return 0;
}
