---
title: tmux -- 终端复用
date: 2016-10-11 10:18
tags:
- tmux
- linux
---

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
#选择分割的窗格
bind k selectp -U #选择上窗格
bind j selectp -D #选择下窗格
bind h selectp -L #选择左窗格
bind l selectp -R #选择右窗格

#重新调整窗格的大小
bind ^k resizep -U 10
bind ^j resizep -D 10
bind ^h resizep -L 10
bind ^l resizep -R 10

#交换两个窗格
bind ^u swapp -U
bind ^d swapp -D

# 颜色
set -g status-fg white
set -g status-bg cyan
#设置终端颜色为256色  
set -g default-terminal "screen-256color"

# 对齐方式
set-option -g status-justify centre

# 左下角
# set-option -g status-left '#[bg=black,fg=green][#[fg=blue]#S#[fg=green]]'
set-option -g status-left-length 20

# 窗口列表
setw -g automatic-rename on
set-option -g allow-rename off

set-window-option -g window-status-format '#[fg=yellow,bold]#I:#W#[fg=blue,dim]'
set-window-option -g window-status-current-format '#[fg=green,bold][#[fg=blue]#I#[fg=blue]:#[fg=blue]#W#[fg=dim]#[fg=green,bold]]'
# 右下角
set -g status-right '#[fg=green,bold][#[fg=yellow,bold]%Y-%m-%d %H:%M:%S#[fg=green]]'

```

#### tmux 快捷键

`ctrl + q`  是 `prefix`
`prefix + c` 创建新窗口
`prefix + ,` 窗口重命名
`prefix + n` 下一个窗口
`prefix + ctrl + n` 开启一个新session
`prefix + tab`  切换到上次工作的窗口
`prefix + d`  detach current tmux session ， 可以用`tmux a`命令重新恢复


#### tmux 常见问题

tmux title 经常改变
这个问题我是从stackoverflow上找到的，[原问题在这里](http://stackoverflow.com/questions/17289439/tmux-window-title-keeps-renaming),解决方案是在tmux.conf中添加如下配置

```bash
set-option -g allow-rename off
```
