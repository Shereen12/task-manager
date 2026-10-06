<?php

require(__DIR__ . '/../helpers/DB.php');
session_start();
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    $error = "Email and password are required.";
    $_SESSION['login_error'] = $error;
    header("Location: ../../login.php");
    exit();
}
try {
    $email = $_POST['email'];
    $password = $_POST['password'];




    $stmt = $conn->prepare("SELECT * FROM users where email=:email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        header("Location: ../../dashboard.php");
        exit();
    } else {

        $error = "Invalid email or password.";
        $_SESSION['login_error'] = $error;
        header("Location: ../../login.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
