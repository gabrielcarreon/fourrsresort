<?php
include_once '../../php/database/DBOperations.php';

if (isset($_POST['userIDInput'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->login($_POST['userIDInput'], $_POST['passwordInput']));
}
if (isset($_POST['logout'])) {
    if ($_POST['logout'] == 1) {
        session_start();
        if (session_destroy()) {
            exit('true');
        }
        exit('false');
    }
    exit('false');
}
