<?php
App::uses('AppController', 'Controller');
App::uses('Router', 'Routing');
App::uses('AuthComponent', 'Controller/Component');

class MessagesController extends AppController
{
    public $uses = array('Message', 'Users');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->baseUrl = Router::url('/', true);
        $this->Auth->allow('listMessage', 'getMessages', 'showMore', 'deleteConvo', 'newMessage', 'getRecepient');
    }

    private function checkSession()
    {
        if (CakeSession::check('user')) {
            return true;
        } else {
            $this->redirect(array('action' => 'index'));
            return false;
        }
    }

    public function getRecepient(){
        if ($this->request->is("get")) {
            $term = $_GET['searchTerm'];

            $query = "SELECT user_id, name FROM users WHERE name LIKE '%{$term}%'";
            $users = $this->Users->query($query);

            $results = [];
            foreach($users as $key => $value){
                $results['text'][$key] = $value['users']['name'];
            }
            echo '<pre>';
            print_r($results);
            exit;
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

    public function listMessage()
    {
        if ($this->checkSession()) {
            $userId = $this->Session->read('user');
            $user = $this->Users->findByUserId($userId);
            $this->set('user', $user);
            $this->set('baseUrl', $this->baseUrl);
            $this->render('/Pages/message');
        }
    }

    public function newMessage()
    {
        if ($this->checkSession()) {
            $userId = $this->Session->read('user');
            $user = $this->Users->findByUserId($userId);
            $this->set('user', $user);
            $this->set('baseUrl', $this->baseUrl);
            $this->render('/Pages/newMessage');
        }
    }

    public function getMessages($offset = 0, $limit = 4)
    {
        $userId = $this->Session->read('user');
        // Perform the raw query
        $query = "
        SELECT m.*, u.name, u.photo, u.user_id
        FROM messages m
        LEFT JOIN users u ON (m.from_fk_user_id = u.user_id OR m.to_fk_user_id = u.user_id)
        WHERE (m.to_fk_user_id = :userId AND m.from_fk_user_id = :userId)
            OR (m.to_fk_user_id != m.from_fk_user_id AND (m.to_fk_user_id = :userId OR m.from_fk_user_id = :userId))
            AND (m.from_fk_user_id != :userId OR m.to_fk_user_id != :userId)
        ORDER BY m.date_sent DESC
        ";
        $messages = $this->Message->query($query, array('userId' => $userId));

        // Format the date_sent field in each message
        foreach ($messages as &$message) {
            $message['m']['date_sent'] = date('F j, Y g:i A', strtotime($message['m']['date_sent']));
        }

        if (!empty($messages)) {
            // Filter the results to show only the latest message for each conversation
            $filteredMessages = array();
            $conversationIds = array();
            foreach ($messages as $message) {
                $conversationId = min($message['m']['to_fk_user_id'], $message['m']['from_fk_user_id']);
                if (!in_array($conversationId, $conversationIds)) {
                    $filteredMessages[] = $message;
                    $conversationIds[] = $conversationId;
                }
            }

            // Set offset and limit
            $slicedMessages = array_slice($filteredMessages, $offset, $limit);
            $slicedMessagesLength = count($filteredMessages);

            // Prepare the response data
            $data = array();
            $data['messages'] = $slicedMessages;
            $data['offset'] = $offset;
            $data['limit'] = $limit;
            $data['length'] = $slicedMessagesLength;

            echo json_encode($data);
        } else {
            echo json_encode(array());
        }

        $this->autoRender = false;
    }


    public function showMore()
    {
        $this->autoRender = false;
    }
}
