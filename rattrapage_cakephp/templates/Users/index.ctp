<!-- templates/Users/index.ctp -->

<div class="users index">
    <h2><?= __('Liste des utilisateurs') ?></h2>
    <table>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('email', 'Email') ?></th>
                <th><?= $this->Paginator->sort('created', 'Créé le') ?></th>
                <th><?= $this->Paginator->sort('modified', 'Modifié le') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= h($user->id) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('Première')) ?>
        <?= $this->Paginator->prev('< ' . __('Précédente')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('Suivante') . ' >') ?>
        <?= $this->Paginator->last(__('Dernière') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} sur {{pages}}')) ?></p>
</div>