#!/usr/local/bin/python3
#coding: utf-8

'''
函数有多个可省略参数，如何给指定的参数传值
'''
def funx(a =None , b =None , c = None):
    print ("a b c => %s %s %s" % (a , b ,c))

if __name__=='__main__':
    funx(a=2)
    funx(b=1)
    funx(c=33)
    funx(a=1,c=2)
