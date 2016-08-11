#!/bin/python2.7

##this is O(N^2) version
class Solution(object):
    def lengthOfLongestSubstring(self, s):
        """
        :type s: str
        :rtype: int
        """
        if s=="":
            return 0
        lt = list(s)
        maxLen = 1
        begin = 0
        o_s = enumerate(lt)
        for k,v in o_s:
            o_s1 = enumerate(lt[k+1:])
            nk = 1
            ha = [v]
            for k1, v1 in o_s1:
                nk = k1 + 1
                if v1 not in ha:
                    ha.append(v1)
                    nk = len(ha)
                else:
                    break
            if nk > maxLen:
                begin = k + 1
                maxLen = nk
        return maxLen

    def lengthOfLongestSubstringV1(self , s):
        if s == '':
            return 0
        
        return -1;


if __name__ == '__main__':
    s = Solution()
    test = "c"
    print s.lengthOfLongestSubstring(test)
