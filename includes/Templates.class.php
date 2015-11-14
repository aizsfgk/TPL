<?php
//模版类
class Templates {

    //用来保存自定义变量
    private $_vars = array();
    //保存系统变量
    private $_config = array();

    public function __construct() {
        if (!is_dir(TPL_DIR) || !is_dir(TPL_C_DIR) || !is_dir(CACHE)) {
            exit('ERROR:模版目录或者编译目录或者缓存目录不存在！请手工设置！');
        }
        //保存系统变量
        $_sxe = simplexml_load_file('config/profile.xml');//simplexml_load_file转换一个标准xml文件为一个对象
        $_tagLib = $_sxe->xpath('/root/taglib');//按xpath进行查询，返回一个数组

        foreach ($_tagLib as $_tag) {
            $this->_config["{$_tag->name}"] = $_tag->value;//将系统配置变量都放入$_config变量中
        }

    }
    //assin()方法，用于注入变量
    public function assign($_var, $_value) {
        //$_var,同步模版里的变量
        //$_value,表示业务逻辑层中的值
        if (isset($_var) && !empty($_var)) {
            //
            $this->_vars[$_var]=$_value;
        } else {
            exit('ERROR:请设置模版变量');
        }

    }
    //display()方法
    public function display($_file) {
        //设置模版路径
        $_tplFile = TPL_DIR.$_file;
        //判断模版是否存在
        if (!file_exists($_tplFile)) {
            exit('ERROR:模版文件不存在');
        }
        //生成编译文件
        $_parFile = TPL_C_DIR.md5($_file).$_file.'.php';
        //生成缓存文件
        $_cacheFile = CACHE.md5($_file).$_file.'.html';
       //当第二次运行相同文件，直接载入缓存文件
        if (IS_CACHE){
            //缓存编译文件都存在
            if (file_exists($_cacheFile) && file_exists($_parFile)) {
                //判断模版文件是否修改过
                if ( filemtime($_parFile)>=filemtime($_tplFile) && filemtime($_cacheFile)>=filemtime($_parFile) ) {
                    include $_cacheFile;
                    return;
                }
            }
        }
        //当编译文件不存在或者模版文件修改过，则生成编译文件
        if (!file_exists($_parFile) || filemtime($_parFile)<filemtime($_tplFile)) {

            //模版文件引入解析文件
            require ROOT_PATH.'/includes/Parser.class.php';
            $_parser = new Parser($_tplFile);    //模版文件传到构造方法里边
            $_parser->compile($_parFile);
        }

        //载入编译文件
        include $_parFile;

        if (IS_CACHE) {
            //获取缓存区数据

            //echo ob_get_contents();
            file_put_contents($_cacheFile,ob_get_contents());
            //清除缓存区，就是清除了编译文件
            ob_end_clean();
            //载入缓存文件
            include $_cacheFile;
        }

    }
}

?>