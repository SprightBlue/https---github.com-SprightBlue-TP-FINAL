<?php

    class Database {

        private $conn;

        public function __construct($host, $dbname, $username, $password) {
            try {
                $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
            }catch(Exception $e) {
                die("Connection failed: " . $e->getMessage());
            }     
        }

        public function getUser($username, $password) {
            $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE username=:username AND pass=:pass");
            $stmt->execute(array(":username"=>$username, ":pass"=>$password));
            if($stmt->rowCount()>0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
            }else {
                return false;
            }
        }

        public function createUser($fullname, $yearOfBirth, $gender, $country, $city, $email, $pass, $username, $profilePicture, $token, $active) {
            $stmt = $this->conn->prepare("INSERT INTO usuario(fullname, yearOfBirth, gender, country, city, email, pass, username, profilePicture, token, active)
            VALUES(:fullname, :yearOfBirth, :gender, :country, :city, :email, :pass, :username, :profilePicture, :token, :active)");
            $stmt->execute(array(":fullname"=>$fullname, ":yearOfBirth"=>$yearOfBirth, ":gender"=>$gender, ":country"=>$country,":city"=>$city, 
            ":email"=>$email, ":pass"=>$pass, ":username"=>$username, ":profilePicture"=>$profilePicture, ":token"=>$token, ":active"=>$active));
        }

        public function activeUser($token) {
            $stmt = $this->conn->prepare("UPDATE usuario SET active=1 WHERE token=:token");
            $stmt->execute(array(":token"=>$token));
        }

        public function deleteUser($id) {
            $stmt = $this->conn->prepare("DELETE FROM usuario WHERE id=:id");
            $stmt->execute(array(":id"=>$id));
        }

        public function updateUser($id, $fullname, $yearOfBirth, $gender, $country, $city, $email, $pass, $username, $profilePicture) {
            $stmt = $this->conn->preapre("UPDATE FROM usuario SET fullname=:fullname, yearOfBirth=:yearOfBirth, gender=:gender, country=:country,
            city=:city, email=:email, pass=:pass, username=:username, profilePicture=:profilePicture WHERE id=:id");
            $stmt->execute(array(":fullname"=>$fullname, ":yearOfBirth"=>$yearOfBirth, ":gender"=>$gender, ":country"=>$country, ":city"=>$city,
            ":email"=>$email, ":pass"=>$pass, ":username"=>$username, ":profilePicture"=>$profilePicture));
        }

        public function __destruct() {
            $this->conn = null;
        }

    }

?>