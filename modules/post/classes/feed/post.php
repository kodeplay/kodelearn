<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Post extends Feed {
    
    public function render(){
    	
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
            ->bind('post', $post)
            ->bind('user', $user)
            ->bind('span', $span)
            ->bind('role', $role)
            ->bind('feed_id', $feed_id)
            ->bind('comments', $comments)
            ->bind('url', $url)
            ->bind('link', $query)
            ->bind('video', $query_video)
            ;    
                
        $feed_id = $this->id;
        $post = ORM::factory('post', $this->respective_id);
        $user = ORM::factory('user', $this->actor_id);
        $curr_user = Auth::instance()->get_user();
        $role = $curr_user->role()->name;
        
        $span = Date::fuzzy_span($this->time);
        
        $comment = ORM::factory('feedcomment');
        $comment->where('feed_id', '=', $feed_id)
                ->order_by('date', 'DESC');
        $comments = $comment->find_all();
        
        $url = Url::site('profile/view/id/');
        $query = "";
        if($post->link == 'link') {
            $query = DB::select('key', 'value')
                    ->from('post_meta')
                    ->where('post_id', '=', $post->id)
                    ->execute()->as_array('key','value');
        }
        $query_video = "";
        if($post->link == 'video') {
            $query_video = DB::select('key', 'value')
                    ->from('post_meta')
                    ->where('post_id', '=', $post->id)
                    ->execute()->as_array('key','value');
        }
        
        return $view->render();        
    }
    
    public function save(){
    	$this->type = 'post';
    	parent::save();
    }    
}