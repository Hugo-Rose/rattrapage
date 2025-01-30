<!-- templates/Users/register.php -->
<div class="users form">
    <h2>Inscription</h2>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <?= $this->Form->control('email', ['label' => 'Adresse e-mail']) ?>
        <?= $this->Form->control('password', ['label' => 'Mot de passe', 'type' => 'password']) ?>
        <?= $this->Form->control('confirm_password', ['label' => 'Confirmer le mot de passe', 'type' => 'password']) ?>
    </fieldset>
    <?= $this->Form->button('S\'inscrire') ?>
    <?= $this->Form->end() ?>
</div>