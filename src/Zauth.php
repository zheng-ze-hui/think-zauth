<?php
//
//
//

namespace zauth;

use think\facade\Config;
use think\facade\Db;

class Zauth{
    public function __construct(){

    }

    // 根据用户id 获取角色,返回值为数组
    // @param  uid int     参数 用户id
    // @return array       返回 用户所属的用户组 array(
    // array('uid'=>'用户id','role_id'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
    // ...)
    public static function getRolesForUser($uid){
        static $roles = array();
        $list = Db::name('zauth_user_role')
            ->alias([Config::get('database.connections.mysql.prefix').'zauth_user_role'=>'ur', Config::get('database.connections.mysql.prefix').Config::get('zauth.roles_tb')=>'r'])
            ->join(Config::get('database.connections.mysql.prefix').Config::get('zauth.roles_tb'),'ur.rid= r.id')
            ->where('uid', $uid)
            ->where('r.status',1)
            ->field('rid,title')
            ->order('rid')
            ->select()->toArray();
        return $list;
    }

    // 根据用户id 获取权限,返回值为数组
    public static function getPermissionsForUser($uid){
        if($uid==1){ // 默认管理员 全部权限
            return Db::name('zauth_rules')->select()->toArray();
        }
        $roles = self::getRolesForUser($uid);
        if(is_numeric(array_search(1, array_column($roles, 'rid')))){ // 二维数组查找,找到返回键值否则返回false
            return Db::name('zauth_rules')->select()->toArray(); // 管理员 全部权限
        }
        $rules = array();
        foreach ($roles as $role) {
            $list = Db::name('zauth_role_rule')
                ->alias([Config::get('database.connections.mysql.prefix').'zauth_role_rule'=>'rr', Config::get('database.connections.mysql.prefix').'zauth_rules'=>'r'])
                ->join(Config::get('database.connections.mysql.prefix').'zauth_rules','rr.rule_id= r.id')
                ->where('role_id', $role['rid'])
                ->field('r.id, title, icon, parent_id, rule_url')
                ->order('r.id')
                ->select()->toArray();
            $rules = $rules + $list;
        }
        return array_unique($rules, SORT_REGULAR);
    }

    // 根据用户id 获取分级规则,返回值为数组
    public static function getRulesForUser($uid){
        $rules = self::getPermissionsForUser($uid);
        // var_dump($rules);
        $tree = array();
        //第一步，将分类id作为数组key,并创建children单元
        foreach($rules as $rule){
            $tree[$rule['id']] = $rule;
            $tree[$rule['id']]['children'] = array();
        }

        //第二步，利用引用，将每个分类添加到父类children数组中，这样一次遍历即可形成树形结构。
        foreach($tree as $key=>$item){
            if($item['parent_id'] != 0){
                $tree[$item['parent_id']]['children'][] = &$tree[$key];//注意：此处必须传引用否则结果不对
                if($tree[$key]['children'] == null){
                    unset($tree[$key]['children']); //如果children为空，则删除该children元素（可选）
                }
            }
        }

        //第三步，删除无用的非根节点数据
        foreach($tree as $key=>$rule){
            if($rule['parent_id'] != 0){
                unset($tree[$key]);
            }
        }

        return $tree;
    }

    // 根据用户id 判断某个用户是否拥有某个权限,返回值为数组
    public static function hasPermissionForUser($uid, $rule_url, $level=1){
        if($uid==1){ // 默认管理员 全部权限
            return true;
        }
        $getRr = Db::name('zauth_role_rule')
            ->alias([Config::get('database.connections.mysql.prefix').'zauth_role_rule'=>'rr', Config::get('database.connections.mysql.prefix').'zauth_user_role'=>'ur', Config::get('database.connections.mysql.prefix').'zauth_rules'=>'r'])
            ->join(Config::get('database.connections.mysql.prefix').'zauth_user_role','rr.role_id = ur.rid')
            ->join(Config::get('database.connections.mysql.prefix').'zauth_rules','rr.rule_id = r.id')
            ->where('uid', $uid)
            ->where('rule_url', $rule_url)
            ->where('status',1)
            ->find();
        if($getRr){
            return true;
        }
        return false;
    }
}