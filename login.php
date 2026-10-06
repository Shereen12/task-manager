<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Login</title>

<head>
    <link rel="stylesheet" href="styles.css">
</head>

<body id="login">
    <div>
        <form action="backend/login.php/" method="POST">
            <?php
            session_start();
            if (isset($_SESSION['email_error'])) {
                echo '<p style="color: red;">' . $_SESSION['email_error'] . '</p>';
                unset($_SESSION['email_error']);
            }

            if (isset($_SESSION['login_error'])) {
                echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']);
            }
            ?>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>