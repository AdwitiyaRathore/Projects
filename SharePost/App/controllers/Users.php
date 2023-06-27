<?php
  class Users extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
    }

//                                                REGISTER METHOD
//*********************************************************************************************************************

    public function register(){
        // check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // process form
            
            // sanitize Post data...
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // init data...
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // validation the email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }else{
                // check email...
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email is already taken';
                }
            }

            // validation the name
            if(empty($data['name'])){
                $data['name_err'] = 'Please enter name';
            }

            // validation the password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter email';
            }
            elseif(strlen($data['password']) < 6){
                $data['password_err'] = 'password must be atleast 6 characters';
            }
            elseif($this->userModel->numThere($data['password']) == false){
                $data['password_err'] = 'password must contain a number';
            }
            elseif($this->userModel->smallAlpha($data['password']) == false){
                $data['password_err'] = 'password must contain a small letter';
            }

            // validation the confirm_password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            }else{
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Password do no match';
                }
            }

            // make sure errors are empty...
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                // validation
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // register User
                if($this->userModel->register($data)) {// we are gonna call the function called register...
                // which takes all the data array...

                    flash('register_success', 'You are registered and can log in');
                // when the user is registered we want them to redirect to login page...
                // we our gonna load a funtion to load our new page in url_helper.php
                    redirect('users/login');
                }else{
                    die('Something went wrong');
                }
            }
            else{
                // load view with error...
                $this->view('users/register', $data);
            }

        }
        else{
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

        // load view
        $this->view('users/register', $data);
        }
    }

//                                              LOGIN METHOD
//*********************************************************************************************************************
    public function login(){
        // check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // process form

            // sanitize Post data...
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // init data...
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // validation the email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }

            // validation the password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }

            // check for user/email...
            if($this->userModel->findUserByEmail($data['email'])){
                // user found
                //die('success');
            }else{
                $data['email_err'] = 'No user found';
            }
            
            // make sure errors are empty...
            if(empty($data['email_err']) && empty($data['password_err'])){
                // validation
                //die('success');
                // check and set logged in user...
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if($loggedInUser){
                    // create session...
                    //die('success');
                    $this->createUserSession($loggedInUser);
                }else{
                    $data['password_err'] = 'Password incorrect';

                    $this->view('users/login', $data);
                }
            }
            else{
                // load view with error...
                $this->view('users/login', $data);
            }

        }
        else{
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            // load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;

        redirect('posts');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();
        redirect('users/login');
    }
}