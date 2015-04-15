<?php

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';
    public $belongsTo = array(
        'Player' => array(
            'className' => 'Player',
            'foreignKey' => 'player_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Guild' => array(
            'className' => 'Guild',
            'foreignKey' => 'guild_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    
    public function nbFighters($player_id) {
        $fighterid = $this->find('all', array('conditions' => array("player_id" => $player_id)));
        $nb = 0;
        foreach ($fighterid as $fighter) {
            if ($fighter['Fighter']['current_health'] > 0) {
                $nb++;
            }
        }
        return $nb;
    }
    
    public function getFighters($player_id) {
        $fighterid = $this->find('all', array('conditions' => array("player_id" => $player_id)));
        $nb = array();
        $i = 0;
        foreach ($fighterid as $fighter) {
            if ($fighter['Fighter']['current_health'] > 0) {
                $nb[$i] = array($fighter['Fighter']['id'], 
                    $fighter['Fighter']['name'], 
                    $fighter['Fighter']['level'],
                    $fighter['Fighter']['current_health'],
                    $fighter['Fighter']['skill_strength'],
                    $fighter['Fighter']['skill_sight'],
                    $fighter['Fighter']['skill_health'],
                    $fighter['Fighter']['xp']);
                $i++;
            }
        }
        return $nb;
    }
    
    public function getFId($player_id, $name) {
        $fighterid = $this->find('all', array('conditions' => array("player_id" => $player_id)));
        foreach ($fighterid as $fighter) {
            if ($fighter['Fighter']['current_health'] > 0 && $fighter['Fighter']['name'] == $name) {
                return $fighter['Fighter']['id'];
            }
        }
    }

    public function get_fighter_name($player_id) {
        // function pour trouver le fighter vivant du player
        $fighterid = $this->find('all', array('conditions' => array("player_id" => $player_id)));
        foreach ($fighterid as $fighter) {
            if ($fighter['Fighter']['current_health'] > 0) {
                return $fighter['Fighter']['name'];
            }
        }
        //Il n'a pas de combattant vivant
        return "Nouvel Inscrit";
    }

    public function doMove($fighterId, $coordx, $coordy) {
        //recuperer la position et fixer l'id de travail
        $datas = $this->read(null, $fighterId);

        $this->set('coordinate_x', $coordx);
        $this->set('coordinate_y', $coordy);

        //sauver la modif
        $this->save();
        return 1;
    }

    public function doAttack($fighterId, $fighterSubiId) {
        $datas1 = $this->read(null, $fighterId);
        $datas2 = $this->read(null, $fighterSubiId);
        $mess = "";
        $chance_reussit = 10 + $datas2['Fighter']['level'] - $datas1['Fighter']['level'];
        if ($chance_reussit > mt_rand(1, 20)) {

            $damages = $datas1['Fighter']['skill_strength'];
            $this->set('current_health', $datas2['Fighter']['current_health'] - $damages);
            $this->save();
            if ($this->xpUp($datas1['Fighter']['id'])) {
                $mess = "Gagne de l'xp et peut level up. <br/>";
            } else {
                $mess = "Gagne un point d'xp. <br/>";
            }

            if ($datas2['Fighter']['current_health'] <= $damages) {
                $lvlup = $this->xpKill($datas1['Fighter']['id'], $datas2['Fighter']['id']);
                if ($lvlup)
                    return $mess . $datas1['Fighter']['name'] . " a tué " . $datas2['Fighter']['name'] . " et gagne assez d'xp pour monter de niveau";
                else
                    return $mess . $datas1['Fighter']['name'] . " a tué " . $datas2['Fighter']['name'];
            }
            // return true si cible touchée
            return $mess . $datas1['Fighter']['name'] . " a touché " . $datas2['Fighter']['name'] . " en lui infligeant " . $damages . " dommages. ";
        } else {
            return $mess . "L'attaque de " . $datas1['Fighter']['name'] . " sur " . $datas2['Fighter']['name'] . " a echouée. ";
        }
    }

    public function createFighter($fighter, $player, $x, $y) {

        $this->create();
        $this->set('player_id', $player);
        $this->set('skill_sight', 0);
        $this->set('skill_strength', 1);
        $this->set('skill_health', 3);
        $this->set('level', 1);
        $this->set('current_health', 3);
        $this->set('coordinate_x', $x);
        $this->set('coordinate_y', $y);
        $this->set('name', h($fighter['name']));
        $this->save();

        $datas = $this->getFId($player, h($fighter['name']));
        if ($datas)
            return $datas;
        else
            return false;
    }

    public function LvlUp($fighterId, $force, $hp, $vue) {

        // recup le perso
        $datas = $this->read(null, $fighterId);
        // fait son choix
        $this->set('skill_health', $datas['Fighter']['skill_health'] + 3 * $hp);
        $this->set('skill_strength', $datas['Fighter']['skill_strength'] + $force);
        $this->set('skill_sight', $datas['Fighter']['skill_sight'] + $vue);

        $this->set('current_health', $datas['Fighter']['skill_health'] + 3 * $hp);

        $this->set('level', $datas['Fighter']['level'] + ($force + $hp + $vue));
        $this->save();
        return true;
    }

    public function xpUp($fighterId) {
        // recup le perso
        $datas = $this->read(null, $fighterId);
        $this->set('xp', $datas['Fighter']['xp'] + 1);
        $this->save();

        //return "xppppppppppppppppp:";
        //retourne si need lvlup pas
        return (($datas['Fighter']['xp']) % 4 == 0);
    }

    public function xpKill($figtherIdWin, $figtherIdLost) {
        $datasLost = $this->read(null, $figtherIdLost);
        $this->set('coordinate_y', -1);
        $this->set('coordinate_x', -1);
        $this->save();
        $datasWin = $this->read(null, $figtherIdWin);
        $this->set('xp', $datasWin['Fighter']['xp'] + $datasLost['Fighter']['xp']);


        $this->save();
        //retourne si lvl up pas
        return $datasLost['Fighter']['xp'] >= 4;
    }

    public function savePicture($fighterId, $nb) {
        $charaPath = IMAGES . "Fighter" . DS . "chara" . $nb . ".png";

        $charsetPath = IMAGES . "Fighter" . DS . "charset" . $nb . ".jpg";

        // Recuperation de l'extension de l'image
        //$extension1 = strtolower(pathinfo($picture['name'], PATHINFO_EXTENSION));
        // Lien ou enregistrer l'avatar, nomme avatar_fighterId
        $filePath = IMAGES . "Fighter" . DS . "avatar" . $fighterId . ".png"; // . $extension;
        $setPath = IMAGES . "Carte" . DS . "Fighter" . $fighterId . ".jpg";
        // Si l'image existe déjà, on la supprime
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        if (file_exists($setPath)) {
            unlink($setPath);
        }
        // On deplace alors l'image au bon endroit, ici webroot/img
        if (copy($charaPath, $filePath) && copy($charsetPath, $setPath)) {
            return true;
        } else {
            return false;
        }
    }

    public function AddInventory($fighterId, $bonus) {
        $datas = $this->read(null, $fighterId);
        $this->set('skill_strength', $datas['Fighter']["skill_strength"] + $bonus[0]);
        $this->set('skill_sight', $datas['Fighter']["skill_sight"] + $bonus[1]);
        $this->set('skill_health', $datas['Fighter']["skill_health"] + $bonus[2]);
        $this->save();
    }

}
