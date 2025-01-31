<!-- templates/Users/login.php -->
<style>
    .users.form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .users.form h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .users.form .btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 0;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }
    .users.form .btn-primary {
        background-color: #cc1f1a;
        color: white;
    }
    .users.form .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .register-link {
        text-align: center;
        margin-top: 20px;
    }
</style>

<div class="users form">
<?= $this->Flash->render() ?>
    <h3>Connexion</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Veuillez entrer votre nom d\'utilisateur et votre mot de passe') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Login')); ?>
    <?= $this->Form->end() ?>
    

    <!-- Lien vers la page d'inscription -->
    <div class="register-link">
        <p>Pas encore de compte ? <?= $this->Html->link('S\'inscrire', ['action' => 'register'], ['class' => 'btn btn-secondary']) ?></p>
    </div>
</div>
<div class="footer-content">
            <p>&copy; <?= date('Y') ?> <a href="https://github.com/Hugo-Rose" target="_blank">ROSE Hugo</a>. Tous droits réservés.
            </p>
            <p>Propulsé avec <a href="https://cakephp.org" target="_blank">CakePHP</a>.</p>
        </div>
