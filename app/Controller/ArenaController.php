<?php

App::uses('CakeEmail', 'Network/Email');

/*use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookJavaScriptLoginHelper;

App::uses('CakeEmail', 'Network/Email');

App::uses('AppController', 'Controller');
App::import('Vendor', 'FacebookSession', array('file' => 'Facebook' . DS . 'FacebookSession.php'));
App::import('Vendor', 'FacebookRedirectLoginHelper', array('file' => 'Facebook' . DS . 'FacebookRedirectLoginHelper.php'));
App::import('Vendor', 'FacebookRequest', array('file' => 'Facebook' . DS . 'FacebookRequest.php'));
App::import('Vendor', 'FacebookResponse', array('file' => 'Facebook' . DS . 'FacebookResponse.php'));
App::import('Vendor', 'FacebookSDKException', array('file' => 'Facebook' . DS . 'FacebookSDKException.php'));
App::import('Vendor', 'FacebookRequestException', array('file' => 'Facebook' . DS . 'FacebookRequestException.php'));
App::import('Vendor', 'FacebookJavaScriptLoginHelper', array('file' => 'Facebook' . DS . 'FacebookJavaScriptLoginHelper.php'));
App::import('Vendor', 'FacebookAuthorizationException', array('file' => 'Facebook' . DS . 'FacebookAuthorizationException.php'));
App::import('Vendor', 'GraphObject', array('file' => 'Facebook' . DS . 'GraphObject.php'));
App::import('Vendor', 'GraphUser', array('file' => 'Facebook' . DS . 'GraphUser.php'));
App::import('Vendor', 'GraphSessionInfo', array('file' => 'Facebook' . DS . 'GraphSessionInfo.php'));



FacebookSession::setDefaultApplication('726387000774029', '672acf05f541d71e546a9949e78f1d9c');

*/
/**
 * Main controller of our small application
 *
 * @author Germanicus, Guitton, Hassani & Nomede-Martyr
 */
class ArenaController extends AppController {

    public $uses = array('Player', 'Fighter', 'Events', 'Tools');
    public $helpers = array('Js' => array('Jquery'), 'Html');
    public $components = array('RequestHandler', 'Session', 'Cookie');

    /**
     * index method : first page
     *
     * @return void
     */
    public function index() {
        if ($this->Session->check('Connected') == true) {
            $string = "" . $this->Session->read('Connected');
            $fighterName = $this->Fighter->get_fighter_name($string);
            if ($this->Session->read('Connected'))
                $this->set('myname', $fighterName);
        }
        else if ($this->Session->check('Connected_Face') == true) {
            $string = "" . $this->Session->read('Connected_Face');
            $fighterName = $this->Fighter->get_fighter_name($string);
            if ($this->Session->read('Connected_Face'))
                $this->set('myname', $fighterName);
        }
        else
            $this->set('myname', "Invite");
    }

   /* public function facebook() {

        $helper = new FacebookJavaScriptLoginHelper();
        $session = $helper->getSession();

        try {
            if ($session) {
                $user_profile = (new FacebookRequest(
                        $session, 'GET', '/me'
                        ))->execute()->getGraphObject(GraphUser::className());

                $return = $this->Player->check_login_face($user_profile->getProperty('email'));

                $this->Session->write('Connected_Face', $return);
                $this->redirect(array('action' => 'character'));
            }
        } catch (FacebookRequestException $ex) {
            
        } catch (\Exception $ex) {
            
        }
        
    }*/

    public function login() {

        // Affichage selon les cas
        if ($this->Session->check('Connected') == null && $this->Session->check('Connected_Face') == null) {
            $this->set('check', 1);
        } else if ($this->Session->check('Connected_Face') == true && $this->Session->check('Connected') == null) {
            $this->set('check', 2);
        } else if ($this->Session->check('Connected_Face') == null && $this->Session->check('Connected') == true) {


            $this->set('check', 3);
        }


        if ($this->request->is('post')) {
            if (isset($this->request->data['Subscribe'])) {


                $return = $this->Player->createNew($this->request->data['Subscribe']['email'], $this->request->data['Subscribe']['password']);


                if ($return == false) {

                    $this->Session->setFlash("Email dejà utilisé ou Champs mal rempli !");
                } else {
                    
                    $destinataire = $this->request->data['Subscribe']['email'];                    
                    $this->Events->addevent($destinataire . " s'est inscrit.");
                    $this->Session->setFlash("Inscription réussie ! Un email vous a été envoyé ! ");
                    $email = new CakeEmail('default');                    
                    $email->from(array('me@example.com' => 'L équipe webarena SI2-01-AE'));
                    $email->to($destinataire);
                    $email->subject('Inscription réussit');
                    $email->send('Merci pour votre inscription !!! ');
                }
                    
                unset($this->request->data['Subscribe']);
            } else if (isset($this->request->data['Login'])) {


                $return = $this->Player->checkLogin($this->request->data['Login']['email'], $this->request->data['Login']['password']);


                unset($this->request->data['Login']);

                if ($return == false) {
                    $this->Session->setFlash("Erreur email/password !");
                } else {
                    $this->Session->write('Connected', $return);
                    $this->Events->addevent($this->request->data['Login']['email'] . " s'est connecté");
                    $this->Session->setFlash("Authentification réussie !");

                    $fighters = $this->Fighter->getFighters($return);
                    if ($fighters) {
                        $this->redirect(array('action' => 'sight'));
                        $this->Session->write('activeFighter', $fighters[0][0]);
                    } else {
                        $this->redirect(array('action' => 'createfighter'));
                    }
                }
            } else if (isset($this->request->data['Delog']) && $this->Session->check('Connected') == true) {


                $this->Session->delete('Connected');

                $this->Events->addevent($this->request->data['Login']['email'] . " s'est deconnecté");
                $this->Session->setFlash("Deconnexion réussie !");
                $this->redirect(array('action' => 'login'));
            } else if (isset($this->request->data['logout_face']) && $this->Session->check('Connected_Face') == true) {


                $this->Session->delete('Connected_Face');
                $this->Session->setFlash("Deconnexion réussie !");
                $this->redirect(array('action' => 'login'));
            }
        }
    }

    public function recover() {
        if ($this->request->data['Recover'] ['email'] != null) {
            $destinataire= $this->request->data['Recover']['email'];
            
            $email = new CakeEmail('default');                    
            $email->from(array('me@example.com' => 'L équipe webarena SI2-01-AE'));
            $email->to($destinataire);
            $email->subject('Réinitialisation du mot de passe');
            $nouveaumotdepasse = mt_rand(0, 565756);
            $email->send('Nouveau mot de passe  : '.$nouveaumotdepasse);
            
            $this->Player->saveMdp($nouveaumotdepasse, $destinataire);
            $this->Session->setFlash("Un mail vous a été envoyé !");
                
            
            $this->redirect(array('action' => 'login'));
            
        } else {
            $this->redirect(array('action' => 'login'));
        }
    }

    public function character() {
        $playerId = $this->Session->read('Connected');
        $fighters = $this->Fighter->getFighters($playerId);
        if ($fighters) {
            $this->set("fighters", $fighters);
            $this->set("nb", count($fighters));
            if ($this->request->is('post')) {
                if (isset($this->request->data['Fighter'])) {
                    $this->Session->write('activeFighter', $fighters[$this->request->data['Fighter']['avatar'] - 1][0]);
                }
            }
        } else {
            $this->redirect("createfighter");
        }
    }

    public function doaction() {

        if ($this->request->is('GET')) {
            $data_form = $this->request->query;
            if ($this->request->query['Action'] == "Attaque") {
                $action = 0;
            } elseif ($this->request->query['Action'] == "Move") {
                $action = 1;
            } elseif ($this->request->query['Action'] == "GetItem") {
                $action = 2;
            }

            if (isset($data_form)) {
                $fightertt = $this->Fighter->findById($this->Session->read('activeFighter'));
                $fighter = $fightertt['Fighter'];
                $coord = $this->change_coord($data_form['Direction'], $fighter['coordinate_x'], $fighter['coordinate_y']);
                if ($coord != "Erreur") {
                    $position = $this->quiestla($coord[0], $coord[1]);
                    //attaque//move//item ?                    
                    if ($action == 0) {
                        //attaque
                        $this->attaque($position, $fighter);
                    } elseif ($action == 1) {
                        // move
                        $this->move($position, $fighter, $coord);
                    } else {
                        $this->getitem($fighter, $position);
                    }
                } else {
                    $this->Events->addevent($fighter['name'] . " tente de rentrer dans un mur", $fighter['coordinate_x'], $fighter['coordinate_y']);
                    $this->Session->setFlash("Erreur dans la direction, c'est certainement un mur...");
                }
            }
        }
    }

    public function attaque($position, $fighter) {
        if ($position > 0) {
            $result = $this->Fighter->doAttack($fighter['id'], $position);

            if ($result) {
                $this->Events->addevent($result, $fighter['coordinate_x'], $fighter['coordinate_y']);
                $this->Session->setFlash($result);
            }
        } elseif ($position < 0) {

            $this->Events->addevent($fighter['name'] . "... Pourquoi tant de haine envers " . $this->messagePosition($position), $fighter['coordinate_x'], $fighter['coordinate_y']) . " ?";
            $this->Session->setFlash("Pourquoi tant de haine envers " . $this->messagePosition($position)) . " ?";
        } else {
            $this->Events->addevent($fighter['name'] . " tente de taper dans le vide...", $fighter['coordinate_x'], $fighter['coordinate_y']);
            $this->Session->setFlash("Il est inutile de taper dans le vide...");
        }
    }

    public function move($position, $fighter, $coord) {
        $fighposx = $fighter['coordinate_x'];
        $fighposy = $fighter['coordinate_y'];
        if ($position == 0) {
            $processingResult = $this->Fighter->doMove($fighter['id'], $coord[0], $coord[1]);
            if ($processingResult) {
                $this->Events->addevent("Déplacement de " . $fighter['name'] . " de [" . $fighposx . "," . $fighposy . "] vers [" . $coord[0] . "," . $coord[1] . "]", $coord[0], $coord[1]);
                $this->Session->setFlash("Déplacement de " . $fighter['name'] . " de [" . $fighposx . "," . $fighposy . "] vers [" . $coord[0] . "," . $coord[1] . "]");
            }
        } else {
            $this->Events->addevent("Deplacement impossible : vous ne pouvez marcher sur " . $this->messagePosition($position), $fighposx, $fighposy);
            $this->Session->setFlash("Deplacement impossible : vous ne pouvez marcher sur " . $this->messagePosition($position));
        }
    }

    //fonction de recuperation d'item
    public function getitem($fighter, $position) {
        //on verifie que l'on recupere bien un item ou autre chose ...
        if ($position < 0) {
            //rajoute dans l'inventaire du fighter et affiche l'event/message
            $retour = $this->Tools->AddInventory($fighter['id'], (- $position));
            $this->Fighter->AddInventory($fighter['id'], $retour[1]);
            $this->Events->addevent($fighter['name'] . " : " . $retour[0], $fighter['coordinate_x'], $fighter['coordinate_y']);

            $this->Session->setFlash($retour[0]);
        } elseif ($position > 0) {
            $this->Events->addevent($fighter['name'] . " tente de ramasser un joueur...", $fighter['coordinate_x'], $fighter['coordinate_y']);
            $this->Session->setFlash("Heu tu peux pas ramasser un joueur...");
        } elseif ($position == 0) {
            $this->Events->addevent($fighter['name'] . " joue avec de la terre...", $fighter['coordinate_x'], $fighter['coordinate_y']);
            $this->Session->setFlash("Il y a rien à rammasser !");
        }
    }

    public function createfighter() {
        $this->set('guilds', $this->Fighter->Guild->find('list', array(
                    'recursive' => -1,
                    'fields' => array('id', 'name')
        )));

        do {
            $x = mt_rand(0, LABYX - 1);
            $y = mt_rand(0, LABYY - 1);
        } while ($this->quiestla($x, $y) !== 0);

        if ($this->request->is('post')) {
            if (isset($this->request->data['Fighter'])) {
                $this->request->data['Fighter'][] = $processingResult = $this->Fighter->createFighter($this->request->data['Fighter'], $this->Session->read('Connected'), $x, $y);

                $this->Session->write('activeFighter', $processingResult);
                $this->Fighter->savePicture($this->Session->read('activeFighter'), $this->request->data['Fighter']['avatar']);
                if ($processingResult) {
                    $this->Events->addevent("Création de : " . h($this->request->data['Fighter']['name']));
                    $this->Session->setFlash("Personnage créé !");
                    $this->redirect(array('action' => 'sight'));
                }
            }
        }
    }

    public function lvlup() {

       $fighter = $this->Fighter->findById($this->Session->read('activeFighter'));
       if ($fighter) {
            if ($this->request->is('post') && isset($this->request->data['FighterLvlup'])) {
                $ptSight = $this->request->data['FighterLvlup']['Sight'];
                $ptStrength = $this->request->data['FighterLvlup']['Strength'];
                $ptHp = $this->request->data['FighterLvlup']['Health'];
                
                $fighter2 = $fighter['Fighter'];
                // verif que le nb de point soit inférieur ou = au point de level disponnible 
                if (($ptHp + $ptSight + $ptStrength) - (floor($fighter2['xp'] / 4) - $fighter2['level'] + 1) <= 0) {
                    $processingResult = $this->Fighter->LvlUp($this->Session->read('activeFighter'), $ptStrength, $ptHp, $ptSight);
                    if ($processingResult) {
                        $this->Events->addevent($fighter2['name'] . " a sauvegardé un lvl-up.");
                        $this->Session->setFlash("Lvl up sauvegardé !");
                    } else {
                        $this->Events->addevent($fighter2['name'] . " a généré une erreur sur le lvl-up");
                        $this->Session->setFlash("Erreur De lvl Up");
                    }
                } else {
                    $this->Events->addevent($fighter2['name'] . " a tenté de tricher");
                    $this->Session->setFlash("La triche c'est pas bien!!!");
                }
            }

            $this->set('raw', $fighter);
        } else {
            $this->redirect("createfighter");
        }
    }

    public function diary() {
        //recupere les evenement des derniere 24h
        $eventDate = $this->Events->find('all', array('conditions' => array(
                "Events.date >" => date('Y-m-d H-i-s', strtotime("-24 hours"))
        )));
        $this->set('event', $eventDate);
    }

    public function change_coord($direction, $coor_x, $coor_y) {
        // On trouve les coordonnees d'attaque
        if ($direction == 'Nord' && ($coor_y - 1) >= 0) {
            $coor_y = $coor_y - 1;
        } elseif ($direction == 'Sud' && ($coor_y + 1) < 10) {
            $coor_y = $coor_y + 1;
        } elseif ($direction == 'Est' && ($coor_x + 1) < 15) {
            $coor_x = $coor_x + 1;
        } elseif ($direction == 'Ouest' && ($coor_x - 1) >= 0) {
            $coor_x = $coor_x - 1;
        } else {
            $this->Session->setFlash("Il y a une erreur dans la direction.");
            return "Erreur";
        }
        return array($coor_x, $coor_y);
    }

    public function quiestla($coor_x, $coor_y) {
        $FighterPosXY = $this->Fighter->find('first', array('conditions' => array('Fighter.coordinate_y' => $coor_y, 'Fighter.coordinate_x' => $coor_x)));
        $Item = $this->Tools->find('first', array('conditions' => array('Tools.coordinate_y' => $coor_y, 'Tools.coordinate_x' => $coor_x)));
        // On recherche si il y un fighter au niveau des coordonnees d'attaque        
        if ($FighterPosXY) {
            return $FighterPosXY['Fighter']['id'];
        } elseif ($Item) {
            //retourne - 1 si item sur la pos
            return - ($Item['Tools']['id']);
        }
        return 0;
    }

    public function messagePosition($Id) {
        if ($Id < 0) {
            $item = $this->Tools->findById(- $Id);
            $message = "l'item " . $item['Tools']['type'];
        } elseif ($Id > 0) {
            $fightert = $this->Fighter->findById($id);
            $fighter = $fightert['Fighter'];
            $message = "le fighter " . $fighter['Fighter']['name'];
        }
        return $message;
    }

    public function generation_items() {
        //generation d'item aléatoire si moins de 5 sur la carte
        $add24h = false;
        $Item = $this->Tools->find('all', array('conditions' => array('Tools.coordinate_y >=' => "0", 'Tools.coordinate_x >=' => "0")));
        if (count($Item) < Min_Tool) {
            $eventDate = $this->Events->find('all', array('conditions' => array(
                    "Events.date >" => date('Y-m-d H-i-s', strtotime("-" . Time_appear))
            )));
            // regarde si il y a déja eu une apparition les dernieres 24h
            foreach ($eventDate as $value) {
                if (strpos($value['Events']['name'], "Nouvelle objet Rajouter sur la carte") !== false) {
                    $add24h = true;
                }
            }
            if ($add24h == false) {
                for ($i = count($Item); $i < Min_Tool; $i++) {
                    $message = $this->Tools->generation_item();
                    $this->Events->addevent($message[0], $message[1], $message[2]);
                }
            }
        }
    }

    public function carte() {
        $fighter = $this->Fighter->findById($this->Session->read('activeFighter'));

        if ($fighter) {
            $fighter = $fighter['Fighter'];
            // recupere la pos du fihter actuel
            $posx = $fighter['coordinate_x'];
            $posy = $fighter['coordinate_y'];
            //on recupere la vue 
            $vue = $fighter['skill_sight'];
            //creer un double array de la taille du laby
            $laby = array();

            //boucle 
            for ($i = 0; $i < LABYY; $i++) {
                $laby[$i] = array();
                for ($j = 0; $j < LABYX; $j++) {
                    //regarde si il est dans le champs de vue du fighter                
                    if (abs($posx - $j) + abs($posy - $i) <= $vue) {
                        $id = $this->quiestla($j, $i);
                        if ($id > 0) {
                             $fightert = $this->Fighter->findById($id);
                            $fighter = $fightert['Fighter'];
                            $laby[$i][$j] = array("F", "<p class=\"tooltips\"><b>Name : </b>" . $fighter['name'] . "</p><p class=\"tooltips\"><b>Lvl : </b>" . $fighter['level'] . "</p><p class=\"tooltips\"><b>Health : </b>" . $fighter['current_health'] . "</p><p class=\"tooltips\"><b>Strenght : </b>" . $fighter['skill_strength'] . "</p>", $fighter['id']);
                        } elseif ($id < 0) {
                            $Toolst = $this->Tools->findById(- $id);
                            $Tools = $Toolst['Tools'];
                            $typet = split("de ", $Tools['type']);
                            $typett = split(" ", $typet[1]);
                            $laby[$i][$j] = array("T", "<b>Name : </b>" . $Tools['type'] . "<br /><b>Stats : " . $Tools['bonus'] . " " . $typett[0]);
                        } else {
                            $laby[$i][$j] = 2;
                        }
                    } else {
                        //case noire
                        $laby[$i][$j] = 0;
                    }
                }
            }
            $activeFightert = $this->Fighter->findById($this->Session->read('activeFighter'));
            $activeFighter = $activeFightert['Fighter'];
            $this->set("Carte", $laby);
            $this->set("cartex", LABYX);
            $this->set("cartey", LABYY);
            $this->set("activeFighter", $activeFighter);
            return true;
        } else {
            return false;
        }
    }

    public function sight() {

        $datas1 = $this->Tools->find('all', array(
            'conditions' => array('Tools.fighter_id' => $this->Session->read('activeFighter'))
        ));

        $array = $this->Tools->get_pos($datas1);
        foreach ($array as $key => $value) {
            if ($value != array()) {
                $this->set('s' . $key . 'Nom', $value['Tools']['type']);
                $types = split("de ", $value['Tools']['type']);
                $typess = split(" ", $types[1]);
                $this->set('s' . $key . 'Bonus', $typess[0] . " : " . $value['Tools']['bonus']);
             }
        }
        $this->set('tool', $this->Tools->type_emplacement);


        if ($this->RequestHandler->isAjax() && $this->request->query) {
            $this->doaction();
        }

        if ($this->carte()) {
            $this->set('raw', $this->Fighter->findById($this->Session->read('activeFighter')));
            $this->render("sight");
        } else {
            $this->redirect("createfighter");
        }
    }

    public function beforeFilter() {

        if ($this->RequestHandler->isAjax()) {
            // creer des items si moin de 5 sur la carte...
            $this->generation_items();

            $this->layout = 'ajax';
        }
        if ($this->Session->check('Connected') == true || $this->request->params['action'] == 'login') {
            
        } else if ($this->Session->check('Connected') == true && $this->request->params['action'] == 'login') {
            
        } else if ($this->Session->check('Connected_Face') == true || $this->request->params['action'] == 'login') {
            
        } else if ($this->Session->check('Connected_Face') == true && $this->request->params['action'] == 'login') {
            
        } else if ($this->request->params['action'] == 'index' || $this->request->params['action'] == 'halloffeme' || $this->request->params['action'] == 'halloffemefighter' || $this->request->params['action'] == 'halloffemedate' || $this->request->params['action'] == 'halloffemesight' || $this->request->params['action'] == 'halloffemestrength' || $this->request->params['action'] == 'halloffemehealth' || $this->request->params['action'] == 'halloffemecurrenthealth' || $this->request->params['action'] == 'halloffemename' || $this->request->params['action'] == 'facebook' || $this->request->params['action'] == 'recover') {
            
        } else if ($this->Session->check('Connected') == null && $this->Session->check('Connected_Face') == null) {

            $this->redirect(array('action' => 'login'));
        }
    }

    //Nombre de fighter par guild 
    public function halloffeme() {
        if ($this->request->is('Ajax')) {
            echo json_encode($this->Fighter->find('all', array(
                        'recursive' => 2,
                        'fields' => array(
                            'Player.email as email',
                            'COUNT(Fighter.id) as nb',
                        ),
                        'group' => 'player_id')));
            exit();
        }
    }

    //Nombre de fighter par Niveau 

    public function halloffemefighter() {
        if ($this->request->is('Ajax')) {
            echo json_encode($this->Fighter->find('all', array(
                        'fields' => array(
                            'level as niveau',
                            'COUNT(Fighter.id) as nb',
                        ),
                        'group' => 'level')));


            exit();
        }
    }

    public function halloffemedate() {
        if ($this->request->is('Ajax')) {
            echo json_encode($this->Events->find('all', array(
                        'fields' => array(
                            'date as date',
                            'COUNT(Events.id) as nb',
                        ),
                        'group' => 'date')));


            exit();
        }
    }

    public function halloffemesight() {
        if ($this->request->is('Ajax')) {
            echo json_encode($this->Fighter->find('all', array(
                        'fields' => array(
                            'skill_sight'
                        ),
                        'limit' => 5)));
            exit();
        }
    }

    public function halloffemestrength() {
        if ($this->request->is('Ajax')) {
            echo json_encode($this->Fighter->find('all', array(
                        'fields' => array(
                            'skill_strength'
                        ),
                        'limit' => 5)));
            exit();
        }
    }

    public function halloffemehealth() {
        if ($this->request->is('Ajax')) {
            echo json_encode($this->Fighter->find('all', array(
                        'fields' => array(
                            'skill_health'
                        ),
                        'limit' => 5)));
            exit();
        }
    }

    public function halloffemecurrenthealth() {
        if ($this->request->is('Ajax')) {
            echo json_encode($this->Fighter->find('all', array(
                        'fields' => array(
                            'current_health'
                        ),
                        'limit' => 5)));
            exit();
        }
    }

    public function halloffemename() {
        if ($this->request->is('Ajax')) {
            echo json_encode($this->Fighter->find('all', array(
                        'fields' => array(
                            'name'
                        ),
                        'limit' => 5)));
            exit();
        }
    }

    public function svn() {
        
    }

}

?>
