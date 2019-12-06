# think-zauth

think-zauth 是一个专为 ThinkPHP6.0 打造的权限控制库。

## 安装
> composer require zheng-ze-hui/think-zauth

> composer require zheng-ze-hui/think-zauth @dev (开发阶段使用该方式安装)

> composer update zheng-ze-hui/think-zauth @dev

## 发布配置文件和数据库迁移文件
> php think zauth:publish

## 执行迁移工具
> php think migrate:run
//此时数据库便创建了prefix_rules表.

## 卸载
> composer remove zheng-ze-hui/think-zauth