<?php
    class Images extends Controller {

        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }
        }

        public function index() {
            redirect('albums');
        }

        public function upload($album_id) {
            $this->checkAlbumOwner($album_id);
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'POST':
                    $this->uploadAction($album_id);
                    break;
            }
        }

        public function uploadAction($album_id) {
            if(count($_FILES['images']['name']) <= 0) {
                die('there is no images');
            }
            if(count($_FILES['images']['name']) > 5) {
                die('only 5 images is allowed');
            }
            for ($i=0; $i < count($_FILES['images']['name']); $i++) {
                $error = $this->validateImage('images', $i);
                if($error !== '') {
                    die($error);
                    continue;
                }
                $img_name = bin2hex(random_bytes(10));
                $tmp = explode('.', $_FILES['images']['name'][$i]);
                $file_ext = strtolower(end($tmp));
                $imageInfo = [
                    "image_url" => $img_name . '.' . $file_ext,
                    "album_id" => $album_id,
                    "title" => "some title"
                ];
                $created = $this->model("Image")->create($imageInfo);
                if(!$created) {
                    die("image not uploaded");
                }
                $file_tmp = $_FILES['images']['tmp_name'][$i];
                move_uploaded_file($file_tmp, IMAGES_URL . "/" . $img_name . '.' . $file_ext);
            }
            redirect('albums/album/' . $album_id);
        }

        public function validateImage($name, $index, $size = 2) {
            $errors = array();

            if(!isset($_FILES[$name]['name'][$index]) || empty($_FILES[$name]['name'][$index])) {
                $errors[] = 'no image';
                return $errors[0];
            }

            $file_name = $_FILES[$name]['name'][$index];
            $file_size = $_FILES[$name]['size'][$index];
            $file_tmp = $_FILES[$name]['tmp_name'][$index];
            $file_type = $_FILES[$name]['type'][$index];
            $tmp = explode('.', $file_name);
            $file_ext = strtolower(end($tmp));
            
            $extensions = array("jpeg","jpg","png");
            
            if(in_array($file_ext,$extensions) === false){
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }
            
            if($file_size > ($size * 1024 * 1024)) {
                $errors[] = 'File size must be less than ' . $size . ' MB';
            }

            if(count($errors) <= 0 ) {
                return '';
            } else {
                return $errors[0];
            }
        }

        public function checkAlbumOwner($album_id) {
            try {
                $album = $this->model("Album")->getAlbumById($album_id);
                if($album->user_id != $_SESSION['user_id']) {
                    die("403 forbidden");
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }

        }
    }