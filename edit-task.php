<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div id="header">
        <?php session_start();
        if ($_SESSION['logged_in']) { ?>
            <?php require(__DIR__ . "/backend/edit-task.php"); ?>

            <a href="dashboard.php">Dashboard</a>
            <a href="./backend/logout.php">Logout</a>
    </div>
    <div id="edit-task">
        <form id="edit-task-form">
            <p id="message"></p>

            <input hidden name="id" value="<?php echo $result['id'] ?>">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo $result['title'] ?>" />
            <p id="title-error"></p>

            <label for="description">Description</label>
            <textarea name="description" id="description"><?php echo $result['description'] ?></textarea>
            <p id="description-error"></p>

            <label for="priority">Priority</label>
            <select name="priority" id="priority">
                <option value="low" <?php if ($result['priority'] == 'low') echo "selected"; ?>>Low</option>
                <option value="medium" <?php if ($result['priority'] == 'medium') echo "selected"; ?>>Medium</option>
                <option value="high" <?php if ($result['priority'] == 'high') echo "selected"; ?>>High</option>
            </select>
            <p id="priority-error"></p>


            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="<?php echo $result['due_date'] ?>" />
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