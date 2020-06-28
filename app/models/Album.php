<?php
    class Album {
        private $db;
        private $table = "maher_albums";

        const NO_ALBUM_FOUND_ERR = "no album found for the given id"; 

        public function __construct() {
            $this->db = new Database;
        }

        public function getAll() {
            try {
                $this->db->query("SELECT * FROM " . $this->table);
                $albums = $this->db->resultset();
                return $albums;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function create($albumInfo) {
            try {
                $this->db->query("INSERT INTO " . $this->table . "(title, description, cover_image, user_id) VALUES(:title, :description, :cover_image, :user_id)");
                $this->db->bind("title", $albumInfo['title']);
                $this->db->bind("description", $albumInfo['description']);
                $this->db->bind("cover_image", $albumInfo['cover_image']);
                $this->db->bind("user_id", $albumInfo['user_id']);

                $this->db->execute();

                return true;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function getAlbumById($id) {
            try {
                $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id");
                $this->db->bind("id", $id);

                $foundAlbum = $this->db->single();

                if(!$foundAlbum) {
                    throw new Exception(self::NO_ALBUM_FOUND_ERR);
                }

                return $foundAlbum;
            } catch(Exception $e) {
                $msg = $e->getMessage();
                if($msg === self::NO_ALBUM_FOUND_ERR) {
                    throw $e;
                } else {
                    die($msg);
                }
            }
        }
    }