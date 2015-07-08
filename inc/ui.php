<?php
/**
 * Created by PhpStorm.
 * User: Neal
 * Date: 7/7/2015
 * Time: 11:32 PM
 */

include_once ('data.php');

function echoToDoList() {
    $items = selectItems("*");
    foreach ($items as $item) {
        echoToDoListItem($item['item_id'], $item['completed'], $item['description'], $item['due_date']);
    }
}

function echoToDoListItem($item_id, $completed, $description, $due_date) {
    $echo = "<li id=\"item-$item_id\"><input type=\"checkbox\"";
    $echo .= " id=\"check-$item_id\"";
    if ($completed) {
        $echo .= " checked";
    }
    $echo .= "/><label for=\"check-$item_id\">$description</label> (<time>$due_date</time>)</li>";
    echo $echo;
}
