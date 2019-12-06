<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

function copy_file()
{
	$destination = $this->app->getRootPath() . '/database/migrations/';
    if(!is_dir($destination)){
        mkdir($destination, 0755, true);
    }
    $source = __DIR__.'/../../database/migrations/';
    $handle = dir($source);
    
    while($entry=$handle->read()) {   
        if(($entry!=".")&&($entry!="..")){   
            if(is_file($source.$entry)){
                copy($source.$entry, $destination.$entry);   
            }
        }
    }
}

// /**
//  * @param $config
//  * @return string
//  */
// function captcha_src($config = null): string
// {
//     return Route::buildUrl('/captcha' . ($config ? "/{$config}" : ''));
// }

// /**
//  * @param $id
//  * @return string
//  */
// function captcha_img($id = ''): string
// {
//     $src = captcha_src($id);

//     return "<img src='{$src}' alt='captcha' onclick='this.src=\"{$src}?\"+Math.random();' />";
// }

// /**
//  * @param string $value
//  * @return bool
//  */
// function captcha_check($value)
// {
//     return Captcha::check($value);
// }
