<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blogs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
	<link href="<?php echo RootREL; ?>media/bootstrap5/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo RootREL; ?>media/fontawesome/css/all.css" rel="stylesheet">
	<link href="<?php echo RootREL; ?>media/css/main.css" rel="stylesheet">
	<?php echo html_helpers::cssHeader(); ?>
</head>
<body>
<header class="container">
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Blogs</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?php echo html_helpers::url('/'); ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo html_helpers::url(['ctl'=>'tables']); ?>">Tables</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo html_helpers::url(['ctl'=>'posts']); ?>">Blogs</a>
          </li>
        </ul>
        <?php if(isset($_SESSION["username"])) { ?>
          <span class='text-success mx-2'><?php echo $_SESSION["username"]; ?></span>
          <a class='btn-primary p-2' style="text-decoration: none;" href="<?php echo html_helpers::url(['ctl'=>'login','act'=>'logout']); ?>">Logout</a>
        <?php } else { ?>
          <a class='btn-primary p-2 mx-2' style="text-decoration: none;" href="<?php echo html_helpers::url(['ctl'=>'register','act'=>'index']); ?>">Register</a>
          <a class='btn-primary p-2 mx-2' style="text-decoration: none;" href="<?php echo html_helpers::url(['ctl'=>'login','act'=>'index']); ?>">Login</a> 
        <?php } ?>
      </div>
    </div>
  </nav>
</header>
<main>
  <!-- <div class="container"> -->
