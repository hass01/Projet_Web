
<?php


App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Player extends AppModel {
    //put your code here
    
    
    
    public function createNew($mail,$pass){
        
       if  (($this->find('first', array(
            'conditions' => array('email' => $mail)
        ))== null) && $mail!=null && $pass!=null  ){
           
          
               $passwordHasher = new SimplePasswordHasher();
        $pass=$passwordHasher->hash($pass);
        
        $this->create();
        $this->save(array('Player' => array('email'=>$mail,'password'=>$pass)));
           
        return true;
           }
                  else {return false;}
        
    
}


public function saveMdp($password, $destinataire){
        $fighterid = $this->find('first', array('conditions' => array("email" => $destinataire)));
        pr($fighterid);
        $activePlayerrr = $this->read(null, $fighterid['Player']['id']);
        
        $passwordHasher = new SimplePasswordHasher();
        $passwd=$passwordHasher->hash($password);
        echo "t";
        $this->set('password', $passwd);
        $this->save();        
    }

public function checkLogin($login,$passwd){
    
  
    $datas1=$this->find('first', array(
            'conditions' => array('email' => $login)
        ));
    if ($datas1!=null && $datas1['Player']['password']!=null)
    {
     $passwordHasher = new SimplePasswordHasher();
        $passwd=$passwordHasher->hash($passwd);
        
    if ($datas1['Player']['password']== $passwd){
       
       return $datas1['Player']['id'];
        
    }
    else {
        return false;
        
    }
   
    }
    else {
        false;
        
    }    
}

public function check_login_face($login)
        
{
    
    $datas1=$this->find('first', array(
            'conditions' => array('email' => $login)
        ));
    if ($datas1!=null)
    {
        return $datas1 ['Player']['id'];
    }
    else {
        
     
         $this->create();
        $this->save(array('Player' => array('email'=>$login)));
          
          $email = $this->find('first', array(
            'conditions' => array('email' => $login)
        ));
          return  $email['Player']['id'];
            
        
        
    }
    
}


}
