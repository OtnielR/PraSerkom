<?php

class Database {

    public mysqli $conn;
    public User $userModel;

    public function __construct()
    {
        $this->conn = new mysqli(DB_SERVER, DB_USER_USERNAME, DB_USER_PASSWORD, DB_NAME);

        if ($this->conn->connect_error) {
            die("Koneksi error: " . $this->conn->connect_error);
        }

        $this->userModel = new User($this);

        $this->migrate();
        $this->seeder();
    }


    public function __destruct()
    {
        $this->conn->close();
    }

    public function migrate() {
        $queries = [
            "CREATE TABLE IF NOT EXISTS `users` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(50) NOT NULL,
                `email` VARCHAR(100) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS `events` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(100) NOT NULL,
                `category` ENUM('Music', 'Festival', 'Seminar') NOT NULL,
                `ticket_price` INT NOT NULL,
                `description` TEXT NOT NULL,
                `image` VARCHAR(100) NULL,
                `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS `orders` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `customer_name` VARCHAR(50) NOT NULL,
                `customer_email` VARCHAR(100) NOT NULL,
                `total_price` INT NOT NULL,
                `status` ENUM('Pending', 'Confirmed', 'Cancelled') NOT NULL,
                `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS `order_details` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `order_id` INT NOT NULL,
                `event_id` INT NOT NULL,
                `quantity` INT NOT NULL,
                `subtotal` INT NOT NULL,
                `timestamps` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
            );"
        ];

        foreach ($queries as $index => $query) {
            if (!$this->conn->query($query)) {
                die("Table with index " . $index . " failed to be created " . $this->conn->error);
            }
        }
    }

    private function seeder() {
        $isUserExist = $this->userModel->getUserByEmail(DEFAULT_ADMIN_EMAIL);
    
        if (!$isUserExist){
            $this->userModel->create(DEFAULT_ADMIN_USERNAME, DEFAULT_ADMIN_EMAIL, DEFAULT_ADMIN_PASSWORD);
        }

    }
}