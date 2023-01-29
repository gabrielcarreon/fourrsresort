<?php
include_once '../../php/database/DBOperations.php';

if (isset($_POST['user-id'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->getUserInfo($_POST['user-id']));
}

if (isset($_POST['add-user-role'])) {
    $isFailed = false;
    $jsonError = array();
    $dbOperations = new DBOperations();
    if (isset($_POST['add-user-is-active'])) {
        $isactive = 1;
    } else {
        $isactive = 0;
    }
    foreach ($_POST as $name => $value) {
        if ($value == '') {
            if ($name == 'add-user-suffix') {
                if (isset($_POST['checkbox-suffix'])) {
                    $jsonError[] = array("error" => $name);
                    $isFailed = true;
                } else {
                    $suffix = '';
                }
            } elseif ($name == 'add-user-mname') {
                if (isset($_POST['checkbox-manme'])) {
                    $jsonError[] = array("error" => $name);
                    $isFailed = true;
                } else {
                    $mname = '';
                }
            } else {
                $jsonError[] = array("error" => $name);
                $isFailed = true;
            }
        } else {
            $mname = $_POST['add-user-mname'];
            $suffix = $_POST['add-user-suffix'];
        }
    }
    if ($isFailed) {
        exit(json_encode($jsonError));
    }
    exit($dbOperations->addUserInfo(
        $_POST['add-user-fname'],
        $mname,
        $_POST['add-user-lname'],
        $suffix,
        $_POST['add-user-email'],
        $_POST['add-user-password'],
        $isactive,
        $_POST['add-user-role']
    ));
}
if (isset($_POST['edit-uid'])) {
    if ($_POST['edit-password'] == '') {
        exit('userinfo-password');
    }
    if ($_POST['edit-is_active'] == 'true') {
        $isactive = 1;
    } else {
        $isactive = 0;
    }
    $dbOperations = new DBOperations();
    exit($dbOperations->editUser(
        $_POST['edit-uid'],
        $_POST['edit-password'],
        $isactive
    ));
}

if (isset($_POST['delete-user-id'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->deleteUser($_POST['delete-user-id']));
}

if (isset($_POST['old-password'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->changeUserPassword(
        $_POST['old-password'],
        $_POST['new-password']
    ));
}
