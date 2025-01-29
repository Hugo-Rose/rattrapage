<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
    <div class="column-responsive column-50">
        <div class="users form content">
            <h3>Connexion</h3>
            <?= $this->Form->create() ?>
            <fieldset>
                <legend>Veuillez vous connecter</legend>
                <?= $this->Form->control('email', ['label' => 'Email', 'required' => true]) ?>
                <?= $this->Form->control('password', ['label' => 'Mot de passe', 'required' => true, 'type' => 'password']) ?>
            </fieldset>
            <?= $this->Form->button('Se connecter') ?>
            <?= $this->Form->end() ?>

            <p>Vous n'avez pas de compte ? <?= $this->Html->link("S'inscrire", ['action' => 'add']) ?></p>
        </div>
    </div>
</div>

