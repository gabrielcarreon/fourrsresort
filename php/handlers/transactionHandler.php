<?php
include_once '../../php/database/DBOperations.php';

if (isset($_POST['init-transaction'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->getTransactions($_POST['init-transaction']));
}
if (isset($_POST['open-transaction-id'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->openTransaction($_POST['open-transaction-id']));
}
if (isset($_POST['trans-id'])) {
    $isFailed = false;
    $jsonError = array();
    $dbOperations = new DBOperations();

    foreach ($_POST as $name => $value) {
        if ($value == '') {
            if ($name == 'trans-amount-paid') {
                if (isset($_POST['trans-is-package-paid'])) {
                    $jsonError[] = array("error" => $name);
                    $jsonError[] = array("error" => "trans-is-package-paid");
                    $isFailed = true;
                }
            } else {
                $jsonError[] = array("error" => $name);
                $isFailed = true;
            }
        }
    }
    if ($isFailed) {
        exit(json_encode($jsonError));
    }
    if (isset($_POST['trans-is-package-paid'])) {
        $packagePaid = 1;
        $amountPaid = $_POST['trans-amount-paid'];
    } else {
        $packagePaid = 0;
        $amountPaid = 0;
    }
    if (isset($_POST['addons'])) {
        $addons = $_POST['addons'];
    } else {
        $addons = 0;
    }
    if (isset($_POST['quantity'])) {
        $quantity = $_POST['quantity'];
    } else {
        $quantity = 0;
    }

    exit($dbOperations->editTransaction(
        $_POST['trans-id'],
        $_POST['trans-time-out'],
        $addons,
        $quantity,
        $amountPaid,
        $packagePaid
    ));
}
if (isset($_POST['init-chart'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->getTransactionChart($_POST['init-chart'], $_POST['filter-chart']));
}
if (isset($_POST['transaction-id'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->getTransactions($_POST['transaction-id']));
}

if (isset($_POST['confirm-id'])) {
    $dbOperations =  new DBOperations();
    exit($dbOperations->confirmOnlineBooking($_POST['confirm-id']));
}
if (isset($_POST['init-table'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->getTransactionTable($_POST['init-table'], $_POST['filter-chart']));
}
