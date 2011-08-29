<?php defined('SYSPATH') or die('No direct script access.');

class Model_Room extends ORM {


    protected $_has_many = array(
        'events' => array(
            'model' => 'event', 
            'foreign_key' => 'room_id'
        )
    );

    public function validator($data) {
        return Validation::factory($data)
            ->rule('room_name', 'not_empty')
            ->rule('room_name', 'min_length', array(':value', 3))
            ->rule('room_number', 'not_empty')
            ->rule('location_id', 'not_empty');
    }

    public function __toString() {
        return ucfirst($this->room_name);
    }

    /**
     * Method to return an anchor tag with room_name as the text and 
     * link to the room as href
     */
    public function toLink() {
        if (Acl::instance()->is_allowed('exam_edit')) {
            $url = Url::site('room/edit/id/'.$this->id);
        } else {
            $url = Url::site('room');
        }
        return Html::anchor($url, (string) $this);
    }
}