<?php defined('SYSPATH') or die('No direct script access.');
include(DOCROOT.'vendor/simple_html_dom.php');

class Controller_Profile extends Controller_Base {
    
    public function action_index() {
        
        $html = file_get_html('http://www.kodeplay.com/');

        // Find all images 
        foreach($html->find('img') as $element) 
               echo "<img src='".$element->src ."' style='width: 150px; height: 125px;' />" ;
    }
    
    public function action_view(){
        $user_id = $this->request->param('id');
        
        $user = ORM::factory('user', $user_id);
        
        DynamicMenu::extend(array(
            'profilemenu' => array(
                array('profile/view/id/'.$user_id, 'Info', 1, array()),
                array('profile/view/id/'.$user_id, 'Wall', 2, array()),
            ),
        ));
        $view = View::factory('profile/view')
                ->bind('user', $user);
                    
        Breadcrumbs::add(array(
            'Profile', Url::site('profile/view/id/'.$user_id)
        ));
                    
        $this->content = $view;
        
    }
    
    protected function menu_init() {
        $this->view->bind('topmenu', $topmenu)
            ->bind('myaccount', $myaccount)
            ->bind('sidemenu', $profilemenu)
            ->bind('image', $image)
            ->bind('role', $role)
            ->bind('username', $username)
            ->bind('user', $user);
        $user_id = $this->request->param('id');
        $user = ORM::factory('user', $user_id);

        $role = $user->role()->name;
        $username = $user->firstname;
        $avatar = $user->avatar;
        $avatar = $avatar === null ? '' : $avatar;
        $img_user = CacheImage::instance()->resize($avatar, 100, 100);
        
        
        $view_avatar = View::factory('account/sidemenu/profile')
                ->bind('avatar_user', $img_user)
                ->bind('user', $user)
                ->bind('role', $role)
                ;
        $this->view->set('avatar', $view_avatar);
        
        $menu = Acl_Menu::factory('profile');

        $topmenu = $menu->get('topmenu');
        $profilemenu = $menu->get('profilemenu');
       
        $myaccount = $menu->get('myaccount');
        $institution = ORM::factory('institution', $id=1);
        $image = CacheImage::instance()->resize($institution->logo, 240, 60);
    }
    
}