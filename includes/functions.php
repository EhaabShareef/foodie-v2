<?php
// Database connection
function getDbConnection() {
    $conn = new mysqli('localhost', 'root', '', 'foodie_mv');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

?>