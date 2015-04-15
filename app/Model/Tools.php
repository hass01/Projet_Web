<?php

App::uses('AppModel', 'Model');

class Tools extends AppModel {
    public $type_emplacement = array("Arme", "Casque", "Botte", "Plastron", "Gant");
    public $type_amelioration = array(" de Force", " de Vision", " de Vie");
    public $correspondance = array("skill_strength","skill_sight","skill_health");
    public $type_point = array(" Mineur", " Majeur", " Supérieur");
    
    //put your code here
    public $belongsTo = array(
        'Fighter' => array(
            'className' => 'Fighter',
            'foreignKey' => 'fighter_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $position = array('tete'=> 'haut','arme'=>'gauche','bottes'=>'bas','plastron'=>'millieu','gant'=>'droite');
 
    //retourne l'equipement du joueur dans un ordre précis pour laficher
    public function get_pos($equipement){
        $array = array();
        $this->type_emplacement;
        foreach($equipement as $tools){
            for($i=0;$i<count($this->type_emplacement);$i++){
                if(strpos($tools['Tools']['type'],$this->type_emplacement[$i])!== false){
                    $array[$i] = $tools;
                }
            }
        }
        return $array;
    }

    //fonction de génération aléatoire d'item.
    public function generation_item() {        
        $nb_emplacement = mt_rand(0, count($this->type_emplacement) - 1);
        $emplacement = $this->type_emplacement[$nb_emplacement];

        
        $nb_amelioration = mt_rand(0, count($this->type_amelioration) - 1);
        $amelioration = $this->type_amelioration[$nb_amelioration];

        
        $nb_point = mt_rand(1, count($this->type_point));
        $point = $this->type_point[$nb_point -1];
        
        // mettre une variable bd pour le nb de place dans la laby ?
        do {
            $coordonne_x = mt_rand(0, LABYX-1);
            $coordonne_y = mt_rand(0, LABYY-1);
            $FighterPosXY = $this->find('first', array('conditions' => array('Fighter.coordinate_y' => $coordonne_y, 'Fighter.coordinate_x' => $coordonne_x)));
            $Item = $this->find('first', array('conditions' => array('Tools.coordinate_y' => $coordonne_y, 'Tools.coordinate_x' => $coordonne_x)));           
        } while ($FighterPosXY != null and $Item != Null);
        

        // verif que ya bien la place de mettre l'objet
        if ($FighterPosXY == null and $Item == Null) {
            $this->create();
            $nom = $emplacement . $amelioration . $point;
            
            $this->set('type', $nom);
            $this->set('bonus', $nb_point);
            $this->set('coordinate_x', $coordonne_x);
            $this->set('coordinate_y', $coordonne_y);
            $this->save();
            return array("Nouvel objet ajouté sur la carte en x:".$coordonne_x .", y :".$coordonne_y, $coordonne_x,$coordonne_y);          
        }
        
            return false;            
    }
    
    //permet de rajouter un equipemetn dans un inventaire.
    public function AddInventory($fighterId, $itemId){
        // on read pour retirer 
        $datas = $this->read(null, $itemId);        
        $retour = $this->retirer($fighterId,$datas);
        $concordance = $this->getconcordance($datas['Tools']['type']);
        $retour[1][$concordance]= $retour[1][$concordance] +$datas['Tools']['bonus'];
        
        // on ajout au fighter
        $datas = $this->read(null, $itemId);
        $this->set('fighter_id',$fighterId);
        $this->set('coordinate_x',-1);
        $this->set('coordinate_y',-1);
        $this->save(); 
          
        return array($retour[0]."L'item ". $datas['Tools']['type'] . " a été équipé. ",$retour[1]);
    }
    
    // fonction qui permet de retirer un equipement si on veut en equiper un autre
    public function retirer($fighterId, $itemadd) {
        //on regarde si il a aps déja un equipement a cette pos:
        $ItemFighter = $this->find('all', array('conditions' => array('Tools.fighter_id' => $fighterId)));
        $message = "";
        $skill = array(0,0,0);
        
        foreach($ItemFighter as $item){    
            $num = $this->getemplacement($item);
            if($num == $this->getemplacement($itemadd)){
                $value = $this->getconcordance($item['Tools']['type']);
                $skill[$value]= $skill[$value] - $item['Tools']['bonus'];
                $message = $message. $this->deletItem($item);                
            }
        }
        return array($message,$skill);             
    }
    
    //retourne  le numero de l'emplacement (casque,gant ...) d'un equipement
    public function getemplacement($tool) {
        for ($i = 0; $i < count($this->type_emplacement); $i++) {
            if (strpos($tool['Tools']['type'], $this->type_emplacement[$i]) !== false) {
                return $i;
            }
        }
        return -1;
    }

    //retourne le type d'amélioration de l'equipement
    public function getconcordance($type){
        for($i=0;$i<count($this->type_amelioration);$i++){
            if(strpos($type,$this->type_amelioration[$i]) !==false){
                return $i;
            }
        }
    }
    
    public function deletItem($ItemFighter){
        $datas = $this->read(null, $ItemFighter['Tools']['id']);
        $this->delete($datas['Tools']['id']);
        return "L'item ". $datas['Tools']['type'] . " a été détruit. ";
    }
}
