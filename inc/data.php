<?php
/**
 * Created by PhpStorm.
 * User: Neal
 * Date: 7/7/2015
 * Time: 11:49 PM
 */

include ('_credentials.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATA);

function insertItem($description, $due_date) {
    global $dbc;

    $q = 'INSERT INTO items (description, due_date) VALUES (?, ?)';
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param($stmt, 'ss', $description, $due_date);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_affected_rows($dbc);
    mysqli_stmt_close($stmt);

    if ($rows != 1) {
        return NULL;
    }
    return selectItems('*', 'item_id=' . mysqli_insert_id($dbc))[0];
}

function selectItems($columns, $where = NULL) {
    global $dbc;

    $items = array();

    $q = 'SELECT ' . $columns . ' FROM items';
    if ($where) {
        $q = $q . ' WHERE ' . $where;
    }
    $result = mysqli_query($dbc, $q);
    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $items[] = $row;
        }
    }

    return $items;
}

function updateItemCompletion($item_id, $completed) {
    global $dbc;

    $q = "UPDATE items SET completed=? WHERE item_id=?";
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param($stmt, 'ii', $completed, $item_id);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_affected_rows($dbc);
    mysqli_stmt_close($stmt);

    if ($rows != 1) {
        return NULL;
    }
    return selectItems('*', 'item_id=' . $item_id)[0];
}
