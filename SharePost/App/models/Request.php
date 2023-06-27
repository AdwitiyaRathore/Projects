<?php 
    class Request{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }
        
        public function friendRequest($data){

            $this->db->query('INSERT INTO requests (sender_id, receiver_id) VALUES (:sender_id, :receiver_id )');

            $this->db->bind(':sender_id', $data['sender_id']);
            $this->db->bind(':receiver_id', $data['receiver_id']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
        
        // here the error was instead of assigning I was comparing...
        // we needed to check if the data is prasent in the table...
        // hence we assign the value with "="...

        // to check if the session user is already following the second user...
        public function isFollowing($data){
            $this->db->query('SELECT * FROM requests WHERE (receiver_id = :receiver_id AND sender_id = :sender_id)');

            $this->db->bind(':sender_id', $data['sender_id']);
            $this->db->bind(':receiver_id', $data['receiver_id']);
            $result = $this->db->single();
            
            return $result;
        }

        // to check if the second user is already following the session user...
        public function areFriends($data){
            $this->db->query('SELECT * FROM requests WHERE 
                                                    (receiver_id = :sender_id AND sender_id = :receiver_id) 
                                                    AND (receiver_id = :receiver_id AND sender_id = :sender_id)');

            $this->db->bind(':sender_id', $data['sender_id']);
            $this->db->bind(':receiver_id', $data['receiver_id']);
            $result = $this->db->single();
            
            return $result;
        }

        // unfollow a user...
        public function unfriend($data){
            $this->db->query('DELETE FROM requests WHERE (receiver_id = :receiver_id AND sender_id = :sender_id)');

            $this->db->bind(':sender_id', $data['sender_id']);
            $this->db->bind(':receiver_id', $data['receiver_id']);

            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function show(){

            $this->db->query('SELECT *,
                            users.id as userId,
                            requests.receiver_id as requestId,
                            users.created_at as userCreated,
                            requests.sent_at as requestsSent
                            FROM users
                            INNER JOIN requests
                            ON users.id = requests.receiver_id
                            ORDER BY users.created_at DESC
                            ');

            $results = $this->db->resultSet();

            return $results;
        }
    }