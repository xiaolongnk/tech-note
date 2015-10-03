# .bashrc

# Source global definitions
if [ -f /etc/bashrc ]; then
    . /etc/bashrc
fi

export LANG=C
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8
export LC_CTYPE=C

#User specific aliases and functions
export PYCURL_SSL_LIBRARY=nss
export SVN_EDITOR=vim
export EDITOR=vim

# Source global definitions
if [ -f /etc/bashrc ]; then
    . /etc/bashrc
fi

# pro
alias ls='ls --color'
alias ll='ls -lG'
alias la='ls -GAalth'
alias l='ls -GCF'
alias lt='ls -Glth'
alias tf='tail -f'
alias grep='grep --color=always'
alias tree='tree -C'
alias rscp='rsync -v -P -e ssh'
alias wget='wget -c'
alias cse='ssh xiaolongou@osys11.meilishuo.com'
alias pandora='cd /code/pandora/'
alias hgadmin='cd /code/hgadmin/'
alias pusher='cd /code/hgpusher/'


## Parses out the branch name from .git/HEAD:
find_git_branch () {
    local dir=. head
    until [ "$dir" -ef / ]; do
        if [ -f "$dir/.git/HEAD" ]; then
            head=$(< "$dir/.git/HEAD")
            if [[ $head = ref:\ refs/heads/* ]]; then
                git_branch="->${head#*/*/}"
            elif [[ $head != '' ]]; then
                git_branch="->(detached)"
            else
                git_branch="->(unknow)"
            fi
            return
        fi
        dir="../$dir"
    done
    git_branch=''
}
PROMPT_COMMAND="find_git_branch; $PROMPT_COMMAND"
# Here is bash color codes you can use
black=$'\[\e[1;30m\]'
red=$'\[\e[1;31m\]'
green=$'\[\e[1;32m\]'
yellow=$'\[\e[1;33m\]'
blue=$'\[\e[1;34m\]'
magenta=$'\[\e[1;35m\]'
cyan=$'\[\e[1;36m\]'
white=$'\[\e[1;37m\]'
normal=$'\[\e[m\]'


function straceall {
strace $(pidof "${1}" | sed 's/\([0-9]*\)/-p \1/g')
}

# 加入 git  自动补齐
git_completion="$HOME/.vim/.git_completion.bash"
if [[ -f $git_completion ]]; then
    source $git_completion
fi
#PS1="[\[\033[01;32m\]\u\[\033[00m\]\[\033[31;40m\]@\[\033[00m\]\[\033[36;40m\]\h\[\033[00m\]]yellow\$git_branch$white\$ $normal"
PS1="[\[\033[01;32m\]\u\[\033[00m\]\[\033[31;40m\]@\[\033[00m\]\[\033[36;40m\]fox\[\033[00m\]:\[\033[35;40m\]\w\[\033[00m\]]$yellow\$git_branch$white\$ $normal"
# User specific aliases and functions

alias grep='grep --color -n'
alias ll='ls -al'
alias ls='ls -G'
alias mg='mongo 192.168.190.2:27030'
alias mr='redis-cli -h 192.168.190.4'
alias msql='mysql -u root -h sql -plehe2011 higo'
alias note='cd /Users/a2014/work/csdn/xlonote/'
alias p='python'
alias shutdown='shutdown -h -n now'
alias smd='ssh root@192.168.190.2'
alias ssq='ssh root@192.168.190.4'
alias v='vim'
alias work='ssh root@123.57.210.211'
export USER=fox
export pusher_env=dev
