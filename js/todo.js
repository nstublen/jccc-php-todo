$(document).ready(function () {
    // Each checkbox has a "completion-state" class.
    watchCheckboxes($(".completion-state"));
    // Each delete button has a "delete-task" class.
    watchDeleteButtons($(".delete-task"));
    // The form submit button has a "task-submit" id.
    watchTaskSubmitButton($("#task-submit"))
});

// Each <li> element has an "id" attribute in the form "task-#". We
// can pass the value of an "id" attribute to extractTaskId, which
// will parse the value and return the number after the dash.
function extractTaskId(text) {
    var index = text.indexOf("-");
    // If we find the dash, we can return everything after the dash
    // and convert it to an integer value. If we can't find the dash
    // we will return an undefined result.
    return (index >= 0) ? parseInt(text.substring(index + 1)) : undefined;
}

// Given any element within an <li> element, we can use jQuery to
// find the <li> element and retrieve its task ID from the "id"
// attribute.
function getElementTaskId(element) {
    // closest() will find the nearest ancestor element that matches
    // the specified selector. We are looking for the closest <li>
    // element.
    var $li = $(element).closest("li");
    return extractTaskId($li.attr("id"));
}

// Whenever a checkbox is clicked, we get the new state and send it
// back to the server.
function handleCompletionStatusChecked() {
    var taskId = getElementTaskId(this);
    var completed = $(this).is(":checked");
    sendTaskCompletion(taskId, completed);
}

// Whenever a delete button is clicked, we send the task ID back
// to the server so the task can be deleted.
function handleDeleteTaskClicked() {
    var taskId = getElementTaskId(this);
    sendTaskDeletion(taskId);
}

// When the "Add" button is clicked, we get the description and
// due date and send them back to the server.
function handleTaskSubmitClicked() {
    var description = $("#task-description").val();
    var dueDate = $("#task-due-date").val();
    sendTaskInsertion(description, dueDate);
}

function resetForm() {
    $("#task-description").val("");
    $("#task-due-date").val("");
}

function sendTaskCompletion(taskId, completed) {
    var taskData = {
        task_id: taskId,
        completed: completed
    };

    $.ajax({
        url: 'api/tasks.php',
        method: 'PUT',
        data: JSON.stringify(taskData),
        dataType: 'json',
        success: updateTaskList
    });
}

function sendTaskDeletion(taskId) {
    var taskData = {
        task_id: taskId
    };

    $.ajax({
        url: 'api/tasks.php',
        method: 'DELETE',
        data: JSON.stringify(taskData),
        dataType: 'json',
        success: updateTaskList
    });
}

function sendTaskInsertion(description, dueDate) {
    var taskData = {
        description: description,
        due_date: dueDate
    };

    $.ajax({
        url: 'api/tasks.php',
        method: 'POST',
        data: JSON.stringify(taskData),
        dataType: 'json',
        success: updateTaskList
    });
}

function updateTaskList(jsonResponse) {
    var $li = $("#task-" + jsonResponse.task_id);
    if ($li.length > 0) {
        if (jsonResponse.task_html) {
            $li.replaceWith(jsonResponse.task_html)
        } else {
            $li.slideUp(function () {
                $li.remove();
            })
        }
    } else {
        var $task = $(jsonResponse.task_html).hide();
        $("#task-list").append($task);
        $task.slideDown();
        resetForm();
    }
}

function watchCheckboxes($checkboxes) {
    $checkboxes.click(handleCompletionStatusChecked);
}

function watchDeleteButtons($buttons) {
    $buttons.click(handleDeleteTaskClicked);
}

function watchTaskSubmitButton($button) {
    $button.click(handleTaskSubmitClicked);
}
