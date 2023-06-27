<?php
    /*
    *PDO Database Class
    *Connect to database
    *Create prepared statements
    *Bind values
    *Return rows and results
    */
    class Database{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        // when ever we prepare statement we use database handler..
        private $dbh;
        // when we have the statement that also needs to have a property...
        private $stmt;
        // property for the error, if we have any error...
        private $error;

        
        public function __construct(){
            // Set DSN
            $dbh = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true, // we just want to persistent connection 
                // so this can increase performance by checking to see if thers's already a 
                // connection that's established with the database... 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // more elegent way to handle errors...

            );

            // create PDO instance...
            try{ // PDO instance...
                $this->dbh = new PDO($dbh, $this->user, $this->pass, $options);
            }
            
            catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this-> error;
            }
        }

        // prepare statement with query...
        // function or method to write queries...
        public function query($sql){

            $this->stmt = $this->dbh->prepare($sql); //A prepared statement is a feature used 
            //to execute the same (or similar) SQL statements repeatedly with high efficiency
        }

        // bind values
        public function bind($param, $value, $type=null){
            // we are going to bind the value and going to pass the  param 
            //which is going to be a name param then we pass whatever is passed as the value
            // then 3rd param is the type...

            if(is_null($type)){ // if is null then true and then we want to switch...
                switch(true){
                    case is_int($value): // if the value is int then...
                        $type = PDO::PARAM_INT;
                        break;
                    
                    case is_bool($value): 
                        $type = PDO::PARAM_BOOL;
                        break;
                    
                    case is_null($value): 
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }

        // execute the prepared statement...
        public function execute(){
            return $this->stmt->execute();
        }

        // get result set as array of objects 
        public function resultSet(){
            $this->execute(); // calling the execute function here...
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        } 

        // get single record as obj...
        public function single(){ 
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // get the row count...
        public function rowCount(){
            return $this->stmt->rowCount();
        }
    }
?>