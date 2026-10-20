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
        $stmt = $this->db->conn->prepare("SELECT * FROM order_details INNER JOIN events ON order_details.event_id = events.id WHERE order_id=?");

        $stmt->bind_param("s", $orderId);

        $stmt->execute();

        $result = $stmt->get_result();

        if (!$result) {
            return false;
        }

        return $result;
    }

    public function create(string $customer_name, string $customer_email, int $total_price): false|int
    {
        $stmt = $this->db->conn->prepare("INSERT INTO orders (customer_name, customer_email, total_price, status) VALUE (?, ?, ?, 'Pending')");

        $stmt->bind_param("ssi", $customer_name, $customer_email, $total_price);

        $stmt->execute();

        $result = $this->db->conn->insert_id;

        if (!$result) {
            return false;
        }

        return $result;
    }

    public function updateStatus(int|string $orderId, string $status)
    {
        $stmt = $this->db->conn->prepare("UPDATE orders SET status=? WHERE id=?");

        $stmt->bind_param("ss", $status, $orderId);

        $result = $stmt->get_result();

        if (!$result) {
            return false;
        }

        return true;
    }
}
