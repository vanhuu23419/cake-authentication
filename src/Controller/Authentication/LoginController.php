<?php
namespace App\Controller\Authentication;

use Exception;
use Cake\Routing\Router;
use Cake\Event\EventInterface;
use App\Controller\AppController;
use App\Model\Authentication\AppAuthentication;

class LoginController extends AppController {

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        $this->Authentication->allowUnauthenticated(['index']);
    }

    /**
     * Checking user authentication, rendering login page & displaying login errors
     */
    public function index() 
    {
        $request = $this->request;
        $authResult = $this->Authentication->getResult();

        // user is logged in
        if ($authResult->isValid()) {
            $rdr = $request->getQuery('redirect') ?? $request->getData('redirect');
            if ($rdr) {
                return $this->redirect($rdr);
            }
            else {
                return $this->redirect(Router::url([
                    '_name' => 'home_index',
                ], true));
            }
        }

        // need authentication, redirect to login page
        return $this->render();
    }
}