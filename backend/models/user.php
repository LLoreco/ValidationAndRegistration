<?php
    require_once __DIR__ . '/../database/database.php';
    class User{

        private $db;
        private $minPasswordLength = 6;
        private $logFile = __DIR__ . '/../logs/user_errors.log';

        public function __construct(){
            $database = new Database();
            $this->db = $database->connect();
        }

        public function register($username, $email, $password){

            if(empty($username) || empty($email) || empty($password)){
                $this->logError("Empty fields in registration");
                return ['success' => false, 'message' => 'You have empty fields'];
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->logError("Incorrect email in registration");
                return ['success' => false, 'message' => 'Incorrect email adress'];
            }
            if(strlen($password) < $this->minPasswordLength){
                $this->logError("Password is too short in registration");
                return ['success' => false, 'message' => 'Password is too short'];
            }

            $emailCheck = $this->checkEmail($email);
            if($emailCheck != null){
                return $emailCheck;
            }

            $hashedPassword = $this->hashPassword($password);
            try{
                if ($this->insertUser($username, $email, $hashedPassword)){
                    return ['success' => true, 'message' => 'Registration successful'];
                }
                else{
                    $this->logError("Registration failed stroke 40");
                    return ['success' => false, 'message' => 'Registration failed'];
            }
            } catch(PDOException $e){
                $this->logError("Database error stroke 44");
                return ['success' => false, 'message' => 'Database error:' . $e->getMessage()];
            }
            
        }
        public function login($email, $password){
            if(empty($email) || empty($password)){
                $this->logError("Empty fields in login");
                return ['success' => false, 'message' => 'You have empty fields'];
            }
            $this->fetchUser($email, $password);
        }
        private function checkEmail($email){
            try{
                $query = 'SELECT id FROM users WHERE email = :email';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->logError("Enail already registered in checkEmail()");
                    return ['success' => false, 'message' => 'Email already registered'];
                }
                return null;
            } catch (PDOException $e){
                $this->logError("Database error stroke 68");
                return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
            }

        }
        private function hashPassword($password){
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            return $hashPassword;
        }
        private function insertUser($username, $email, $password){
            try{
                $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->execute();
            } catch(PDOException $e){
                $this->logError("Database error stroke 86");
                return false;
            }
            
        }
        private function fetchUser($email, $password){
            try {
                $query = "SELECT id, email, password FROM users WHERE email = :email";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    return ['success' => true, 'message' => 'Login successful'];
                }
                return ['success' => false, 'message' => 'Invalid email or password'];
            } catch (PDOException $e) {
                $this->logError("Database error stroke 104");
                return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
            }
        }

        private function logError($message) {
            $timestamp = date('Y-m-d H:i:s');
            $logMessage = "[$timestamp] $message" . PHP_EOL;
            error_log($logMessage, 3, $this->logFile);
        }
    }
?>