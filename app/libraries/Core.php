<?php
    class Core {

        private $url;
        private $currentController = 'Pages';
        private $currentMethod = 'index';
        private $params = [];

        public function __construct() {
            // CORE
            $this->getUrl();
            $this->getController();
            $this->getMethod();
            $this->getParams();

            // MIDDLEWARES
            $this->middlewares();

            // HANDLE REQUEST
            $this->initController();
            $this->callMethod();
        }

        public function getUrl() {
            if(!isset($_GET['url'])) {
                return;
            }
            $url = $_GET['url'];
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $this->url = $url;
        }

        public function getController() {
            if(!isset($this->url[0])) {
                return;
            }
            $this->currentController = $this->url[0];
            unset($this->url[0]);
        }

        public function getMethod() {
            if(!isset($this->url[1])) {
                return;
            }
            $this->currentMethod = $this->url[1];
            unset($this->url[1]);
        }

        public function getParams() {
            if(!isset($this->url)) {
                return;
            }
            $this->params = array_values($this->url);
        }

        public function initController() {
            $controllerFile = '../app/controllers/' . ucwords($this->currentController) . '.php';
            try {
                if (!file_exists($controllerFile)) {
                    throw new Exception ('404 page not found');
                }
                require_once '../app/controllers/' . ucwords($this->currentController) . '.php';
                $this->currentController = new $this->currentController;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function callMethod() {
            try {
                if (!method_exists($this->currentController, $this->currentMethod)) {
                    throw new Exception ('404 page not found');
                }
                call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
            } catch (ArgumentCountError $e) {
                die("400, too few parameters");
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function middlewares() {
            require_once '../app/middlewares/all_middlewares.php';
        }
    }