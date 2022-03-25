<?php
namespace App\Controller\Authentication;

use Exception;
use Cake\Routing\Router;
use Cake\Event\EventInterface;
use Cake\Controller\Controller;
use App\Controller\AppController;
use App\Model\Authentication\AppAuthentication;

/**
 * Handle Google OAuth2 Login 
 */
class GoogleLoginController extends AppController {

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        $this->Authentication->allowUnauthenticated(['authentication']);
    }

    /**
     * Google Authentication handler
     */
    public function authentication() {
        $session = $this->request->getSession();
        $session->read();
        // must write logics here due to bug related to namespace of ```Google_Client class```
        require __DIR__.'/google/authentication.php';
    }

    // /**
    //  * User just authenticated using Google Account.
    //  * If this user is existed, then login, otherwise create new user & login.
    //  */
    // public function authenticated() {
    //     $session = $this->request->getSession();
    //     $session->read();
    //     // must write logics here due to bug related to namespace of ```Google_Client class```
    //     require __DIR__.'/google/authenticated.php';
    // }
}