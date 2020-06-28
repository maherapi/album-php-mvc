<?php
    class User {
        private $db;
        private $table = "maher_users";

        const WRONG_CREDS_ERR = "wrong email or password"; 
        const WRONG_PASSWORD_ERR = "password does not match"; 
        const NO_USER_FOUND_ERR = "no user found for the given email"; 
        const USER_EXISTS_ERR = "user already exists"; 

        public function __construct() {
            $this->db = new Database;
        }

        public function register($userInfo) {
            try {
                $this->db->query("INSERT INTO " . $this->table . "(name, username, email, password) VALUES(:name, :username, :email, :password)");
                $this->db->bind("name", $userInfo['name']);
                $this->db->bind("username", $userInfo['username']);
                $this->db->bind("email", $userInfo['email']);
                $hashedPassword = password_hash($userInfo['password'],  PASSWORD_DEFAULT);
                $this->db->bind("password", $hashedPassword);

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
                $this->db->query("SELECT * FROM " . $this->table . " WHERE email LIKE :email");
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
    }