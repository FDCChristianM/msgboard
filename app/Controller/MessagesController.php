<?php
App::uses('AppController', 'Controller');
App::uses('Router', 'Routing');
App::uses('AuthComponent', 'Controller/Component');

class MessagesController extends AppController
{
    public $uses = array('Message', 'Users', 'Reply');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->baseUrl = Router::url('/', true);
        $this->Auth->allow('listMessage', 'getMessages', 'showMore', 'deleteConvo', 'newMessage', 'getRecepient', 'sendMessage', 'viewMessage', 'getMessageDetail', 'deleteChat', 'sendReply');
    }

    public function getRecepient()
    {
        if ($this->request->is("get")) {
            $term = $_GET['searchTerm'];

            $query = "SELECT user_id, name, photo FROM users WHERE name LIKE '%{$term}%'";
            $users = $this->Users->query($query);
            $results = [];

            if (!empty($users)) {
                foreach ($users as $key => $value) {
                    $results['result'][$key]['text'] = $value['users']['name'];
                    $results['result'][$key]['id'] = $value['users']['user_id'];
                    $results['result'][$key]['image'] = $value['users']['photo'];
                }
            } else {
                $results['result'][0]['text'] = 'No User Found';
            }

            echo json_encode($results);
        }

        $this->autoRender = false;
    }

    public function deleteConvo()
    {
        if ($this->request->is("post")) {
            $userId = $this->Session->read('user');
            $otherId = $this->request->data['id'];

            // Delete messages query
            $query = "
                DELETE FROM messages
                WHERE (from_fk_user_id = :userId OR from_fk_user_id = :otherId)
                AND (to_fk_user_id = :userId OR to_fk_user_id = :otherId)
            ";

            // Bind parameters and execute the query
            $this->Message->query($query, array(
                'userId' => $userId,
                'otherId' => $otherId
            ));

            $this->autoRender = false;
        }
    }

    public function deleteChat(){
        if ($this->request->is("post")) {
            $msg_id = $this->request->data['id'];
            $query = "
            DELETE FROM messages
            WHERE message_id = :msg_id
            ";

            $this->Message->query($query , array('msg_id' => $msg_id));

            $this->autoRender = false;
        }
    }

    public function sendReply(){
        if ($this->request->is("post")) {
            $userId = $this->Session->read('user');
            $date = new DateTime("now", new DateTimeZone("Asia/Manila"));
        
            $data = array(
                'from_fk_user_id' => $userId,
                'to_fk_user_id' =>  $this->request->data['recepient'],
                'content'   => $this->request->data['content'],
                'date_sent' => $date->format("Y-m-d H:i:s")
            );

            $this->Reply->set($data); 
            if ($this->Reply->validates()){
                if($this->Reply->save($data)){
                    $response = array('status' => 'success', 'message' => 'Successfully sent.');
                }else{
                    $response = array('status' => 'error', 'message' => 'Failed to send reply.');
                }
            }else{
                $errors = $this->Reply->validationErrors;
                $response = array('status' => 'error', 'errors' => $errors);
            }
           

            echo json_encode($response);
        }
        $this->autoRender = false;
    }


    public function listMessage()
    {
        $userId = $this->Session->read('user');
        $user = $this->Users->findByUserId($userId);
        $this->set('user', $user);
        $this->set('baseUrl', $this->baseUrl);
        $this->render('/Pages/message');
    }

    public function viewMessage()
    {
        $userId = $this->Session->read('user');
        $user = $this->Users->findByUserId($userId);
        $this->set('user', $user);
        $this->set('baseUrl', $this->baseUrl);
        $this->render('/Pages/messageHistory');
    }


    public function newMessage()
    {
        $userId = $this->Session->read('user');
        $user = $this->Users->findByUserId($userId);
        $this->set('user', $user);
        $this->set('baseUrl', $this->baseUrl);
        $this->render('/Pages/newMessage');
    }

    public function getMessages($offset = 0, $limit = 4)
    {
        $userId = $this->Session->read('user');
        // Perform the raw query
        $query = "
            SELECT m.message_id, m.to_fk_user_id, m.from_fk_user_id, m.content, m.date_sent, 
                CASE
                    WHEN m.from_fk_user_id = :userId THEN u2.name
                    ELSE u1.name
                END AS name,
                CASE
                    WHEN m.from_fk_user_id = :userId THEN u2.photo
                    ELSE u1.photo
                END AS photo,
                CASE
                    WHEN m.from_fk_user_id = :userId THEN u2.user_id
                    ELSE u1.user_id
                END AS user_id
            FROM messages m
            LEFT JOIN users u1 ON m.from_fk_user_id = u1.user_id
            LEFT JOIN users u2 ON m.to_fk_user_id = u2.user_id
            WHERE (m.to_fk_user_id = :userId AND m.from_fk_user_id = :userId)
                OR (m.to_fk_user_id != m.from_fk_user_id AND (m.to_fk_user_id = :userId OR m.from_fk_user_id = :userId))
                AND (m.from_fk_user_id != :userId OR m.to_fk_user_id != :userId)
            ORDER BY m.date_sent DESC
        ";

        $messages = $this->Message->query($query, array('userId' => $userId));

        if (!empty($messages)) {
            $latestDates = [];
            foreach ($messages as $index => $message) {
                $user_id = $message[0]['user_id'];
                $date_sent = $message['m']['date_sent'];

                // Check if the user_id already exists in $latestDates
                if (isset($latestDates[$user_id])) {
                    $latestDate = $latestDates[$user_id]['date_sent'];

                    // Compare dates and update if the current date_sent is later
                    if ($date_sent > $latestDate) {
                        // Remove the previous entry from the array
                        unset($messages[$latestDates[$user_id]['index']]);
                        $latestDates[$user_id] = [
                            'date_sent' => $date_sent,
                            'index' => $index
                        ];
                    } else {
                        // Remove the current entry since it's a duplicate with an older date_sent
                        unset($messages[$index]);
                    }
                } else {
                    // Add the first occurrence of the user_id to $latestDates
                    $latestDates[$user_id] = [
                        'date_sent' => $date_sent,
                        'index' => $index
                    ];
                }
            }

            // Re-index the array
            $messages = array_values($messages);
            $renamedMessages = [];
            foreach ($messages as $index => $message) {
                foreach($message as $key => $value){
                    if($key == 'm'){
                        $renamedMessages[$index]['m'] = $value;
                    }else{
                        $renamedMessages[$index]['u'] = $value;
                    }
                }
            }

            $filteredMessages = $renamedMessages;
            $slicedMessages = array_slice($filteredMessages, $offset, $limit);
            $slicedMessagesLength = count($filteredMessages);

            // Prepare the response data
            $data = array();
            $data['messages'] = $slicedMessages;
            $data['offset'] = $offset;
            $data['limit'] = $limit;
            $data['length'] = $slicedMessagesLength;

            foreach ($data['messages'] as $key => $value) {
                $data['messages'][$key]['user'] = $userId;
            }

            echo json_encode($data);
        }else {
            echo json_encode(array());
        }

        
        $this->autoRender = false;
    }


    public function getMessageDetail($offset = 0, $limit = 4)
    {
        if ($this->request->is('post')) {
            $userId = $this->Session->read('user');
            $otherId = $this->request->data['id'];

            // Delete messages query
            $query = "
                SELECT m.*, u.name, u.photo, u.user_id FROM messages m
                LEFT JOIN users u ON m.from_fk_user_id = u.user_id
                WHERE (from_fk_user_id = :userId OR from_fk_user_id = :otherId)
                AND (to_fk_user_id = :userId OR to_fk_user_id = :otherId)
                ORDER BY date_sent DESC
            ";

            // Bind parameters and execute the query
            $messages = $this->Message->query($query, array(
                'userId' => $userId,
                'otherId' => $otherId
            ));

            $slicedMessages = array_slice($messages, $offset, $limit);
            $slicedMessagesLength = count($messages);

            $data['messages'] = $slicedMessages;
            $data['offset'] = $offset;
            $data['limit'] = $limit;
            $data['length'] = $slicedMessagesLength;

            foreach ($data['messages'] as $key => $value) {
                $data['messages'][$key]['user'] = $userId;
            }

            echo json_encode($data);

            $this->autoRender = false;
        }
    }

    public function sendMessage()
    {
        if ($this->request->is('post')) {
            $userId = $this->Session->read('user');
            $date = new DateTime("now", new DateTimeZone("Asia/Manila"));
            $this->Message->set($this->request->data);
            if ($this->Message->validates()) {
                $data = array(
                    'from_fk_user_id' => $userId,
                    'to_fk_user_id' => $this->request->data['recepient'],
                    'content' => $this->request->data['content'],
                    'date_sent' => $date->format("Y-m-d H:i:s")
                );

                if ($this->Message->save($data)) {
                    $response = array('status' => 'success', 'message' => 'Message sent.');
                } else {
                    $response = array('status' => 'error', 'message' => 'Failed to send message.');
                }
            } else {
                $errors = $this->Message->validationErrors;
                $response = array('status' => 'error', 'errors' => $errors);
            }

            echo json_encode($response);
        }
        $this->autoRender = false;
    }
}
