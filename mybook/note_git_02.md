![git linux](https://omssgfgqf.qnssl.com/images/2017/11/25/15116072519020.jpeg)

这里整理了一些学习Git过程中遇到的一些问题，大部分的解决方案都来自Stackoverflow。这些问题比较散乱，相互间联系很弱，但是都是一些很容易遇到的问题，有较高的使用价值，所以整理一下，作为日后参考。
1.【git error object file is empty】[git error object file is empty](http://stackoverflow.com/questions/11706215/how-to-fix-git-error-object-file-is-empty)
2.【Git 删除远端已经合并的分支】在开发过程中，尤其当团队比较大的时候，项目成员比较多，git的分支可能会会多。好多已经开发完成并合并到主干的分支，都一直保存着，当你执行一个统计，分支少则几十个，多则几百个，虽说远端分支不太影响，但没用的东西，尽量还是清理掉，保持简单，高效。如题，在工作中，我遇到了这个问题，我的第一想法是google这个问题，找到了stackoverflow上的一个回答。[删除远端的已经合并的分支](http://stackoverflow.com/questions/6127328/how-can-i-delete-all-git-branches-which-have-been-merged)，删除这些分支是没有任何影响的，因为这些分支所有代码都在master中了，所以请尽管删除
[shell]
git branch -r --merged | grep -v '\*\|master\|develop' | sed 's/origin\///' | xargs -n 1 git push --delete origin
[/shell]
3.【git clean branch delete by remote】删除本地的那些已经在远端删除了的分支，如果你clone了一些别人的分支，但是过了一段时间，别人的这个分支已经不存在了，作者已经删除了。对于这类分支，可以这样干掉`git remote prune origin`。
4.【How can I get a list of git branches, ordered by most recent commit】[How can I get a list of git branches, ordered by most recent commit](http://stackoverflow.com/questions/5188320/how-can-i-get-a-list-of-git-branches-ordered-by-most-recent-commit), 这个问题主要也使用来解决无效分支的问题的，如果分支已经很多了，我们可以删除超过2个月没有提交记录的分支，这个时候，你可以参考这个问题。
5.【Git修改提交记录的作者信息】。例如你之前在另外一台电脑上，你忘记改git user 的name 和 email了，导致你的Git提交记录中，你表现为多重身份，你想使他们统一为一个，这个时候，你就遇到了我曾经遇到的问题。这里提供一个链接[Git修改作者信息](http://www.jianshu.com/p/b6add8187c06),当然，这个帖子并不是我最早看到的那个，不过内容还可以，可以参考，我就不再这里copy了。
6.【Git 修改最近一次提交信息】可以使用`git commit --amend`。
7.【Git 修改多次提交信息】`git rebase -i HEAD~3` , 可以在编辑界面中按照提示进行操作。[Git 修改多次提交信息](https://git-scm.com/book/zh/v2/Git-%E5%B7%A5%E5%85%B7-%E9%87%8D%E5%86%99%E5%8E%86%E5%8F%B2)
8.【Git merge mutilpe commits into one】[参考这篇文章]( http://gitready.com/advanced/2009/02/10/squashing-commits-with-rebase.html)，其中最核心的资料就是rebase -i 这个命令。
9.【Git use different gitconfig for diffenrent project】[stackoverflow problem](http://stackoverflow.com/questions/9063176/git-multiple-user-names-for-the-different-projects-within-the-same-system),如果你用你自己的电脑给公司的项目写代码，你肯定更愿意使用自己公司的账户和名字，而不是自己私人的name 和 email。可以在你的git全局配置中配置成自己私人的name和email，而在项目中的git配置中，可以加入自己的公司的name和email，项目中的git配置中的user部分的优先级是比全局的高的，所以这样就解决了我们的问题。配置方法如下.
[shell]
#只给当前项目配置，也可以通过修改.git/config 中的user部分来实现.
git config --local user.name = yourname
git config --local user.email = yourname@cmcm.com
#给全局配置
git config --global user.name = privatename
git config --global user.email = privatename@126.com
[/shell]
