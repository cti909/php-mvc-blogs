<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="content">
	<div class="alert alert-success" role="alert">
		<h4 class="alert-heading">Well done!</h4>
		<p>2 tables users & user_activity were created sucessful! You could go to each table to see all fields of it.</p>
		<hr>
		<ol>
		<?php foreach($this->tables as $table) { ?>
			<li><a href="<?php echo html_helpers::url(['ctl'=>'tables', 'act'=>'getfields', 'params'=>['table'=>$table]]); ?>"><?php echo $table ?></a></li>
		<?php } ?>
		</ol>
	</div>
</div>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>
