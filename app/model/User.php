<?php

class User
{

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getUserByEmail(string $email)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE email=?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if (!$result) {
            return false;
        }

        $user = $result->fetch_assoc();

        return $user;
    }

    public function create(string $username, string $email, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->conn->prepare("INSERT INTO users (username, email, password) VALUE (?, ?, ?)");

        $stmt->bind_param("sss", $username, $email, $hashedPassword);


        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

