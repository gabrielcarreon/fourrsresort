<?php
include_once '../../php/database/DBOperations.php';

$dbOperations = new DBOperations();
exit($dbOperations->getAddOns());
