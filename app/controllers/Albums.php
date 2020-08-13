<?php
    class Albums extends Controller {

        public function __construct() {
            if(!isLoggedIn()) {
                redirect('users/login');
            }
            if(isAdmin()) {
                redirect('admins');
            }
            if(!userIsActivated()) {
                redirectNotActivatedUsers();
            }
        }

        public function index() {
            $albums = $this->model("Album")->getAll();
            $data = [
                'albums' => $albums
            ];
            $this->view('albums/index', $data);
        }

        public function create() {
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':
                    $this->createView();
                    break;
                case 'POST':
                    $this->createAction();
                    break;
            }
        }

        public function album($id) {
            try {
                $album = $this->model("Album")->getAlbumById($id);
                $images = $this->model("Image")->getImagesByAlbumId($id);
                $album->images = $images;
                $data = [
                    "album" => $album
                ];
                $this->view('albums/album', $data);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function createView() {
            $data = [
                'title' => '',
                'description' => '',
                'title_err' => '',
                'description_err' => '', 
                'cover_image_err' => '',
                'error' => false
            ];
            $this->view('albums/create', $data);
        }

        public function createAction() {
            if(!$this->validateCreateAlbumForm()) {
                return;
            }
            $cover_img_name = bin2hex(random_bytes(10));
            $tmp = explode('.', $_FILES['cover_image']['name']);
            $file_ext = strtolower(end($tmp));
            $albumInfo = [
                "title" => $_POST['title'],
                "description" => $_POST['description'],
                "cover_image" => $cover_img_name . '.' . $file_ext,
                "user_id" => $_SESSION['user_id']
            ];
            $created = $this->model("Album")->create($albumInfo);
            if(!$created) {
                die("album not created");
            }
            $file_tmp = $_FILES['cover_image']['tmp_name'];
            move_uploaded_file($file_tmp, COVERS_URL . "/" . $cover_img_name . '.' . $file_ext);
            redirect('albums');
        }

        public function validateCreateAlbumForm() {
            $errors = [
                'title_err' => $this->validateTitle($_POST['title']),
                'description_err' => $this->validateDescription($_POST['description']),
                'cover_image_err' => $this->validateImage('cover_image')
            ];
            $data = [];
            $hasError = false;
            foreach($errors as $error => $msg) {
                $data[$error] = $msg;
                if($msg !== '') {
                    $hasError = true;
                }
            }
            $data['title'] = $_POST['title'];
            $data['description'] = $_POST['description'];
            $data['error'] = $hasError;
            if($hasError) {
                $this->view('albums/create', $data);
                return false;
            } else {
                return true;
            }
        }

        public function validateImage($name, $size = 2) {
            $errors = array();

            if(!isset($_FILES[$name]) || empty($_FILES[$name]['name'])) {
                $errors[] = "image is required";
                return $errors[0];
            }

            $file_name = $_FILES[$name]['name'];
            $file_size = $_FILES[$name]['size'];
            $file_tmp = $_FILES[$name]['tmp_name'];
            $file_type = $_FILES[$name]['type'];
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

        private function validateTitle($title) {
            if(!isset($title) || $title === null || $title === '') {
                return "title is required";
            }
            return '';
        }

        private function validateDescription($description) {
            if(!isset($description) || $description === null || $description === '') {
                return "description is required";
            }
            return '';
        }
    }