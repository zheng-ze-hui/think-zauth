<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateZauthRulesTable extends Migrator
{
    public  function  change()
    {
        // create the table
        $table  =  $this->table('zauth_rules',array('collation'=>'utf8mb4_unicode_ci', 'comment'=>'规则表'));
        $table->addColumn('url', 'string',array('limit' => 80,'default'=>'','comment'=>'规则url'))
        ->addColumn('password', 'string',array('limit'  =>  32,'default'=>md5('123456'),'comment'=>'用户密码')) 
        ->addColumn('login_status', 'boolean',array('limit'  =>  1,'default'=>0,'comment'=>'登陆状态'))
        ->addColumn('login_code', 'string',array('limit'  =>  32,'default'=>0,'comment'=>'排他性登陆标识'))
        ->addColumn('last_login_ip', 'integer',array('limit'  =>  11,'default'=>0,'comment'=>'最后登录IP'))
        ->addColumn('last_login_time', 'integer',array('default'=>0,'comment'=>'最后登录时间'))
        ->addColumn('is_delete', 'boolean',array('limit'  =>  1,'default'=>0,'comment'=>'删除状态，1已删除'))
        ->addIndex(array('username'), array('unique'  =>  true))
        ->create();
    }
}
