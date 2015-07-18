<?php
include ('inc/data.php');
include ('inc/ui.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>ToDo App</title>
    <link href="css/todo.css" rel="stylesheet" />
    <script src="js/todo.js"></script>
</head>
<body>
    <header>
        <h1>ToDo App</h1>
    </header>
    <main>
        <form>
            <input type="text" placeholder="New task" name="description" autofocus />
            <input type="date" name="due_date" />
            <input type="button" value="Add" />
        </form>
        <?php echoToDoList(); ?>
    </main>
</body>
</html>