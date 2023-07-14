<?php
App::uses('AppController', 'Controller');
App::uses('Router', 'Routing');
App::uses('AuthComponent', 'Controller/Component');

class UsersController extends AppController {
    public $uses = array('Users', 'Login', 'Profile', 'Account');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->baseUrl = Router::url('/', true);
        $this->Auth->allow('login', 'logout', 'register', 'registerUser', 'authenticate', 'thankyou', 'myProfile', 'editProfile', 'updateProfile', 'account', 'updateAccount');
    }

    public function thankyou(){
        $this->set('baseUrl', $this->baseUrl);
        $this->render('/Pages/thankyou');
    }

    public function myProfile(){
        $userId = $this->Session->read('user');
        $user = $this->Users->findByUserId($userId);
        $this->set('user', $user);
        $this->set('baseUrl', $this->baseUrl);
        $this->render('/Pages/myProfile');
    }

    public function account(){
        $userId = $this->Session->read('user');
        $user = $this->Users->findByUserId($userId);
        $this->set('user', $user);
        $this->render('/Pages/account');
    }

    public function editProfile(){
        $userId = $this->Session->read('user');
        $user = $this->Users->findByUserId($userId);
        $this->set('user', $user);
        $this->set('baseUrl', $this->baseUrl);
        $this->render('/Pages/editProfile');
    }

    public function updateAccount(){
        $userId = $this->Session->read('user');
        if ($this->request->is("post")) {
            $data = array(
                'email' => $this->request->data['email'],
                'own_email' => $this->request->data['own_email'],
                'password' => $this->request->data['password'],
                'cpwd' => $this->request->data['cpwd']
            );
            
            // Set the data to the model and validate
            $this->Account->set($data);
            
            if ($this->Account->validates()) {
                // Hash the password
                $passwordHash = Security::hash($this->request->data['password'], null, true);
    
                // Construct the raw SQL query
                $query = "UPDATE users SET email = '{$this->request->data['email']}', password = '{$passwordHash}' WHERE user_id = {$userId}";
                
                // Execute the raw query
                $this->Account->query($query);
    
                $response = array('status' => 'success', 'message' => 'Profile updated successfully.');
            } else {
                // Echo validation errors
                $errors = $this->Account->validationErrors;
                $response = array('status' => 'error', 'errors' => $errors);
            }
    
            echo json_encode($response);
        }
        $this->autoRender = false;
    }
    
    public function updateProfile(){
        if ($this->request->is("post")) {
            // Get the session user ID
            $userId = $this->Session->read('user');

            // Prepare the data to update
            $data = array(
                'name' => $this->request->data['name'],
                'birthdate' => $this->request->data['birthdate'],
                'gender' => $this->request->data['gender'],
                'hubby' => $this->request->data['hubby']
            );

            // Check if a photo was uploaded
            if (!empty($_FILES['upload-profile']['name'])) {
                $photoPath = 'profile_photos/'; // Set the path to the profile_photos folder
                $photoName = $_FILES['upload-profile']['name'];
                $fileExtension = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));

                // Generate a unique filename
                $uniqueFileName = time() . '_' . mt_rand() . '.' . $fileExtension;

                $targetPath = WWW_ROOT . $photoPath . $uniqueFileName;
                $tmpPath = $_FILES['upload-profile']['tmp_name'];

                // Define the allowed extensions
                $allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');

                // Move the uploaded photo to the target path
                if (in_array($fileExtension, $allowedExtensions)) {
                    if (move_uploaded_file($tmpPath, $targetPath)) {
                        // Photo moved successfully, update the photo field in the $data array
                        $data['photo'] = $uniqueFileName;
                    } else {
                        // Failed to move the photo
                        $response = array('status' => 'error', 'errors' => array('photo' => array('Failed to upload photo.')));
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = array('status' => 'error', 'errors' => array('format' => array('Invalid file format.')));
                    echo json_encode($response);
                    exit;
                }
            }

            // Set the data to the model and validate
            $this->Profile->set($data);
            if ($this->Profile->validates()) {
                // Construct the raw SQL query
                $query = "UPDATE users SET ";
                foreach ($data as $field => $value) {
                    $query .= "{$field} = '{$value}', ";
                }
                $query = rtrim($query, ', ');
                $query .= " WHERE user_id = {$userId};";

                // Execute the raw query
                $this->Profile->query($query);

                $response = array('status' => 'success', 'message' => 'Profile updated successfully.');
            } else {
                // Echo validation errors
                $errors = $this->Profile->validationErrors;
                $response = array('status' => 'error', 'errors' => $errors);
            }

            echo json_encode($response);
        }

        $this->autoRender = false;
    }

    public function authenticate() {
        if ($this->request->is("post")) {
            $date = new DateTime("now", new DateTimeZone("Asia/Manila"));
            $email = $this->request->data["email"];
            $password = $this->request->data["password"];
    
            $this->Login->set($this->request->data); // Set the model data for validation
            if ($this->Login->validates()) { // Perform model validation
                $user = $this->Users->findByEmail($email);
                if (!empty($user)) {
                    // Verify the password
                    if ($user['Users']["password"] === Security::hash($password, "sha1", true)) {
                        // Update last_login using raw query
                        $userId = $user['Users']['user_id'];
                        $lastLogin = $date->format("Y-m-d H:i:s");;
                        $query = "UPDATE users SET last_login = '{$lastLogin}' WHERE user_id = {$userId}";
                        $this->Users->query($query);

                        $response = array('status' => 'success');
                        $this->Session->write('user', $user['Users']['user_id']);
                    } else {
                        $response = array('status' => 'error', 'errors' => array('password' => array('Invalid password.')));
                    }
                } else {
                    $response = array('status' => 'error', 'errors' => array('email' => array('User does not exist.')));
                }
            } else {
                // Echo validation errors
                $errors = $this->Login->validationErrors;
                $response = array('status' => 'error', 'errors' => $errors);
            }
    
            echo json_encode($response);
        }
        $this->autoRender = false;
    }    


    public function register(){
        $this->set('baseUrl', $this->baseUrl);
        $this->render('/Pages/register');
    }

    public function registerUser(){
        if ($this->request->is('post')) {
            $date = new DateTime("now", new DateTimeZone("Asia/Manila"));
            $this->Users->set($this->request->data); // Set the model data for validation
            if ($this->Users->validates()) { // Perform model validation
                $this->request->data['Users']['date_created'] = $date->format("Y-m-d H:i:s"); // Set the date_created field

                if ($this->Users->save($this->request->data)) { // Save the data
                    $response = array('status' => 'success', 'message' => 'Registration successful.');
                } else {
                    $response = array('status' => 'error', 'message' => 'Failed to save user data.');
                }
            } else {
                // Echo validation errors
                $errors = $this->Users->validationErrors;
                $response = array('status' => 'error', 'errors' => $errors);
            }

            echo json_encode($response);
        }

        $this->autoRender = false;
    }

    public function logout() {
        $this->Session->delete('user'); 
        return $this->redirect($this->Auth->logout());
    }
}
