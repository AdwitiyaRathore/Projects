<?php 
    class Posts extends Controller{

        public function __construct(){
            // we are checking if the user has logged in...
            // if you want guest to enter the post then you need to put it in the 
            // method you want to protect...

            if(!isLoggedIn()){ //if the user is not logged in...
                // we used "isLoggedIn function from the helperUser to check if the user exists...
                 redirect('users/login');
            }

            $this->postModel = $this->Model('Post'); // in Libraries/controller.php we give model
            // function details of the model Post... 
            $this->userModel = $this->Model('User');
            $this->requestModel = $this->Model('Request');
        }
        public function index(){

            // Get Posts...
            $posts = $this->postModel->getPosts(); // from controller-> model fun-> models folder-> post.php... 
            
            $data = [
                'posts' => $posts
            ];
            $this->view('posts/index', $data);
        }

        public function add(){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // sanitize post array...
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '', 
                    'body_err' => ''
                ];

                // validate the title...
                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }

                // validate the body...
                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body text';
                }

                // make sure no errors...
                if(empty($data['title_err']) && empty($data['body_err'])){
                    // validated 
                    if($this->postModel->addPost($data)){
                        flash('post_message', 'Post Added');
                        redirect('posts');
                    }else{
                        die('Something went wrong');
                    }

                }else{
                    // load the view with errors
                    $this->view('posts/add', $data);
                }

            }else{
                // form data...
                $data = [
                    'title' => '',
                    'body' => ''
                ];

                $this->view('posts/add', $data);
            }
        }

        public function edit($id){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // sanitize post array...
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '', 
                    'body_err' => ''
                ];

                // validate the title...
                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }

                // validate the body...
                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body text';
                }

                // make sure no errors...
                if(empty($data['title_err']) && empty($data['body_err'])){
                    // validated 
                    if($this->postModel->updatePost($data)){
                        flash('post_message', 'Post Updated');
                        redirect('posts');
                    }else{
                        die('Something went wrong');
                    }

                }else{
                    // load the view with errors
                    $this->view('posts/edit', $data);
                }

            }else{
                // get existing post from model...
                $post = $this->postModel->getPostById($id);

                // check for owner...
                if($post->user_id != $_SESSION['user_id']){
                    redirect('posts');
                }
                // form data...
                $data = [
                    'id' => $id,
                    'title' => $post->title,
                    'body' => $post->body
                ];

                $this->view('posts/edit', $data);
            }
        
        }

        public function show($id){

            $post = $this->postModel->getPostById($id);
            // we want the name of the user from the user table hence we are 
            // using userModel instead of making a join... and passing the 
            // value of the post-> id we want to get...
            $user = $this->userModel->getUserById($post->user_id);

            $sender_id = $_SESSION['user_id'];
            // $receiver_id = $this->requestModel->getIntoById($post->user_id, $sender_id);
            $receiver_id = $post->user_id;

            $requestData = [
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $post->id
            ];
            $follower = $this->requestModel->isFollowing($requestData);

            $data = [
                'post' => $post,
                'user' => $user,
                // 'follower' => $follower
            ];

            $this->view('posts/show', $data);
        }

        public function delete($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get existing post from the model...
                $post = $this->postModel->getPostById($id);

                // check for owner...
                if($post->user_id != $_SESSION['user_id']){
                    redirect('posts');
                }

                if($this->postModel->deletePost($id)){
                    flash('post_message', 'Post Removed');
                    redirect('posts');
                }else{
                    die('something went wrong');
                }
            }else{
                redirect('posts');
            }
        }

// ********************************************************Reply**********************************************
        public function reply($id){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // sanitize post array...
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data = [
                    'id' => $id,
                    'body' => trim($_POST['body']),
                    'sender_id' => $_SESSION['user_id'],
                    'receiver_id' => $id,
                    'body_err' => ''
                ];

                // validate the body...
                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body text';
                }

                // make sure no errors...
                if(empty($data['body_err'])){
                    // validated 
                    if($this->postModel->addReply($data)){
                        flash('reply_message', 'reply posted');
                        redirect('posts');
                    }else{
                        die('Something went wrong');
                    }

                }else{
                    // load the view with errors
                    $this->view('posts/reply', $data);
                }

            }else{
                // get existing post from model...
                $post = $this->postModel->getPostById($id);
                // form data...
                $data = [
                    'body' => '',
                    'receiver_id' => $id,
                ];

                $this->view('posts/reply', $data);
            }
        
        }
        
        public function showReply($id){

            $reply = $this->postModel->getReply($id);
            $post_id = $this->postModel->getPostById($id);

            $data = [
                'reply' => $reply,
                'post_id' => $post_id
            ];

            $this->view('posts/showReply', $data);

        }
}