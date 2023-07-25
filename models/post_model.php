<?php
class post_model extends main_model {
	protected $table = 'posts';
	public function get_total_count($category,$search_token) {
		if ($category == 0)
			$query = "
			SELECT COUNT(*) 
			FROM posts
			WHERE posts.content LIKE '%$search_token%'
			";
		else
			$query = "
			SELECT COUNT(*) 
			FROM posts 
			WHERE posts.content LIKE '%$search_token%' AND posts.category_id=$category
			";
		$result = mysqli_query($this->con,$query);
		$row = mysqli_fetch_array($result);
		return $row[0];
	}
	public function get_posts($category,$sort,$search_token,$start,$page_limit) {
		if ($category == 0)
			$query = 
			"
			SELECT posts.id, users.name, posts.content, posts.photo, posts.posting_time, posts.creator_id 
			FROM posts, users
			WHERE users.id = posts.creator_id AND posts.content LIKE '%$search_token%'
			ORDER BY posts.posting_time $sort, id desc
			LIMIT $start, $page_limit
			";
		else
			$query = 
			"
			SELECT posts.id, users.name, posts.content, posts.photo, posts.posting_time, posts.creator_id 
			FROM posts, users
			WHERE users.id = posts.creator_id AND posts.content LIKE '%$search_token%' AND posts.category_id=$category
			ORDER BY posts.posting_time $sort, id desc
			LIMIT $start, $page_limit
			";
		$result = mysqli_query($this->con,$query);
		return $result;
	}
	public function get_detail_post($post_id) {
		$query = "SELECT posts.id, users.name, posts.content, posts.photo, posts.posting_time, posts.creator_id FROM posts, users where users.id = posts.creator_id and posts.id=".$post_id;
		$result = mysqli_query($this->con,$query);
		return $result;
	}
	
	public function delete_post($post_id) {
		$query = "DELETE FROM $this->table WHERE id=".$post_id; // "" co the "$post_id"
		mysqli_query($this->con,$query);
	}
}
?>
