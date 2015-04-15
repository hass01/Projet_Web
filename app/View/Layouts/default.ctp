<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php //echo $cakeDescription ?>
            <?php echo $this->fetch('title'); ?>
        </title>
        <?php
        echo $this->Html->meta(
                'favicon.ico', '/favicon.ico', array('type' => 'icon')
        );

        echo $this->Html->css(array(
            'webarena',
            '../js/DataTables/media/css/jquery.dataTables.min',
            'jquery-ui.min.css',
            'jquery-ui.theme.min.css',
            'jquery-ui.structure.min.css'
        ));


        echo $this->Html->script(array(
            'jquery',
            'DataTables/media/js/jquery.dataTables.min',
            'ajax.js',
            'jquery-ui',
        )); // Inclut la librairie Jquery

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <ul>
                    <li>
                        <h1>Web Arena</h1>
                    </li>
                    <li>
                        <h2>Jeux Video Online</h2>
                    </li>
                </ul>
            </div>
            <div id="content">
                <table>
                    <tr>
                        <td class="cadre">
                            <ul>
                                <li>
<?php echo $this->Html->link('Accueil', array('controller' => 'Arena', 'action' => '/')); ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('Connexion', array('controller' => 'Arena', 'action' => 'login')); ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('Arene', array('controller' => 'Arena', 'action' => 'sight')); ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('Personnages', array('controller' => 'Arena', 'action' => 'character')); ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('Nouveau', array('controller' => 'Arena', 'action' => 'createfighter')); ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('Historique', array('controller' => 'Arena', 'action' => 'diary')); ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('Statistique', array('controller' => 'Arena', 'action' => 'halloffeme')); ?>
                                </li>
                            </ul>
                        </td>
                        <td id="contenu">
<?php
echo $this->fetch('content');
echo $this->Session->flash();
?>
                        </td>
                        <td class="cadre2">
                        </td>
                    </tr>
                </table>
            </div>
            <div id="footer">
                <p>
<?php
echo "@ ";
echo $this->fetch('group', 'SI2-01-AE');
echo " - ";
echo $this->fetch('author', 'Germanicus, Guitton, Hassani & Nomede-Martyr');
?>
                </p><p>                    
                    <?php echo $this->fetch('options', 'Options : Gestion avancee des combattants et de leur equipement, Interface avancee & Connexion Facebook'); ?>
                </p><p>
                    <?php echo $this->Html->link('Lien vers le suivi de version', array('controller' => 'Arena', 'action' => 'svn')); ?>
                </p><p>
                    <?php echo $this->fetch('enLigne', '<a href=\'http://projetwebarena.esy.es/WebArenaGoupSI2-01-AE/Arena\'>Version en ligne</a>'); ?>
                </p>
            </div>
        </div>
        <?php //echo $this->element('sql_dump'); ?>
    </body>
</html>
