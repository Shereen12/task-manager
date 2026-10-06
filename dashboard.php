<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body id="dashboard">
    <?php session_start();
    if ($_SESSION['logged_in']) { ?>
        <?php require(__DIR__ . "/backend/dashboard-index.php"); ?>
        <div id="header">
            <h1>Welcome <?php echo $_SESSION['name']; ?></h1>
            <a href="create-task.php">Create Task</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="stats">
            <h1>You have: </h1>

            <div class="cards">
                <div class="card"><?php echo $totalCount[0] ?> total tasks </div>
                <div class="card"><?php echo $pendingCount[0] ?> pending tasks </div>
                <div class="card"><?php echo $completedCount[0] ?> completed tasks </div>
            </div>
        </div>

        <div>
            <div class="controls">
                <input type="text" placeholder="search" style="padding: 1%;" id="search-input" />
                <select onchange="filterByStatus(event.target.value)">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
                <select onchange="filterByPriority(event.target.value)">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">high</option>
                </select>
            </div>
            <div class="tasks" id="tasks">
                <?php foreach ($result as $task) {
                ?>
                    <div class="task" id="task-<?php echo $task['id'] ?>">
                        <li><span>Title: </span><input disabled value="<?php echo $task['title']; ?>" /></li>
                        <li><span>Description: </span><input disabled value="<?php echo $task['description']; ?>" /></li>
                        <li><span>Priority: </span><input disabled value="<?php echo $task['priority']; ?>" /></li>
                        <li><span>Status: </span><input disabled value="<?php echo $task['status']; ?>" /></li>
                        <li><span>Due Date: </span><input disabled value="<?php echo $task['due_date']; ?>" /></span>
                        <li><a id="edit-button" href="edit-task.php?id=<?php echo $task['id']; ?>">Edit</a></li>
                        <li><button style="background-color: red;" onclick="deleteTask(<?php echo $task['id']; ?>)">Delete</button></li>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } else {
        header("Location: login.php");
        exit();
    } ?>
</body>
<script src="functions.js"></script>

</html>