<?php
include_once '../../php/database/DBOperations.php';

$dbOperations = new DBOperations();

if (isset($_POST['filter-price'])) {
    exit($dbOperations->getOnlineBooking($_POST['filter-price']));
}
