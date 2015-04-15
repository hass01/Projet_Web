<h1>Ajouter un personnage</h1>

<?php
$this->assign('title', 'Creer Combattant');
echo $this->Html->script('slider'); // Inclut la page javascript du slider
echo "<div class=\"avatars\">";
echo "<div class=\"slider\">";
for ($i = 0; $i < 8; $i++) {
    echo "<a href=\"#" . ($i + 1) . "\">";
    $link = 'Fighter/chara' . ($i + 1) . '.png';
    echo $this->Html->image($link, array('alt' => 'Avatar'));
    echo "</a>";
}
echo "</div>";
echo "<div class=\"next_s\"></div>";
echo "<div class=\"previous_s\"></div>";
echo "</div>";
?>

<?php
echo $this->Form->create('Fighter');
echo $this->Form->input('avatar', array('label' => ''));
echo $this->Form->input('Fighter.name', array('label' => 'Nom:'));
echo $this->Form->input('Fighter.guild_id', array('label' => 'Guide'));
echo $this->Form->end('Creer ce nouveau Combattant');
?>

<?php echo $this->Js->writeBuffer(); // Écrit les scripts en mémoire cache
?>