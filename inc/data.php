<?php
/**
 * Created by PhpStorm.
 * User: Neal
 * Date: 7/7/2015
 * Time: 11:49 PM
 */

include ('_credentials.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATA);

function deleteTask($task_id) {
    global $dbc;

    $q = 'DELETE FROM tasks WHERE task_id=?';
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param($stmt, 'i', $task_id);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_affected_rows($dbc);
    mysqli_stmt_close($stmt);
}

function insertTask($description, $due_date) {
    global $dbc;

    $q = 'INSERT INTO tasks (description, due_date) VALUES (?, ?)';
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param($stmt, 'ss', $description, $due_date === "" ? NULL : $due_date);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_affected_rows($dbc);
    mysqli_stmt_close($stmt);

    if ($rows != 1) {
        return NULL;
    }
    return selectTasks('*', 'task_id=' . mysqli_insert_id($dbc))[0];
}

function selectTasks($columns, $where = NULL) {
    global $dbc;

    $tasks = array();

    $q = 'SELECT ' . $columns . ' FROM tasks';
    if ($where) {
        $q = $q . ' WHERE ' . $where;
    }
    $result = mysqli_query($dbc, $q);
    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $tasks[] = $row;
        }
    }

    return $tasks;
}

function updateTaskCompletion($task_id, $completed) {
    global $dbc;

    $q = "UPDATE tasks SET completed=? WHERE task_id=?";
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param($stmt, 'ii', $completed, $task_id);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_affected_rows($dbc);
    mysqli_stmt_close($stmt);

    if ($rows != 1) {
        return NULL;
    }
    return selectTasks('*', 'task_id=' . $task_id)[0];
}
