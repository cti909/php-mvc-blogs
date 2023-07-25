<?php
class main_controller {
	protected $layout = "";
	protected $model; 
	protected $controller = "home";
	protected $action = "index";
	public	 $components;
	//protected $htmlhp;
	
	public function  __construct() {
		global $cn, $app;
		$this->controller = $cn;
		$app['ctl'] = $this->controller;
		if(isset($_GET["act"])) $this->action = $_GET["act"];
		$app['act'] = $this->action;
		if(method_exists($this, $this->action)) {
			if(count($_GET)>2) {
				// This build for CRUD 
				if($this->action=='view' || $this->action=='edit' || $this->action=='del') {
					$id='';
					if(isset($_GET['id']))	$id=$_GET['id'];
					$this->{$this->action}($id);
				} else {				
					if($this->action=='login'||$this->action=='logout') $this->{$this->action}();
					$params = array_slice($_GET, 2, count($_GET)); //0 ctl, 1 act, 2->.. params
					// echo print_r($params);
					$this->{$this->action}($params);
				}
			} else $this->{$this->action}();
		} else {
			include "views/staticpages/error.php";
		}
	}
	
	public function display($options=null) {
		if(!isset($options['ctl']))	$options['ctl'] = $this->controller;
		if(!isset($options['act']))	$options['act'] = $this->action;
		include_once "views/".$options['ctl']."/".$options['act'].".php";
	}

    public function setProperty($name, $value) {
        $this->$name = $value;
		echo $this->$name;
    }
}
?>
