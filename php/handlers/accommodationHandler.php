<?php
include_once '../../php/database/DBOperations.php';

if (isset($_POST['inp-package-name'])) {

    $dbOperations = new DBOperations();
    if (isset($_FILES['file'])) {
        $lid = $dbOperations->setPackage(
            $_POST['inp-package-name'],
            $_POST['inp-package-price'],
            $_POST['inp-description'],
            "placeholder",
            $_POST['inp-status']
        );
        if ($lid != 'true' || $lid != 'false') {
            move_uploaded_file($_FILES['file']['tmp_name'], "package/" . $lid . ".jpg");
        }
        exit('1');
    } else {
        exit($dbOperations->setPackage(
            $_POST['inp-package-name'],
            $_POST['inp-package-price'],
            $_POST['inp-description'],
            "empty",
            $_POST['inp-status']
        ));
    }
}

if (isset($_POST['disp_package_id'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->displayRoom($_POST['disp_package_id']));
}

if (isset($_POST['editPackageID'])) {
    $dbOperations = new DBOperations();
    if (isset($_FILES['file'])) {
        $lid = $_POST['editPackageID'];
        if (file_exists('package/' . $lid . '.jpg')) {
            unlink('package/' . $lid . '.jpg');
            move_uploaded_file($_FILES['file']['tmp_name'], "package/" . $lid . ".jpg");
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], "package/" . $lid . ".jpg");
        }

        $lid = $dbOperations->editPackage(
            $_POST['editPackageID'],
            $_POST['editPackageName'],
            $_POST['editPackagePrice'],
            $_POST['editPackageDescription'],
            $_POST['editPackageStatus'],
            "edit"
        );
        exit('1');
    } else {
        exit($dbOperations->editPackage(
            $_POST['editPackageID'],
            $_POST['editPackageName'],
            $_POST['editPackagePrice'],
            $_POST['editPackageDescription'],
            $_POST['editPackageStatus'],
            "noedit"
        ));
    }
}
if (isset($_POST['delete-package-id'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->deleteRoom($_POST['delete-package-id']));
}
if (isset($_POST['reRoomID'])) {
    $dbOperations = new DBOperations();
    exit($dbOperations->displayRoom($_POST['reRoomID']));
}

if (isset($_POST['inp-guest-name'])) {
    $isFailed = false;
    $jsonError = array();
    $dbOperations = new DBOperations();

    if (!isset($_POST['addon'])) {
        $addon = 0;
    } else {
        $addon = $_POST['addon'];
    }
    if (!isset($_POST['quantity'])) {
        $quantity = 0;
    } else {
        $quantity = $_POST['quantity'];
    }
    if (!isset($_POST['fee'])) {
        $fee = 0;
    } else {
        $fee = $_POST['fee'];
    }

    foreach ($_POST as $name => $value) {
        if ($name == 'inp-amount-paid') {
            if (($value == '' || $value == ' ') && $_POST['is-package-paid'] == '1') {
                $jsonError[] = array("error" => $name);
                $jsonError[] = array("error" => "is-package-paid");

                $isFailed = true;
            }
        } elseif ($name == 'inp-downpayment') {
            if (($value == '' || $value == ' ') && $_POST['is-package-paid'] == '0') {
                $jsonError[] = array("error" => $name);
                $jsonError[] = array("error" => "is-package-paid");
                $isFailed = true;
            }
        } elseif ($value == '') {
            $jsonError[] = array("error" => $name);
            $isFailed = true;
        }
    }

    if ($isFailed) {
        exit(json_encode($jsonError));
    } else {
        exit($dbOperations->getPackage(
            $_POST['inp-guest-name'],
            $_POST['inp-contact-number'],
            $addon,
            $quantity,
            $fee,
            $_POST['is-package-paid'],
            $_POST['inp-amount-paid'],
            $_POST['inp-downpayment'],
            $_POST['get-package-id'],
            $_POST['inp-time-in'],
            $_POST['inp-time-out']
        ));
    }
}
