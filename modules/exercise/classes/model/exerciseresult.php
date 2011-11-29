<?php defined('SYSPATH') or die('No direct script access.');

class Model_Exerciseresult extends ORM {

    protected $_belongs_to = array(
        'exercise' => array(
            'model' => 'exercise', 
        )
    );

    public function to_link() {
        return Html::anchor('exercise/result/id/'.$this->id, $this->score);
    }

    public function date_repr() {
        return date('d M, Y', strtotime($this->attempted_at));
    }
}

