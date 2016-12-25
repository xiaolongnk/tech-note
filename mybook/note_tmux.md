---
title: tmux -- 终端复用
date: 2016-10-11 10:18
tags:
- tmux
- linux
---
#### tmux 简介


这里简单介绍一下[tmux](https://github.com/tmux/tmux)。
tmux 是一个终端复用软件，类似的软甲有screen。但是现在的screen 用的人已经越来越少了。
慢慢得会被tmux一统江湖。先不多说了，看一张效果图吧。

![tmux 效果1](https://img.nofile.cc/images/2016/12/25/14826321686494.png)
![tmux 效果2](https://img.nofile.cc/images/2016/12/25/14826334955905.png)

有时候，我们需要开多个terminal，大部分情况下，我们可以通过多个tab来完成。但是在我们
不需要全屏展示的时候，这样感觉浪费。比如说我们需要一边写代码，一边看log，一边调试
代码。这个时候，用多个tab的方式，效率就比较低了。有tmux之后，我们就可以都在一个terminal
中完成这个操作了。

除了，终端分屏的功能，tmux还可以帮我们保存我们的工作session。我们在一个session中打开的tab
都会被保存下来，我们可以中断当前的工作，去做其他的事情，在我们回来之后，我们还可以直接恢复
我们原来的工作环境。所有打开的窗口会再次出现，就算关了terminal也没有关系。

并且现在有了[session恢复插件](https://github.com/tmux-plugins/tmux-resurrect)之后，就
算server重启了也没有关系了，我们的session依然可以恢复。

tmux可以支持鼠标了，不过这个功能要求tmux的version>2.2 。如果比较就的系统，会给你配备1.6的tmux。
这个时候，可能需要你自己编译一个tmux啦，具体的方法，可以参考前面那个tmux的链接啦。

总之，linux的软件，未经配置的是一个，配置好的是另一个，当然我说的易用性。tmux同样也有很强的定制
性，具体的配置，可以参考我下面的配置。里面有一些简单的解释，不过不那么全。如果你很感兴趣，那么
可以对其中自己不太明白的地方，自己搜索下,应该能获得很多新知识,可以帮助你更好的使用tmux。


如果你希望了解更多的tmux插件，你可以参考这个[tpm](https://github.com/tmux-plugins/tpm)

#### tmux 配置

```bash
set -g prefix ^q
unbind ^b  
bind a send-prefix  
unbind '"'  
bind - splitw -v  
unbind %  
bind \ splitw -h  
bind r source-file ~/.tmux.conf \; display "Reloaded!"  

unbind C-[  
unbind C-]  
bind C-n new-session   
bind Tab last-window

#set status-interval 1
set-option -g status on  
set-option -g status-interval 1  
set-option -g status-justify "left"  
set-option -g status-left-length 60  
set-option -g status-right-length 90  
set-option -g  mouse on

#选择分割的窗格
bind k selectp -U #选择上窗格
bind j selectp -D #选择下窗格
bind h selectp -L #选择左窗格
bind l selectp -R #选择右窗格
#----------------------------------------------

#重新调整窗格的大小
bind ^k resizep -U 10
bind ^j resizep -D 10
bind ^h resizep -L 10
bind ^l resizep -R 10
bind ^u swapp -U
bind ^d swapp -D
#----------------------------------------------

# 颜色
set -g status-fg white
set -g status-bg cyan
#设置终端颜色为256色  
set -g default-terminal "screen-256color"
# Use vim keybindings in copy mode
setw -g mode-keys vi
# 对齐方式
set-option -g status-justify centre

# 左下角
# set-option -g status-left '#[bg=black,fg=green][#[fg=blue]#S#[fg=green]]'
set-option -g status-left-length 20
set-option -g allow-rename off
# 窗口列表
setw -g automatic-rename on
set-window-option -g window-status-format '#[fg=yellow,bold]#I:#W#[fg=blue,dim]'
set-window-option -g window-status-current-format '#[fg=green,bold][#[fg=blue]#I#[fg=blue]:#[fg=blue]#W#[fg=dim]#[fg=green,bold]]'
# 右下角
set -g status-right '#[fg=green,bold][#[fg=yellow,bold]%Y-%m-%d %H:%M:%S#[fg=green]]'

# just for mac settings. install reattach-to-user-namespace first.
# Copy-paste integration  
set-option -g default-command "reattach-to-user-namespace -l zsh"
# Setup 'v' to begin selection as in Vim
bind-key -t vi-copy v begin-selection
bind-key -t vi-copy y copy-pipe "reattach-to-user-namespace pbcopy"
# Update default binding of `Enter` to also use copy-pipe
unbind -t vi-copy Enter
bind-key -t vi-copy Enter copy-pipe "reattach-to-user-namespace pbcopy"
# Bind ']' to use pbpaste
bind ] run "reattach-to-user-namespace pbpaste | tmux load-buffer - && tmux paste-buffer"

# List of plugins
set -g @plugin 'tmux-plugins/tpm'
set -g @plugin 'tmux-plugins/tmux-sensible'
set -g @plugin 'nhdaly/tmux-better-mouse-mode'
set -g @plugin 'tmux-plugins/tmux-yank'
set -g @plugin 'tmux-plugins/tmux-resurrect'
set -g @plugin 'tmux-plugins/tmux-continuum'
set -g @plugin 'tmux-plugins/tmux-sidebar'
set -g @plugin 'tmux-plugins/tmux-copycat'

# for vim
set -g @resurrect-strategy-vim 'session'
# for neovim
set -g @resurrect-strategy-nvim 'session'
run '~/.tmux/plugins/tpm/tpm'

```
完整的配置文件在这里[tmux-conf](https://raw.githubusercontent.com/xiaolongnk/tmux-conf/master/tmux.conf).
我的github-tmux-conf [tmux-conf](https://github.com/xiaolongnk/tmux-conf)
#### 配置文件依赖

1. tmux-version `>` 1.9
2. mac 下需要reattach-to-user-namespace `brew install reattatch-to-user-namespae`

#### tmux 快捷键

`ctrl + q`  是 `prefix`
`prefix + c` 创建新窗口
`prefix + ,` 窗口重命名
`prefix + n` 下一个窗口
`prefix + ctrl + n` 开启一个新session
`prefix + tab`  切换到上次工作的窗口
`prefix + d`  detach current tmux session ， 可以用`tmux a`命令重新恢复



#### tmux 常见问题

1. tmux title 经常改变

	这个问题我是从stackoverflow上找到的，
	[原问题在这里](http://stackoverflow.com/questions/17289439/tmux-window-title-keeps-renaming),解决
	方案是在tmux.conf中添加如下配置 `set-option -g allow-rename off`
	当然，这个已经包含在我的配置文件里面了。
2. tmux 中 将vim中内容复制到系统剪切板。
	
	还有就是tmux 中使用vim复制到系统clipboard中的问题。一般情况下，只有mac下好像才会有这个问题。
	对应的修复方案也写在配置文件里了。如果是mac系统，直接用这个配置文件应该就可以了，另外需要自己
	安装下依赖。


#### 写在最后

tmux 的包含session，session中可以有好多标签。
有不少快捷键。刚开始记起来可能有点费尽，感觉有点像vim的学习过程。刚开始可能有点困难，但是一旦你适应了，
对它足够了解了，的确会方便很多。
加油吧。有问题欢迎发我邮箱，随时交流。

