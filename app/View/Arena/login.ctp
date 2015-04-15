
<?php $this->assign('title', 'Connexion');
echo $this->Html->script('Facebook');

if ($check == 1) {
    $facebook = "<a href=" . $this->Html->url(array('action' => 'facebook')) . " class='Face'> Se connecter via facebook </a>";

    echo $this->Html->div("", $this->Form->button('Se Connecter', array('type' => 'button', 'id' => 'log')) . $this->Form->button("S'enregistrer", array('type' => 'button', 'id' => 'sub')) .
            "<p>" . $this->Html->link('Mot de passe perdu ?', '#', array('id' => 'mdp_ll')) . "</p>", array('id' => 'log_sub', 'style' => 'display:block;'));

    //formulaire d'inscription
    echo $this->Html->div("", $this->Form->create('Subscribe') . $this->Form->input('email')
            . $this->Form->input('password') . $this->Form->end('Inscription'), array('id' => 'Subscribe', 'style' => 'display:none;'));

    //form de login
    echo $this->Html->div("", $this->Form->create('Login') . $this->Form->input('email')
            . $this->Form->input('password') . $this->Form->end('Connexion') . $facebook, array('id' => 'Login', 'style' => 'display:none;'));

    //form de lost password
    echo $this->Html->div("", $this->Form->create('Recover', array('url' => array('controller' => 'Arena', 'action' => 'recover')))
            . $this->Form->input("email", array(
                'label' => 'Votre email d\'inscription')) . $this->Form->end('Recover'), array('id' => 'mdp_lost', 'style' => 'display:none;'));

    $log_sub = 'document.getElementById("log_sub").style.display="none";';
    $log = 'document.getElementById("Login").style.display="block";';
    $this->Js->get('#log');
    $this->Js->event('click', $log_sub . $log, array('stop' => false));
    $sub = 'document.getElementById("Subscribe").style.display="block";';
    $this->Js->get('#sub');
    $this->Js->event('click', $log_sub . $sub, array('stop' => false));
    $lost = 'document.getElementById("mdp_lost").style.display="block";';
    $this->Js->get('#mdp_ll');
    $this->Js->event('click', $log_sub . $lost, array('stop' => false));
    echo $this->Js->writeBuffer(); // Écrit les scripts en mémoire cache
} elseif ($check == 3) {
    echo $this->Form->create(false);
    echo $this->Form->submit('Deconnexion', array('name' => "Delog"));
    echo $this->Form->end();
} elseif ($check == 2) {
    echo $this->Form->create(false);
    echo $this->Form->submit('Deconnexion', array('name' => "logout_face", 'onclick' => "checkLoginState()"));
    echo $this->Form->end();
}
?>

