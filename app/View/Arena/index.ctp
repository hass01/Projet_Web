
<?php
$this->assign('title', 'Accueil');
echo $this->Html->script('slider'); // Inclut la page javascript du slider
?>
<h1>Bienvenue dans WebArena, <?php echo $myname; ?> !</h1>
<p>Dans ce jeu en ligne, vous aurez la possibilité de créer un ou plusieurs combattants que vous enverrez dans l'arène.
    Ils affronteront leurs adversaires pour tenter de remporter la victoire et de monter de niveau.</p>
<p>Attention ! Quelques cases renferment des équipements qui pourront alors avantager votre personnage. A prendre ou à laisser !</p>


<?php
echo "<h2>Avatars disponibles</h2>";
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
echo $this->Form->create('Fighter');
echo $this->Form->input('avatar', array('label' => ''));
?>
