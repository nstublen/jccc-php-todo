<?php

include_once ('data.php');

function buildTaskHtml($task_id, $completed, $description, $due_date) {
    $html = "<li id=\"task-$task_id\"><input class=\"completion-state\" type=\"checkbox\"";
    $html .= " id=\"check-$task_id\"";
    if ($completed) {
        $html .= " checked";
    }
    $html .= "/><label for=\"check-$task_id\">$description</label> (<time>$due_date</time>)";
    $html .= "<button class=\"delete-task\">Delete</button>";
    $html .= "</li>";
    return $html;
}

function echoToDoList() {
    $tasks = selectTasks("*");
    foreach ($tasks as $task) {
        echoToDoListTask($task['task_id'], $task['completed'], $task['description'], $task['due_date']);
    }
}

function echoToDoListTask($task_id, $completed, $description, $due_date) {
    echo buildTaskHtml($task_id, $completed, $description, $due_date);
}
