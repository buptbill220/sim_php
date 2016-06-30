<?php
require_once('base.class.php');
require_once('errorexp.class.php');

class Autoload extends Base {
    const pattern = '/(\\\?\w+\\\)|(\/?\w+\/)|\\\|\//';
    private $path;
    
    public static function init($path)
    {
        static $loader = null;
        if ($loader == NULL) {
            $loader = new self($path);
        }
        return $loader;
    }
    //autoload class php file
    public function __construct($path)
    {
        $this->path = $path;
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->path);
        spl_autoload_extensions('.php');
        spl_autoload_register(array($this,'lib'));
        spl_autoload_register(array($this,'core'));
        spl_autoload_register(array($this,'ext'));
        spl_autoload_register(array($this,'common'));
    }

    public function load($path)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        spl_autoload_register(array($this, 'loader'));
    }

    public function loader($class)
    {
        try {
            $class = $this->formatClass($class);
        }catch(Errorexp $e){ 
            echo $e->errorMessage();
        }
        spl_autoload_extensions('.class.php');
        spl_autoload($class);
    }

    public function core($class)
    {
        try {
            $class = $this->formatClass($class);
        }catch(Errorexp $e){
            echo $e->errorMessage();
        }
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->path . '/core/');
        spl_autoload_extensions('.class.php');
        spl_autoload($class);
        //spl_autoload_extensions('.php');
        //spl_autoload($class);
    }

    public function lib($class)
    {    
        try {
            $class = $this->formatClass($class);
        }catch(Errorexp $e){
            echo $e->errorMessage();
        }
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->path . '/lib/');
        spl_autoload_extensions('.class.php');
        spl_autoload($class);
        //spl_autoload_extensions('.php');
        //spl_autoload($class);
    }

    public function ext($class)
    {
        try {
            $class = $this->formatClass($class);
        }catch(Errorexp $e){
            echo $e->errorMessage();
        }
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->path . '/ext/');
        spl_autoload_extensions('.class.php');
        spl_autoload($class);
        //spl_autoload_extensions('.php');
        //spl_autoload($class);
    }

    public function common($class)
    {
        try {
            $class = $this->formatClass($class);
        }catch(Errorexp $e){
            echo $e->errorMessage();
        }
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->path . '/common/');
        //spl_autoload_extensions('.class.php');
        //spl_autoload($class);
        spl_autoload_extensions('.php');
        spl_autoload($class);
    }
    private function formatClass($class) {
    //减少preg次数，实际上系统自动注册过的类，下次调用时，不会再注册
        static $classes = array();
        if (empty($class)) {
            throw new Errorexp('format class <' . $class . '> failed!', $this);
        }
        if (!isset($classes[$class])) {
            $class = preg_replace(self::pattern, '', $class);
            $classes[$class] = &$class;
        }
        $class = &$classes[$class];
        return $class;
    }
    //used for load non class php file
    public static function requireAll($folder){
        foreach (glob("{$folder}/*.php") as $filename) {
            if (file_exists($filename)) {
            require_once($filename);
            }
        }
    }
}
