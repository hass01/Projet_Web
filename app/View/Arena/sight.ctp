<?php
$this->assign('title', 'Arene');
$this->Html->css('Tools', array('inline' => false));
$this->Html->script('Tools');
?>

<table id="special">
    <tr>
        <td id="big">

            <?php
//afficher un tableau
            $taille_image = "32px";

            echo "<h1>Arene</h1>";
            echo "<table id=\"map\">";
            echo "<thead>"; /*
              for ($i = 0; $i < count($Carte[0]); $i++) {
              $array_head[$i] = $i ;
              }
              echo $this->Html->tableHeaders($array_head); */
            echo "</thead>";
            echo "<body>";
            for ($i = 0; $i < $cartey; $i++) {
                for ($j = 0; $j < $cartex; $j++) {
                    if ($Carte[$i][$j] == 0) {
                        $array[$i][$j] = $this->Html->image('Carte/Noir.jpg', array('alt' => 'Noir', 'height' => $taille_image, 'width' => $taille_image));
                    } elseif ($Carte[$i][$j] == 2) {
                        $array[$i][$j] = $this->Html->image('Carte/Blanc.jpg', array('alt' => 'Blanc', 'height' => $taille_image, 'width' => $taille_image));
                    } elseif (isset($Carte[$i][$j][0]) && $Carte[$i][$j][0] == "F") {
                        $tooltip = $Carte[$i][$j][1];
                        $fighterId = $Carte[$i][$j][2];
                        $image = 'Carte/Fighter' . $fighterId . '.jpg';
                        $array[$i][$j] = $this->Html->image($image, array('alt' => 'Fighter', 'height' => $taille_image, 'width' => $taille_image, 'title' => $tooltip));
                    } elseif (isset($Carte[$i][$j][0]) && $Carte[$i][$j][0] == "T") {
                        $tooltip = $Carte[$i][$j][1];
                        $array[$i][$j] = $this->Html->image('Carte/Tool.jpg', array('alt' => 'Tools', 'height' => $taille_image, 'width' => $taille_image, 'title' => $tooltip));
                    }
                }
                echo $this->Html->tableCells(array($array[$i]));
            }
            echo "</body>";
            echo "</table>";
            ?>



            <?php
            echo "<table id=\"attaque\">";
            echo "<thead></thead><body>";
            $direction = array("Nord", "Ouest", "Est", "Sud");

            $Attaquenord = $this->Form->create('Attaque', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "Attaque")) . $this->Form->hidden("Direction", array('default' => $direction[0])) . $this->Form->submit('' . $direction[0], array("class" => "submitt")) . $this->Form->end();
            $Attaqueest = $this->Form->create('Attaque', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "Attaque")) . $this->Form->hidden("Direction", array('default' => $direction[2])) . $this->Form->submit('' . $direction[2], array("class" => "submitt")) . $this->Form->end();
            $Attaqueouest = $this->Form->create('Attaque', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "Attaque")) . $this->Form->hidden("Direction", array('default' => $direction[1])) . $this->Form->submit('' . $direction[1], array("class" => "submitt")) . $this->Form->end();
            $Attaquesud = $this->Form->create('Attaque', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "Attaque")) . $this->Form->hidden("Direction", array('default' => $direction[3])) . $this->Form->submit('' . $direction[3], array("class" => "submitt")) . $this->Form->end();
            $Movenord = $this->Form->create('Move', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "Move")) . $this->Form->hidden("Direction", array('default' => $direction[0])) . $this->Form->submit('' . $direction[0], array("class" => "submitt")) . $this->Form->end();
            $Moveest = $this->Form->create('Move', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "Move")) . $this->Form->hidden("Direction", array('default' => $direction[2])) . $this->Form->submit('' . $direction[2], array("class" => "submitt")) . $this->Form->end();
            $Moveouest = $this->Form->create('Move', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "Move")) . $this->Form->hidden("Direction", array('default' => $direction[1])) . $this->Form->submit('' . $direction[1], array("class" => "submitt")) . $this->Form->end();
            $Movesud = $this->Form->create('Move', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "Move")) . $this->Form->hidden("Direction", array('default' => $direction[3])) . $this->Form->submit('' . $direction[3], array("class" => "submitt")) . $this->Form->end();
            $GetItemnord = $this->Form->create('GetItem', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "GetItem")) . $this->Form->hidden("Direction", array('default' => $direction[0])) . $this->Form->submit('' . $direction[0], array("class" => "submitt")) . $this->Form->end();
            $GetItemest = $this->Form->create('GetItem', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "GetItem")) . $this->Form->hidden("Direction", array('default' => $direction[2])) . $this->Form->submit('' . $direction[2], array("class" => "submitt")) . $this->Form->end();
            $GetItemouest = $this->Form->create('GetItem', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "GetItem")) . $this->Form->hidden("Direction", array('default' => $direction[1])) . $this->Form->submit('' . $direction[1], array("class" => "submitt")) . $this->Form->end();
            $GetItemsud = $this->Form->create('GetItem', array('class' => "Bouton_form", 'type' => 'get')) . $this->Form->hidden("Action", array('default' => "GetItem")) . $this->Form->hidden("Direction", array('default' => $direction[3])) . $this->Form->submit('' . $direction[3], array('class' => 'submitt')) . $this->Form->end();
            echo $this->Html->tableCells(array("", $Attaquenord, "", "", $Movenord, "", "", $GetItemnord, ""));
            echo $this->Html->tableCells(array($Attaqueouest, "Attaque", $Attaqueest, $Moveouest, "Move", $Moveest, $GetItemouest, "Rammaser", $GetItemest));
            echo $this->Html->tableCells(array("", $Attaquesud, "", "", $Movesud, "", "", $GetItemsud, ""));

            echo "</body>";
            echo "</table>";
            ?>

        </td>
        <td id="small">
            <?php
            echo "<h2>Combattant</h2>";
            $avatar = "../app/webroot/img/Fighter/avatar" . $activeFighter['id'] . ".png";
            $xp = $activeFighter['xp'] - ($activeFighter['level'] -1)*4; 
            echo "<img src=" . $avatar . " alt=\"Avatar\" />";
            echo "<h3>" . $activeFighter['name'] . "</h3>";
            echo "<h4>Niveau : " . $activeFighter['level'] . "</h4>";
            echo "<h5>XP     : " . $xp . "</h5>";
            echo "<h5>Vie    : " . $activeFighter['current_health'] . " / " . $activeFighter['skill_health'] . "</h5>";
            echo "<h5>Force  : " . $activeFighter['skill_strength'] . "</h5>";
            echo "<h5>Vue    : " . $activeFighter['skill_sight'] . "</h5>";
            if($xp >= 4){
                echo $this->Html->link('Level up', array('controller' => 'Arena', 'action' => 'lvlup'));
            }

            echo "<h2>Equipement</h2>";
            echo "<br />";
            echo $this->Html->image('tools/equipement.png', array('fullBase' => true, 'alt' => 'Fond Equipement', 'id' => 'equip'));
            $text_tooltip1 = "<p class=\"tooltips\"><b>Nom : </b>";
            $text_tooltip2 = "<p class=\"tooltips\"><b>Nombre de Point de ";
            for ($i = 0; $i < count($tool); $i++) {
                if (isset(${"s" . $i . "Nom"})) {
                    $toll = $text_tooltip1 .${"s" . $i . "Nom"}."</p>" . $text_tooltip2 . ${"s" . $i . "Bonus"}."</p>";
                    echo $this->Html->image('tools/' . $tool[$i] . '.jpg', array('alt' => $tool[$i],'title'=>$toll,'id'=>$tool[$i]));
                }
                else
                    echo $this->Html->image('tools/vide.png', array('alt' => 'no equipment','class'=>'vide'));                    
            }?>
        </td>
    </tr>
</table>

