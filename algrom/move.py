# you can write to stdout for debugging purposes, e.g.
# print "this is a debug message"

def solution(A, K):
    # write your code in Python 2.7
    ml = len(A)
    ans = []
    for i in range(0,ml):
        idx = i - K
        if idx < 0:
            ans.append(A[(idx + ml)%ml])
        else:
            ans.append(A[idx%ml])

    return ans

if __name__ == '__main__':
    print solution([3,4],11)
