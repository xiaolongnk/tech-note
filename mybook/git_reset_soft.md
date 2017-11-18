在使用git的过程中，如果提交了自己不想提交的文件，但是这些文件又有一些价值，不能直接reset 掉。因为这样会导致我们的重复劳动，所以最好的办法是将它们从git提交记录中拿出来，就好像我们没有完成了这些修改，只是没有提交一样。下面几个操作会说明这个例子。下面的操作图列举了其中的一种情况，是我在开发过程中遇到的问题。

![git reset --soft](https://omssgfgqf.qnssl.com/images/2017/11/18/15109811952355.jpeg)
![git reset --sofg](https://omssgfgqf.qnssl.com/images/2017/11/18/15109811952390.jpeg)
![git ref log](https://omssgfgqf.qnssl.com/images/2017/11/18/15109815492825.jpeg)

[shell]
git reset --soft HEAD^
git reset --soft master^
[/shell]

`git reflog` 可以帮助我们找到最近的操作记录，并且记录下所有的版本号，如果发生误操作，可以通过`reflog`可以找到对应的版本号，然后用`git reset --hard yourversioncode` 来会退到那个版本，所以，用git会让你的修改非常安全，只要记住`reflog`和`reset`命令就可以了。上面第三章图展示了reflog的用法，`reflog`一般会和`git reset --hard`来配合使用。
[shell]
git reflog
git reset --hard versioncode
[/shell]

最后，贴一下 stackoverflow 上的原问题**[how to uncommit my last commit](https://stackoverflow.com/questions/2845731/how-to-uncommit-my-last-commit-in-git)**uncommit之后，我们可以通过stash将这些不想提交的内容stash起来。
[shell]
git stash        # stash 当前没有commit 的文件
git stash list   # 查看所有的stash
git stash pop    # 恢复最上面的一个stash
[/shell]
