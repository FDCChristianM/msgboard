<?php

class Message extends Model {
    public $useTable = 'messages';
    public $validate = array(
        'recepient' => array(
            'notEmpty' => array(
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Please set your recepient'
            )
        ),
        'content' => array(
            'notEmpty' => array(
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Message is blank.'
            )
        )

    );
}
