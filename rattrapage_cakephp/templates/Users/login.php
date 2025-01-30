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
    <h2>Connexion</h2>
    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->control('email', ['label' => 'Adresse e-mail', 'required' => true]) ?>
        <?= $this->Form->control('password', ['label' => 'Mot de passe', 'type' => 'password', 'required' => true]) ?>
    </fieldset>
    <?= $this->Form->button('Se connecter', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

    <!-- Lien vers la page d'inscription -->
    <div class="register-link">
        <p>Pas encore de compte ? <?= $this->Html->link('S\'inscrire', ['action' => 'register'], ['class' => 'btn btn-secondary']) ?></p>
    </div>
</div>
