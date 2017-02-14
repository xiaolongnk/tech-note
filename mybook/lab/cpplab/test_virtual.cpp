#include <iostream>

using std::cout;

template < typename T> 
ostream &print(ostream &os , const T &t) {
    return os<< t; // no separetor after the last element in the pack.
}

template < typename T , typename ... Args>
ostream &print(ostream &os , const T &t ,  const Args&... rest) {
    os<< t <<",";              // print the first argument
    return print(os , rest...);// recursive call , print the other argument 
} 


int c (char c)
{

}

double c(int c){

}


#define HELLOWORLD(cccc)



int main()
{
    print (cout , 1,2,3,4,5);
    HELLOWORLD(123);
    return 0;
}
