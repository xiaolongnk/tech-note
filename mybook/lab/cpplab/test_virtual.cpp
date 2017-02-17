#include <iostream>

using namespace std;

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
    return 1;
}

double c(int c){
    return 0.1;
}

#ifndef
#define HELLOWORLD(cccc)
#endif

class Vehicle {
    public:
        explicit Vehicle( int topSpeed ) : m_topSpeed (topSpeed ) {}
        int TopSpeed() const{
            return m_topSpeed;
        }

        virtual void Save( std::ostream & ) const = 0;
        // above is a pure virtual function. so this is an abstract class.
    private:
        int m_topSpeed;
};

class WheeledLandVehicle : public Vehicle {
    public:
        WheeledLandVehicle ( int topSpeed , int numberOfWheels )
            : Vehicle (topSpeed) , m_numberOfWheels( numberOfWheels) {}

        int NumberOfWheels() const {
            return m_numberOfWheels;
        }

        void Save( std::ostream & ) const; // is implicitly virtual
    private:
        int m_numberOfWheels;
};

class TrackedLandVehicle : public Vehicle {
    public:
        TrackedLandVehicle ( int topSpeed , int numberOfTracks )
            : Vehicle ( topSpeed ) , m_numberOfTracks ( numberOfTracks ){}
        int NumberOfTracks () const {
            return m_numberOfTracks;
        }
        void Save( std::ostream & ) const; // is implicitly virtual
    private:
        int m_numberOfTracks;
};

int main()
{
    print (cout , 1,2,3,4,5);
    int a = HELLOWORLD(123);
    cout<<a<<endl;
    return 0;
}
