<?php
class ImageRand {
	
	private static $used = array();
	
	private static $img_url = 'http://www.vivinice.com/static/upload/images/';
	
	public static function getImgUrl($repeat=false)
	{
		$images = $repeat === false ? array_diff(self::images(), self::usedImages()) : self::images();
		if (count($images)<=0)
		{
			$images = self::images();
			self::resetUsedImages();
		}
		$key = array_rand($images);
		self::usedImages($images[$key]);
		return self::$img_url . $images[$key];
	}
	
	private static function images()
	{
		static $images;
		if (isset($images))
		{
			return $images;
		}
		$img_path = BASE_PATH . DS . 'static' . DS . 'upload' . DS . 'images';
		foreach (glob($img_path . DS .'*.*') as $image)
		{
			$images[] = substr($image, strlen($img_path . DS));
		}
		return $images;
	}
	
	private static function resetUsedImages()
	{
		self::$used = array();
	}
	
	private static function usedImages($img=null)
	{
		if ( strlen($img) && !in_array($img, self::$used))
		{
			self::$used[] = $img;
		}
		else
		{
			return self::$used;
		}
	}
	
}

?>