<?php

header("Content-Type: application/json; charset=UTF-8");


require(__DIR__ . '/../helpers/DB.php');

$rawInput = file_get_contents('php://input'); //

// 2. Decode the JSON string into an associative PHP array
$data = json_decode($rawInput, true); //

if ($data['id']) {
    try {
        $stmt = $conn->prepare("DELETE FROM tasks where id = ?");
        $stmt->execute([$data['id']]);

        echo "Task deleted successfully";
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
