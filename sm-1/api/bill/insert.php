<?php
session_start();
require_once "../../src/Controllers/ConnectController.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
    exit();
}

$Bill_ID = $_POST['biIdInput'];
if (isset($_FILES['biSlip50Input']) && $_FILES['biSlip50Input']['error'] === UPLOAD_ERR_OK) {
    $Slip_50 = file_get_contents($_FILES['biSlip50Input']['tmp_name']); // Read file contents for blob
} else {
    $Slip_50 = null;
}
if (isset($_FILES['biSlip30Input']) && $_FILES['biSlip30Input']['error'] === UPLOAD_ERR_OK) {
    $Slip_30 = file_get_contents($_FILES['biSlip30Input']['tmp_name']); // Read file contents for blob
} else {
    $Slip_30 = null;
}
if (isset($_FILES['biSlip20Input']) && $_FILES['biSlip20Input']['error'] === UPLOAD_ERR_OK) {
    $Slip_20 = file_get_contents($_FILES['biSlip20Input']['tmp_name']); // Read file contents for blob
} else {
    $Slip_20 = null;
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
    // Check if the Quot_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Bill WHERE Bill_ID = :Bill_ID");
    $stmt_check->bindParam(':Bill_ID', $Bill_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "Bill_ID already exists."));
        exit;
    } else {
        $stmt = $PDOconn->prepare("INSERT INTO Bill (Bill_ID, Slip_50, Slip_30, Slip_20, Status_50, Status_30, Status_20, DatePay_50, DatePay_30, DatePay_20, Cus_ID) 
                            VALUES (:Bill_ID, :Slip_50, :Slip_30, :Slip_20, :Status_50, :Status_30, :Status_20, :DatePay_50, :DatePay_30, :DatePay_20, :Cus_ID)");
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
    }
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