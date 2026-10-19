<?php

class OrderDetail{
    
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(string|int $order_id, string|int $event_id, int $quantity, int $subtotal): bool{
        $query = "INSERT INTO order_details (order_id, event_id, quantity, subtotal) VALUE ({$order_id}, {$event_id}, {$quantity}, {$subtotal});";

        $result = $this->db->conn->query($query);

        if (!$result) {
            return false; 
        } 
        
        return $this->db->conn->insert_id;
    }
}