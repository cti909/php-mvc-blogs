<?php
class comments_controller extends main_controller
{
	public function get_all_comment($params)
	{
		// session_start();
		$comment = comment_model::getInstance();
		$this->comments = $comment->get_all_comments($params["id"]);
		$index = 0;
		$comments_array = [];
		while($row = mysqli_fetch_array($this->comments)){
			array_push($comments_array,[
				"name" => $row["name"],
				"id" => $row["id"],
				"content" => $row["content"],
				"path" => $row["path"],
				"posting_time" => $row["posting_time"],
				"post_id" => $row["post_id"],
				"user_request" => $_SESSION['user_id'],
				"creator_id" =>  $row["creator_id"]
			]);
			$index++;
		}
		// return json
		$json = json_encode($comments_array);
		header('Content-Type: application/json');
		echo $json;
	}
	public function get_comments_by_post()
	{
		$json = file_get_contents('php://input');
		$data_decode = json_decode($json, true);
		$post_id = $data_decode['post_id'];
		$user_id = 0;
		if (isset($_SESSION["user_id"])) $user_id = $_SESSION["user_id"];
		$comment = comment_model::getInstance();
		$this->comments = $comment->get_comments($user_id, $post_id);
		$index = 0;
		$comments_array = [];
		while($row = mysqli_fetch_array($this->comments)){
			$this->comment = array(
				"id" => $row["comment_id"],
				"content" => $row["content"],
				"path" => $row["path"],
				"path_length" => $row["path_length"],
				"posting_time" => $row["posting_time"],
				"creator_id" =>  $row["creator_id"],
				"creator_name" =>  $row["creator_name"],
				'request_user_id' => $user_id,
				"comment_likes_count" =>  $row["comment_likes_count"],
				"is_liked" =>  $row["is_liked"]
			);
			array_push($comments_array, $this->comment);
			$index++;
		}
		header('Content-Type: application/json');
		echo json_encode($comments_array);
	}
	public function like_comment() {
		$json = file_get_contents('php://input');
		$data_decode = json_decode($json, true);
		$action = $data_decode['like'];
		$comment_id = $data_decode['comment_id'];

		$likes = like_model::getInstance();
		$type_post = 2;

		if($action == "del") {
			$likes->like_object_del($_SESSION['user_id'], $comment_id, $type_post);
		} else if($action == "add"){
			$likes->like_object_add($_SESSION['user_id'], $comment_id, $type_post);
		}
		$data = $data_decode['like'];
		$json = json_encode($data);
		header('Content-Type: application/json');
		echo $json;
	}
	public function delete_comment()
	{
		$json = file_get_contents('php://input');
		$data_decode = json_decode($json, true);
		$path = $data_decode['path'];
		$post_id = $data_decode['post_id'];

		$comment = comment_model::getInstance();
		$like = like_model::getInstance();

		// $like->delete_object_like($comment_id, $type_id=2); // delete comment like
		// $comment->delete_comment($comment_id); // delete post
		$comments_del = $comment->get_comments_by_path($post_id, $path);
		while($row = mysqli_fetch_array($comments_del)) {
			$like->delete_object_like($row["id"], $type_id=2); // delete all like in commnent
		}
		$comment->delete_comment_by_path($post_id, $path); // delete comments by path

		$data = $path;
		$json = json_encode($data);
		header('Content-Type: application/json');
		echo $json;
	}
	public function add_comment()
	{
		$json = file_get_contents('php://input');
		$data_decode = json_decode($json, true);
		$post_id = $data_decode['post_id'];
		$path_comment = $data_decode['path']; // comment_id=0 -> create new
		$content = $data_decode['content'];

		// echo $data_decode['post_id']."-".$data_decode['path']."-".$data_decode['content'];

		// $post_id = 67;
		// $path_comment = "0000";
		// $content = "aaa";
		$comment = comment_model::getInstance();
		$comment_count = $comment->check_exist_comment($post_id); // so luong comment trong post
		
		$path_current = "";
		$path_length_current = 0;

		if($comment_count == 0) { // 0 comment
			// chua co comment
			$path_current = "0001";
			$path_length_current = 0;
		} else {
			// ton tai comment
			if($path_comment == "0000") { 
				// lay comment cuoi co path_length=0
				$path_length_current = 0;
				$comment_parent = $comment->get_lastest_comment_by_path($post_id, $path="", $path_length_current);
				while($row = mysqli_fetch_array($comment_parent)) { // 1 row
					$comment_parent_path = $row["path"];
				}
				$path_current_number = intval($comment_parent_path) + 1;
				$path_current = sprintf("%04d", $path_current_number); // so thanh chuoi
				
			} else {
				// ton tai comment cha
				$comment_parent_path = $path_comment;
				$comment_parent_path_length = count( explode(".", $path_comment) ) - 1;
				$path_length_current = $comment_parent_path_length + 1;
				$comment_check = $comment->get_lastest_comment_by_path($post_id, $comment_parent_path, $path_length_current );
				if( mysqli_num_rows($comment_check) > 0) {
					while($row = mysqli_fetch_array($comment_check)) { // 1 row
						$comment_temp = $row["path"];
					}
					$comment_temp_number = substr($comment_temp, -4);
					$path_current_number = intval($comment_temp_number) + 1;
					$path_current = $comment_parent_path.".".sprintf("%04d", $path_current_number);
				}
				else {
					$path_current = $comment_parent_path.".0001";
				}
			}
		}
		// echo $path_current;

		$id_current = $comment->get_max_id_comment() + 1;
		if(!empty($content)) {
			$post_data = array(
				'id' => $id_current,
				'content' => nl2br($content),
				'posting_time' => date("Y-m-d"),
				'post_id' => $post_id,
				'creator_id' => $_SESSION['user_id'],
				'path' => $path_current,
				'path_length' => $path_length_current,
			);
			$comment->addRecord($post_data);
		}

		$user_id = 0;
		if (isset($_SESSION["user_id"])) $user_id = $_SESSION["user_id"];

		$comments_id = [];
		$comments_path = [];
		if ($path_comment != "0000") {
			$comments_id_by_path = $comment->get_comments_by_path($post_id, $path_comment);
		} else {
			$comments_id_by_path = $comment->get_comments_by_path($post_id, "");
		}
		while($row = mysqli_fetch_array($comments_id_by_path)) {
			array_push($comments_id, $row["id"]);
			array_push($comments_path, $row["path"]);
		}
		$data = [
			'id' => $id_current,
			'content' => nl2br($content),
			'posting_time' => date("Y-m-d"),
			'post_id' => $post_id,
			'creator_id' => $_SESSION['user_id'],
			'creator_name' => $_SESSION['username'],
			'path' => $path_current,
			'path_length' => $path_length_current,
			'request_user_id' => $user_id,
			"comment_likes_count" =>  0,
			"is_liked" => 0,
			'comments_id' => $comments_id,
			'comments_path' => $comments_path
		];
		$json = json_encode($data);
		header('Content-Type: application/json');
		echo $json;
	}

	public function like($params) {
		$likes = like_model::getInstance();
		$object = $params['like'];
		if($object == "liked") {
			$likes->userDelLikeCmt($_SESSION['user_id'], $params['post_id'], $params['comment_id']);
		} else if($object == "not_liked"){
			$likes->userAddLike($_SESSION['user_id'], $params['post_id'], $params['comment_id']);
		}
		header( "Location: ".html_helpers::url(array('ctl'=>'posts',
											'act'=>'detail',
											'params' => array(
												'id'=> $params['post_id'],
												'user_like'=> $params['user_like'],
												'post_like' => $params['post_like']
												// 'user_like'=> $this->user_liked
											)
											)));
	}
	
	public function edit_comment() {
		$content = $_POST['content'];
		$comment_id = $_POST['comment_id'];
		if(!empty($content)) {
			$post_data = array(
				'content' => nl2br($content),
				'posting_time' => date("Y-m-d"),
			);
			$comment = comment_model::getInstance();
			$comment->editRecord($comment_id, $post_data);
		} else {
			echo "error";
		}
		if(empty($content)) $content = "";
		$response = [
			'content' => nl2br($content)
		];
		header('Content-Type: application/json');
		echo json_encode($response);
	}
}
?>
