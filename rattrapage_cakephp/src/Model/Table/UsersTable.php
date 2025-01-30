<?php
// src/Model/Table/UsersTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Définir la table associée à ce modèle
        $this->setTable('users'); // Nom de la table dans la base de données
        $this->setDisplayField('email'); // Champ à afficher par défaut
        $this->setPrimaryKey('id'); // Clé primaire de la table

        // Ajouter des comportements ou des associations si nécessaire
        $this->addBehavior('Timestamp'); // Ajoute les champs created et modified automatiquement
    }

    public function validationDefault(Validator $validator): Validator
    {
        // Ajouter des règles de validation pour les champs
        $validator
            ->notEmptyString('email', 'L\'adresse e-mail est requise.')
            ->email('email', false, 'L\'adresse e-mail n\'est pas valide.')
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Cette adresse e-mail est déjà utilisée.',
            ])
            ->notEmptyString('password', 'Le mot de passe est requis.')
            ->minLength('password', 8, 'Le mot de passe doit contenir au moins 8 caractères.');

        return $validator;
    }
}