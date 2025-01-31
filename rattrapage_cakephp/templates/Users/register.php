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

<div class="footer-content">
            <p>&copy; <?= date('Y') ?> <a href="https://github.com/Hugo-Rose" target="_blank">ROSE Hugo</a>. Tous droits réservés.
            </p>
            <p>Propulsé avec <a href="https://cakephp.org" target="_blank">CakePHP</a>.</p>
        </div>