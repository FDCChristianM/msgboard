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

        if (!$this->Session->check('user')) {
            $allowedActions = array('login', 'register', 'registerUser', 'authenticate');
            if (!in_array($this->request->params['action'], $allowedActions) && !($this->request->params['controller'] === 'pages' && $this->request->params['action'] === 'display')) {
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
        }
        
        if ($this->Session->check('user') && ($this->request->params['controller'] == 'pages' && $this->request->params['action'] == 'display' && $this->request->params['pass'][0] == 'login' || $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'register')) {
            // Redirect to the home page or any other appropriate page
            $this->redirect(array('controller' => 'users', 'action' => 'myProfile'));
        }
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