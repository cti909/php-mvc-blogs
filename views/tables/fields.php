<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="container">
	<div class="content">
		<h1>List fields of <?php $this->table; ?></h1>
		<hr>
		<?php if(count($this->fields)) { ?>
			<ol>
			<?php foreach($this->fields as $field) { ?>
				<li><?php echo $field ?></li>
			<?php } ?>
			</ol>
		<?php } else {?>
			<p> There are no fields of <?php $this->table; ?> </p>
		<?php } ?>
	</div>
</div>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>
