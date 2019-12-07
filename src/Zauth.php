<?php
//
//
//

namespace zauth;

use think\Config;
use think\facade\Db;

class Zauth{
	public function __construct(){

	}

	public static function hello(){
		return "Hello World!";
	}

	// 根据用户id 获取角色,返回值为数组
    // @param  uid int     参数 用户id
    // @return array       返回 用户所属的用户组 array(
    // array('uid'=>'用户id','role_id'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
    // ...)
	public static function getRolesForUser($uid){
		return $uid;
	}
}