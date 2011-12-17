<?php defined('SYSPATH') or die('No direct script access.');

class Video_Youtube_Embed {
    
    private $link;
    
    public function __construct($l = null) {
        $this->link = $l;
    }
    
    public function getDataFromLink() {
        $youtube = substr($this->link, 0, 15); // returns "d"
        if($youtube == "http://www.yout" || $youtube == "http://youtu.be") {
            $html = file_get_html($this->link);
            $img_j = $this->parse_youtube_url($this->link,'thumb');
            $code_j = $this->parse_youtube_url($this->link);
            $title_text = array();
            foreach($html->find('title') as $title) { 
                   $title_text[] = $title->plaintext;
            }
            $title_j = "";
            
            if($title_text) {
                $title_j = $title_text[0];
            }
            
            $description = $html->find('p[id=eow-description]', 0)->plaintext;
            $description = substr($description, 0, 255);
            $json = array(
            'img' => $img_j,
            'title' => $title_j,
            'text'=> $description,
            'link' => $this->link,
            'error' => 0,
            'video_share' => 1,
            'code' => $code_j,
            );
        } else {
            $json = array(
            'error' => 1
            );
        }
        
        return $json;
    }
    
    private function parse_youtube_url($url,$return='',$width='',$height='',$rel=0){ 
        $urls = parse_url($url); 
         
        //expect url is http://youtu.be/abcd, where abcd is video iD
        if($urls['host'] == 'youtu.be'){  
            $id = ltrim($urls['path'],'/'); 
        } 
        //expect  url is http://www.youtube.com/embed/abcd 
        else if(strpos($urls['path'],'embed') == 1){  
            $id = end(explode('/',$urls['path'])); 
        } 
         //expect url is abcd only 
        else if(strpos($url,'/')===false){ 
            $id = $url; 
        } 
        //expect url is http://www.youtube.com/watch?v=abcd 
        else{ 
            parse_str($urls['query']); 
            $id = $v; 
        } 
        //return embed iframe 
        if($return == 'embed'){ 
            return '<iframe width="'.($width?$width:560).'" height="'.($height?$height:349).'" src="http://www.youtube.com/embed/'.$id.'?rel='.$rel.'" frameborder="0" allowfullscreen>'; 
        } 
        //return normal thumb 
        else if($return == 'thumb'){ 
            return 'http://i1.ytimg.com/vi/'.$id.'/default.jpg'; 
        } 
        //return hqthumb 
        else if($return == 'hqthumb'){ 
            return 'http://i1.ytimg.com/vi/'.$id.'/hqdefault.jpg'; 
        } 
        // else return id 
        else{ 
            return $id; 
        } 
    } 
    
}