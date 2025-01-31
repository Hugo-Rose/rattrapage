<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="users index content">
    <?= $this->Html->link(__('Login'), ['action' => 'users'], ['class' => 'button float-right']) ?>
    <h3><?= __('Utilisateurs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', __('Identifiant')) ?></th>
                    <th><?= $this->Paginator->sort('actif', __('Actif')) ?></th>
                    <th><?= $this->Paginator->sort('nom', __('Nom')) ?></th>
                    <th><?= $this->Paginator->sort('prenom', __('Prénom')) ?></th>
                    <th><?= $this->Paginator->sort('email', __('Email')) ?></th>
                    <th><?= $this->Paginator->sort('created', __('Créé le')) ?></th>
                    <th><?= $this->Paginator->sort('modified', __('Modifié le')) ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= $user->actif ? __('Oui') : __('Non') ?></td>
                    <td><?= h($user->nom) ?></td>
                    <td><?= h($user->prenom) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Voir'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $user->id], ['confirm' => __('Êtes-vous sûr de vouloir supprimer l\'utilisateur # {0} ?', $user->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        
        <p><?= $this->Paginator->counter(__('Page {{page}} sur {{pages}}, affichant {{current}} enregistrement(s) sur un total de {{count}}')) ?></p>
    </div>
</div>
<div class="footer-content">
            <p>&copy; <?= date('Y') ?> <a href="https://github.com/Hugo-Rose" target="_blank">ROSE Hugo</a>. Tous droits réservés.
            </p>
            <p>Propulsé avec <a href="https://cakephp.org" target="_blank">CakePHP</a>.</p>
        </div>