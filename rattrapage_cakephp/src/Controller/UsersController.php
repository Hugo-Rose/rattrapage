<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Auth\DefaultPasswordHasher;

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

        // Autoriser les utilisateurs non authentifiés à accéder à login, logout et register
        $this->Authentication->allowUnauthenticated(['login', 'logout', 'register']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
{
    // Récupérer tous les utilisateurs
    $users = $this->Users->find('all');

    // Récupérer les utilisateurs paginés
    $users = $this->paginate($this->Users);

    // Passer les utilisateurs à la vue
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

        if ($this->request->is('post')) {
            // Hacher le mot de passe avant de l'enregistrer
            $data = $this->request->getData();
            $hasher = new DefaultPasswordHasher();
            $data['password'] = $hasher->hash($data['password']);

            $user = $this->Users->patchEntity($user, $data);

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
         // indépendamment de POST ou GET, rediriger si l'utilisateur est connecté
         if ($result && $result->isValid()) {
             // rediriger vers /users après la connexion réussie
             $redirect = $this->request->getQuery('index', [
                 'controller' => 'index',
                 'action' => 'index',
             ]);
             return $this->redirect(['controller' => 'Users', 'action' => 'index']);

         }
         // afficher une erreur si l'utilisateur a soumis un formulaire
         // et que l'authentification a échoué
         if ($this->request->is('post') && !$result->isValid()) {
             $this->Flash->error(__('Votre identifiant ou votre mot de passe est incorrect.'));
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
        return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
    }

    /**
     * Register method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful registration, renders view otherwise.
     */
    public function register()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            // Récupérer les données du formulaire
            $data = $this->request->getData();

            // Hacher le mot de passe avant de l'enregistrer
            //$hasher = new DefaultPasswordHasher();
            //$data['password'] = $hasher->hash($data['password']);

            // Assigner les données à l'entité User
            $user = $this->Users->patchEntity($user, $data);

            // Sauvegarder l'utilisateur
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Votre inscription a été effectuée avec succès. Vous pouvez maintenant vous connecter.'));

                // Rediriger vers la page de connexion
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('Une erreur est survenue lors de votre inscription. Veuillez réessayer.'));
            }
        }

        // Passer l'entité user à la vue
        $this->set(compact('user'));
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configurez l'action de connexion pour ne pas exiger d'authentification,
        // évitant ainsi le problème de la boucle de redirection infinie
        $this->Authentication->addUnauthenticatedActions(['login']);
    }
}