<?php

App::uses('AppModel', 'Model');
class Events  extends AppModel {
    //put your code here
    public function addevent($message,$coord_x =0, $coord_y =0){
        if($message){
            $this->create();
            $this->set('name', $message);
            $this->set('date', date("Y-m-d H-i-s"));
            $this->set('coordinate_x', $coord_x);
            $this->set('coordinate_y', $coord_y);
            $this->save();
            return true;
        }
        return false;        
    }
}
