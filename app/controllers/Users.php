<?php
    class Users extends Controller {

        public function login() {
            if(isLoggedIn()) {
                redirect('albums');
            }
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':
                    $this->loginView();
                    break;
                case 'POST':
                    $this->loginAction();
                    break;
            }
        }
        
        public function register() {
            if(isLoggedIn()) {
                redirect('albums');
            }
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':
                    $this->registerView();
                    break;
                case 'POST':
                    $this->registerAction();
                    break;
            }
        }

        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_username']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect('users/login');      
        }
        
        public function loginView() {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
                'error' => false
            ];
            $this->view('users/login', $data);
        }

        public function loginAction() {
            if(!$this->validateLoginForm()) {
                return;
            }
            $creds = [
                "email" => $_POST['email'],
                "password" => $_POST['password']
            ];
            try {
                $model = $this->model("User");
                $createdUser = $model->login($creds);
                $this->createUserSession($createdUser);
                redirect('albums');
            } catch (Exception $e) {
                flash("login_faild", $e->getMessage(), "alert alert-danger");
                $data = [
                    "email" => $_POST['email'],
                    "password" => $_POST['password'],
                    'email_err' => '',
                    'password_err' => '',
                    'error' => true
                ];
                $this->view('users/login', $data);
            }
        }

        public function registerView() {
            $data = [
                'name' => '',
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'error' => false
            ];
            $this->view('users/register', $data);
        }

        public function registerAction() {
            if(!$this->validateRegisterForm()) {
                return;
            }
            $userInfo = [
                "name" => $_POST['name'],
                "username" => $_POST['username'],
                "email" => $_POST['email'],
                "password" => $_POST['password']
            ];
            try {
                $model = $this->model("User");
                $createdUser = $model->register($userInfo);
                $this->createUserSession($createdUser);
                redirect('albums');
            } catch (Exception $e) {
                flash("register_faild", $e->getMessage(), "alert alert-danger");
                $data = [
                    "name" => $_POST['name'],
                    "username" => $_POST['username'],
                    "email" => $_POST['email'],
                    "password" => $_POST['password'],
                    'confirm_password' => $_POST['confirm_password'],
                    'name_err' => '',
                    'username_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                    'error' => true
                ];
                $this->view('users/register', $data);
            }
        }

        private function validateLoginForm() {
            $errors = [
                'email_err' => $this->validateEmail($_POST['email']),
                'password_err' => $this->validatePassword($_POST['password'])
            ];
            $data = [];
            $hasError = false;
            foreach($errors as $error => $msg) {
                $data[$error] = $msg;
                if($msg !== '') {
                    $hasError = true;
                }
            }
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['error'] = $hasError;
            if($hasError) {
                $this->view('users/login', $data);
                return false;
            } else {
                return true;
            }
        }

        private function validateRegisterForm() {
            $errors = [
                'name_err' => $this->validateName($_POST['name']),
                'username_err' => $this->validateUsername($_POST['username']),
                'email_err' => $this->validateEmail($_POST['email']),
                'password_err' => $this->validatePassword($_POST['password']),
                'confirm_password_err' => $this->validateConfirmPassword($_POST['password'], $_POST['confirm_password'])
            ];
            $data = [];
            $hasError = false;
            foreach($errors as $error => $msg) {
                $data[$error] = $msg;
                if($msg !== '') {
                    $hasError = true;
                }
            }
            $data['name'] = $_POST['name'];
            $data['username'] = $_POST['username'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['confirm_password'] = $_POST['confirm_password'];
            $data['error'] = $hasError;
            if($hasError) {
                $this->view('users/register', $data);
                return false;
            } else {
                return true;
            }
        }

        private function validateName($name) {
            if(!isset($name) || $name === null || $name === '') {
                return "name is required";
            }
            $name = str_replace(" ", "", strtolower($name));
            if(!filter_var($name, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/[a-z]*/"]])) {
                return "not a valid name (must contains letters only)";
            }
            return '';
        }

        private function validateUsername($username) {
            if(!isset($username) || $username === null || $username === '') {
                return "username is required";
            }
            $username = strtolower($username);
            if(!filter_var($username, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/[a-z]*/"]])) {
                return "not a valid username (must contains letters only)";
            }
            return '';
        }

        private function validateEmail($email) {
            if(!isset($email) || $email === null || $email === '') {
                return "email is required";
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "not a valid email";
            }
            return '';
        }

        private function validatePassword($password) {
            if(!isset($password) || $password === null || $password === '') {
                return "password is required";
            }
            return '';
        }

        private function validateConfirmPassword($password, $confirm) {
            if($password !== $confirm) {
                return "password does not match";
            }
            return '';
        }

        private function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_username'] = $user->username; 
            $_SESSION['user_email'] = $user->email; 
            $_SESSION['user_name'] = $user->name;
        }
    }