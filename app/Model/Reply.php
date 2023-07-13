<?php

class Reply extends Model {
    public $useTable = 'messages';
    public $validate = array(
        'content' => array(
            'notEmpty' => array(
                'rule' => 'notBlank',
                'required' => true,
                'message' => 'Message is blank.'
            )
        )

    );
}
