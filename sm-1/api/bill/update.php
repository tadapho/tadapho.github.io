<?php
session_start();
require_once "../../src/Controllers/ConnectController.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
    exit();
}

$ID = $_POST['ID'];
$Bill_ID = $_POST['biIdInput'];

// Fetch the current record from the database
// $stmt = $PDOconn->prepare("SELECT * FROM Bill WHERE Bill_ID = :bill_id");
// $stmt->bindParam(':Bill_ID', $ID);
// $stmt->execute();
// $bill = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_FILES['biSlip50Input']) && $_FILES['biSlip50Input']['error'] === UPLOAD_ERR_OK) {
    $Slip_50 = file_get_contents($_FILES['biSlip50Input']['tmp_name']); // Read file contents for blob
} else {
    $Slip_50 = null;
    $stmt = $PDOconn->prepare("SELECT * FROM Bill WHERE Bill_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();
    $bill = $stmt->fetch(PDO::FETCH_ASSOC);
    $Slip_50 = $bill['Slip_50']; // Using array notation
}
if (isset($_FILES['biSlip30Input']) && $_FILES['biSlip30Input']['error'] === UPLOAD_ERR_OK) {
    $Slip_30 = file_get_contents($_FILES['biSlip30Input']['tmp_name']); // Read file contents for blob
} else {
    $Slip_30 = null;
    $stmt = $PDOconn->prepare("SELECT * FROM Bill WHERE Bill_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();
    $bill = $stmt->fetch(PDO::FETCH_ASSOC);
    $Slip_30 = $bill['Slip_30']; // Using array notation
}
if (isset($_FILES['biSlip20Input']) && $_FILES['biSlip20Input']['error'] === UPLOAD_ERR_OK) {
    $Slip_20 = file_get_contents($_FILES['biSlip20Input']['tmp_name']); // Read file contents for blob
} else {
    $Slip_20 = null;
    $stmt = $PDOconn->prepare("SELECT * FROM Bill WHERE Bill_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();
    $bill = $stmt->fetch(PDO::FETCH_ASSOC);
    $Slip_30 = $bill['Slip_20']; // Using array notation
}

$Pay_50 = 0;
$Pay_30 = 0;
$Pay_20 = 0;
$Status_50 = $_POST['biStatus50Input'];
$Status_30 = $_POST['biStatus30Input'];
$Status_20 = $_POST['biStatus20Input'];
$DatePay_50 = $_POST['biDatePay50Input'];
if ($DatePay_50 === '') {
    $DatePay_50 = null;
    $DatePay_30 = null;
    $DatePay_20 = null;
} else {
    $DatePay_30 = date('Y-m-d', strtotime($DatePay_50 . '+15 days'));
    $DatePay_20 = date('Y-m-d', strtotime($DatePay_50 . '+18 days'));
}
$Cus_ID = $_POST['cusIdSelect'];
if ($Cus_ID === '') {
    $Cus_ID = null;
}

try {
    $stmt = $PDOconn->prepare("UPDATE Bill 
                           SET Bill_ID = :Bill_ID, 
                                Slip_50 = :Slip_50, 
                                Slip_30 = :Slip_30, 
                                Slip_20 = :Slip_20, 
                                Status_50 = :Status_50, 
                                Status_30 = :Status_30, 
                                Status_20 = :Status_20, 
                                DatePay_50 = :DatePay_50, 
                                DatePay_30 = :DatePay_30, 
                                DatePay_20 = :DatePay_20,
                                Cus_ID = :Cus_ID
                           WHERE Bill_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':Bill_ID', $Bill_ID);
    $stmt->bindParam(':Slip_50', $Slip_50);
    $stmt->bindParam(':Slip_30', $Slip_30);
    $stmt->bindParam(':Slip_20', $Slip_20);
    $stmt->bindParam(':Status_50', $Status_50);
    $stmt->bindParam(':Status_30', $Status_30);
    $stmt->bindParam(':Status_20', $Status_20);
    $stmt->bindParam(':DatePay_50', $DatePay_50);
    $stmt->bindParam(':DatePay_30', $DatePay_30);
    $stmt->bindParam(':DatePay_20', $DatePay_20);
    $stmt->bindParam(':Cus_ID', $Cus_ID);
    $stmt->execute();

    http_response_code(200);
    echo json_encode(array("message" => "Data update successfully."));
} catch (PDOException $e) {
    // Handle database errors
    http_response_code(500);
    echo json_encode(array("message" => "Database Error: " . $e->getMessage()));
} catch (Exception $e) {
    // Handle other errors
    http_response_code(400);
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}
