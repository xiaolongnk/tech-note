#include <iostream>
#include <string>
#include <vector>
#include <stack>
#include <sstream>
#include <iomanip>

using namespace std;


/***
 * max length of the ads position can display is 34;
 * min_space between source and taboola is 8 blank space;
 * if source is longger , then Powerd By can be skipped;
 * if source is still logger , then Powered By Taboola can be skipped;
 *
 * @date: 2017-03-03 18:44
 ***/
string get_taboola_source(const string & source)
{
    const string string_full_taboola = "      Powered By Taboola";
    string taboola_source = "";
    ushort source_length = source.length();
    if( source_length > 10) {
        //width is bigger than 10 , splice and add ...
        taboola_source = source.substr(0 , 10);
        taboola_source += "... ";
    }else {
        // no add ...
        ushort delta = 19 - source_length;
        taboola_source = source;
        for (ushort i = 0; i < delta; ++i) {
            taboola_source += " ";
        }
    }
    int delta = 0;
    for(ushort i = 0 ; i <= 10 && i < source.length(); ++i){
        if(source[i] == ' ') {
            taboola_source += " ";
        }
    }
    taboola_source += string_full_taboola;
    return taboola_source;
}


/***
 * simple test code for stringstream.
 * 2017-03-06 17:37
 */

void test_stringstream()
{
    stringstream hello;
    hello<<"xx"<<"wew"<<123123;
    string result;
    hello>>result;
    cout<<result<<endl;

    hello.clear();
    hello.str();
    hello<<"3333"<<"123123"<<"hello world";
    string ch;
    hello>>ch;
    cout<<ch<<endl;
    cout<<"============="<<endl;
    cout<<ch.c_str()<<endl;
}

void test_string()
{
    string h1 = "7.2.0.0";
    string h2 = "7.2.1";
    if(h1 >= h2) {
        cout<<"Yes"<<endl;
    }
}

void test_taboola()
{
    vector< string > ss;
    for(ushort i = 0 ; i< 20 ; ++i){
        string  s = "";
        for(ushort j = 0 ; j < i ; ++j) {
            s += "a";
        }
        ss.emplace_back(s);
    }

    for(const auto & x : ss){
        cout<<get_taboola_source(x)<<endl;
    }
}


/**
 * return  1 if v1 > v2
 * return  0 if v1 == v2
 * return -1 if v1 < v2
 * 2017-03-16 15:36
 */
int version_larger_simple (const string & v1 , const string &v2)
{
    if( v1 == v2 ) return 0;
    else if( v1 > v2 ) return 1;
    else return -1;
}

/**
 * return  1 if v1 > v2
 * return  0 if v1 == v2
 * return -1 if v1 < v2
 * return -2 if v1 or v2 illegal
  *2017-03-16 15:36
 */
int version_larger_strong (const string &v1 , const string &v2) 
{
    // version illegal check.
    
    for(ushort i = 0 ; i < v1.length() ; ++i) {
        if(!((v1[i] == '.') || v1[i] >= '0' && v1[i] <='9')) {
            return -2;
        }
    }
    for(ushort i = 0 ; i < v2.length() ; ++i) {
        if(!((v2[i] == '.') ||v2[i] >= '0' && v2[i] <='9')) {
            return -2;
        }
    }

    istringstream is1(v1) , is2(v2);
    string token;
    stack<string> mst1;
    long f_value = 0 , s_value = 0;
    const int base = 10000;

    while(getline(is1 , token , '.')) {
        mst1.push(token);
    }

    ushort cnt = 0;
    int power = 1;
    unsigned short tmp = 0;
    while(!mst1.empty()) {
        tmp = atoi(mst1.top().c_str());
        for(ushort i = 0; i <  cnt; ++i) {
            power *= base;
        }
        f_value += power * tmp;
        mst1.pop();
        ++cnt;
    }

    while(getline(is2 , token , '.')) {
        mst1.push(token);
    }

    cnt = 0;
    power = 1 ;
    tmp = 0;
    while( !mst1.empty()) {
        tmp = atoi(mst1.top().c_str());
        for(ushort i = 0; i < cnt ; ++i) {
            power *= base;
        }
        s_value +=  power * tmp;
        mst1.pop();
        ++cnt;
    }
    if(f_value == s_value) return 0;
    else if(f_value > s_value) return 1;
    else return -1;
}



void test_compare()
{
    string s1 , s2;
    short flag1 =0 ,flag2 = 0;
    while(cin>>s1>>s2) {
        flag1 = version_larger_simple(s1 , s2);
        flag2 = version_larger_strong(s1 , s2);
        cout<<left<<setw(15)<<s1<<left<<setw(10)<<s2<<right<<setw(5)<<flag1<<right<<setw(5)<<flag2<<endl;
    }
}

int main()
{
    test_compare();
    return 0;
}
