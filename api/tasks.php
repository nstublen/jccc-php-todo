<?php

header('Content-type: application/json');

include ("../inc/data.php");
include ("../inc/ui.php");

$params = json_decode(file_get_contents("php://input"));

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $rows = selectTasks('*');
    foreach($rows as $row) {
        $task = array();
        $task['task_id'] = $row['task_id'];
        $task['task_html'] = buildTaskHtml($row['task_id'],
                                           $row['completed'],
                                           $row['description'],
                                           $row['due_date']);
        $response[] = $task;
    }
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_row = insertTask($params->{'description'}, $params->{'due_date'});
    $response['task_id'] = $new_row['task_id'];
    $response['task_html'] = buildTaskHtml($new_row['task_id'],
                                           $new_row['completed'],
                                           $new_row['description'],
                                           $new_row['due_date']);
}

else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $row = updateTaskCompletion($params->{'task_id'}, $params->{'completed'});
    $response['task_id'] = $row['task_id'];
    $response['task_html'] = buildTaskHtml($row['task_id'],
                                           $row['completed'],
                                           $row['description'],
                                           $row['due_date']);
}

else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    deleteTask($params->{'task_id'});
    $response['task_id'] = $params->{'task_id'};
    $response['task_html'] = NULL;
}

echo json_encode($response);
