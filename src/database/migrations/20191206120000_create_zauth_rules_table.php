<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateZauthRulesTable extends Migrator
{
    public  function  change()
    {
        // create the table
        $table_rules  =  $this->table('zauth_rules',array('collation'=>'utf8mb4_unicode_ci', 'comment'=>'规则表'));
        $table_rules->addColumn('rule_url', 'string',array('limit' => 80,'default'=>'','comment'=>'规则url'))
        ->addColumn('title', 'string',array('limit' => 20,'comment'=>'规则标题')) 
        ->addColumn('type', 'integer',array('limit' => 1,'default'=>1,'comment'=>'规则类型,1导航,2其他如按钮等'))
        ->addColumn('icon', 'string',array('limit' => 32,'default'=>NULL,'null'=>true,'comment'=>'图标'))
        ->addColumn('parent_id', 'integer',array('default'=>0,'comment'=>'父规则ID'))
        ->addColumn('rule_order', 'integer',array('limit' => 3,'default'=>0,'comment'=>'规则排序'))
        ->addColumn('status', 'integer',array('limit' => 1,'default'=>1,'comment'=>'状态,0禁用,1启用'))
        ->addIndex(array('url', 'title'), array('unique'  =>  true))
        ->create();

        $table_user_role  =  $this->table('zauth_user_role', array('id' => false, 'primary_key' => ['uid', 'rid'], 'collation'=>'utf8mb4_unicode_ci', 'comment'=>'用户-角色关系表'));
        $table_user_role->addColumn('uid', 'integer',array('comment'=>'用户id'))
        ->addColumn('rid', 'integer',array('comment'=>'角色id')) 
        ->addColumn('position', 'integer',array('limit' => 1,'default'=>3,'comment'=>'角色职位,1主管,2副主管,3普通'))
        ->create();

        $table_role_rule  =  $this->table('zauth_role_rule', array('id' => false, 'primary_key' => ['role_id', 'rule_id'], 'collation'=>'utf8mb4_unicode_ci', 'comment'=>'角色-规则关系表'));
        $table_role_rule->addColumn('role_id', 'integer',array('comment'=>'角色id'))
        ->addColumn('rule_id', 'integer',array('comment'=>'规则id'))
        ->addColumn('level', 'integer',array('limit' => 1,'default'=>1,'comment'=>'权限级别,1读,2写,3批...可扩展'))
        ->create();
    }
}
