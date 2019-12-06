<?php

namespace zauth;

use think\Service;

class ZauthService extends Service
{
    /**
     * 注册服务.
     *
     * @return void
    **/
    public function register()
    {
        // 注册数据迁移服务
        // $this->app->register(\think\migration\Service::class);
    }

    /**
     * 启动函数
     *
     * @return void
    **/
    public function boot()
    {
		$this->commands(['zauth:publish' => Publish::class]);
    }
}
