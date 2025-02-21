<?php
session_start();

// Initialize tasks array
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Handle adding a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $_SESSION['tasks'][] = $task;
    }
}

// Handle deleting a task
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    if (isset($_SESSION['tasks'][$index])) {
        array_splice($_SESSION['tasks'], $index, 1);
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Handle clearing all tasks
if (isset($_GET['clear'])) {
    $_SESSION['tasks'] = [];
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP To-Do List</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { width: 50%; margin: 50px auto; }
        ul { list-style-type: none; padding: 0; }
        li { background: #f4f4f4; padding: 10px; margin: 5px; border-radius: 5px; }
        a { text-decoration: none; color: red; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Simple PHP To-Do List</h2>
        <form method="POST">
            <input type="text" name="task" placeholder="Enter task..." required>
            <button type="submit">Add Task</button>
        </form>

        <ul>
            <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                <li><?= htmlspecialchars($task) ?>
                    <a href="?delete=<?= $index ?>">❌</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <a href="?clear=1" style="color: blue;">Clear All</a>
    </div>
</body>
</html>
