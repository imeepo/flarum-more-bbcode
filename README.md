# Imeepo/flarum-more-bbcode

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/imeepo/flarum-more-bbcode.svg)](https://packagist.org/packages/imeepo/flarum-more-bbcode) [![Total Downloads](https://img.shields.io/packagist/dt/imeepo/flarum-more-bbcode.svg)](https://packagist.org/packages/imeepo/flarum-more-bbcode)

A [Flarum](http://flarum.org) extension. Adds more BBCode

## 安装

使用composer进行安装:

```sh
composer require imeepo/flarum-more-bbcode:"*"
```

## 如何使用

### 登录/回复可见
当创建/编辑一篇文章时，你可以简单地使用[reply]BBCode使它对其他用户隐藏，只有回复的用户才可以看到隐藏内容。

```bbcode
[login]这里的内容登录可见[/login]
[reply]这里的内容回复可见[/reply]
```
### 网盘样式
很优雅的分享网盘链接，或Github/Gitee仓库链接(如果没有密码可以不填写)
```bbcode
[cloud type=lz title=标题 url=链接]密码[/cloud]
[cloud type=123 title=标题 url=链接]密码[/cloud]
[cloud type=ali title=标题 url=链接]密码[/cloud]
[cloud type=bd title=标题 url=链接]密码[/cloud]
[cloud type=ty title=标题 url=链接]密码[/cloud]
[cloud type=360 title=标题 url=链接]密码[/cloud]
[cloud type=ct title=标题 url=链接]密码[/cloud]
[cloud type=tx title=标题 url=链接]密码[/cloud]
[cloud type=kk title=标题 url=链接]密码[/cloud]
[cloud type=other title=标题 url=链接]密码[/cloud]
[cloud type=github title=标题 url=链接]v1.0.0[/cloud]
[cloud type=gitee title=标题 url=链接]v1.0.0[/cloud]
```
## 已知问题

* 用户在回复带有隐藏内容的帖子后,再次点击回复按钮，隐藏内容样式会丢失
* 帖子列表的摘要会显示隐藏内容（临时解决：别把隐藏内容放到帖子太靠前的地方）
* ~~帖子作者在编辑的时候,网盘下载地址会点击不了~~（已修复）

## TODO
* 尝试修复已知问题
* 权限控制
  

## 更新

```sh
composer update imeepo/flarum-more-bbcode:"*"
php flarum migrate
php flarum cache:clear
```

## 更新内容
### 1.0.3
* 修复了en.yml（[Litalino修复](https://github.com/imeepo/flarum-more-bbcode/pull/2/commits/5ac34546d7a6c372af65471c22c2304943c3f0f0)）
* 为other下载添加了语言

### 1.0.2
* 修复帖子作者在编辑的时候，网盘下载地址会点击不了（[zxy19修复](https://github.com/imeepo/flarum-more-bbcode/commit/c1e4cfcde7c1de0314be5656306fe9c7c81b9e2b)）
* 新增夸克网盘

## 链接

- [Packagist](https://packagist.org/packages/imeepo/flarum-more-bbcode)
- [GitHub](https://github.com/imeepo/flarum-more-bbcode)
- [Discuss](https://discuss.flarum.org/d/PUT_DISCUSS_SLUG_HERE)
