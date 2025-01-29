<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Authentication\Middleware\AuthenticationMiddleware;
use Authentication\AuthenticationService;
use Authentication\Authenticator\SessionAuthenticator;
use Authentication\Authenticator\FormAuthenticator;

/**
 * Application setup class.
 */
class Application extends BaseApplication
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Appel du parent pour charger les fichiers bootstrap
        parent::bootstrap();

        // Vérification de l'environnement CLI
        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add(
                'Table',
                (new TableLocator())->allowFallbackClass(false)
            );
        }

        // Chargement du plugin Authentication
        $this->addPlugin('Authentication');
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        
    // Ajoute l'authentification après
    $middlewareQueue->add(new AuthenticationMiddleware($this->getAuthenticationService()));

        // Middleware de gestion des erreurs
        $middlewareQueue->add(new ErrorHandlerMiddleware(Configure::read('Error')));

        // Middleware d'assets (CSS, JS, etc.)
        $middlewareQueue->add(new AssetMiddleware());

        // Middleware de routage
        $middlewareQueue->add(new RoutingMiddleware($this));

        // Middleware d'authentification
        $authentication = new AuthenticationMiddleware($this->getAuthenticationService());
        $middlewareQueue->add($authentication);

        // Middleware de parsing du corps de la requête
        $middlewareQueue->add(new BodyParserMiddleware());

        // Middleware de protection CSRF
        $middlewareQueue->add(new CsrfProtectionMiddleware());

        return $middlewareQueue;
    }

    /**
     * Get the authentication service.
     *
     * @return \Authentication\AuthenticationService The authentication service.
     */
    public function getAuthenticationService(): AuthenticationService
    {
        $service = new AuthenticationService();

        $service->setConfig([
            'unauthenticatedRedirect' => '/users/login',
            'queryParam' => 'redirect',
        ]);

        // Authentificateurs
        $service->loadAuthenticator(SessionAuthenticator::class);
        $service->loadAuthenticator(FormAuthenticator::class, [
            'fields' => ['username' => 'email', 'password' => 'password'],
            'loginUrl' => '/users/login',
        ]);

        // Identifiants (User Table)
        $service->loadIdentifier('Authentication.Password', [
            'fields' => ['username' => 'email', 'password' => 'password'],
        ]);

        return $service;
    }
}