<?php
class register_controller extends main_controller
{
    public function index() 
	{
		$this->display();
	}
    public function register() {
        if(isset($_POST['btn_submit'])) {
            $account = $_POST['data'][$this->controller];
			// if(!empty($acc['fullname']))  {
				$result = user_model::getInstance();
                
				$result->addRecord($account);
				header( "Location: ".html_helpers::url(array('ctl'=>'home')));
            // }
        }
    }
}
?>
