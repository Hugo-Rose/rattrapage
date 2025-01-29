<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

 use Cake\Routing\Route\DashedRoute;
 use Cake\Routing\RouteBuilder;
 use Cake\Routing\Router;
 
 return function (RouteBuilder $routes): void {
     $routes->setRouteClass(DashedRoute::class);
 
     $routes->scope('/', function (RouteBuilder $builder): void {
         // Page d'accueil
         $builder->connect('/', ['controller' => 'Users', 'action' => 'login']);
 
         // Authentification
         $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
         $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
 
         // Gestion des utilisateurs (Admin uniquement)
         $builder->connect('/users', ['controller' => 'Users', 'action' => 'index']);
         $builder->connect('/users/add', ['controller' => 'Users', 'action' => 'add']);
         $builder->connect('/users/edit/*', ['controller' => 'Users', 'action' => 'edit']);
         $builder->connect('/users/delete/*', ['controller' => 'Users', 'action' => 'delete']);
 
         // Pages par défaut
         $builder->connect('/pages/*', 'Pages::display');
 
         // Fallbacks pour les autres routes
         $builder->fallbacks();
     });
 };
 
