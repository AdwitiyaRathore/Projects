<?php 
/*
-> base controller
-> loads the models and views
-> this will allow us to load models from our controller...
*/

class Controller{
    // load model...
    public function model($model){
        // require model file...
        require_once '../app/models/' . $model . '.php';

        // instantiate model...
        return new $model();
        
    }

    // load view
    public function view($view, $data = []){ // (pages.index, title)
        // check for view file...
        if (file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else{
            die('views does not exist!!');
        }
    }
}
?>