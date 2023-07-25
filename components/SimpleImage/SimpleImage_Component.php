<?php
class SimpleImage_Component {
	var $image;
	var $image_type;
	
	public static function uploadImg($flies, $desfd, $newSize=null) {
		$t=time();
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $flies["image"]["name"]);
		
		$extension = end($temp);
		if ((($flies["image"]["type"] == "image/gif")
			|| ($flies["image"]["type"] == "image/jpeg")
			|| ($flies["image"]["type"] == "image/jpg")
			|| ($flies["image"]["type"] == "image/pjpeg")
			|| ($flies["image"]["type"] == "image/x-png")
			|| ($flies["image"]["type"] == "image/png"))
			&& ($flies["image"]["size"] < 200000000)
			&& in_array($extension, $allowedExts))
		{
			if ($flies["image"]["error"] > 0) {
				//var_dump($flies["image"]["error"]);
				echo 'error';
				return false;
		    }
			$ulfd = UploadREL .$desfd.'/';
			$newfn = time().rand(10000,99999).'.'.$extension;
		    if (file_exists($ulfd . $newfn)) {
		      	return true;
		    } else {
		        move_uploaded_file($flies["image"]["tmp_name"], $ulfd.$newfn);
				$SimpleImg = new self;
				$SimpleImg->load($ulfd.$newfn);
				if(isset($newSize['height']) && !isset($newSize['width'])) {
					$newW = 200;
					$SimpleImg->resizeToHeight($newW);
				} else {
					$newW = 200;
					if($desfd == "posts") $newW = 1262;
					if(isset($newSize['width'])) {
						$newW = $newSize['width'];
					}
					$SimpleImg->resizeToWidth($newW);
				}
				$SimpleImg->save($ulfd.$newfn);
				return $newfn;
		    }
		} else {
			echo "Invalid file";
			return false;
		}
	}
	
	function load($filename) {
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		if( $this->image_type == IMAGETYPE_JPEG ) {
			$this->image = imagecreatefromjpeg($filename);
		} elseif( $this->image_type == IMAGETYPE_GIF ) {
			$this->image = imagecreatefromgif($filename);
		} elseif( $this->image_type == IMAGETYPE_PNG ) {
			$this->image = imagecreatefrompng($filename);
		}
	}
   
	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image,$filename,$compression);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif($this->image,$filename);
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($this->image,$filename);
		}
		if( $permissions != null) {
			chmod($filename,$permissions);
		}
	}
   
	function output($image_type=IMAGETYPE_JPEG) {
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif($this->image);
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($this->image);
		}
	}
   
	function getWidth() {
		return imagesx($this->image);
	}
   
	function getHeight() {
		return imagesy($this->image);
	}
   
	function resizeToHeight($height) {
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width,$height);
    }
 
	function resizeToWidth($width) {
		$ratio = $width / $this->getWidth();
		$height = $this->getheight() * $ratio;
		$this->resize($width,$height);
	}
 
	function scale($scale) {
		$width = $this->getWidth() * $scale/100;
		$height = $this->getheight() * $scale/100;
		$this->resize($width,$height);
	}
 
	function resize($width,$height) {
		$new_image = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;
	}
}
?>
