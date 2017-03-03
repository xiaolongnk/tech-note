/**
 * simple thread test code
 * 2017-02-22 20:31
 * compile this with command:
 * g++ -g -o 1 test_thread.cpp -std=c++14 -lpthread
 */
#include <iostream>
#include <thread>

using namespace std;


void foo(int a)
{
    cout<<"foo: "<<a<<endl;
}

class Bar
{
    public:
        void operator() (int a)
        {
            cout<< a <<endl;
        }
        void operator[] (int a)
        {
            cout<< "hh "<< a << endl;
        }
};

int main()
{
    Bar bar;
    bar(123);
    bar[12323];
//  std::thread thread(bar, 10);
//  thread.join();
    cout<<"finished"<<endl;
    return 0;
}
