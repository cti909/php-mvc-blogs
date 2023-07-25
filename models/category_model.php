<?php
class category_model extends main_model {
	protected $table = 'categories';
	public function get_all_categories() {
		$query = "SELECT * FROM categories";
		$result = mysqli_query($this->con,$query);
		return $result;
	}
}
?>
