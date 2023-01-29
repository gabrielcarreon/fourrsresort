<?php
include_once '../../php/database/DBOperations.php';
$errorArray = array();
$isValid = true;
$dbOperations = new DBOperations();
if (isset($_POST['id-book-online'])) {
    foreach ($_POST as $name => $value) {
        if ($value == '' || $value == ' ') {
            $errorArray = array('error' => $name);
            $isValid = false;
        }
    }
    foreach ($_FILES as $name => $value) {
        if ($value == '' || $value == ' ') {
            $errorArray = array('error' => $name);
            $isValid = false;
        }
    }
    // var_dump($_POST);
    // exit(json_encode($_FILES['inp-receipt-img']['name']));
    if ($isValid) {
        $lid = $dbOperations->bookOnline(
            $_POST['id-book-online'],
            $_POST['inp-guest-name'],
            $_POST['inp-time-in'],
            $_POST['inp-time-out'],
            $_POST['inp-contact-number'],
            $_FILES['inp-id-img']['name'],
            $_FILES['inp-receipt-img']['name']
        );
        $directory = "../../files";
        $receiptName = $_FILES['inp-receipt-img']['name'];
        $idName = $_FILES['inp-id-img']['name'];
        mkdir("$directory/$lid");
        move_uploaded_file($_FILES['inp-receipt-img']['tmp_name'], "$directory/$lid/$receiptName");
        move_uploaded_file($_FILES['inp-id-img']['tmp_name'], "$directory/$lid/$idName");
        exit('1');
    }
    exit(json_encode($errorArray));
}
