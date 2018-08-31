<?php 
    /*
     * App Core Class
     * Create URL & loads core controller
     * URL FORMAT - /controller/method/prarams
    */
    class Core {
        // $currentController and $currentMethod will change when our url changes
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            //$this->getUrl();
            
            // This will print out our url in the format we defined in getUrl() method. 
            // ex.Array ( [0] => posts [1] => edit [2] => 1 [3] => 22 )
            //print_r($this->getUrl()); 

            $url =$this->getUrl();

            

            // Look in controllers for first value
            // Because everything is redirected through index.php in public folder, 
            // we have to access other files or folders from that level.
            // Thus, here we have to use two '.' to access app/controllers.
            if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
                // If exists, set as controller
                $this->currentController = ucwords($url[0]);

                // Unset 0 index
                unset($url[0]);
            }

            // Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            // Instantiate controller class
            $this->currentController = new $this->currentController;

            // Check for the second part of the url
            if(isset($url[1])){
                // Check to see if method exists in controller
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    

                    // Unset 1 index
                    unset($url[1]);
                } 

                //$this->currentMethod = 'login';
            }

            // Get params
            $this->params = $url ? array_values($url) : [];

            // Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

        }

        public function getUrl(){

            /* Since we have put a place holder in our .htaccess file, 
            we can get any url params from our url address just after our root directory 
            instead of having all the '/index.php?url=' in the address bar. 
            In fact the url param is just the staff after the '=' in the original address. 
            But now, we can just use the url after our root directory. 
            It is the same param. Thus, we can get the url using global $_GET method.
            */
            if(isset($_GET['url'])){
                // rtrim method will trim whatever characters you desire from the end of a string.
                // In this case, it is the back slash at the end of our url.
                $url = rtrim($_GET['url'], '/');

                // the filter_var method will filter out any charaters that an url should not have.
                $url = filter_var($url, FILTER_SANITIZE_URL);

                // the explode method will break our url into different sections between each '/' and put them into an array.
                $url = explode('/', $url);

                return $url;
            }
        }
    }    