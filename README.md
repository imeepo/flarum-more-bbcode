# Imeepo/flarum-more-bbcode

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/imeepo/flarum-more-bbcode.svg)](https://packagist.org/packages/imeepo/flarum-more-bbcode) [![Total Downloads](https://img.shields.io/packagist/dt/imeepo/flarum-more-bbcode.svg)](https://packagist.org/packages/imeepo/flarum-more-bbcode)

A [Flarum](http://flarum.org) extension. Adds more BBCode

## 安装

使用composer进行安装:

```sh
composer require imeepo/flarum-more-bbcode:"*"
```

## 如何使用

当创建/编辑一篇文章时，你可以简单地使用[reply]BBCode使它对其他用户隐藏，只有回复的用户才可以看到隐藏内容。

```bbcode
[reply]这里的内容回复可见[/reply]
```

## 已知问题

在帖子列表展示摘要时，如果出现隐藏内容的话，不会被隐藏，

## 更新

```sh
composer update imeepo/flarum-more-bbcode:"*"
php flarum migrate
php flarum cache:clear
```

## 链接

- [Packagist](https://packagist.org/packages/imeepo/flarum-more-bbcode)
- [GitHub](https://github.com/imeepo/flarum-more-bbcode)
- [Discuss](https://discuss.flarum.org/d/PUT_DISCUSS_SLUG_HERE)
