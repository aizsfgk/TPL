<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php echo $this->_config['webname'];?></title>
</head>
<body>

<!--我是静态注释-->
系统分页数为：<?php echo $this->_config['filesize'];?>
<?php /* 我是php注释 */ ?>
<?php echo $this->_vars['content'];?><?php echo $this->_vars['name'];?>
<br/>
<?php if ($this->_vars['a']) { ?>
    <div>我是一号界面</div>
<?php } else { ?>
    <div>我是二号界面</div>
<?php }?>
<br/>
<?php foreach ($this->_vars['array'] as $key=>$value) {?>
    <?php echo $key ?>...<?php echo $value ?><br/>
<?php } ?>
</body>
</html>