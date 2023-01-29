<?php
require_once 'config.php';
require_once 'C:\xampp\htdocs\fourRsResort\php\functions.php';

class DBOperations
{
    private $db;
    public function __construct()
    {
        date_default_timezone_set('Asia/Singapore');
        // establish connection to database

        if ($this->db = new mysqli(
            DB_SERVER,
            DB_USERNAME,
            DB_PASSWORD,
            DB_NAME
        )) {
        } else {
            die();
        }
    }

    //Login Page
    public function login($user_id, $password)
    {
        //compare input to database data
        $uidDB = $this->validateInput($user_id);
        $passwordDB = $this->validateInput($password);

        $result = $this->db->query("SELECT * FROM resortdb.users WHERE user_id = '$uidDB' AND password = '$passwordDB' AND is_active = 1");
        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            session_start();
            $_SESSION['fourRsuid'] = $rows['user_id'];
            $_SESSION['fourRsuser_type'] = $rows['user_type'];
            $_SESSION['fourRsuname'] = $rows['fname'] . " " . $rows['lname'];
            $_SESSION['fourRsisActive'] = $rows['is_active'];
            header('Location: ../modules/content.php');
            exit();
        } else {
            return 'false';
        }
    }

    public function getUserData()
    {
        $result = $this->db->query("SELECT * FROM resortdb.users");
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
                $userJson = array(
                    "id" => $rows['id'],
                    "user_id" => $rows['user_id'],
                    "fname" => $rows['fname'],
                    "mname" => $rows['mname'],
                    "lname" => $rows['lname'],
                    "user_type" => ucfirst($rows['user_type'])
                );
            }
        }
        return json_encode($userJson);
    }

    public function getAccommodation()
    {
        session_start();
        $packageJSON = array();
        $result = $this->db->query("SELECT * FROM resortdb.package");

        if (isset($_SESSION['fourRsuser_type'])) {
            $access = $_SESSION['fourRsuser_type'];
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    if (file_exists("../handlers/package/" . $rows['image'] . ".jpg")) {
                        $packageJSON[] = array(
                            'package_id' => $rows['package_id'],
                            'package_name' => $rows['package_name'],
                            'price' => $rows['price'],
                            'description' => $rows['description'],
                            'image' => $rows['image'],
                            'access' => $access,
                            'status' => $rows['status']
                        );
                    } else {
                        $packageJSON[] = array(
                            'package_id' => $rows['package_id'],
                            'package_name' => $rows['package_name'],
                            'price' => $rows['price'],
                            'description' => $rows['description'],
                            'image' => 'placeholder',
                            'access' => $access,
                            'status' => $rows['status']

                        );
                    }
                }
            }
        } else {
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    if (file_exists("../handlers/package/" . $rows['image'] . ".jpg")) {
                        $packageJSON[] = array(
                            'package_id' => $rows['package_id'],
                            'package_name' => $rows['package_name'],
                            'price' => $rows['price'],
                            'description' => $rows['description'],
                            'image' => $rows['image'],
                            'status' => $rows['status']
                        );
                    } else {
                        $packageJSON[] = array(
                            'package_id' => $rows['package_id'],
                            'package_name' => $rows['package_name'],
                            'price' => $rows['price'],
                            'description' => $rows['description'],
                            'image' => 'placeholder',
                            'status' => $rows['status']

                        );
                    }
                }
            }
        }

        return json_encode($packageJSON);
    }

    public function setPackage($packageName, $packagePrice, $packageDesc, $packageImage, $packageStatus)
    {
        session_start();
        $packageNameDB = $this->validateInput($packageName);
        $packagePriceDB = $this->validateInput($packagePrice);
        $packageDescDB = $this->validateInput($packageDesc);
        $packageImageDB = $this->validateInput($packageImage);
        $packageStatusDB = $this->validateInput($packageStatus);
        $access = $_SESSION['fourRsuser_type'];
        if ($access == 'admin') {
            if ($this->db->query("INSERT INTO resortdb.package
                        (package_name, price, description, image, status) 
                        VALUES 
                        ('$packageNameDB', $packagePriceDB, '$packageDescDB', '$packageImageDB', $packageStatusDB)")) {
                $lid = $this->db->insert_id;
                if ($packageImageDB == 'placeholder') {
                    $this->db->query("UPDATE resortdb.package SET image = $lid WHERE package_id = $lid");
                    return $lid;
                } else {
                    $this->db->query("UPDATE resortdb.package SET image = 'placeholder' WHERE package_id = $lid");
                    return "1";
                }
            }
            return "0";
        }
        return "0";
    }

    public function displayRoom($packageID)
    {
        $packageIDDB = $this->validateInput($packageID);
        $result = $this->db->query("SELECT * FROM resortdb.package WHERE package_id = $packageIDDB");
        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            $packageInfoJSON = array(
                'package_id' => $rows['package_id'],
                'package_name' => $rows['package_name'],
                'price' => $rows['price'],
                'description' => $rows['description'],
                'image' => $rows['image'],
                'status' => $rows['status']
            );
        }
        return json_encode($packageInfoJSON);
    }

    public function editPackage($roomID, $packageName, $packagePrice, $packageDesc, $roomStatus, $packageImage)
    {
        session_start();
        $idDB = $this->validateInput($roomID);
        $nameDB = $this->validateInput($packageName);
        $priceDB = $this->validateInput($packagePrice);
        $descDB = $this->validateInput($packageDesc);
        $imgDB = $this->validateInput($packageImage);
        $statusDB = $this->validateInput($roomStatus);
        $query = "UPDATE resortdb.package
                    SET package_name = '$nameDB', 
                        price = $priceDB, 
                        description = '$descDB'";
        if ($imgDB == 'edit') {
            $query .= ", image = '$roomID'";
        }
        $query .= ", status = $statusDB 
                WHERE package_id = $idDB";
        $access = $_SESSION['fourRsuser_type'];
        if ($access == 'admin') {
            if ($this->db->query($query)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function getPackage($guestName, $contact, $addon, $quantity, $fee, $isPaid, $paidFee, $downpayment, $packageId, $timeIn, $timeOut)
    {
        session_start();
        $staffID = $_SESSION['fourRsuid'];
        $guestNameDB = $this->validateInput($guestName);
        $contactDB = $this->validateInput($contact);
        $packageIDDB = $this->validateInput($packageId);
        $isPaidDB = $this->validateInput($isPaid);
        $paidFeeDB = $this->validateInput($paidFee);
        $downpaymentDB = $this->validateInput($downpayment);
        $timeInDB = $this->validateInput($timeIn);
        $timeOutDB = $this->validateInput($timeOut);
        $package = $this->db->query("SELECT * FROM resortdb.package WHERE package_id = $packageIDDB");
        if ($package->num_rows > 0) {
            $rows = $package->fetch_assoc();
            $query = "INSERT INTO resortdb.transactions (package_id, price, isPaid, price_paid, downpayment, guest_name, contact, emp_no, time_in, time_out) VALUES($packageIDDB," . $rows['price'] . ", $isPaidDB, $paidFeeDB,  $downpaymentDB, '$guestNameDB', '$contactDB',$staffID, '$timeInDB','$timeOutDB');
                        SELECT @lid :=  LAST_INSERT_ID();";
            if (is_array($addon)) {
                $addOnQuery = "INSERT INTO resortdb.addons (transaction_id, addon_id, quantity, fee) VALUES";
                for ($x = 0; $x < count($addon); $x++) {
                    $addOnValue = $this->validateInput($addon[$x]);
                    $addOnFee = $this->validateInput($fee[$x]);
                    $addOnQuantity = $this->validateInput($quantity[$x]);
                    $query .= "UPDATE resortdb.inventory SET quantity = quantity - $addOnQuantity WHERE id = $addOnValue AND is_available = 1;
                                UPDATE resortdb.inventory SET is_available = 0 WHERE quantity = 0 OR quantity < 0;";
                    $addOnQuery .= "(@lid, $addOnValue, $addOnQuantity, $addOnFee),";
                }
                $query = $query . $addOnQuery;
            }

            if ($this->db->multi_query(substr($query, 0, -1))) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function deleteRoom($packageID)
    {
        session_start();
        $packageIDDB = $this->validateInput($packageID);
        if ($_SESSION['fourRsuser_type'] == 'admin' && $_SESSION['fourRsisActive'] == 1) {
            if ($this->db->query("DELETE FROM resortdb.package WHERE package_id = $packageIDDB")) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function getTransactions($initTrans)
    {
        $initTransDB = $this->validateInput($initTrans);
        $result = $this->db->query("SELECT * FROM resortdb.transactions WHERE id > $initTransDB");
        $transactionJSON = array();
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
                if ($rows['isPaid'] == 0) {
                    $status = 'To pay';
                } elseif ($rows['isPaid'] == 1) {
                    $status = 'Paid';
                } elseif ($rows['isPaid'] == 3) {
                    $status = 'To confirm';
                } elseif ($rows['isPaid'] == 4) {
                    $status = 'Confirmed';
                }
                $transactionJSON[] = array(
                    "id" => $rows['id'],
                    "guest_name" => $rows['guest_name'],
                    "date" => convertToTextDate($rows['date']),
                    "price_paid" => $rows['price_paid'],
                    "isPaid" => $status
                );
            }
        }
        return json_encode($transactionJSON);
    }
    public function getTransactionChart($initTrans, $filter)
    {
        $initTransDB = $this->validateInput($initTrans);
        $date =  date("Y-m-d H:i:s");
        $query = "SELECT SUM(price_paid) AS total_paid, DATE_FORMAT(date, '%e') AS day, DATE_FORMAT(date, '%U') AS week, DATE_FORMAT(date, '%M') AS month, DATE_FORMAT(date, '%Y') AS year FROM resortdb.transactions WHERE id > $initTransDB";
        if ($filter == 0) {
            $query .= " AND date BETWEEN (SELECT DATE_ADD('$date', INTERVAL -7 DAY) AS transactions) AND '$date' GROUP BY DATE_FORMAT(date, '%D') ORDER BY date ASC";
        } else if ($filter == 1) {
            $query .= " AND DATE_FORMAT(date, '%M') =  DATE_FORMAT('$date', '%M') GROUP BY DATE_FORMAT(date, '%U') ORDER BY date ASC";
        } elseif ($filter == 2) {
            $query .= " GROUP BY DATE_FORMAT(date, '%M'), DATE_FORMAT('$date', '%Y') ORDER BY date ASC";
        }
        $result = $this->db->query($query);
        $transactionJSON = array();
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
                $transactionJSON[] = array(
                    "day" => $rows['day'],
                    "week" => $rows['week'],
                    "month" => $rows['month'],
                    "year" => $rows['year'],
                    "total_paid" => $rows['total_paid']
                );
            }
        }
        return json_encode($transactionJSON);
    }
    public function openTransaction($transactID)
    {
        $transactIDDB = $this->validateInput($transactID);
        $addOnsJSON = array();
        $result = $this->db->query("SELECT 
        t.id,
        t.date,
        t.time_in,
        t.time_out,
        t.price AS trans_price,
        t.isPaid,
        t.receipt,
        t.id_file,
        t.price_paid,
        t.downpayment,
        t.guest_name,
        t.contact,
        p.package_name,
        p.price AS package_price,
        p.image,
        CONCAT(u.fname, ' ', u.lname) AS name
        FROM resortdb.transactions t 
        LEFT JOIN resortdb.users u ON t.emp_no = u.user_id
        LEFT JOIN resortdb.package p ON t.package_id = p.package_id
        WHERE t.id = $transactIDDB");
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
                $transactionInfoJSON = array(
                    "id" => $rows['id'],
                    "date" => convertToTextDate($rows['date']),
                    "time_in" => convertToTextDate($rows['time_in']),
                    "time_out" => convertToTextDate($rows['time_out']),
                    "trans_price" => $rows['trans_price'],
                    "status" => $rows['isPaid'],
                    "price_paid" => $rows['price_paid'],
                    "receipt" => $rows['receipt'],
                    "id_file" => $rows['id_file'],
                    "downpayment" => $rows['downpayment'],
                    "guest_name" => $rows['guest_name'],
                    "contact" => $rows['contact'],
                    "staff_name" => $rows['name'],
                    "package_name" => $rows['package_name'],
                    "image" => $rows['image'],
                    "package_price" => $rows['package_price']
                );
            }
            $addOnsQuery = $this->db->query("SELECT a.id, a.addon_id, a.quantity, a.fee, i.item_desc, i.quantity AS inventory_quantity, i.price FROM resortdb.addons a JOIN inventory i ON a.addon_id = i.id WHERE a.transaction_id = $transactIDDB");
            if ($addOnsQuery->num_rows > 0) {
                while ($rows = $addOnsQuery->fetch_assoc()) {
                    $addOnsJSON[] = array(
                        "id" => $rows['id'],
                        "item_desc" => $rows['item_desc'],
                        "quantity" => $rows['quantity'],
                        "inventory_quantity"  => $rows['inventory_quantity'],
                        "price" => $rows['price'],
                        "addon_id" => $rows["addon_id"],
                        "fee" => $rows["fee"]
                    );
                }
            }
            $totalAddOnsQuery = $this->db->query("SELECT * FROM resortdb.inventory WHERE is_available = 1");
            if ($totalAddOnsQuery->num_rows > 0) {
                while ($rows = $totalAddOnsQuery->fetch_assoc()) {
                    $totalAddOnsJSON[] = array(
                        "id" => $rows['id'],
                        "item_desc" => $rows['item_desc'],
                        "quantity" => $rows['quantity'],
                        "price" => $rows["price"]
                    );
                }
            }
        }
        $transactionJSON = array(
            "transact_info" => $transactionInfoJSON,
            "addons_info" => $addOnsJSON,
            "all_addons" => $totalAddOnsJSON
        );
        return json_encode($transactionJSON, JSON_FORCE_OBJECT);
    }
    public function editTransaction($transactID, $timeOut, $addons, $quantity, $amountPaid, $isPaid)
    {
        session_start();
        $transactIDDB = $this->validateInput($transactID);
        $timeOutDB = $this->validateInput($timeOut);
        $amountPaidDB = $this->validateInput($amountPaid);
        $isPaidDB = $this->validateInput($isPaid);
        $user = $_SESSION['fourRsuid'];

        $isPaidDB = $this->validateInput($isPaid);
        $query = "UPDATE resortdb.transactions SET time_out = '$timeOutDB', isPaid = $isPaidDB, price_paid = $amountPaidDB, emp_no = $user WHERE id = $transactIDDB;";
        if (is_array($addons)) {
            $query .= "DELETE FROM resortdb.addons WHERE transaction_id = $transactIDDB;";
            $addonQuery = '';
            $count = 0;
            foreach ($addons as $value) {
                $addonDB = $this->validateInput($value);
                $quantityDB = $this->validateInput($quantity[$count]);
                $addonQuery .= "INSERT INTO resortdb.addons (transaction_id, addon_id, quantity, fee) 
                SELECT '$transactIDDB', '$addonDB', '$quantityDB', '$quantityDB' * price FROM resortdb.inventory WHERE id = '$addonDB';";
                $count++;
            }
            $query = $query .= $addonQuery;
        }
        if ($this->db->multi_query($query)) {
            return true;
        }
        return false;
    }
    public function getInventory()
    {
        $inventoryJSON = array();
        if ($result = $this->db->query("SELECT * FROM resortdb.inventory")) {
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    $inventoryJSON[] = array(
                        "id" => $rows['id'],
                        "item_desc" => $rows['item_desc'],
                        "quantity" => $rows['quantity'],
                        "is_available" => convertAvailability($rows['is_available'])
                    );
                }
                return json_encode($inventoryJSON);
            }
            return false;
        }
        return false;
    }
    public function getAddOns()
    {
        $inventoryJSON = array();
        if ($result = $this->db->query("SELECT * FROM resortdb.inventory WHERE quantity > 0")) {
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    $inventoryJSON[] = array(
                        "id" => $rows['id'],
                        "item_desc" => $rows['item_desc'],
                        "quantity" => $rows['quantity'],
                        "is_available" => convertAvailability($rows['is_available']),
                        "price" => $rows['price']
                    );
                }
                return json_encode($inventoryJSON);
            }
            return false;
        }
        return false;
    }
    public function getInventoryInfo($productID)
    {
        $productIDDB = $this->validateInput($productID);
        if ($rst = $this->db->query("SELECT * FROM resortdb.inventory WHERE id = $productIDDB")) {
            if ($rst->num_rows > 0) {
                $rows = $rst->fetch_assoc();
                $inventoryJSON = array(
                    "id" => $rows['id'],
                    "item_desc" => $rows['item_desc'],
                    "quantity" => $rows['quantity'],
                    "is_available" => $rows['is_available'],
                    "price" => $rows['price']
                );
                return json_encode($inventoryJSON);
            }
            return false;
        }
        return false;
    }
    public function editInventory($productID, $productName, $productQuantity, $productPrice, $productAvailability)
    {
        $productIDDB = $this->validateInput($productID);
        $productNameDB = $this->validateInput($productName);
        $productQuantityDB = $this->validateInput($productQuantity);
        $productAvailabilityDB = $this->validateInput($productAvailability);
        $productPriceDB = $this->validateInput($productPrice);
        session_start();
        if ($_SESSION['fourRsuser_type'] == 'admin') {
            if ($this->db->query("UPDATE resortdb.inventory SET item_desc = '$productNameDB', quantity = $productQuantityDB, price = $productPriceDB, is_available = $productAvailabilityDB WHERE id = $productIDDB")) {
                return true;
            }
        }
        return false;
    }
    public function addInventory($productName, $productQuantity, $productPrice, $productAvailability)
    {
        $productNameDB = $this->validateInput($productName);
        $productQuantityDB = $this->validateInput($productQuantity);
        $productPriceDB = $this->validateInput($productPrice);
        $productAvailabilityDB = $this->validateInput($productAvailability);
        if ($this->db->query("INSERT INTO resortdb.inventory (item_desc, quantity, price, is_available) VALUES ('$productNameDB', '$productQuantityDB', '$productPriceDB', '$productAvailabilityDB')")) {
            return true;
        }
        return false;
    }
    public function deleteItem($productID)
    {
        $productIDDB = $this->validateInput($productID);
        // $query = "DELETE FROM resortdb.inventory WHERE id = '$productIDDB'";
        // exit($query);
        if ($this->db->query("DELETE FROM resortdb.inventory WHERE id = '$productIDDB'")) {
            return true;
        }
        return false;
    }
    public function getUsers()
    {
        $usersJSON = array();
        session_start();
        if ($_SESSION['fourRsuser_type'] == 'admin') {
            if ($rst = $this->db->query("SELECT user_id, user_type, CONCAT(fname, ' ', mname, ' ', lname) AS name, email, password , is_active FROM resortdb.users WHERE user_type ='staff'")) {
                if ($rst->num_rows > 0) {
                    while ($rows = $rst->fetch_assoc()) {
                        $usersJSON[] = array(
                            "user_id" => $rows["user_id"],
                            "user_type" => ucfirst($rows["user_type"]),
                            "name" => $rows["name"],
                            "email" => $rows["email"],
                            "password" => $rows["password"],
                            "is_active" => $rows['is_active']
                        );
                    }
                }
                return json_encode($usersJSON);
            }
            return false;
        }
        return false;
    }
    public function getUserInfo($userid)
    {
        $useridDB = $this->validateInput($userid);

        session_start();
        if ($_SESSION['fourRsuser_type'] == 'admin') {
            if ($result = $this->db->query("SELECT user_id, user_type, CONCAT(fname, ' ', mname, ' ', lname) AS name, email, password, is_active FROM resortdb.users WHERE user_id = $useridDB")) {
                if ($result->num_rows > 0) {
                    $rows = $result->fetch_assoc();
                    return json_encode($rows);
                }
            }
            return false;
        }
        return false;
    }

    public function addUserInfo($fname, $mname, $lname, $suffix, $email, $password, $isActive, $role)
    {
        session_start();
        if ($_SESSION['fourRsuser_type'] != 'admin') {
            return false;
        }
        $fnameDB = $this->validateInput($fname);
        $mnameDB = $this->validateInput($mname);
        $lnameDB = $this->validateInput($lname);
        $suffixDB = $this->validateInput($suffix);
        $emailDB = $this->validateInput($email);
        $passwordDB = $this->validateInput($password);
        $isActiveDB = $this->validateInput($isActive);
        $roleDB = $this->validateInput($role);
        $firstID = date("Ym");
        $rst = $this->db->query("SELECT MAX(id) AS max FROM resortdb.users");
        if ($rst->num_rows > 0) {
            $maxid = $rst->fetch_assoc();
        } else {
        }
        $newID =  $firstID .= sprintf('%04d', $maxid['max'] + 1);
        if ($this->db->query("INSERT INTO resortdb.users (user_id, user_type, is_active, fname, mname, lname, suffix, email, password) VALUES($newID, '$roleDB', $isActiveDB, '$fnameDB', '$mnameDB', '$lnameDB', '$suffixDB', '$emailDB', '$passwordDB')")) {
            return true;
        } else {
            return false;
        }
    }
    public function editUser($uid, $password, $isActive)
    {
        session_start();
        if ($_SESSION['fourRsuser_type'] == 'admin') {
            $uidDB = $this->validateInput($uid);
            $passwordDB = $this->validateInput($password);
            $isActiveDB = $this->validateInput($isActive);
            if ($this->db->query("UPDATE resortdb.users SET password = '$passwordDB', is_active = $isActiveDB WHERE user_id = '$uidDB'")) {
                return true;
            }
        }
        return false;
    }
    public function deleteUser($uid)
    {
        $uidDB = $this->validateInput($uid);
        if ($this->db->query("DELETE FROM resortdb.users WHERE user_id = $uidDB")) {
            return true;
        }
        return false;
    }
    public function changeUserPassword($oldPassword, $newPassword)
    {
        session_start();
        $oldPasswordDB = $this->validateInput($oldPassword);
        $newPasswordDB = $this->validateInput($newPassword);
        $userID = $_SESSION['fourRsuid'];
        $this->db->query("UPDATE resortdb.users SET password = '$newPasswordDB' WHERE user_id = $userID AND password = '$oldPasswordDB'");
        if ($this->db->affected_rows >  0) {
            // session_destroy();

            echo 1;
        }
        echo 0;
    }
    function validateInput($input)
    {
        return $this->db->real_escape_string(htmlspecialchars($input));
    }
    public function getOnlineBooking($filter)
    {
        $packageJSON = array();
        $filterDB = $this->validateInput($filter);
        $queryBuilder = "SELECT * FROM resortdb.package WHERE 1=1";
        switch ($filterDB) {
            case '1':
                $queryBuilder .= " AND price < 2000";
                break;
            case '2':
                $queryBuilder .= " AND price BETWEEN 2000 AND 4000";

                break;
            case '3':
                $queryBuilder .= " AND price > 4000";
                break;
        }
        $rst = $this->db->query($queryBuilder);
        if ($rst->num_rows > 0) {
            while ($rows = $rst->fetch_assoc()) {
                if (file_exists("../handlers/package/" . $rows['image'] . ".jpg")) {
                    $packageJSON[] = array(
                        'package_id' => $rows['package_id'],
                        'package_name' => $rows['package_name'],
                        'price' => $rows['price'],
                        'description' => $rows['description'],
                        'image' => $rows['image'],
                        'status' => $rows['status']
                    );
                } else {
                    $packageJSON[] = array(
                        'package_id' => $rows['package_id'],
                        'package_name' => $rows['package_name'],
                        'price' => $rows['price'],
                        'description' => $rows['description'],
                        'image' => 'placeholder',
                        'status' => $rows['status']

                    );
                }
            }
        }
        return json_encode($packageJSON);
    }
    public function bookOnline($packageID, $guestName, $timeIn, $timeOut, $contactNo, $idFile, $receiptFile)
    {
        $packageID = $this->validateInput($packageID);
        $guestName = $this->validateInput($guestName);
        $contactNo = $this->validateInput($contactNo);
        $idFile = $this->validateInput($idFile);
        $receiptFile = $this->validateInput($receiptFile);
        $timeIn = date("Y-m-d H:i:s", strtotime($this->validateInput($timeIn)));
        $timeOut = date("Y-m-d H:i:s", strtotime($this->validateInput($timeOut)));
        $priceQuery = $this->db->query("SELECT price from resortdb.package WHERE package_id = '$packageID';");
        if ($priceQuery->num_rows > 0) {
            $priceRow = $priceQuery->fetch_assoc();
            $price = $priceRow['price'];
            $this->db->query("INSERT INTO resortdb.transactions (package_id, date, time_in, time_out, price, isPaid, receipt, id_file, guest_name, contact) 
                                VALUES ('$packageID',now(),'$timeIn','$timeOut', $price, '3','$receiptFile', '$idFile', '$guestName', '$contactNo');");
            return $this->db->insert_id;
        }
        return 0;
    }
    public function confirmOnlineBooking($confirmID)
    {
        session_start();
        $user = $_SESSION['fourRsuid'];
        $confirmID = $this->validateInput($confirmID);
        if ($this->db->query("UPDATE resortdb.transactions SET isPaid = 4, emp_no = '$user', downpayment = price/2 WHERE id = '$confirmID';")) {
            return true;
        }
        return false;
    }
    public function getTransactionTable($initID, $filter)
    {
        $jsonData =  array();
        $queryBuilder = 'SELECT * FROM resortdb.transactions WHERE 1=1';
        switch ($filter) {
            case '0':
                $queryBuilder .= " AND date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
                break;
            case '1':
                $queryBuilder .= " AND MONTH(date) = MONTH(CURRENT_DATE) AND YEAR(date) = YEAR(CURRENT_DATE)";
                break;
            case '2':
                $queryBuilder .= " AND YEAR(date) = YEAR(CURRENT_DATE)";
                break;
        }
        $rst = $this->db->query($queryBuilder);
        if ($rst->num_rows > 0) {
            while ($rows = $rst->fetch_assoc()) {
                $jsonData[] = array(
                    'id' => $rows['id'],
                    'date' => convertToTextDate($rows['date']),
                    'price_paid' => $rows['price_paid'],
                    'guest_name' => $rows['guest_name']
                );
            }
        }
        return json_encode($jsonData);
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
