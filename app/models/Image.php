<?php
    class Image {
        private $db;
        private $table = "maher_images";

        const NO_IMAGE_FOUND_ERR = "no image found for the given id"; 

        public function __construct() {
            $this->db = new Database;
        }

        public function getAll() {
            try {
                $this->db->query("SELECT * FROM " . $this->table);
                $images = $this->db->resultset();
                return $images;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function create($imageInfo) {
            try {
                $this->db->query("INSERT INTO " . $this->table . "(image_url, title, album_id) VALUES(:image_url, :title, :album_id)");
                $this->db->bind("image_url", $imageInfo['image_url']);
                $this->db->bind("title", $imageInfo['title']);
                $this->db->bind("album_id", $imageInfo['album_id']);

                $this->db->execute();

                return true;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function getImagesByAlbumId($album_id) {
            try {
                $this->db->query("SELECT * FROM " . $this->table . " WHERE album_id = :album_id");
                $this->db->bind("album_id", $album_id);

                $images = $this->db->resultset();

                return $images;
            } catch(Exception $e) {
                $msg = $e->getMessage();
                die($msg);
            }
        }
    }