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
session_start();
$user_id = $_SESSION['user_id'];

if ($title == "" || $description == "" || $priority == "" || $due_date == "") {
    echo "input cannot be empty";
    exit;
}

if ($priority != 'low' && $priority != 'medium' && $priority != 'high') {
    echo "wrong value for priority";
    exit;
}

$now = date('Y-m-d');

if ($due_date < $now) {
    throw new Exception("Date is invalid", 422);
}
try {
    $stmt = $conn->prepare("INSERT into tasks (title, description, priority, due_date, user_id) values (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $priority, $due_date, $user_id]);

    echo "Task created successfully";
} catch (PDOException $e) {
    throw new Exception($e->getMessage(), 500);
}
