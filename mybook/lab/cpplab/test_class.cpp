#include <iostream>
#include <string>
#include <vector>
#include <stdio.h>

using std::string;
using std::vector;
using std::cout;
using std::endl;


#define LOG(format, ...) \
            printf("[%d] [%x] "format "\n",11, 22, ##__VA_ARGS__)


class Student
{
    private:
        int age;
        string name;
        string birthday;
        vector<float> grades;
        Student(int age =0 , string name = "" , string birthday = ""){
            this->age = age;
            this->name = name;
            this->birthday = birthday;
        }

    public:
        // c++ 11 forbiden use non const static member.
        const static int ref = 0x11;

        void setBirthday( string birthday) {
            this->birthday = birthday;
        }

        void setAge(int age) {
            this->age = age;
        }

        void setName(string name){
            this->name = name;
        }

        void printInfo() const {
            cout<<"Name     is:"<<this->name<<endl;
            cout<<"Age      is:"<<this->age<<endl;
            cout<<"birthday is:"<<this->birthday<<endl;
        }
        void hello(int a) {
            cout<<a<<endl;
        }
        void hello(float b) {
            cout<<b<<endl;
        }

        static Student& getInstance()
        {
            static Student instance;
            return instance;
        }

        ~Student()
        {
            cout<<"destructed"<<endl;
        }
};

int main()
{
    cout<<Student::ref<<endl;
    Student &p = Student::getInstance();
    p.printInfo();
    p.setAge(11);
    p.setName("ouxiaolong");
    p.setBirthday("1989-10-18");
    p.printInfo();
    int a = 100;
    float b=12.33;
    p.hello(a);
    p.hello(b);

    LOG(" %s hello %d" , "what is your name" , 333);
    return 0;
}
