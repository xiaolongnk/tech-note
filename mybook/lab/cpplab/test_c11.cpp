/**
 * this program is aimed for c++11 feature test.
 * make this program with 
 * -std=c++11
 *
 */

#include <iostream>
#include <array>
#include <vector>
#include <deque>
#include <map>
#include <queue>
#include <algorithm>
#include <unordered_map>
#include <string>
#include <iterator>
#include <cmath>
#include <typeinfo>

using std::cout;
using std::endl;

struct hello
{
    int i = 10;
};

void refer(hello &x);

void test_vector()
{
//    std::vector<int> v = { 7 , 5, 16 , 8};
//    v.push_back(25);
//    v.push_back(13);
//    for(int n:v){
//        std::cout << n <<"\n";
//    }
//    std::cout<<v.size()<<std::endl;

//    std::deque<int> d = {5,6,7,8};
//    d.push_front(4);
//    d.push_back(9);
//    for(int n:d)
//        std::cout<<n<<std::endl;
    std::unordered_map<std::string , std::string> u = {
            {"RED" , "#FF0000"},
            {"GREEN" , "#00FF00"},
            {"BLUE" , "#0000FF"}
    };
    for( const auto& n :u){
        std::cout << "Key:[" << n.first << "] Value:[" << n.second <<"]\n";
    }
    u["BLACK"] = "#000000";
    u["WHITE"] = "#FFFFFF";

    std::cout << "The HEX of color RED is:[" << u["RED"] << "]\n";
    std::cout << "The HEX of color BLACK is:[" << u["BLACK"] << "]\n";
}

void test_array()
{
    std::array<int , 3> a1 {{ 2, 1, 3}};
    std::array<int , 3> a2 = {1 , 2 , 3};
    std::array<std::string , 2> a3 = {std::string("a") , "b"};

    std::sort(a1.begin() , a1.end());
    std::reverse_copy(a2.begin() , a2.end(),
                      std::ostream_iterator<int>(std::cout , " "));
    std::cout<< '\n';

    for(const auto& s:a1) std::cout << s << ' ';
    std::cout<<std::endl;
    for(const auto& s:a3) std::cout << s << ' ';
}


template<typename T> void print_queue(T& q){
    while(!q.empty()){
        std::cout << q.top() <<" ";
        q.pop();
    }
    std::cout<< '\n';
}


void test_priority_queue()
{
    std::priority_queue<int> q;
    for(int n:{1,8,5,6,2,3,0,7,3})
        q.push(n);
    print_queue(q);


    std::priority_queue<int , std::vector<int> , std::greater<int> > q2;
    for(int n :{1,8,5,6,2,3,0,7,3})
        q2.push(n);

    print_queue(q2);

    auto cmp = [](int left , int right) {return (left ^ 1 ) < (right ^ 1);};
    std::priority_queue<int , std::vector<int> , decltype(cmp) > q3(cmp);

    for(int n : {1,8,5,6,2,3,0,7,3})
        q3.push(n);
    print_queue(q3);

}



template< class T , class U>
auto add(T t , U u) -> decltype(t + u) // the return type is tyep type of operator + (T , U)
{
    return t + u;
}

auto get_fun(int arg) -> double (*) (double)  // same as: double (*get_fun(int))(double)
{
    switch (arg)
    {
        case 1: return std::fabs;
        case 2: return std::sin;
        default: return std::cos;
    }
}

void test_auto()
{
    auto a = 1 + 2;
    std::cout << "type of a:"<< typeid(a).name() << '\n';
    auto b = add(1 , 1.2);
    std::cout << "type of b: " << typeid(b).name() << '\n';
    auto c = {1,2};
    std::cout << "type of c: " << typeid(c).name() << '\n';

    auto my_lambda = [](int x){ return x + 3; };
    std::cout << "my_lambda: "<< my_lambda(5) << '\n';

    auto my_fun = get_fun(2);
    std::cout << "type of my_fun: " << typeid(my_fun).name() << '\n';
    std::cout << "my_fun: " << my_fun(3) <<'\n';
}



void test_refer()
{
    hello x;
    x.i = 100;
    cout<<x.i<<endl;
    hello *c = &x;
    cout<<c->i<<endl;
    refer(x);
    cout<<x.i<<endl;
}

void refer(hello & x)
{
    x.i = 200;
}

int main()
{
    test_refer();
    return 0;
}
