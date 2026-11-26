<?php
class Bucketlist
{
    private mysqli $db;
    private string $name;
    private string $description;
    private int $priority;

    // Konstruktor
    function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);

        if ($this->db->connect_errno > 0) {
            die("Error connecting: " . $this->db->connect_error);
        }

        // Säkerställer så att å, ä och ö kan lagras och hämtas
        $this->db->set_charset("utf8mb4");
    }

    // Hämtar all data från databasens tabell bucketlist
    public function getItems(): array
    {
        $sql = "SELECT * FROM bucketlist ORDER BY created_at DESC;";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addItem(string $name, string $description, int $priority): bool
    {
        // Validerar värden
        if (!$this->setName($name)) return false;
        if (!$this->setDescription($description)) return false;
        if (!$this->setPriority($priority)) return false;

        // SQL-fråga med values ? för att förhindra injections
        $sql = "INSERT INTO bucketlist (name, description, priority) VALUES (?, ?, ?)";

        // Förbereder SQL-frågan
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;

        // Binder samman värden till SQL-frågan och anger datatyp
        $stmt->bind_param("ssi", $this->name, $this->description, $this->priority);

        // Kör frågan
        return $stmt->execute();
    }

    // Ta bort en list-item
    public function deleteItem(int $id): bool
    {
        $sql = "DELETE FROM bucketlist WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) return false;

        // Binder id till SQL-fråga och anger datatyp int
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Set-metoder för validering
    public function setName(string $name): bool
    {
        $name = trim($name);
        if ($name != "") {
            $this->name = $name;
            return true;
        } else {
            return false;
        }
    }

    public function setDescription(string $description): bool
    {
        $description = trim($description);
        if ($description != "") {
            $this->description = $description;
            return true;
        } else {
            return false;
        }
    }

    public function setPriority(int $priority): bool
    {
        if ($priority >= 1 && $priority <= 3) {
            $this->priority = $priority;
            return true;
        } else {
            return false;
        }
    }

    // Destruktor
    // Stänger db-anslutningen
    function __destruct()
    {
        $this->db->close();
    }
}
