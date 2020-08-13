<?php
    class Notifications extends Controller {

        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            if(!userIsActivated()) {
                redirectNotActivatedUsers();
            }
        }

        public function index() {
            $userId = $_SESSION['user_id'];
            if(!isset($userId)) {
                die("no user id provided");
            }
            $notifications = $this->model("Notification")->getUnreadNotificationsByUser($userId);
            echo json_encode(['notifications' => $notifications, 'count' => count($notifications)]);
        }

        public function read() {
            $userId = $_SESSION['user_id'];
            if(!isset($userId)) {
                die("no user id provided");
            }
            $notifications = $this->model("Notification")->readNotificationsByUser($userId);
        }
    }