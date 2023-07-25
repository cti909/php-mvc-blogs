<?php
class html_helpers{
	public static function url($options=null) {
		if($options=='/')
			return 'index.php';
			
		global $cn, $app;
		if(!isset($options['ctl'])) {
			$options['ctl'] = $cn;
			//$options['ctl'] = $app['ctl'];
		}
		$act = '';
		if(isset($options['act'])) {
			$act = '&act='.$options['act'];
			//$options['act'] = $app['act'];
		}
		$params = '';
		if(isset($options['params']) and $options['params']) {
			foreach($options['params'] as $k=>$v) {
				$params .= '&'.$k.'='.$v;
			}
		}
		return 'index.php?ctl='.$options['ctl'].$act.$params;
	}

	public static function _media($buffer) {
		global $obMediaFiles;

		$content = $buffer;

		$cssFiles = "";
		if(isset($obMediaFiles['css']) && count($obMediaFiles['css'])) {
			foreach( $obMediaFiles['css'] as $css) {
				$cssFiles .= '<link href="'.$css.'" rel="stylesheet">';
			}
		}
		$content = str_replace("CSSABOVE", $cssFiles, $content);

		$jsFiles = "";
		if(isset($obMediaFiles['js']) && count($obMediaFiles['js'])) {
			foreach( $obMediaFiles['js'] as $js) {
				$jsFiles .= '<script src="'.$js.'"></script>';
			}
		}
		$content = str_replace("JSBOTTOM", $jsFiles, $content);

		return $content;
	}

	public static function cssHeader() {
		global $mediaFiles;
		$cssFiles = "";
		if(isset($mediaFiles['css']) && count($mediaFiles['css'])) {
			foreach( $mediaFiles['css'] as $css) {
				$cssFiles .= '<link href="'.$css.'" rel="stylesheet">';
			}
		}
		return $cssFiles;
	}

	public static function jsFooter() {
		global $mediaFiles;

		$jsFiles = "";
		if(isset($mediaFiles['js']) && count($mediaFiles['js'])) {
			foreach( $mediaFiles['js'] as $js) {
				$jsFiles .= '<script src="'.$js.'"></script>';
			}
		}
		return $jsFiles;
	}

	public static function header($layout, $options=null) {
		include_once 'views/layout/'.$layout.'header.php';
	}

	public static function footer($layout, $options=null) {
		include_once 'views/layout/'.$layout.'footer.php';
	}
}
?>
