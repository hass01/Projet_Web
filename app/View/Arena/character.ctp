<h1>Vos Combattants</h1>

<?php
$this->assign('title', 'Combattants');
echo $this->Html->script('slider'); // Inclut la page javascript du slider
echo "<div class=\"avatars\">";
echo "<div class=\"slider\">";
for ($i = 0; $i < $nb; $i++) {
    echo "<a href=\"#\">";
    $link = 'Fighter/avatar' . $fighters[$i][0] . '.png';
    $string = 'avatar' . $fighters[$i][0];
    echo $this->Html->image($link, array('alt' => $string));
    echo "</a>";
    $ind = $i;
}
echo "</div>";
echo "<div class=\"next_s\" onclick=\"change($ind);\"></div>";
echo "<div class=\"previous_s\"></div>";
echo "</div>";
?>

<?php
echo $this->Form->create('Fighter');
echo $this->Form->input('avatar', array('label' => ''));


for ($i = 0; $i < $nb; $i++) {
    $xp = $fighters[$i][7] - ($fighters[$i][2] -1)*4;             
    echo "<div class=\"infos\" style=\"display: none;\" id= " . ($i+1) . ">";
    echo "<b>Name : </b>" . $fighters[$i][1];
    echo "<br /><b>Niveau : </b>" . $fighters[$i][2];
    echo "<br /><b>XP : </b>" . $xp;
    echo "<br /><b>Vie : </b>" . $fighters[$i][3] . " / " . $fighters[$i][6];
    echo "<br /><b>Force : </b>" . $fighters[$i][4];
    echo "<br /><b>Vue : </b>" . $fighters[$i][5];
    echo "</div>";
}


echo $this->Form->end('Choisir ce Combattant');
?>

<?php echo $this->Js->writeBuffer(); // Écrit les scripts en mémoire cache
?>