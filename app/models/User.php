<?php
    class User {
        private $db;
        private $table = "maher_users";
        private $categoriesTable = "maher_user_category";

        const WRONG_CREDS_ERR = "wrong email or password"; 
        const WRONG_PASSWORD_ERR = "password does not match"; 
        const NO_USER_FOUND_ERR = "no user found for the given email"; 
        const USER_EXISTS_ERR = "user already exists"; 

        public function __construct() {
            $this->db = new Database;
        }

        public function register($userInfo) {
            try {
                $this->db->query("INSERT INTO " . $this->table . "(name, username, email, password, user_category) VALUES(:name, :username, :email, :password, :category)");
                $this->db->bind("name", $userInfo['name']);
                $this->db->bind("username", $userInfo['username']);
                $this->db->bind("email", $userInfo['email']);
                $hashedPassword = password_hash($userInfo['password'],  PASSWORD_DEFAULT);
                $this->db->bind("password", $hashedPassword);
                $this->db->bind("category", $userInfo['category']);

                $this->db->execute();

                $createdUser = $this->findUserByEmail($userInfo['email']);
                unset($createdUser->password);
                return $createdUser;
            } catch (Exception $e) {
                if($e->getCode() == 23000) {
                    throw new Exception(self::USER_EXISTS_ERR);
                } else {
                    die($e->getMessage());
                }
            }
        }

        public function login($userCreds) {
            try {
                $foundUser = $this->findUserByEmail($userCreds['email']);
                $match = password_verify($userCreds['password'], $foundUser->password);
                if(!$match) {
                    throw new Exception(self::WRONG_PASSWORD_ERR);
                }
                unset($foundUser->password);
                return $foundUser;
            } catch (Exception $e) {
                $msg = $e->getMessage();
                if($msg === self::WRONG_PASSWORD_ERR || $msg === self::NO_USER_FOUND_ERR) {
                    throw new Exception(self::WRONG_CREDS_ERR);
                } else {
                    die($msg);
                }
            }
        }

        public function findUserByEmail($email) {
            try {
                $this->db->query(
                    " SELECT u.id, name, username, email, password, created_at, user_category, category, is_admin, is_activated" .
                    " FROM " . $this->table . " u" .
                    " JOIN " . $this->categoriesTable . " c" .
                    " ON u.user_category = c.id" .
                    " WHERE email LIKE :email"
                );
                $this->db->bind("email", $email);
                $createdUser = $this->db->single();
                if(!$createdUser) {
                    throw new Exception(self::NO_USER_FOUND_ERR);
                }
                return $createdUser;
            } catch(Exception $e) {
                $msg = $e->getMessage();
                if($msg === self::NO_USER_FOUND_ERR) {
                    throw $e;
                } else {
                    die($msg);
                }
            }
        }

        public function getAllUsers() {
            try {
                $this->db->query(
                    " SELECT u.id, name, username, email, password, created_at, user_category, category, is_admin, is_activated" .
                    " FROM " . $this->table . " u" .
                    " JOIN " . $this->categoriesTable . " c" .
                    " ON u.user_category = c.id" .
                    " WHERE is_admin != 1"
                );
                $users = $this->db->resultset();
                return $users;
            } catch(Exception $e) {
                die($msg);
            }
        }

        public function updateUserActivationStatus($newStatus, $userId) {
            $status = 0;
            if($newStatus == true) {
                $status = 1;
            } else {
                $status = 0;
            }
            try {
                $this->db->query(
                    " UPDATE " . $this->table .
                    " SET is_activated = :status" .
                    " WHERE id = :userId"
                );
                $this->db->bind("status", $status);
                $this->db->bind("userId", $userId);
                $this->db->execute();
            } catch(Exception $e) {
                die($msg);
            }
        }

        public function getUsersStatistics() {
            try {
                $this->db->query(
                    " SELECT 'is_activated_' || is_activated AS activation_status, count(id) AS count" .
                    " FROM " . $this->table .
                    " WHERE is_admin != 1" .
                    " GROUP BY is_activated"
                );
                $usersStatistics = $this->db->resultset();
                foreach($usersStatistics as $stat) {
                    if($stat->activation_status === 'is_activated_1')
                        $activated_users = $stat->count;
                    if($stat->activation_status === 'is_activated_0')
                        $deactivated_users = $stat->count;
                }
                $data = [
                    'activated_users' => $activated_users,
                    'deactivated_users' => $deactivated_users
                ];
                return $data;
            } catch(Exception $e) {
                die($msg);
            }
        }

        public function getCategories() {
            try {
                $this->db->query("SELECT * FROM " . $this->categoriesTable);
                $categories = $this->db->resultset();
                return $categories;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function getCategoriesByParent($parentId = null) {
            try {
                $this->db->query("SELECT * FROM " . $this->categoriesTable . " WHERE parent_id IS :parentId");
                $this->db->bind("parentId", $parentId);
                $categories = $this->db->resultset();
                return $categories;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }