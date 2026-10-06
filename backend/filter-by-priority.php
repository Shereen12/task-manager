<?php

header("Content-Type: application/json; charset=UTF-8");
require(__DIR__ . '/../helpers/DB.php');
$rawInput = file_get_contents('php://input'); //

// 2. Decode the JSON string into an associative PHP array
$data = json_decode($rawInput, true); //
$filter = $data['filter'];


try {
    $stmt = $conn->prepare("SELECT * from tasks where priority = ?");
    $stmt->execute([$filter]);
    $tasks = $stmt->fetchAll();

    echo json_encode(['tasks' => $tasks]);
} catch (PDOException $e) {
    throw new Exception($e->getMessage(), 500);
}
