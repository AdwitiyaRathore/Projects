<?php
    class User{
        private $db;

        public function __construct(){
            $this->db = new Database; // the Database class is from database.php
        }

        // register user
        public function register($data){
            $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
            
            // bind values...
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);

            // execute
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        // Login user...
        public function login($email, $password){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            $hashed_password = $row->password; // get hashed password from the database...
            if(password_verify($password, $hashed_password)){
                return $row;
            } else{
                return false;
            }
        }

        // find user by email...
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');
            
            // bind values...
            $this->db->bind(':email', $email); // bind email parameter to the email variable...

            $row = $this->db->single(); // this will give us the data...
            
            // check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        // find user by id...
        public function getUserById($id){
            $this->db->query('SELECT * FROM users WHERE id = :id');
            
            // bind values...
            $this->db->bind(':id', $id); // bind email parameter to the email variable...

            $row = $this->db->single(); // this will give us the data...
            
            return $row;
        }

        public function numThere($password){
            $pass = $password;
            $isThereNum = false;
            for($i=0; $i<strlen($pass); $i++){
                if (ctype_digit($pass[$i])){
                    $isThereNum = true;
                    break;
                }
            }

            return $isThereNum;
        }

        public function capitalAlpha($password){
            $pass = $password;
            $i = 0;
            $present = false;
            for($i; $i<strlen($pass); $i++){
                if(ord($pass[$i]) >= 65 && ord($pass[$i])<=90){
                    $present = true;
                    break;
                }
            }
            return $present;
        }

        public function smallAlpha($password){
            $pass = $password;
            $i = 0;
            $present = false;
            for($i; $i<strlen($pass); $i++){
                if(ord($pass[$i]) >= 97 && ord($pass[$i])<=122){
                    $present = true;
                    break;
                }
            }
            return $present;
        }
    }
    // we work from our controller to our models to our database library.