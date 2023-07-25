<?php

use function PHPSTORM_META\type;

class posts_controller extends main_controller
{
	// lay ten tac gia + noi dung + thong ke comment va like bai viet do
	// co nut xem chi tiet -> hien thi bai viet va chi tiet cac cac comment
	// xoa post thi xoa het toan bo post like comment
	// sua post -> sua content
	// them post mac dinh like=0 comment.count=0
	
	public function index()		// post sap xep theo thu tu posting_time desc va id desc (lay moi nhat)
	{
		$this->category_id = 0; // all
		$this->sort = "desc"; // desc
		$this->search_token = "";
		$this->page_current = 1;
		if(isset($_GET["category"])) $this->category_id = $_GET["category"];
		if(isset($_GET["sort"])) $this->sort = $_GET["sort"];
		if(isset($_GET["search_token"])) $this->search_token = $_GET["search_token"];
		if(isset($_GET["page"])) $this->page_current = $_GET["page"];

		// lay like post, like comment cua post day, request.user da like post chua
		$likes = like_model::getInstance();
		$user_id = -1;
		if(isset($_SESSION['user_id'])) {
			$user_id = $_SESSION['user_id'];
		} else {
			$user_id = -1;
		}
		$liked_post = $likes->get_posts_like($user_id);
		$post_id_like = array();
		$post_likes_count = array();
		$comments_count = array();
		$is_liked = array();
		$index_like = 0;
		while($row = mysqli_fetch_array($liked_post)){
			$post_id_like[$index_like] = $row[0];
			$post_likes_count[$index_like] = $row[1];
			$comments_count[$index_like] = $row[2];
			$is_liked[$index_like] = $row[3];
			$index_like++;
		}
		
		// pagination
		$page_limit = 5; // post/1page
		$start = ($this->page_current-1)*$page_limit;
		$posts = post_model::getInstance();
		$post_total_count = $posts->get_total_count($this->category_id,$this->search_token); // total posts
		$this->page_count = ceil($post_total_count / $page_limit);
		
		$this->records = $posts->get_posts($this->category_id,$this->sort,$this->search_token,$start,$page_limit);
		$this->dictionary = [];
		
		// update data
		$index = 0;
		while($row = mysqli_fetch_array($this->records)){
			if (isset($_SESSION['user_id']) && $_SESSION['user_id']==$row["creator_id"])
				$this->dictionary[$index]["is_creator"] = TRUE;
			else $this->dictionary[$index]["is_creator"] = FALSE;
			$this->dictionary[$index]["id"] = $row["id"];
			$this->dictionary[$index]["creator_name"] = $row["name"];
			$this->dictionary[$index]["content"] = $row["content"];
			$this->dictionary[$index]["photo"] = $row["photo"];
			$this->dictionary[$index]["creator_id"] = $row["creator_id"];
			$this->dictionary[$index]["posting_time"] = $row["posting_time"];
			$this->dictionary[$index]["creator_id"] = $row["creator_id"];
			// $this->dictionary[$index]["post_likes_count"] = $post_likes_count[$index];
			// $this->dictionary[$index]["comment_likes_count"] = $comment_likes_count[$index];
			// $this->dictionary[$index]["is_liked"] = $is_liked[$index];
			// $liked_post = $likes->get_posts_like($user_id, $row["id"]);
			// while($row = mysqli_fetch_array($liked_post)){ // chi 1 row
			// 	$this->dictionary[$index]["post_likes_count"] = $row[1];
			// 	$this->dictionary[$index]["comment_likes_count"] = $row[2];
			// 	$this->dictionary[$index]["is_liked"] = $row[3];
			// }
			for($i=0; $i < $index_like; $i++) {
				if($post_id_like[$i] == $row["id"]) {
					$this->dictionary[$index]["post_likes_count"] = $post_likes_count[$i];
					$this->dictionary[$index]["comments_count"] = $comments_count[$i];
					$this->dictionary[$index]["is_liked"] = $is_liked[$i];
					break;
				}
			}

			$index++;
		}
		$this->records_count = $index;

		// get categories
		$categories_model = category_model::getInstance();
		$this->categories_all = $categories_model->get_all_categories();
		$index = 0;
		$this->categories = [];
		while($row = mysqli_fetch_array($this->categories_all)){
			$this->categories[$index]["id"] = $row["id"];
			$this->categories[$index]["name"] = $row["name"];
			$index++;
		}
		$this->categories_count = $index;
		$this->display();
	} 
	
	public function like_post() {
		$json = file_get_contents('php://input');
		$data_decode = json_decode($json, true);
		$action = $data_decode['like'];
		$post_id = $data_decode['post_id'];

		$likes = like_model::getInstance();
		$type_post = 1;

		if($action == "del") {
			$likes->like_object_del($_SESSION['user_id'], $post_id, $type_post);
		} else if($action == "add"){
			$likes->like_object_add($_SESSION['user_id'], $post_id, $type_post);
		}
		$data = $data_decode['like'];
		$json = json_encode($data);
		header('Content-Type: application/json');
		echo $json;
	}
	public function detail($params) //detail
	{ 

		$posts = post_model::getInstance();
		$this->post_records = $posts->get_detail_post($params['id']);
		// $this->setProperty('records',$this->records); //dang k=>v
		$this->post = [];
		$index = 0;
		while($row = mysqli_fetch_array($this->post_records)){
			if (isset($_SESSION['user_id']) && $_SESSION['user_id']==$row["creator_id"]) 
				$this->post["is_creator"] = TRUE;
			else $this->post["is_creator"] = FALSE;
			$this->post["id"] = $row["id"];
			$this->post["creator_name"] = $row["name"];
			$this->post["content"] = $row["content"];
			$this->post["photo"] = $row["photo"];
			$this->post["creator_id"] = $row["creator_id"];
			$this->post["posting_time"] = $row["posting_time"];
			$this->post["creator_id"] = $row["creator_id"];
			$this->post["post_likes_count"] = $params['post_likes_count'];
			$this->post["comments_count"] = $params['comments_count'];
			$this->post["is_liked"] = $params['is_liked'];
			$index++;
		}
		$this->display();
	}

	// chua dung ajax
	public function add()
	{
		if(isset($_POST['btn_submit'])) {
			$image = null;
			if(isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
				$image = SimpleImage_Component::uploadImg($_FILES, $this->controller);
			}
			if(!empty($_POST['content']) || $image !== null) {
				$post_data = array(
					'content' => nl2br($_POST['content']),
					'photo' => $image,
					'posting_time' => date("Y-m-d"),
					'creator_id' => $_SESSION['user_id'],
					'category_id' => $_POST['category']
				);
				$post = post_model::getInstance();
				if($post->addRecord($post_data))
					header( "Location: ".html_helpers::url(array('ctl'=>'posts')));
			} else {
				echo "<script>alert('You should write content or choice image!');</script>";
				
			}
		}
	}

	// thieu xoa anh, chi click 1 lan, bam nhieu lan-> json loi
	public function edit_post() {
		$content = $_POST['content'];
		$post_id = $_POST['post_id'];
		$image = null;
		$image_name = null;
		if(isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
			$image = SimpleImage_Component::uploadImg($_FILES, $this->controller);
		}

		if($image !== null) {
			$image_name = $image;
		} else {
			if (isset($_POST['image_temp']))
				$image_name = $_POST['image_temp'];
			else
				$image_name = null;
		}
		if(!empty($content) || $image_name !== null) {
			$post_data = array(
				'content' => nl2br($content),
				'photo' => $image_name,
				'posting_time' => date("Y-m-d"),
			);
			$post = post_model::getInstance();
			$post->editRecord($post_id, $post_data);
		} else {
			echo "error";
		}
		if(empty($content)) $content = "";
		if($image_name == null) $image_name = "";
		$response = [
			'content' => nl2br($content),
			'image' => "$image_name",
		];
		// header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	public function delete_post()
	{
		$json = file_get_contents('php://input');
		$data_decode = json_decode($json, true);
		$post_id = $data_decode['post_id'];

		$post = post_model::getInstance();
		$comment = comment_model::getInstance();
		$like = like_model::getInstance();

		$like->delete_object_like($post_id, $type_id=1); // delete post like
		$comments_by_post = $comment->get_comments_by_post($post_id);
		while ($row = mysqli_fetch_array($comments_by_post)) {
			$like->delete_object_like($row["id"], $type_id=2); // delete all like in commnent
		}
		$comment->delete_comments_by_post($post_id); // delete comments
		$post->delete_post($post_id); // delete post

		$data = $data_decode['post_id'];
		$json = json_encode($data);
		header('Content-Type: application/json');
		echo $json;
	}
}
?>
