<?php
header("Content-Type: application/json; charset=UTF-8");
require(__DIR__ . '/../helpers/DB.php');
$rawInput = file_get_contents('php://input'); //

// 2. Decode the JSON string into an associative PHP array
$data = json_decode($rawInput, true); //
$title = $data['title'];
$description = $data['description'];
$priority = $data['priority'];
$due_date = $data['due_date'];
$id = $data['id'];

if ($title == "" || $description == "" || $priority == "" || $due_date == "") {
    throw new Exception("Input cannot be empty", 422);
}

if ($priority != 'low' && $priority != 'medium' && $priority != 'high') {
    throw new Exception("wrong value for priority", 422);
}

$now = date('Y-m-d');

if ($due_date < $now) {
    throw new Exception("Date is invalid", 422);
}
try {
    $stmt = $conn->prepare("UPDATE  tasks set title=?, description=?, priority=?, due_date=? where id=?");
    $stmt->execute([$title, $description, $priority, $due_date, $id]);

    echo "Task created successfully";
} catch (PDOException $e) {
    throw new Exception($e->getMessage(), 500);
}
