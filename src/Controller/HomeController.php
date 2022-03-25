<?php
namespace App\Controller;

use Cake\Routing\Router;
use Cake\Event\EventInterface;
use App\Controller\AppController;

class HomeController extends AppController {

    public function index() 
    {
        $result = $this->Authentication->getResult();
        $data = $result->getData();
        return $this->render();
    }
}