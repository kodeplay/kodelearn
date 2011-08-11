<?php defined('SYSPATH') or die('No direct access allowed.');

class Sort {
	
	private $link = '';
	
	private $heading = array();
	
	private $order = 'ASC';
	
	private $sort = '';
	
	private $check_box_column = TRUE;
	
	private $arrows = array('asc' => '&#x25BC;', 'desc' => '&#9650;');
	
	public function __construct($heading = array()){
		
		if($heading){
			$this->set_heading($heading);
		}
	}
	
	public function set_heading($heading){
		$this->heading = $heading;
	}
	
	public function set_link($link){
		$this->link = $link;
	}
	
	public function set_sort($sort){
		$this->sort = $sort; 
	}
	
	public function set_check_box_column($flag){
		$this->check_box_column = $flag;
	}
	
	public function set_order($order, $switch = TRUE){
		
		if($switch){
			if($order == 'ASC'){
				$order = 'DESC';
			} else {
				$order = 'ASC';
			}
		}
		$this->order = $order;
	}
	
	public function get_order(){
		return $this->order;
	}
	
	public function render(){
		
		$html = '';
		$html .= '<tr>';
		if($this->check_box_column){
			$html .= '<th><input type="checkbox" onclick="$(\'.selected\').attr(\'checked\', this.checked);"/></th>';
		}
		
		foreach($this->heading as $text => $option){
			
			if(is_array($option)){
				$sort = $option['sort'];
				$attributes = ($option['attributes']) ? $option['attributes'] : array(); 
			} else {
				$sort = $option;
				$attributes = array();
			}
			
            $html .= '<th' . HTML::attributes($attributes) . '>';
			if($sort){
				$html .= Html::anchor($this->link . '/sort/' . $sort . '/order/' . $this->order , $text);
				if($this->sort == $sort){
					$html .= '<span class="">' . $this->arrows[strtolower($this->order)] . '</span>';
				}
			} else {
	            $html .= $text;
			}
			$html .= '</th>';
		}
		
        $html .= '</tr>';
		$html .= '';
		
		return $html;
	}
	
}