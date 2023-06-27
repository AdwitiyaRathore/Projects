<?php 
    class Requests extends Controller{

        public function __construct(){
            $this->requestModel = $this->Model('Request');
            $this->postModel = $this->Model('Post');
        }

        public function index(){
            //echo "you sent a friend request";
        }

        public function checkFriend($receiver_id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'sender_id' => $_SESSION['user_id'],
                    'receiver_id' => $receiver_id,
                    'sender_id_err' => '',
                    'received_id_err' => ''
                ];

                if(empty($data['sender_id'])){
                    $data['sender_id_err'] = 'Please try again, some credencials are missing';
                }
                
                if(empty($data['receiver_id'])){
                    $data['received_id_err'] = 'There is some error, please try again later';
                }

                $follower = $this->requestModel->isFollowing($data);
                $friends = $this->requestModel->areFriends($data);
                
                if(empty($data['sender_id_err']) && empty($data['received_id_err'])){

                    if(!empty($follower)){
                        
                        flash('Request_message', 'You are already a follower!');
                        redirect('posts');
                    }
                    elseif(!empty($friends)){
                        flash('Request_message', 'You are already friends!');
                        redirect('posts');
                    }
                    else{
                        
                        if($this->requestModel->friendRequest($data)){
                            flash('Request_message', 'A friend request is sent!');
                            redirect('posts');
                        }
                        else{
                            die('something is wrong');
                        }
                    }
                }else{
                    $this->view('posts');
                }
                
            } 
            
        }

        public function unfollow($receiver_id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $data = [
                    'sender_id' => $_SESSION['user_id'],
                    'receiver_id' => $receiver_id
                ];

                $user_id = $_SESSION['user_id'];

                if($this->requestModel->unfriend($data)){
                    flash('Request_message', 'You unfollowed a user');
                    redirect('posts/show/$user_id');
                }else{
                    die('something went wrong');
                }
            }else{
                redirect('posts');
            }
        }

        public function showRequests(){

            $request = $this->requestModel->show();
            $data = [
                'request' => $request
            ];

            $this->view('requests/showRequests', $data);
        }
    }