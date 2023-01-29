<?php
include_once '../../php/database/DBOperations.php';

if (isset($_POST['inventory-id'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->getInventoryInfo($_POST['inventory-id']));
}

if (isset($_POST['inv-id'])) {
    $isFailed = false;
    $jsonError = array();
    foreach ($_POST as $name => $value) {
        if ($value == '' || $value == ' ') {
            $jsonError[] = array('error' => $name);
            $isFailed = true;
        }
    }
    if ($isFailed) {
        exit(json_encode($jsonError));
    }
    $dbOperations = new DBOperations();
    if (isset($_POST['inv-available'])) {
        $available = 1;
    } else {
        $available = 0;
    }
    exit($dbOperations->editInventory(
        $_POST['inv-id'],
        $_POST['inv-name'],
        $_POST['inv-quantity'],
        $_POST['inv-price'],
        $available
    ));
}
if (isset($_POST['add-inv-id'])) {

    $isFailed = false;
    $jsonError = array();
    foreach ($_POST as $name => $value) {
        if ($value == '' || $value == ' ') {
            if ($name != 'add-inv-id') {
                $jsonError[] = array('error' => $name);
                $isFailed = true;
            }
        }
    }
    if ($isFailed) {
        exit(json_encode($jsonError));
    }
    if (isset($_POST['add-available'])) {
        $available = 1;
    } else {
        $available = 0;
    }

    $dbOperations = new DBOperations();
    exit($dbOperations->addInventory(
        $_POST['inv-name'],
        $_POST['inv-quantity'],
        $_POST['inv-price'],
        $available
    ));
}
if (isset($_POST['delete-id'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->deleteItem($_POST['delete-id']));
}
