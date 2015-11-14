<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><!--{webname}--></title>
</head>
<body>

<!--我是静态注释-->
系统分页数为：<!--{filesize}-->
{#}我是php注释{#}
{$content}{$name}
<br/>
{if $a}
    <div>我是一号界面</div>
{else}
    <div>我是二号界面</div>
{/if}
<br/>
{foreach $array(key,value)}
    {@key}...{@value}<br/>
{/foreach}
</body>
</html>