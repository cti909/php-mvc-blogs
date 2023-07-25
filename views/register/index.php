
<?php 
global $mediaFiles;
array_push($mediaFiles['css'], RootREL.'media/css/background.css');
?>
<?php $params = (isset($this->record))? array('id'=>$this->record['id']):''; ?>
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="background_login" style="width: 100vw; height: 94vh;">
    <div class="container">
        <div style="display: flex; justify-content:center;">
            <div class="bg-dark text-white" style="border-radius: 15px; opacity: 0.7;margin-top: 10rem;">
            <form class="p-4" id="form_login" method="post" action="<?php echo html_helpers::url(
                array('ctl'=>'register', 
                'act'=>'register', 
			    'params'=>$params   
                )); ?>">
                <h1 class="text-center">Register</h1>
                <div class="mb-4">
                    <label>Name:</label>
                    <!-- <input class="col-8 form-control" style="width: auto;" type="text" name="name" placeholder="Name"> -->
                    <input class="col-8 form-control" name="data[<?php echo $this->controller; ?>][name]" type="text" id="name" placeholder="Name" <?php echo (isset($this->record))? "value='".$this->record['name']."'":""; ?>>
                </div>
                <div class="mb-4">
                    <label>Username:</label>
                    <!-- <input class="col-8 form-control" style="width: auto;" type="text" name="username" placeholder="Username"> -->
                    <input class="col-8 form-control" name="data[<?php echo $this->controller; ?>][username]" type="text" id="username" placeholder="Username" <?php echo (isset($this->record))? "value='".$this->record['username']."'":""; ?>>
                </div>
                <div class="mb-4">
                    <label>Password:</label>
                    <!-- <input class="col-8 form-control" style="width: auto;" type="password" name="password" placeholder="Password"> -->
                    <input class="col-8 form-control" name="data[<?php echo $this->controller; ?>][password]" type="password" id="password" placeholder="Password" <?php echo (isset($this->record))? "value='".$this->record['password']."'":""; ?>>
                </div>
                <button class="btn btn-primary btn-block mx-auto d-block" name="btn_submit">Register</button>
            </form>
        </div>
        </div>
    </div>
</div>
<script>
    let name = document.getElementById("name");
    let username = document.getElementById("username");
    let password = document.getElementById("password");
    let form_login = document.getElementById("form_login");
    form_login.addEventListener("submit", function(event) {
        if(username.value == "" || password.value == "" || name.value == "") {
            event.preventDefault();
            alert("You need enter name, username, password!");
        }
    });
    let params = new URLSearchParams(location.search);
    let error = params.get('error');
    if(error == "true")alert("Username or password is failed!")
</script>