<?php
include ('inc/data.php');
include ('inc/ui.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>ToDo App</title>
    <link href="css/todo.css" rel="stylesheet" />
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/todo.js"></script>
</head>
<body>
    <header>
        <h1>ToDo App</h1>
    </header>
    <main>
        <form>
            <input id="task-description" type="text" placeholder="New task" name="description" autofocus />
            <input id="task-due-date" type="date" name="due_date" />
            <input id="task-submit" type="button" value="Add" />
        </form>
        <ul id="task-list">
            <?php echoToDoList(); ?>
        </ul>
    </main>
</body>
</html>