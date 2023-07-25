<?php
global $mediaFiles;
array_push($mediaFiles['css'], RootREL.'media/css/posts.css');
?>
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="container pt-4">
	<div class="row">
		<div class="col-8">
			<div class="d-flex">
				<strong class="w-25 d-flex align-items-center text-center">Choose of category:</strong>
				<select class="w-25 form-select" name="categories" id="categories">
					<option value="0" selected>All</option>
					<?php if($this->categories_all) { ?>	
						<?php for($i=0; $i < $this->categories_count; $i++) { ?>

							<?php if ($this->category_id == $this->categories[$i]['id']) { ?> 
							<option value="<?php echo $this->categories[$i]['id']; ?>" selected>
								<?php echo $this->categories[$i]['name']; ?>
							</option>
							<?php } else { ?>
							<option value="<?php echo $this->categories[$i]['id']; ?>">
								<?php echo $this->categories[$i]['name']; ?>
							</option>
							<?php } ?>	

						<?php } ?>
					<?php } ?>
				</select>
				<div class="d-flex align-items-center px-3">
					<div class="form-check pe-2">
						<?php if ($this->sort == "desc") { ?>
						<input class="form-check-input" type="radio" name="sort" id="desc" value="desc" checked>
						<?php } else { ?>
							<input class="form-check-input" type="radio" name="sort" id="desc" value="desc">
						<?php } ?>
						<label class="form-check-label" for="desc">
							Latest time
							<i class="fa-solid fa-arrow-down-short-wide"></i>
						</label>
					</div>
					<div class="form-check">
						<?php if ($this->sort == "asc") { ?>
						<input class="form-check-input" type="radio" name="sort" id="asc" value="asc" checked>
						<?php } else { ?>
						<input class="form-check-input" type="radio" name="sort" id="asc" value="asc">
						<?php } ?>
						<label class="form-check-label" for="asc">
							Oldest time
							<i class="fa-solid fa-arrow-down-wide-short"></i>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="d-flex">
				<form method="POST" class="input-group mb-3" id="search_content">
					<input id="search_token" type="search" class="form-control" placeholder="Search" value="<?php echo $this->search_token; ?>"/>
					<button type="submit" class="btn btn-primary">
						<i class="fas fa-search"></i>
					</button>
				</form>
			</div>
		</div>
	</div>
	<?php if(isset($_SESSION['user_id'])) { ?>
	<div class="card">
		<div class="card-header">
			<strong>Create new posts</strong>
		</div>
		<div class="card-body">
			<form method="POST" name="create_post" enctype="multipart/form-data" action="<?php echo html_helpers::url(
																	array('ctl'=>'posts', 
																		'act'=>'add'
																	)); ?>">
				<select class="w-25 form-select mb-2" name="category">
					<?php if($this->categories_all) { ?>	
						<?php for($i=0; $i<$this->categories_count; $i++) { ?>
						<option value="<?php echo $this->categories[$i]['id']; ?>">
							<?php echo $this->categories[$i]['name']; ?>
						</option>
						<?php } ?>
					<?php } ?>
				</select>
				<textarea class="form-control mb-2" name="content" placeholder="New posts"></textarea>
				<input class="form-control mb-2" type="file" name="image">
				<button class="form-control btn btn-outline-dark" type="submit" name="btn_submit">
					Send posting
				</button>
			</form>
		</div>
	</div>
	<?php } ?>
	<!-- --------------show post------------------- -->
	<?php if($this->records_count != 0) { ?>		
		<?php for($index=0; $index<$this->records_count; $index++) { ?>
		<div class="card shadow-lg my-3" id="post-<?php echo $this->dictionary[$index]["id"] ?>">
			<div class="card-body">
				<div class="d-flex">
					<div class="border border-dark rounded-circle icon-svg">
						<i class="fa-solid fa-user"></i>
					</div>
					<h5 class="d-flex align-items-center card-title text-margin ms-2"><?php echo $this->dictionary[$index]["creator_name"]; ?></h5>
					<?php if($this->dictionary[$index]["is_creator"]) { ?>
					<div class="ps-2" id="group-button-<?php echo $this->dictionary[$index]["id"]; ?>">
						<button class="btn btn-warning" id="edit-post-<?php echo $this->dictionary[$index]["id"]; ?>" onclick="post_edit_form(<?php echo $this->dictionary[$index]['id'] ?>)">
							<i class="fa-solid fa-pen-to-square"></i>
						</button>
						<button class="btn btn-danger" id="delete-post-<?php echo $this->dictionary[$index]["id"]; ?>" onclick="post_delete(<?php echo $this->dictionary[$index]['id'] ?>, 0)">
							<i class="fa-solid fa-trash"></i>
						</button>
					</div>
					<?php } ?>
				</div>
				<small class="text-muted">Posting time: <?php echo $this->dictionary[$index]["posting_time"] ?></small>
				<p class="card-text" id="content-text-<?php echo $this->dictionary[$index]["id"]; ?>"><?php echo $this->dictionary[$index]["content"] ?></p>
				<?php if($this->dictionary[$index]["photo"] != null) { ?>
				<img class="img-thumbnail" id="content-image-<?php echo $this->dictionary[$index]["id"]; ?>" src="<?php echo "media/upload/" .$this->controller.'/'.$this->dictionary[$index]["photo"]; ?>" alt="loading" >
				<?php } ?>
				<div id="input-file-<?php echo $this->dictionary[$index]["id"]; ?>"></div>
				<hr>
	
				<?php if($this->dictionary[$index]["is_liked"] == 1) { ?>
				<span id="like-text-<?php echo $this->dictionary[$index]['id'] ?>">You and <?php echo $this->dictionary[$index]["post_likes_count"]-1; ?> people liked</span>
				<?php } else { ?>
				<span id="like-text-<?php echo $this->dictionary[$index]['id'] ?>"><?php echo $this->dictionary[$index]["post_likes_count"]; ?> people liked</span>
				<?php } ?>
				
				<div class="d-flex">
					<div class="feature-item pe-2">
						<button class="btn btn-outline-dark w-100" id="post-like-<?php echo $this->dictionary[$index]["id"]; ?>" onclick="like_post_change(
												<?php if (isset($_SESSION['user_id'])) echo $_SESSION['user_id']; else echo 0; ?>,
												<?php echo $this->dictionary[$index]['id']; ?>,
												<?php echo $this->dictionary[$index]['post_likes_count']; ?>,
												<?php echo $this->dictionary[$index]['is_liked']; ?>
											)">
							<?php if($this->dictionary[$index]["is_liked"] == 1) { ?>
							<i class="fa-solid fa-thumbs-up"></i>
							<?php } else { ?>
							<i class="fa-regular fa-thumbs-up"></i>
							<?php } ?>
						</button>
					</div>
					<div class="feature-item ps-2">
						<a role="button" class="btn btn-outline-dark w-100" href="<?php echo html_helpers::url(
										array('ctl'=>'posts', 
											'act'=>'detail',
											'params'=>array(
												'id' => $this->dictionary[$index]["id"],
												'post_likes_count' => $this->dictionary[$index]["post_likes_count"],
												'comments_count' => $this->dictionary[$index]["comments_count"],
												'is_liked' => $this->dictionary[$index]["is_liked"]
											)
										)); ?>">
							Comments (<?php echo $this->dictionary[$index]["comments_count"]; ?>)
						</a>
					</div>
					<div class="feature-item px-2">
						<a role="button" href="#" class="btn btn-outline-dark w-100">
							Share
							<i class="fa-solid fa-share"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	<?php } else { ?>
			<strong class="d-block text-center">There are no records</strong> 
	<?php }  ?>
	</div>
</div>
<div class="container">
	<input type="hidden" value="<?php echo $this->page_current; ?>" id="page_current">
	<input type="hidden" value="<?php echo $this->page_count; ?>" id="page_count">
	<ul class="d-flex justify-content-center p-3" id="pagination" style="list-style: none;">
	</ul>
</div>

</div>
<?php array_push($mediaFiles['js'], RootREL."media/js/jquery.min.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/posts.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/post_action.js"); ?>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>
