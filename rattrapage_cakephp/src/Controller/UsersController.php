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

        if ($result->isValid()) {
            $user = $this->Authentication->getIdentity();
            $this->Flash->success(__('Connexion réussie.'));

            // Redirection personnalisée pour les administrateurs
            if ($user->get('role') === 'admin') {
                return $this->redirect(['controller' => 'Admin', 'action' => 'dashboard']);
            }

            return $this->redirect($this->Authentication->getLoginRedirect() ?? '/');
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
            $hasher = new DefaultPasswordHasher();
            $data['password'] = $hasher->hash($data['password']);

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

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Autoriser l'accès à l'action 'login', 'logout' et 'register' pour tous les utilisateurs
        $this->Authentication->allowUnauthenticated(['login', 'logout', 'register']);

        // Vérifier les permissions pour les actions sensibles
        if (in_array($this->request->getParam('action'), ['delete', 'edit', 'add'])) {
            $user = $this->Authentication->getIdentity();

            // Si l'utilisateur n'est pas administrateur, rediriger avec un message d'erreur
            if (!$user || $user->get('role') !== 'admin') {
                $this->Flash->error(__('Vous n\'avez pas les permissions nécessaires.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }
}