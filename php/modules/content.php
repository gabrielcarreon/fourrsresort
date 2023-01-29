<?php
session_start();
if (!isset($_SESSION) || !array_key_exists('fourRsuser_type', $_SESSION)) {
    exit();
}
$page = '';
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Four Rs Resort</title>
    <?php
    include 'head.php';
    ?>

    <link rel="stylesheet" href="../../css/content.css">
    <link rel="stylesheet" href="../../css/transaction.css">
    <link rel="stylesheet" href="../../css/inventory.css">
    <link rel="stylesheet" href="../../css/sales.css">
    <link rel="stylesheet" href="../../css/users.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
    <script src="../../js/bootstrap-datetimepicker.min.js"></script>


</head>

<body>
    <?php
    include 'navbar.php';

    switch ($page) {
        case '':
        case 'packages':
            include 'packages.php';
            break;
        case 'transactions':
            include 'transactions.php';
            break;
        case 'inventory':
            include 'inventory.php';
            break;
        case 'sales':
            include 'sales.php';
            break;
        case 'users':
            include 'users.php';
            break;
        default:
            break;
    }
    include 'modals.php';
    ?>
</body>

</html>