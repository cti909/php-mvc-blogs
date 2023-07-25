<?php 
	global $obMediaFiles;
	array_push($obMediaFiles['css'], "media/css/sidebar.css");
?>
<div class="list-group">
	<a href="#" class="list-group-item active">
		<h4 class="list-group-item-heading">Management posts</h4>
	</a>
	<a href="<?php echo html_helpers::url(array('ctl'=>'posts')); ?>" class="list-group-item">List all posts</a>
	<a href="<?php echo html_helpers::url(array('ctl'=>'posts', 'act'=>'add')); ?>" class="list-group-item">Add new post</a>
</div>
