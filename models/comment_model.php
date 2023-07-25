<?php
class comment_model extends main_model {
	protected $table = 'comments';
	
	public function check_exist_comment($post_id) {
		$query = "SELECT COUNT(*) AS comment_count FROM comments WHERE post_id = $post_id;";
		$result = mysqli_query($this->con,$query);
		$row = mysqli_fetch_array($result);
		return $row[0];
	}
	// public function get_comment_by_path($path) {
	// 	$query = "SELECT * FROM comments WHERE path = $path;";
	// 	$result = mysqli_query($this->con,$query);
	// 	echo $query;
	// 	return $result;
	// }
	public function get_lastest_comment_by_path($post_id, $path, $path_length) {
		$query = "
		SELECT *
		FROM comments
		WHERE id = (
			SELECT MAX(id)
			FROM comments
			WHERE post_id = $post_id AND path_length = $path_length AND path LIKE '$path%'
		);";
		$result = mysqli_query($this->con,$query);
		return $result;
	}
	public function get_max_id_comment() {
		$query = "
		SELECT id
		FROM comments
		WHERE id = (
			SELECT MAX(id)
			FROM comments
		);";
		$result = mysqli_query($this->con,$query);
		$row = mysqli_fetch_array($result);
		return $row[0];
	}
	//----------------------------
	public function get_all_comments($post_id) {
		$query = "SELECT users.name, comments.id, comments.content, comments.posting_time, comments.post_id ,comments.creator_id ,comments.path FROM comments, users, posts 
					where users.id = comments.creator_id and comments.post_id = posts.id and comments.post_id =".$post_id." ORDER BY comments.path ASC;";
		$result = mysqli_query($this->con,$query);
		return $result;
	}
	public function delete_comments_by_post($post_id) {
		$query = "DELETE FROM $this->table WHERE post_id=".$post_id; // "" co the "$post_id"
		mysqli_query($this->con,$query);
	}
	public function get_comments_by_post($post_id) {
		$query = "SELECT id FROM comments WHERE post_id=$post_id;";
		$result = mysqli_query($this->con,$query);
		return $result;
	}
	public function get_comments($user_id, $post_id, $type_id=2) {
		$query = 
		"
		SELECT 
			comments.id AS comment_id, 
            comments.content,
            comments.path,
			comments.path_length,
            comments.posting_time,
            comments.creator_id,
            users.name AS creator_name,
			COUNT(DISTINCT comment_likes.id) AS comment_likes_count,
			MAX(IF(my_likes.user_id = 1, 1, 0)) AS is_liked
		FROM 
			comments 
			INNER JOIN posts ON posts.id = comments.post_id
			LEFT JOIN likes AS comment_likes 
				ON comment_likes.object_id = comments.id AND comment_likes.type_id = $type_id
			LEFT JOIN likes AS my_likes 
				ON my_likes.object_id = comments.id AND my_likes.user_id = $user_id AND my_likes.type_id = $type_id
			INNER JOIN users ON comments.creator_id = users.id
		WHERE 
			posts.id = $post_id
		GROUP BY comments.id
		ORDER BY comments.path ASC;
		";
		$result = mysqli_query($this->con,$query);
		return $result;
	}
	public function add_comment($comment_id) {
		$query = "DELETE FROM $this->table WHERE id=".$comment_id;
		mysqli_query($this->con,$query);
	}
	public function delete_comment($comment_id) {
		$query = "DELETE FROM $this->table WHERE id=".$comment_id;
		mysqli_query($this->con,$query);
	}
	public function get_comments_by_path($post_id, $path) {
		$query = "SELECT * FROM comments WHERE post_id=$post_id AND path LIKE '$path%';";
		$result = mysqli_query($this->con,$query);
		return $result;
	}
	public function delete_comment_by_path($post_id, $path) {
		$query = "DELETE FROM $this->table WHERE post_id=$post_id AND path LIKE '$path%'" ;
		mysqli_query($this->con,$query);
	}

}
?>
