#include <iostream>
#include <string>
#include <vector>
#include <sstream>

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
    const string full_taboola = "Powered By Taboola";
    // len is 17 , powerd by can be skipped whose length is 10.
    const string only_taboola = "Taboola"; // len is 8
    const string min_space    = "        ";
    string taboola_source     = "";
    int cursor = 9 - source.length();
    int delta = 5;
    if( cursor > 0 ) {
        string blank_space = "";
        for(int j = 0 ; j < (cursor + 4 + delta) ; ++j ) blank_space += " ";
        taboola_source = source + min_space + blank_space + full_taboola;
    } else if ( cursor > -11 ) {
        string blank_space = "";
        for(int j = 0 ; j < (15 + cursor + delta)   ; ++j ) blank_space += " ";
        taboola_source = source + min_space + blank_space + only_taboola;
    } else {
        return source;
    }
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

int main()
{
    vector<string> test;
    for(short i = 0 ; i < 40 ; ++i){
        string s = "";
        for(short j = 0; j < i ; ++j){
            s += "x";
        }
        test.emplace_back(s);
    }
    test_stringstream();
    return 0;
}
