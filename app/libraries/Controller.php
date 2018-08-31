<?php
/*
 * Base controller
 * Loads the models and views
 */
class Controller {
    // Load model
    public function model($model){
        // require model file
        require_once '../app/models/' . $model . '.php';

        // Instatiate model
        return new $model();
    }

    // Load view
    // the $data array is the dynamic data passed in
    public function view($view, $data = []){
        // Check for the view file
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else {
            // view does not exist
            die('View does not exist');
        }
    }
} 