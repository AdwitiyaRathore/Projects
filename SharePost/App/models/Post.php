<?php
    class Post{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getPosts(){

            // here we are joining the two tables using inner join
            // through id...
            $this->db->query('SELECT *,
                            posts.id as postId,
                            users.id as userId,
                            posts.created_at as postCreated,
                            users.created_at as userCreated
                            FROM posts
                            INNER JOIN users
                            ON posts.user_id = users.id
                            ORDER BY posts.created_at DESC
                            ');

            $results = $this->db->resultSet();

            return $results;
        }

        public function addPost($data){
            $this->db->query('INSERT INTO posts (title, user_id, body) VALUES(:title, :user_id, :body)');
            
            // bind values...
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':body', $data['body']);

            // execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function getPostById($id){
            $this->db->query('SELECT * FROM posts WHERE id=:id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public function updatePost($data){
            $this->db->query('UPDATE posts SET title=:title, body=:body WHERE id=:id');
            
            // bind values...
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);

            // execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function deletePost($id){
            $this->db->query('DELETE FROM posts WHERE id = :id');
            
            // bind values...
            $this->db->bind(':id', $id);

            // execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function addReply($data){
            $this->db->query('INSERT INTO reply (sender_id, receiver_id, body) VALUES(:sender_id, :receiver_id, :body)');
            
            // bind values...
            $this->db->bind(':sender_id', $data['sender_id']);
            $this->db->bind(':receiver_id', $data['receiver_id']);
            $this->db->bind(':body', $data['body']);

            // execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function getReply($receiver_id){
            $this->db->query('SELECT *,
                            posts.id as postId,
                            reply.receiver_id as replyId,
                            posts.created_at as postCreated,
                            reply.sent_at as replySent
                            FROM posts
                            INNER JOIN reply
                            ON posts.user_id = reply.receiver_id
                            ORDER BY reply.sent_at DESC
                            ');

            // $this->db->bind(':receiver_id', $receiver_id);
            $results = $this->db->resultSet();

            return $results;
        }
    }