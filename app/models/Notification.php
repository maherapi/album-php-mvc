<?php
    class Notification {
        private $db;
        private $table = "maher_notifications";

        public function __construct() {
            $this->db = new Database;
        }

        public function create($notInfo) {
            try {
                $this->db->query("INSERT INTO " . $this->table . "(title, description, target_user) VALUES(:title, :description, :target_user)");
                $this->db->bind("title", $notInfo['title']);
                $this->db->bind("description", $notInfo['description']);
                $this->db->bind("target_user", $notInfo['target_user']);

                $this->db->execute();
            } catch (Exception $e) {
                if($e->getCode() == 23000) {
                    throw new Exception(self::USER_EXISTS_ERR);
                } else {
                    die($e->getMessage());
                }
            }
        }

        public function getUnreadNotificationsByUser($userId) {
            try {
                $this->db->query(
                    " SELECT *" .
                    " FROM " . $this->table .
                    " WHERE target_user = :userId" .
                    " AND read_status = 0"
                );
                $this->db->bind("userId", $userId);
                $notifications = $this->db->resultset();
                return $notifications;
            } catch(Exception $e) {
                die($msg);
            }
        }

        public function readNotificationsByUser($userId) {
            try {
                $this->db->query(
                    " UPDATE " . $this->table .
                    " SET read_status = 1" .
                    " WHERE target_user = :userId"
                );
                $this->db->bind("userId", $userId);
                $this->db->execute();
            } catch(Exception $e) {
                die($msg);
            }
        }
    }