<?php $this->assign('title', 'Level Up');?>

<h1>Level Up</h1>
<div id="personnage">
<?php 

$this->Html->css('lvlup', array('inline' => false));

echo $this->Form->create('FighterLvlup');
$nbpt =  floor($raw['Fighter']['xp']/4) - $raw['Fighter']['level'] +1;
$avatar = "../app/webroot/img/Fighter/avatar" . $raw['Fighter']['id'] . ".png";
echo "<img src=". $avatar . " alt=\"Avatar\" />";
echo "<h3>". $raw['Fighter']['name'] ."</h3>";
echo "<h4>Level : ". $raw['Fighter']['level']."</h4>";
echo "<p>Nombre de point disponible: <span id='nbpt'>".$nbpt ."</span></p>";

echo "<table id='table_id' class='datable'>"; 
    echo "<thead>";
        echo $this->Html->tableHeaders(array('Nom stats', 'Actuel', '', '+ Stats',''));
    echo "</thead>";
    echo "<body>";
    echo $this->Html->tableCells(array(
        array("Sight : ", $raw['Fighter']['skill_sight'],$this->Form->button(' - ', array('type' => 'button','id'=>'m_Sight','class'=>'boutonPM')),
            $this->Html->div(null, '0',array('id'=> 'skill_Sight')),$this->Form->button(' + ', array('type' => 'button','id'=>'p_Sight','class'=>'boutonPM'))),
        array("Strenght : ",$raw['Fighter']['skill_strength'],$this->Form->button(' - ', array('type' => 'button','id'=>'m_Strength','class'=>'boutonPM')),
            $this->Html->div(null, '0',array('id'=> 'skill_Strength')), $this->Form->button(' + ', array('type' => 'button','id'=>'p_Strength','class'=>'boutonPM'))),
        array("Health : ",$raw['Fighter']['skill_health'], $this->Form->button(' - ', array('type' => 'button','id'=>'m_Health','class'=>'boutonPM')),
            $this->Html->div(null, '0',array('id'=> 'skill_Health')),$this->Form->button(' + ', array('type' => 'button','id'=>'p_Health','class'=>'boutonPM')))     
        ));
    echo "</body>";
echo "</table>";

echo $this->Form->hidden('Sight', array('default' => '0','id' => 'Sight'));
echo $this->Form->hidden('Strength', array('default' => '0','id' => 'Strength'));
echo $this->Form->hidden('Health', array('default' => '0','id' => 'Health'));
echo $this->Form->end('LvlUp');

$scriptm = 'var id = this.id.split("_")[1];
            var input = document.getElementById(id);
            var nb_pt = parseInt(document.getElementById("nbpt").innerHTML);
            if(nb_pt >=0){
            var nb =  parseInt(input.value);
                if(nb != 0){
                    nb =  nb -1;
                    if(id == "Health")document.getElementById("skill_"+ id).innerHTML = 3*nb;
                    else document.getElementById("skill_"+ id).innerHTML = nb;
                    input.value = nb;
                    nb_pt = nb_pt +1;
                    document.getElementById("nbpt").innerHTML = nb_pt;
                }
            }';
$scriptp = ' var id = this.id.split("_")[1];
            var input = document.getElementById(id);
            var nb_pt = parseInt(document.getElementById("nbpt").innerHTML);
            if(nb_pt >0){
            var nb =  parseInt(input.value);
                nb =  nb +1;
                if(id == "Health")document.getElementById("skill_"+ id).innerHTML = 3*nb;
                else document.getElementById("skill_"+ id).innerHTML = nb;
                input.value = nb;
                nb_pt = nb_pt -1;
                document.getElementById("nbpt").innerHTML = nb_pt;
            }';

$this->Js->get('#m_Sight');
$this->Js->event('click', $scriptm, array('stop' => false));
$this->Js->get('#p_Sight');
$this->Js->event('click', $scriptp, array('stop' => false));

$this->Js->get('#m_Strength');
$this->Js->event('click', $scriptm, array('stop' => false));
$this->Js->get('#p_Strength');
$this->Js->event('click', $scriptp, array('stop' => false));

$this->Js->get('#m_Health');
$this->Js->event('click', $scriptm, array('stop' => false));
$this->Js->get('#p_Health');
$this->Js->event('click', $scriptp, array('stop' => false));
echo $this->Js->writeBuffer(); // Écrit les scripts en mémoire cache

?>
</div>