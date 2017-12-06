<?php

function getAllTasksWithDueDate($username) {
    global $dbh;

    $stmt = $dbh->prepare(
        "SELECT
            T.task_id, T.title, T.category,
            T.priority, T.duedate, T.parent_task
        FROM Task T, UserTask UT
        WHERE
            T.task_id = UT.task_id AND
            T.duedate IS NOT NULL AND
            UT.username like ?"
    );
    $stmt->execute(array($username));
    
    return $stmt->fetchAll();
}

function getAllTasks() {
    global $dbh;

    $stmt = $dbh->prepare(
        "SELECT * FROM Task
        ORDER BY task_id DESC"
    );
    $stmt->execute();

    return $stmt->fetchAll();
}

// Projects are Tasks that have no parent Task
function getParentTasks($username) {
    global $dbh;

    $stmt = $dbh->prepare(
        "SELECT
            T.task_id, T.title, T.category,
            T.priority, T.duedate, T.parent_task
        FROM Task T, UserTask UT
        WHERE
            T.task_id = UT.task_id AND
            T.parent_task IS NULL AND
            UT.username like ?"
    );
    $stmt->execute(array($username));

    return $stmt->fetchAll();
}

function getUsersTasks($username) {
    global $dbh;
    
    $stmt = $dbh->prepare(
        "SELECT
            T.task_id, T.title, T.category,
            T.priority, T.duedate, T.parent_task
        FROM Task T, UserTask UT
        WHERE
            T.task_id = UT.task_id AND
            UT.username like ?"
    );
    $stmt->execute(array($username));

    return $stmt->fetchAll();
}

function getChildTasks($parent_id) {
    global $dbh;
    
    $stmt = $dbh->prepare(
        "SELECT * FROM Task
        WHERE parent_task = ?
        ORDER BY task_id DESC"
    );
    $stmt->execute(array($parent_id));

    return $stmt->fetchAll();  
}

function getTasksByCategory($cat) {
    global $dbh;

    $stmt = $dbh->prepare(
        "SELECT * FROM Task
        WHERE category like ?
        task_id DESC"
    );
    $stmt->execute(array($cat));
    
    return $stmt->fetchAll();
}

function getTaskById($id) {
    global $dbh;

    $stmt = $dbh->prepare(
        "SELECT * FROM Task
        WHERE task_id = ?"
    );

    $stmt->execute(array($id));

    return $stmt->fetch();
}

function getAllItems() {
    global $dbh;
    
    $stmt = $dbh->prepare(
        "SELECT * FROM Item"
    );
    $stmt->execute();

    return $stmt->fetchAll();  
}

function getItemById($id) {
    global $dbh;
    
    $stmt = $dbh->prepare(
        "SELECT * FROM Item
        WHERE item_id = ?"
    );
    $stmt->execute(array($id));

    return $stmt->fetch();
}

function getTasksItems($task_id) {
    global $dbh;
  
    $stmt = $dbh->prepare(
        "SELECT * FROM Item
        WHERE task_id = ?"
    );
    $stmt->execute(array($task_id));

    return $stmt->fetchAll();
}

function addItem($task_id, $description) {
    global $dbh;

    $stmt = $dbh->prepare(
        "INSERT INTO Item
        (task_id, description) VALUES
        (?, ?)"
    );

    $stmt->execute(array($task_id, $description));

    return getLastItem();
}

function getLastItem() {
    global $dbh;

    $stmt = $dbh->prepare(
        "SELECT * FROM Item
        ORDER BY item_id DESC LIMIT 1"
    );
    $stmt->execute();
    return $stmt->fetch();
}

function getLastTask() {
    global $dbh;
    
    $stmt = $dbh->prepare(
        "SELECT * FROM Task
        ORDER BY task_id DESC LIMIT 1"
    );
    $stmt->execute();
    return $stmt->fetch();
}

?>