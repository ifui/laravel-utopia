# Laravel Utopia

> 基于 Laravel 开发的后端系统

## 特性

基于 `Laravel Modules` 纯模块开发

## 拓展包

- [AdminAuth](https://github.com/ifui/AdminAuth-module) 管理员模块
- [SMS](https://github.com/ifui/Sms-module) 短信模块
- [Pay](https://github.com/ifui/Pay-module) 支付模块

## 常用命令

新建模块

`php artisan module:make Blog`

生成 `IDE Helper` 文件

```bash
php artisan ide-helper:generate
php artisan ide-helper:models
php artisan ide-helper:meta
```

## 注意

.env 文件中的 `SESSION_DOMAIN` 应配置为前端文件站点

安装拓展包或者对进行拓展包依赖安装的时候，请使用 `composer update` 合并 `composer.json` 配置
