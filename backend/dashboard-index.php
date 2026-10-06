<?php

require(__DIR__ . '/../helpers/DB.php');

session_start();
$pending = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE status = 'pending' AND user_id = :user_id");
$pending->execute(['user_id' => $_SESSION['user_id']]);
$pendingCount = $pending->fetch();

$total = $conn->prepare("SELECT COUNT(*) FROM tasks where user_id = :user_id");
$total->execute(['user_id' => $_SESSION['user_id']]);
$totalCount = $total->fetch();

$completed = $conn->prepare("SELECT COUNT(*) FROM tasks where status = 'completed' AND user_id = :user_id");
$completed->execute(['user_id' => $_SESSION['user_id']]);
$completedCount = $completed->fetch();

$tasks = $conn->prepare("SELECT * from tasks where user_id = :user_id");
$tasks->execute(['user_id' => $_SESSION['user_id']]);
$result = $tasks->fetchAll(PDO::FETCH_ASSOC);
