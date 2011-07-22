<?php defined('SYSPATH') or die('No direct access allowed.');

class CacheImage {
	
	
	protected $config = NULL;
	
	public $filename = NULL;
	
	public $image_root = NULL;
	
	private static $instance = NULL;
	
	public function __construct(){
		
		$this->config = Kohana::config('cacheimage');
		
		$this->image_root = DOCROOT . $this->config['image_dir'];
		
	}
	
	public static function factory(){
		if(self::$instance !== NULL){
			return $this->object;
		} else {
			return new self();
		}
	}
	
	public function resize($filename, $width = 100 , $height = 100){
		
		if((!$filename) OR (!file_exists($this->image_root . $filename)))
		  $filename = $this->config['default_filename'];
		
        $info = pathinfo($filename);
        $extension = $info['extension'];
		
        $new_image = $this->config['cache_dir'] . '/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		
        if (!file_exists($this->image_root . $new_image) || (filemtime($this->image_root . $filename) > filemtime($this->image_root . $new_image))) {

        	$image = Image::factory($this->image_root . $filename);
            $image->resize($width, $height, Image::AUTO)->save($this->image_root . $new_image);
        }
        
        return URL::base() . $this->config['image_dir'] . $new_image;
        
	}
	
}
    