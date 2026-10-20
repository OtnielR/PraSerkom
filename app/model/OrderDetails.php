<?php

class OrderDetail
{

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(string|int $order_id, string|int $event_id, int $quantity, int $subtotal): false|int
    {
        $stmt = $this->db->conn->prepare("INSERT INTO order_details (order_id, event_id, quantity, subtotal) VALUE (?, ?, ?, ?)");

        $stmt->bind_param("ssii", $order_id, $event_id, $quantity, $subtotal);

        $stmt->execute();

        $result = $this->db->conn->insert_id;

        if (!$result) {
            return false;
        }

        return $result;
    }
}
