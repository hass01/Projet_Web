<?php $this->assign('title', 'Historique'); ?>

<?php

echo "<table id='diary' class='display'>";
echo "<thead>";
echo $this->Html->tableHeaders(array('Evenement', 'Date', 'Coordonée X', 'Coordonée X'));
echo "</thead>";
echo "<tbody>";
for ($i = 0; $i < count($event); $i++) {
    echo $this->Html->tableCells(array(array($event[$i]['Events']['name'], $event[$i]['Events']['date'], $event[$i]['Events']['coordinate_x'], $event[$i]['Events']['coordinate_y'])));
}
echo"</tbody>";
echo "</table>";
?>