<?php
class tables_controller extends main_controller {
	public function index() {
		$user = user_model::getInstance();
		$this->tables = $user->getAllTables();
		$this->display();
	}
	public function create() {
		$user = user_model::getInstance();
		$user->createTable();
		
		// $activity = activity_model::getInstance();
		// $activity->createTable();
		
		$this->tables = $user->getAllTables();
		$this->display();
	}
	public function getfields($params) {
		$this->table  = $params['table'];
		$main = main_model::getInstance();
		$this->fields = $main->getAllFields($this->table);
		$this->display(['act'=>'fields']);
	}
}
?>
