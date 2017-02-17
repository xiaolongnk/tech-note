#include <string>
#include <iterator>
#include <iostream>
#include <algorithm>
#include <array>
#include <vector>
#include <set>

using std::array;
using std::cout;
using std::string;
using std::sort;
using std::reverse_copy;
using std::ostream_iterator;
using std::vector;
using std::copy;
using std::endl;
using std::set;

template<class T>
void print_range(T first , T last , char const * delim = "\n")
{
    --last;
    for(;first != last ; ++first) {
        cout<<*first<<delim;
    }
    cout<<*first;
}

void test()
{
    int a[5] = {1,2,3,4,5};
    vector<int> v(a , a+5);
    print_range(v.begin() , v.end() , "->");
    cout<<endl;
    print_range(v.rbegin() , v.rend() , "<-");
}

void test_shrink()
{
    vector<int> a(100);
    cout<<"size of my vector is: "<<a.capacity()<<endl;
    a.resize(10);
    cout<<"size of my vector is: "<<a.capacity()<<endl;
    a.shrink_to_fit();
    cout<<"size of my vector is: "<<a.capacity()<<endl;
}

int main()
{
    array<int , 3> a1{{1,2,3}};
    array<int , 6 > a2 = {1,2,3 , 4, 5,6};
    array<string , 2> a3 = {string("a") , "b"};

    sort(a1.begin() , a1.end());
    array<int , 6> aa;
    int a11[6];


    vector<int> v1 = {11,22,33,44,55,66};
    for(auto it = v1.begin() ; it!=v1.end(); ++it) {
        cout<<*it<<" ";
    }
    cout<<endl;


    vector<int> v3;
    v3.swap(v1);
    //reverse_copy;(a2.begin() , a2.end() , stream_iterator<int>(cout, " "));
    //v3.assign(v1.begin() , v1.end());
    reverse(v3.begin(), v3.end());
    for(const auto & x:v3) cout<<x<<" ";
    cout<<endl;
    for(const auto& s: a3)
        cout<< s <<' ';
    cout<<"+++++++++++++++++++"<<endl;
    test();
    cout<<endl;

    test_shrink();
    return 0;
}
