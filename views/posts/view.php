<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="row row-offcanvas row-offcanvas-right">
	<div class="col-xs-12 col-sm-9">
	  <div class="table-responsive">
		<table class="table table-bordered table-striped">
		  <colgroup>
			<col class="col-xs-1">
			<col class="col-xs-7">
		  </colgroup>
		  <thead>
			<tr>
			  <th>Field</th>
			  <th>Value</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php foreach($this->record as $field=>$value) : ?>
			<tr>
			  <th scope="row"><?php echo $field ?></th>
			  <td><?php echo $value ?></td>
			</tr>
		  <?php endforeach; ?>
		  </tbody>
		</table>
	  </div>
	</div>
	<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
		<?php include_once 'views/widgets/sidebar.php'; ?>
	</div>
</div>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>
