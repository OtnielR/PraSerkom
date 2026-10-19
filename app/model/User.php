<?php

class User {
    
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getUserByEmail(string $email){
        $query = "SELECT * FROM users WHERE email='{$email}'";
        $result = $this->db->conn->query($query);

        if (!$result ) {
            return false;
        }

        $user = $result->fetch_assoc();

        return $user;
    }

    public function create(string $username, string $email, string $password): bool{
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (username, email, password) VALUE ('{$username}', '{$email}', '{$hashedPassword}');";

        $result = $this->db->conn->query($query);




        if (!$result) {
            return false; 
        } 
        
        return true;
    }
}