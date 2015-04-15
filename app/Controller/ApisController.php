<?php 

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ApisController extends AppController {
    
    public $uses = array('Player', 'Fighter', 'Event');
    
    public function fighterview($id)
    {
        $id=1;
        
       $this->layout = 'ajax'; 
       $this->set('datas', $this->Fighter->find('all',array('conditions' => array('Fighter.id' => $id))));
    }
    
    public function fighterdomove($id, $direction)
    {
       $this->layout = 'ajax'; 
       $this->Fighter->doMove($id, $direction);
       $this->set('datas', $this->Fighter->find('all',array('conditions' => array('Fighter.id' => $id))));
    }
    
    public function fighterdoattack($id, $direction)
    {
       $this->layout = 'ajax'; 
       $this->Fighter->doAttack($id, $direction);
       $this->set('datas', $this->Fighter->find('all',array('conditions' => array('Fighter.id' => $id))));
    }
}
?>

