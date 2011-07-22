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
                'action_edit' => Html::anchor('role/edit/' . $role->id, 'edit'),
                'action_delete' => Html::anchor('role/delete/' . $role->id, 'delete'),
                'action_permissions' => Html::anchor('role/permissions/' . $role->id, 'set permissions'),
            );
        }
        $this->content = $view;
    }

    public function action_add() {

    }

    public function action_edit() {

    }

    protected function form($data) {
        
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