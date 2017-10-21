<?php
    // App Core Class
    // creates URL & loads core controller /controller/method/params
    class Core {

        protected $currentController = "Pages";
        protected $currentMethod = "index";
        protected $params = [];

        public function __construct(){
           // print_r($this->getUrl());
           $url = $this->getUrl();
           // Look in controller for first index
           if(file_exists("../app/controllers/" . ucwords($url[0]) . ".php")){
               // if exists then set as current controller
               $this->currentController = ucwords($url[0]);
               // unset Index 0
               unset($url[0]);
           }
           // require the Controller
           require_once "../app/controllers/" . $this->currentController . ".php";
           // Instantiate controller class
           $this->currentController = new $this->currentController;

           // Check second index of getUrl array
           if(isset($url[1])){
               // check if method exists in controller class
               if(method_exists($this->currentController, $url[1])){
                   $this->currentMethod = $url[1];
                   // unset Index 1
                   unset($url[1]);
               }
           }
           //get params from third index of getUrl array
           $this->params = $url ? array_values($url) : [];
           // callback with array of params
           call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

        }

        public function getUrl(){
            if(isset($_GET["url"])){
                $url = rtrim($_GET["url"], "/");
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode("/", $url);
                return $url;
            }
        }

    }