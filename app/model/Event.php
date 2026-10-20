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
        $query = "SELECT * FROM events WHERE id={$id}";
        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return $result->fetch_assoc();
    }

    public function create(string $title, string $category, int $ticket_price, string $description, string|null $image): bool
    {
        $query = "INSERT INTO events (title, category, ticket_price, description, image) VALUE ('{$title}', '{$category}', {$ticket_price}, '{$description}', '{$image}');";

        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return true;
    }

    public function update(string $eventId, string $title, string $category, int $ticket_price, string $description, string|null $image): bool
    {
        $query = "UPDATE events SET title='{$title}', category='{$category}', ticket_price={$ticket_price}, description='{$description}', image='{$image}' WHERE id={$eventId}";

        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return true;
    }

    public function delete(string $eventId)
    {
        $query = "DELETE FROM events WHERE id={$eventId}";
        $result = $this->db->conn->query($query);

        if (!$result) {
            return false;
        }

        return true;
    }
}

