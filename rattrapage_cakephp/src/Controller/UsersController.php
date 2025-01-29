<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

class UsersController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');

        // Autoriser les utilisateurs non authentifiés à accéder à login
        $this->Authentication->allowUnauthenticated(['login']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
{
    $user = $this->Users->newEmptyEntity();

    // Exemple d'ajout d'un mot de passe haché
    $hashedPassword = (new DefaultPasswordHasher)->hash('rattrapage1234');
    // Assigner le mot de passe haché à l'entité user
    $user->password = $hashedPassword;

    if ($this->request->is('post')) {
        // Sauvegarder l'utilisateur avec le mot de passe haché
        $user = $this->Users->patchEntity($user, $this->request->getData());

        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been saved.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The user could not be saved. Please, try again.'));
    }
    $this->set(compact('user'));
}

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('L\'utilisateur a été mis à jour avec succès.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de mettre à jour l\'utilisateur. Veuillez réessayer.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('L\'utilisateur a été supprimé.'));
        } else {
            $this->Flash->error(__('Impossible de supprimer l\'utilisateur. Veuillez réessayer.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $this->Flash->success(__('Connexion réussie.'));
            $redirect = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($redirect);
        }

        // Afficher un message d'erreur si l'authentification a échoué
        if ($this->request->is('post')) {
            $this->Flash->error(__('Identifiants incorrects, veuillez réessayer.'));
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|null Redirects to login page.
     */
    public function logout()
    {
        $this->Authentication->logout();
        $this->Flash->success(__('Vous avez été déconnecté.'));
        return $this->redirect(['action' => 'login']);
    }
}
