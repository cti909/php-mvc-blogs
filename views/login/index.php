<?php
global $mediaFiles;
array_push($mediaFiles['css'], RootREL.'media/css/background.css');
?>
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="background_login" style="width: 100vw; height: 94vh;">
    <div class="container">
        <div style="display: flex; justify-content:center;">
            <div class="bg-dark text-white" style="border-radius: 15px; opacity: 0.7;margin-top: 10rem;">
                <form class="p-4" id="form_login" method="post" action="<?php echo html_helpers::url(
                    array('ctl'=>'login', 
                        'act'=>'login', 
                        // 'params'=> array('name'=>$name,'username'=>$username,'password'=>$password)
                    )); ?>">
                    <h1 class="text-center">Login</h1>
                    <div class="d-flex mb-4">
                        <label class="text-center">Username:</label>
                        <input class="form-control mx-3" type="text" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="d-flex mb-4">
                        <label class="text-center">Password:</label>
                        <input class="form-control mx-3" type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <button class="btn btn-primary btn-block mx-auto d-block" name="btn_submit" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let username = document.getElementById("username");
    let password = document.getElementById("password");
    let form_login = document.getElementById("form_login");
    form_login.addEventListener("submit", function(event) {
        if(username.value == "" || password.value == "") {
            event.preventDefault();
            alert("You need enter username, password!");
        }
    });
    let params = new URLSearchParams(location.search);
    let error = params.get('error');
    if(error == "true")alert("Username or password is failed!")
</script>
