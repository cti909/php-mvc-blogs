<?php
class login_controller extends main_controller
{
    public function index() 
	{
		$this->display();
	}
    public function login() {
        if(isset($_POST['btn_submit'])) {
            $arr = array("user" => $_POST['username'], "pass" => $_POST['password']);
            $users = user_model::getInstance();
            $this->records = $users->getAllRecords();
            
            $check = false;
            $user = $_POST['username'];
            $pass = $_POST['password'];
            // echo $user.' '.$pass;
            while($row = mysqli_fetch_array($this->records)){
                if($user==$row['username'] && $pass== $row['password']) {
                    $check=true;
                    $_SESSION['username']=$row['name'];
                    $_SESSION['user_id'] = $row['id'];
                    break;
                }
            }
            if($check) 
                header( "Location: ".html_helpers::url(array('ctl'=>'home')));
            else {
                header( "Location: ".html_helpers::url(array('ctl'=>'login', 'act'=>'index', 'params'=>['error'=>'true'])));
            }
        }
    }
    public function logout() {
        session_start();
        // delete all session
        session_unset();
        header("location: ".html_helpers::url(array('ctl'=>'home')));
    }
}
?>
