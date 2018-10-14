#coding:utf-8
'''
little test for urllib2 and beautifulsoup
'''
import urllib2
import cookielib
from bs4 import BeautifulSoup
import re


url = "http://blog.nofile.cc"

print "method 1"

resp1 = urllib2.urlopen(url)


print resp1.getcode()

print len(resp1.read())

print 'method 2'

req = urllib2.Request(url)
req.add_header('user-agent' , 'Mozilla/5.0')

resp2 = urllib2.urlopen(req)

print len(resp2.read())

print 'method 3'
cj = cookielib.CookieJar()

opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
urllib2.install_opener(opener)
resp3 = urllib2.urlopen(url)
print resp3.getcode()
print cj
html_doc = resp3.read()

#### here for beautifulsoup.
soup = BeautifulSoup(html_doc , 'html.parser' , from_encoding='utf-8')

print 'get all links in this page.'
links = soup.find_all('a')

for link in links:
    print link.name , link['href'] , link.get_text()
