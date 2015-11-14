<?php

require dirname(__FILE__).'/template.inc.php';
global $_tpl;

//声明一个变量
$_name = '张世峰';
$_content = '是个美男子';
$_array = array(1,2,3,4,5);

$_tpl->assign('name',$_name);
$_tpl->assign('content', $_content);
$_tpl->assign('a',5<3);
$_tpl->assign('array',$_array);

$_tpl->display('index.tpl');

?>