<?php
class Action {
    private $template;

    function __construct() {
        $this->template = new Template(CUR_TPL_PATH);
    }

    function error() {
        echo "unkown methods called";
    }

    function assign($key, $value) {
        $this->template->assign($key, $value);
        return $this;
    }

    function display($method = 'index') {
        $this->template->display($method . '.tpl.php');
    }
}
