<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Role extends Controller_Base {

    public function action_index() {
        $view = View::factory('role/list')
            ->bind('roles', $roles);
        $role_model = ORM::factory('role');
        $all_roles = $role_model->find_all();
        $roles = array();
        foreach ($all_roles as $role) {
            $roles[] = array(
                'id' => $role->id,
                'name' => $role->name,
                'num_users' => $role->users->count_all(),
                'action_edit' => Html::anchor('role/edit/id/' . $role->id, 'edit'),
                'action_delete' => Html::anchor('role/delete/id/' . $role->id, 'delete'),
                'action_permissions' => Html::anchor('role/permissions/' . $role->id, 'set permissions'),
            );
        }
        $this->content = $view;
    }

    public function action_add() {

    }

    public function action_edit() {
        
        $submitted = false;
        
        $id = $this->request->param('id');
        if(!$id)
            Request::current()->redirect('role');
            
        $role = ORM::factory('role',$id);
        
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $validator = $role->validator($this->request->post());
                if ($validator->check()) {
                    $role->name = $this->request->post('name');
                    $role->description = $this->request->post('description');
                    $role->save();
                    Request::current()->redirect('role');
                    exit;
                } else {
                    $this->_errors = $validator->errors('role');
                }
            }
         }
        
        $form = $this->form('role/edit/id/'.$id ,$submitted, array('name' => $role->name, 'description' => $role->description));
        
        
        $links = array(
            'cancel' => Html::anchor('/role/', 'or cancel')
        );
        
        $view = View::factory('role/form')
                  ->bind('links', $links)
                  ->bind('form', $form);
        $this->content = $view;
    }

    protected function form($action, $submitted = false, $saved_data = array()) {
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'name' => '',
            'description' => '',            
        );
        
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Name', 'name', 'text');
        $form->append('Description', 'description', 'textarea', array('attributes' => array('cols' => 50, 'rows' => 5)));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
    }
    
    public function action_delete(){
        $id = $this->request->param('id');
        if(!$id){
            Request::current()->redirect('role');
        }    
        $role = ORM::factory('role', $id);
        $count = $role->users->count_all();
        if($count<1){
            $role->delete();
        }
        Request::current()->redirect('role');
    }

    public function action_permissions() {
        $view = View::factory('role/permissions')
            ->bind('acl', $acl)
            ->set('action', URL::site('role/permissions'))
            ->bind('role_id', $role_id)
            ->bind('is_current_role', $is_current_role)
            ->set('cancel', URL::site('role'));
        $post = array();        
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $post = $this->request->post();
            $role_id = $post['role_id'];
            $role = ORM::factory('role', $role_id);
            $role->permissions = serialize($post['acl']);
            $role->save();
            Request::current()->redirect('role/index');
        }
        $role_id = $this->request->param('params');
        $role = ORM::factory('role', $role_id);
        $permissions = $role->permissions && $role->permissions !== NULL ? unserialize($role->permissions) : array();
        $acl_array = Acl::acl_array($permissions);
        $$acl = array();
        foreach ($acl_array as $resource=>$levels) {
            $acl[$resource] = array();
            $text_resource = Kohana::message('acl', $resource);
            foreach ($levels as $level=>$permission) {
                $acl[$resource][$level] = array(
                    'resource' => $text_resource,
                    'level' => Inflector::humanize($level),
                    'permission' => $permission,
                    'repr_key' => Acl::repr_key($resource, $level),
                );
            }
        }
        // check whether the role being edited is the role of the current user
        // if yes, show a warning before user tries to deny all permissions
        $user_role_id = Auth::instance()->get_user()->roles->find()->id;
        $is_current_role = ($role_id == $user_role_id);
        $this->content = $view; 
    }
}