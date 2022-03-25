<?php
namespace App\Controller\Authentication;

use Exception;
use Cake\Routing\Router;
use Cake\Event\EventInterface;
use App\Controller\AppController;
use App\Model\Authentication\AppAuthentication;

class LogoutController extends AppController {

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['logout']);
    }

    /**
     * Checking user authentication, rendering login page & displaying login errors
     */
    public function logout() 
    {
        $this->Authentication->logout();
        return $this->redirect(
            Router::url(['_name' => 'home_index'], true)
        );
    }
}