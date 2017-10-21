<?php
// Controller -- loads the models and views

class Controller {
    public function model($model){   // load modul
        // require model
        require_once "../app/models/" . $model .".php";
        // instantiate model
        return new $model();
    }

    public function view($view, $data = []){  // load view
        // check for view & load
        if(file_exists("../app/views/" . $view . ".php")){
            require_once "../app/views/" . $view . ".php";
        } else {
            die("View does not exist");
        }
    }
}