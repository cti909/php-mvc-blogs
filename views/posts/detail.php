<?php
global $mediaFiles;
array_push($mediaFiles['css'], RootREL.'media/fontawesome/css/all.css');
array_push($mediaFiles['css'], RootREL.'media/css/posts.css');
array_push($mediaFiles['css'], RootREL.'media/css/comments_show.css');
?>
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="container">
	<div class="card shadow-lg my-3" id="<?php echo $this->post["id"] ?>">
			<div class="card-body">
				<div class="d-flex">
					<div class="border border-dark rounded-circle icon-svg">
						<i class="fa-solid fa-user"></i>
					</div>
					<h5 class="d-flex align-items-center card-title text-margin ms-2"><?php echo $this->post["creator_name"] ?></h5>
					<?php if($this->post["is_creator"]) { ?>
					<div class="ps-2">
						<button class="btn btn-warning" id="edit-post-<?php echo $this->post["id"]; ?>" onclick="post_edit_form(<?php echo $this->post['id'] ?>)">
							<i class="fa-solid fa-pen-to-square"></i>
						</button>
						<button class="btn btn-danger" id="delete-post-<?php echo $this->post["id"] ?>" onclick="post_delete(<?php echo $this->post['id'] ?>, 1)">
							<i class="fa-solid fa-trash"></i>
						</button>
					</div>
					<?php } ?>
				</div>
				<small class="text-muted">Posting time: <?php echo $this->post["posting_time"] ?></small>
				<p class="card-text" id="content-text-<?php echo $this->post["id"]; ?>"><?php echo $this->post["content"] ?></p>
				<?php if($this->post["photo"] != null) { ?>
				<img class="img-thumbnail" id="content-image-<?php echo $this->post["id"]; ?>" src="<?php echo "media/upload/" .$this->controller.'/'.$this->post["photo"]; ?>" alt="loading" >
				<?php } ?>
				<div id="input-file-<?php echo $this->post["id"]; ?>"></div>
				<hr>
				
				<?php if($this->post["is_liked"] == 1) { ?>
				<span id="like-text-<?php echo $this->post['id']; ?>">You and <?php echo $this->post["post_likes_count"]-1; ?> people liked</span>
				<?php } else { ?>
				<span id="like-text-<?php echo $this->post['id']; ?>"><?php echo $this->post["post_likes_count"]; ?> people liked</span>
				<?php } ?>
	
				<div class="d-flex">
					<div class="feature-item pe-2">
						<button class="btn btn-outline-dark w-100" id="post-like-<?php echo $this->post["id"]; ?>" onclick="like_post_change(
												<?php if (isset($_SESSION['user_id'])) echo $_SESSION['user_id']; else echo 0; ?>,
												<?php echo $this->post['id']; ?>,
												<?php echo $this->post['post_likes_count']; ?>,
												<?php echo $this->post['is_liked']; ?>
											)">
							<?php if($this->post["is_liked"] == 1) { ?>
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
												'id' => $this->post["id"],
												'post_likes_count' => $this->post["post_likes_count"],
												'comments_count' => $this->post["comments_count"],
												'is_liked' => $this->post["is_liked"]
											)
										)); ?>">
							Comments (<?php echo $this->post["comments_count"]; ?>)
						</a>
					</div>
					<div class="feature-item px-2">
						<a role="button" href="#" class="btn btn-outline-dark w-100">
							Share
							<i class="fa-solid fa-share"></i>
						</a>
					</div>
				</div>
				<div>
				<!-- comment -->
				<div class="card shadow-0 border my-3" style="background-color: #f0f2f5;" id="comment">
					<div class="card-body p-4">
					<?php if(isset($_SESSION['user_id'])) { ?>
						<div class="card">
							<div class="card-header">
								<strong>Comment & Question</strong>
							</div>
							<div class="card-body">
								<form method="POST" id="comment-add-0" enctype="multipart/form-data" comment-path="0000">
									<textarea class="form-control mb-2" id="content_0" placeholder="New comment or question"></textarea>
									<!-- <input class="form-control mb-2" type="file" name="image"> -->
									<button class="form-control btn btn-outline-dark" type="submit" name="btn_submit">
										Send
									</button>
								</form>
							</div>
						</div>
						<?php } ?>
						<input type="hidden" id="post_id" value="<?php echo $this->post["id"]; ?>">
						<div id="comments">
							<!-- <div id="comment-12">
								<div class="card my-3">
									<div class="card-body">
										<div class="d-block">
											<strong>Posted by: Ton Tu | <span class="fw-normal">2023-12-2</span></strong>
											<button class="btn btn-warning" id="edit-comment-<?php echo $this->post["id"] ?>">
												<i class="fa-solid fa-pen-to-square"></i>
											</button>
											<button class="btn btn-danger" id="delete-comment-<?php echo $this->post["id"] ?>" onclick="">
												<i class="fa-solid fa-trash"></i>
											</button>								
										</div>
										<p class="card-text">aaaaa</p>
										<img class="img-thumbnail" src="media/upload/" alt="loading" >
										<hr>
										<div class="d-flex">
											<button class="btn btn-outline-dark me-2">
												<i class="fa-solid fa-thumbs-up"></i>
											</button>
											<span></span>
											<button class="btn btn-outline-dark">
												Reply
											</button>
											
										</div>
									</div>
								</div>
								<div>
									<form method="POST" name="create_reply_?" enctype="multipart/form-data" action="" ?>">
										<textarea class="form-control mb-2" name="content" placeholder="Reply"></textarea>
										<input class="form-control mb-2" type="file" name="image_?">
										<button class="form-control btn btn-outline-dark" type="submit" name="btn_submit_?">
											Send
										</button>
									</form>
								</div>
							</div> -->
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php array_push($mediaFiles['js'], RootREL."media/js/jquery.min.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/post_action.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/js/comments.js"); ?>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>
