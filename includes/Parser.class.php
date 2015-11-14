<?php
/**
 * 模版解析类
 * 通过正则表达式进行解析
 * 逐个匹配，实现相应的功能
 */
class Parser {
    //字段，保存模版内容
    private $_tpl;
    //构造方法，接收模版文件中的内容
    public function __construct($_tplFile) {
        if (!$this->_tpl = file_get_contents($_tplFile)) {
            exit('ERROR:模版文件读取错误');
        }
    }
    //解析普通变量
    private function parVar() {
        $_pattern = '/\{\$([\w]+)\}/';
        if (preg_match($_pattern, $this->_tpl)) {
            //将
            $this->_tpl = preg_replace($_pattern,"<?php echo \$this->_vars['$1'];?>",$this->_tpl);
        }
    }
    //解析if语句
    private function parIf() {
        $_patternIf = '/\{if\s+\$([\w]+)\}/';
        $_patternEndIf = '/\{\/if\}/';
        $_patternElse = '/\{else\}/';
        if (preg_match($_patternIf,$this->_tpl)) {
            if (preg_match($_patternEndIf,$this->_tpl)) {
                $this->_tpl = preg_replace($_patternIf,"<?php if (\$this->_vars['$1']) { ?>",$this->_tpl);
                $this->_tpl = preg_replace($_patternEndIf,"<?php }?>",$this->_tpl);
                if (preg_match($_patternElse,$this->_tpl)) {
                    $this->_tpl = preg_replace($_patternElse,"<?php } else { ?>",$this->_tpl);
                }
            } else {
                exit('ERROR:if语句没有关闭');
            }
        }
    }
    //解析注释语句
    private function parComment() {
        $_patternCom = '/\{#\}(.*)\{#\}/';
        if (preg_match($_patternCom,$this->_tpl)) {
            $this->_tpl = preg_replace($_patternCom,"<?php /* $1 */ ?>",$this->_tpl);
        }
    }
    //解析系统变量
    private function parConfig() {
        $_pattern = '/<!--\{([\w]+)\}-->/';

        if (preg_match($_pattern,$this->_tpl)) {

            $this->_tpl = preg_replace($_pattern,"<?php echo \$this->_config['$1'];?>",$this->_tpl);
        }
    }
    //解析foreach语句
    private function parForeach() {
        $_patternForeach = '/\{foreach\s+\$([\w]+)\(([\w]+),([\w]+)\)\}/';
        $_patternEndForeach = '/\{\/foreach\s*\}/';
        $_patternStartVar = '/\{@([\w]+)\}/';
        if (preg_match($_patternForeach,$this->_tpl)) {
            if (preg_match($_patternEndForeach,$this->_tpl)) {

                $this->_tpl = preg_replace($_patternForeach,"<?php foreach (\$this->_vars['$1'] as \$$2=>\$$3) {?>",$this->_tpl);
                $this->_tpl = preg_replace($_patternEndForeach,"<?php } ?>",$this->_tpl);
                if (preg_match($_patternStartVar,$this->_tpl)) {
                    $this->_tpl = preg_replace($_patternStartVar,"<?php echo \$$1 ?>",$this->_tpl);
                }

            }else{
                exit('ERROR:foreach语句必须有结尾标签');
            }
        }
    }
    //解析include方法
    private function parInclude() {
        $_pattern = '/\{include\s+file=\"([\w\.\-]+)\"\}/';
        if (preg_match($_pattern,$this->_tpl,$_file)) {

            if (!file_exists($_file[1]) || empty($_file)) { //$_file[1]第一个捕获的子组
                exit('ERROR:包含文件出错');
            }
            $this->_tpl = preg_replace($_pattern,"<?php include '$1';?>",$this->_tpl);
        }
    }
    //对外公共方法
    public function compile($_parFile) {
        //解析模版内容
        $this->parVar();
        $this->parIf();
        $this->parComment();
        $this->parForeach();
        $this->parInclude();
        $this->parConfig();
        //将解析替换的文件内容放入$_parFile文件中
        if (!file_put_contents($_parFile, $this->_tpl)) {
            exit('ERROR:编译文件生成出错');
        }
    }
}


?>