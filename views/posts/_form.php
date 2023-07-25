<?php 
$params = (isset($this->record))? array('id'=>$this->record['id']):'';
?>
<form method="post" enctype="multipart/form-data" action="<?php echo html_helpers::url(
		array('ctl'=>'posts', 
			  'act'=>$this->action, 
			  'params'=>$params
)); ?>">

  <div class="row mb-3">
    <label for="content" class="col-sm-2 col-form-label">Content</label>
    <div class="col-sm-10">
      <textarea rows="4" cols="50" name="data[<?php echo $this->controller; ?>][content]" type="text" class="form-control" id="content" placeholder="content"><?php echo (isset($this->record))? $this->record['content'] : ""; ?></textarea>
    </div>
  </div>
  
  <div class="row mb-3">
    <label for="posting_time" class="col-sm-2 col-form-label">Posting time</label>
    <div class="col-sm-10">
      <?php 
      $format = "Y-m-d";
      $time = date($format, time());
      // echo $time;
      ?>
      <input readonly name="data[<?php echo $this->controller; ?>][posting_time]" type="text" class="form-control" id="posting_time" placeholder="posting_time" <?php echo "value='".$time."'"; ?>>
    </div>
  </div>
  
  <div class="row mb-3">
    <div class="offset-sm-2 col-sm-10">
      <button name="btn_submit" type="submit" class="btn btn-primary"><?php echo ucwords($this->action); ?></button>
    </div>
  </div>
</form>
<?php global $mediaFiles; ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/jquery.min.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/form.js"); ?>
