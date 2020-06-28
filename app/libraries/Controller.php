<?php
    class Controller {
        public function model($model) {
            $modelFile = '../app/models/' . $model . '.php';
            try {
                if(!file_exists($modelFile)){
                    throw new Exception('Model does not exist');
                } 
                require_once $modelFile;
                return new $model();
            } catch(Exception $e) {
                die($e->getMessage());
            }
        }
      
        public function view($url, $data = []) {
            $viewFile = '../app/views/'. $url .'.php';
            try {
                if(!file_exists($viewFile)){
                    throw new Exception('View does not exist');
                } 
                require_once $viewFile;
            } catch(Exception $e) {
                die($e->getMessage());
            }
        }
    }