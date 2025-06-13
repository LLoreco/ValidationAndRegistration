<?php
require_once __DIR__ . '/../backend/models/user.php';

class AuthController{

    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function register(){
        header('Content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $result = $this->user->register($username, $email, $password);
        echo json_encode($result);
    }

    public function login(){
        header('Content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $result = $this->user->login( $email, $password);
        echo json_encode($result);
    }
}
?>