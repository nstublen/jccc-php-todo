<?php
/**
 * Created by PhpStorm.
 * User: Neal
 * Date: 7/7/2015
 * Time: 11:32 PM
 */

include_once ('data.php');

function echoToDoList() {
    $tasks = selectTasks("*");
    foreach ($tasks as $task) {
        echoToDoListTask($task['task_id'], $task['completed'], $task['description'], $task['due_date']);
    }
}

function echoToDoListTask($task_id, $completed, $description, $due_date) {
    $echo = "<li id=\"task-$task_id\"><input type=\"checkbox\"";
    $echo .= " id=\"check-$task_id\"";
    if ($completed) {
        $echo .= " checked";
    }
    $echo .= "/><label for=\"check-$task_id\">$description</label> (<time>$due_date</time>)</li>";
    echo $echo;
}
