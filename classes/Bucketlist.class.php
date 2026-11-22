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
    }

    public function getItems(): array
    {
        $sql = "SELECT * FROM bucketlist ORDER BY created_at DESC;";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Destruktor
    // Stänger db-anslutningen
    function __destruct()
    {
        $this->db->close();
    }
}
