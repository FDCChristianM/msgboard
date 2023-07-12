<?php

App::uses('Controller', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
class AppController extends Controller {
    public function beforeFilter() {
        parent::beforeFilter();
    
        // Allow access to jQuery datepicker images
        if ($this->name === 'CakeError' && isset($this->request->params['plugin']) && $this->request->params['plugin'] === 'DebugKit') {
            return;
        }
    
        $this->Auth->allow('index', 'view'); // Add other actions that are allowed
    
        // Other beforeFilter code...
    }
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'users', 'action' => 'myProfile'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
            'authorize' => array('Controller'),
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Users',
                    'fields' => array(
                        'email' => 'email',
                        'password' => 'password'
                    )
                )
            )
        )
    );
}