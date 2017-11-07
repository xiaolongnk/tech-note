## Git alias 让Git命令变得更短 

在我们配置了zsh之后，zsh可以帮助我们对git支持的命令也进行一些补全了，这给我们在命令行中使用git带来了一些便利。但是要更高效的使用git，我们也需要了解一些git配置的东西,git的配置文件再用户主目录的.gitconfig里面，全路径是这个`~/.gitconfig`,以后如果我们学会了一些更高级的配置，也都是在这里修改，我们只需要保存维护好这个文件就好,如果换电脑了，把这个文件拿走就可以了。这里我们介绍几个比较常用的git配置项,`alias`,`user`,`color`。下面先简单介绍一下alias的配置，alias就是别名的意思，这样可以提高我们使用git命令的效率，配置如下，可以直接将这一段配置copy到`~/.gitconfig`里面就可以。

>[alias]
>    lg = log --color --graph --pretty=format:'%Cred%h%Creset -%C(yellow)%d%Creset %s %Cgreen(%cr) %C(bold blue)<%an>%Creset' --abbrev-commit
>    lp = log --pretty=oneline --abbrev-commit --graph --decorate
>    ci = commit
>    co = checkout
>    st = status
>    \# 查看远程分支,远程分支会用红色表示出来
>    ba = branch -a
>    bv = branch -v
>    bm = branch -m
>    bd = branch -d
>    b = branch
>    bc = checkout -b
>    rt = reset --hard
>    mg = merge
>    df = diff
>    rv = remote -v
>    rso= remote show origin
>    \# To list untracked files
>    ut = ls-files --other --exclude-standard
>    \# list tracked files
>    tf = ls-files
>    \# show modified files
>    lm = ls-files -m
>    \# show unmerged files
>    lu = ls-files -u
>    unstage  = reset HEAD
>    uncommit = reset --soft HEAD^
>    amend    = commit --amend
>    \# 使用 vimdiff 查看 diff 文件
>    vdf = difftool
>    \# 临时保存
>    ss = stash

## Git user 模块配置
上面我们讨论了git alias模块的配置，现在我们配置一下user模块。在git中，每次提交代码的时候，都会显示提交者的name 和 email，用来区分不同的开发者。而提交这的信息就是在这个user模块里配置。我们可以在全局配置中设置一个用户，每次提交代码的时候，使用的用户都是我们这里配置的，所以我们一般会将自己的name和email配置在这里。
>[user]
>    email = private@gmail.com
>    name = private

现在考虑另外一个问题，我们的电脑是公司的，电脑里有公司的项目，我们要按照公司的账号名和email来提交代码。但是我们电脑上也有自己github上的项目，需要按照github上的以前的账号email来提交代码，这个时候就冲突了？这个时候该怎么办呢？这个时候，可以在git项目中的.git 目录的config文件中进行设置，这个config表示这个项目的git设置，这个设置的优先级会高于~/.gitconfig 这个文件中配置项的设置，所以我们只要在.git/config 再设置一个[user]模块就可以了，这样在公司项目中就可以用公司的邮箱了。下面图片中是一个示例，这是一个项目工程，我们可以看到.git目录，这是每个git项目都会有的，.git目录里面就有config文件，下面的配置需要写到.git/config里面。这个config的配置和~/.gitconfig里面的配置是一样的。
![git config](https://omssgfgqf.qnssl.com/images/2017/11/07/15100445019952.jpeg)
>[user]
>    email = yourcompanyname@gmail.com
>    name = yourcompanyname

## Git color 配置
最后我们介绍下color，这个就是为了让git显示出不同的颜色，来方便查看，作用有限，简单了解一下就可以。
>[color]
>		diff   = always
>    	status = true
>    	branch = auto
>    	interactive = auto
>    	ui = true
>
>[color "diff"]
>    meta = magenta black bold
>
>[color "branch"]
>		current  = bold green
>    	local    = normal
>    	remote   = bold red
>    	upstream = bold blue

最后这里分享一个比较完整的配置，大家可以参考一下**[Git完整配置](https://raw.githubusercontent.com/xiaolongnk/vim-conf/master/gitconfig)**!

