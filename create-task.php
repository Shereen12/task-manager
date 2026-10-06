<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php session_start();
    if ($_SESSION['logged_in']) { ?>
        <div id="header">
            <a href="dashboard.php">Dashboard</a>
            <a href="./backend/logout.php">Logout</a>
        </div>
        <div id="create-task">
            <form id="create-task-form">
                <p id="message"></p>

                <label for="title">Title</label>
                <input type="text" name="title" id="title" />
                <p id="title-error"></p>

                <label for="description">Description</label>
                <textarea name="description" id="description"></textarea>
                <p id="description-error"></p>

                <label for="priority">Priority</label>
                <select name="priority" id="priority">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                <p id="priority-error"></p>


                <label for="due_date">Due Date</label>
                <input type="date" name="due_date" id="due_date" />
                <p id="due_date-error"></p>

                <button type="submit">Save</button>
            </form>
        </div>

    <?php } else {
        header("Location: login.php");
        exit();
    } ?>
    <script src="functions.js"></script>
</body>

</html>