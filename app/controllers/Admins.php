<?php
    class Admins extends Controller {

        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            if(!isAdmin()) {
                die("401 not allowed");
            }
            if(!userIsActivated()) {
                redirectNotActivatedUsers();
            }
        }

        public function index() {
            redirect('admins/statistics');
        }

        public function users() {
            $users = $this->model("User")->getAllUsers();
            $statistics = $this->model("User")->getUsersStatistics();
            $data = [
                'users' => $users
            ];
            $this->view('admins/users', $data);
        }

        public function statistics() {
            $statistics = $this->model("User")->getUsersStatistics();
            $data = [
                'statistics' => $statistics
            ];
            $this->view('admins/statistics', $data);
        }

        public function activate($userId) {
            $this->model("User")->updateUserActivationStatus(true, $userId);
        }

        public function deactivate($userId) {
            $this->model("User")->updateUserActivationStatus(false, $userId);
        }
    }