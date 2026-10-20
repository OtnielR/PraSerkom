<?php

class Event
{

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM events ";
        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return $result;
    }

    public function getEventById(string $id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM events WHERE id=?");

        $stmt->bind_param("s", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        if (!$result) {
            return false;
        }

        return $result->fetch_assoc();
    }

    public function create(string $title, string $category, int $ticket_price, string $description, string|null $image): bool
    {
        $stmt = $this->db->conn->prepare("INSERT INTO events (title, category, ticket_price, description, image) VALUE (?, ?, ?, ?, ?)");

        $stmt->bind_param("ssiss", $title, $category, $ticket_price, trim($description), $image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update(string $eventId, string $title, string $category, int $ticket_price, string $description, string|null $image): bool
    {
        $stmt = $this->db->conn->prepare("UPDATE events SET title=?, category=?, ticket_price=?, description=?, image=? WHERE id=?");

        $stmt->bind_param("ssisss", $title, $category, $ticket_price, trim($description), $image, $eventId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete(string $eventId)
    {
        $stmt = $this->db->conn->prepare("DELETE FROM events WHERE id=?");

        $stmt->bind_param("s", $eventId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
