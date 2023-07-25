<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="container">
	<div class="content">
		<h1>List tables</h1>
		<hr>
		<?php $usertables = [];  ?>
		<?php if(count($this->tables)) { ?>
			<ol>
			<?php foreach($this->tables as $table) { ?>
				<li><a href="<?php echo html_helpers::url(['ctl'=>'tables', 'act'=>'getfields', 'params'=>['table'=>$table]]); ?>"><?php echo $table ?></a></li>
				<?php if($table == 'users' || $table == 'activity_user') array_push($usertables,$table);	; ?>
			<?php } ?>
			</ol>
			<?php if(!count($usertables)) { ?>
				<p> There are no users & activity_user tables added, please <a href="<?php echo html_helpers::url(['ctl'=>'tables', 'act'=>'create']); ?>">click here</a> to add 2 tables <strong>users</strong> & <strong>user_activity</strong> </p>
			<?php } ?>
		<?php } else {?>
			<p> There are no table added, please <a href="<?php echo html_helpers::url(['ctl'=>'tables', 'act'=>'create']); ?>">click here</a> to add 2 tables <strong>users</strong> & <strong>user_activity</strong> </p>
		<?php } ?>
	</div>
</div>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>
