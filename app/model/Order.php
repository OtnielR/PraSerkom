<?php

class Order
{

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM orders";

        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return $result;
    }

    public function getOrderDetailsByOrderId(int|string $orderId)
    {
        $query = "SELECT * FROM order_details INNER JOIN events ON order_details.event_id = events.id WHERE order_id={$orderId}";

        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return $result;
    }

    public function create(string $customer_name, string $customer_email, int $total_price): false|int
    {
        $query = "INSERT INTO orders (customer_name, customer_email, total_price, status) VALUE ('{$customer_name}', '{$customer_email}', {$total_price}, 'Pending');";

        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return $this->db->conn->insert_id;
    }

    public function updateStatus(int|string $orderId, string $status)
    {
        $query = "UPDATE orders SET status='{$status}' WHERE id={$orderId}";

        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return true;
    }
}

