<?php
require(__DIR__ . '/../helpers/DB.php');


session_start();
$task = $conn->prepare("SELECT * FROM tasks WHERE id=:id");
$task->execute(['id' => $_GET['id']]);
$result = $task->fetch();
