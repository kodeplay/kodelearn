<?php defined('SYSPATH') or die('No direct script access.');

class Video_Youtube_Search {
    
    private $string;
    
    public function __construct($s = null) {
        $this->string = $s;
    }
    
    public function getSearchResults() {
        $search = str_replace(" ", "+", $this->string);
        $content = array();    
        $url = 'https://gdata.youtube.com/feeds/api/videos?q='.$search.'+khanacademy&orderby=relevance&start-index=1&max-results=10&v=2&format=5&safeSearch=strict&alt=json';
        $result = $this->curl_request_youtube($url);
        if(isset($result->feed->entry)) {
            foreach($result->feed->entry as $data) {
                $title = (array)$data->title;
                $common = (array)$data;
                $common = (array)$common['media$group'];
                $description = (array)$common['media$description'];
                $code = (array)$common['yt$videoid'];
                $content[] = array(
                    'title'         => $title['$t'],
                    'description'   => $description['$t'],
                    'code'          => $code['$t']
                );
            }
        } 
        return $content;   
    }
    
    private function curl_request_youtube($url){

       if (!function_exists('curl_init')) {
               return "";
       }

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

       $result = curl_exec($ch);
       curl_close ($ch);
       return json_decode($result);
    }
}