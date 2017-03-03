#include <iostream>
#include <curl/curl.h>
#include <boost/asio.hpp>
#include <boost/bind.hpp>
#include <vector>
#include <ctime>

using namespace std;

int main()
{
	curl_global_init( CURL_GLOBAL_ALL );
	CURL * myHandle;
	CURLcode result; // We’ll store the result of CURL’s webpage retrieval, for simple error checking.
	myHandle = curl_easy_init ( ) ;
	// Notice the lack of major error checking, for brevity
	curl_easy_setopt(myHandle, CURLOPT_URL, "http://www.example.com");
	result = curl_easy_perform( myHandle );
    cout<<result<<endl;
	curl_easy_cleanup( myHandle ); 
	printf("LibCurl rules!\n");
    
    std::time_t t = std::time(0);  // t is an integer type
    std::cout << t << " seconds since 01-Jan-1970\n";
	return 0;
}
