#include <iostream>
#include <string>
#include <vector>

using std::string;
using std::vector;
using std::cout;
using std::endl;


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
    return 0;
}
