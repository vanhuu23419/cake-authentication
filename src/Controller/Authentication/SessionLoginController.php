<?php
namespace App\Controller\Authentication;

use App\Controller\AppController;
use App\Model\Authentication\AppAuthentication;
use Cake\Event\EventInterface;

class SessionLoginController extends AppController {

    // Handle login 
    public function login() {
        $accessToken = $this->request->getSession()->read('access_token');
        if ($accessToken) {
            
        }
    }
}