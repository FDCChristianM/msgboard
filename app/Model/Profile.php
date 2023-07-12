<?php
App::uses('Security', 'Utility');

class Profile extends Model {
    public $useTable = 'users';
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Please enter your name.'
            ),
            'range' => array(
                'rule' => array('between', 5, 20),
                'required' => true,
                'message' => 'Name should be between 5 and 20 characters.'
            )
        ),
        'gender' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please select a gender.'
        ),
        'birthdate' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please set your birthdate.'
        ),
        'hubby' => array(
            'rule' => 'notBlank',
            'required' => true,
            'message' => 'Please set your hubby.'
        )
    );
}
