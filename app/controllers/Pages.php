<?php
    class Pages extends Controller {
        public function __construct() {
            if(isLoggedIn()) {
                redirect('albums');
            }
        }

        public function index() {
            $data = [
                'title' => "Album"
            ];
            $this->view('pages/index', $data);
        }
    }