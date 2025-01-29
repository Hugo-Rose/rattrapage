<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('nom', 'string', ['limit' => 255])
              ->addColumn('prenom', 'string', ['limit' => 255])
              ->addColumn('email', 'string', ['limit' => 255])
              ->addColumn('password', 'string', ['limit' => 255])
              ->addColumn('type', 'integer', ['default' => 1, 'comment' => '0: admin, 1: utilisateur simple'])
              ->addTimestamps()
              ->create();
    }
}
