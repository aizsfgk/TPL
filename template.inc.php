<?php
header('Content-Type:text/html;charset=utf-8');
//根目录
define('ROOT_PATH', dirname(__FILE__));
//模版文件目录
define('TPL_DIR',ROOT_PATH.'/templates/');
//编译文件目录
define('TPL_C_DIR',ROOT_PATH.'/templates_c/');
//缓存文件目录
define('CACHE',ROOT_PATH.'/caches/');
//是否开启缓存区
define('IS_CACHE',true);
IS_CACHE ? ob_start() : null;
//引入模版类
require ROOT_PATH.'/includes/Templates.class.php';
$_tpl = new Templates();

?>