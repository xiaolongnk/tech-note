#include<iostream>
#include<unordered_map>
#include<memory>

#ifndef a
#define test
#endif

#if defined(test)
#define bb 1
#endif
using std::make_shared;
using std::cout;
using std::endl;
using std::unordered_map;
using std::shared_ptr;
using std::unique_ptr;
using std::auto_ptr;

int main()
{
    int a  = 10;
    const int *b = &a;
    int const * c = &a;
    int * const d = &a;
    *d = 100;
    cout<<*d<<endl;

    // part for shared_ptr
    struct MyStruct {
        MyStruct(int ii) : i(ii)  {
            cout<<"MyStruct () i = " << i <<endl;
        } 
        ~MyStruct() {
            cout<<"MyStruct deleted"<<endl;
        }
        int i;
    };

    {
        shared_ptr < MyStruct> spMyStruct(new MyStruct(10));
        // shared_ptr has deplicit convert to bool , check if the pointer have bind a resource
        if(spMyStruct) {
            cout<<"1 spMyStruct use count ="<<spMyStruct.use_count()<<endl;
            shared_ptr<MyStruct> sp1 = spMyStruct;
            cout<<"2 sp1 use count ="<<sp1.use_count()<<endl;
            shared_ptr<MyStruct> sp2(sp1);
            cout<<"3 sp2 use count ="<<sp2.use_count()<<endl;
            sp2.reset();
            cout<<"4 After reset , use count fo sp2 ="<<sp2.use_count()<<endl;
        }
        cout<<"5 sp1 and sp2 out of scope"<<endl;
        cout<<"6 use count"<<spMyStruct.use_count()<<endl;
        cout<<"spMyStruct out of scope."<<endl;
    }

    shared_ptr<int> spInt = make_shared<int>(540);
    cout<<*spInt<<endl;
    cout<<spInt<<endl;
    return 0;
}
