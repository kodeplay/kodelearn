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
            ->bind('acl', $acl);
        $acl = Acl::instance()->user_permissions_ui();
        $this->content = $view;
    }
}