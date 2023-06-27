<?php
    class Pages extends Controller{ // we excess controller.php to get 
        // Post from model or views from views...
        public function __construct(){

        }

        public function index(){

            if(isLoggedIn()){
                redirect('posts');
            }

            // by default called function...
            $data = [
                'title' => 'Welcome',
                'description' => 'SharePost is a site where you can connect to different people around the world, post stuff and your views'
            ];

            $this-> view('pages/index', $data);
        }
        
        public function about(){
            $data = [
                'title' => 'Here is everything you would like to know',
                'description' => 'App to share posts with other users.'
            ];
            $this-> view('pages/about', $data);
        }

    }
?>