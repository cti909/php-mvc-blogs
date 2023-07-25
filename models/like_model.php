<?php
class like_model extends main_model {
	protected $table = 'likes';
	// so like cua post, tong so like cua comment user da like
	// SELECT
	// 	posts.id AS post_id,
	// 	COUNT(DISTINCT post_likes.id) AS post_likes_count,
	// 	COUNT(DISTINCT comment_likes.id) AS comment_likes_count,
	// 	IF(COUNT(DISTINCT my_likes.id) > 0, 1, 0) AS is_liked
	// FROM posts
	// 	LEFT JOIN likes AS post_likes ON post_likes.object_id = posts.id AND post_likes.type_id = $type_post
	// 	LEFT JOIN comments ON comments.post_id = posts.id
	// 	LEFT JOIN likes AS comment_likes ON comment_likes.object_id = comments.id AND comment_likes.type_id = $type_comment
	// 	LEFT JOIN likes AS my_likes ON my_likes.object_id = posts.id AND my_likes.user_id = $user_id AND my_likes.type_id = $type_post
	// GROUP BY posts.id;
	
	public function get_posts_like($user_id) {
		// neu khong dung post_id -> lay tat ca like, is_like theo tung post_id
		$type_post = 1;
		$type_comment = 2;
		$query = "
		SELECT 
			posts.id AS post_id, 
			COUNT(DISTINCT post_likes.id) AS post_likes_count, 
			COUNT(DISTINCT comments.id) AS comments_count, 
			MAX(IF(my_likes.user_id = 1, 1, 0)) AS is_liked
		FROM 
			posts 
			LEFT JOIN likes AS post_likes 
				ON post_likes.object_id = posts.id AND post_likes.type_id = $type_post
			LEFT JOIN comments ON comments.post_id = posts.id 
			LEFT JOIN likes AS my_likes 
				ON my_likes.object_id = posts.id AND my_likes.user_id = $user_id AND my_likes.type_id = $type_post
		GROUP BY posts.id;
		";

		$result = mysqli_query($this->con,$query);
		return $result;
	}
	// khi bam vao nut like
	public function like_object_add($user_id, $object_id, $type_id) {
		$query = "INSERT INTO $this->table (user_id,object_id,type_id) VALUES ($user_id, $object_id, $type_id);";
		$result = mysqli_query($this->con,$query);
	}
	public function like_object_del($user_id, $object_id, $type_id) {
		$query = "DELETE FROM $this->table WHERE object_id = $object_id AND user_id=$user_id AND type_id=$type_id";
		$result = mysqli_query($this->con,$query);
	}
	//------------
	public function delete_object_like($object_id, $type_id) { // object: post, comment
		$query = "DELETE FROM $this->table WHERE object_id = $object_id AND type_id=$type_id";
		$result = mysqli_query($this->con,$query);
	}
}	
?>
