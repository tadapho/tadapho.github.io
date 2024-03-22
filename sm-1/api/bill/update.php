<?php
session_start();
require_once "../../src/Controllers/ConnectController.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
    exit();
}

// Check data
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (!isset($data)) {
    http_response_code(422);
    echo json_encode(array("error" => "Input is required."));
    exit;
}

$ID = $data['ID'];
$Bill_ID = $data['biIdInput'];
$Pay_50 = $data['biPay50Input'];
if ($Pay_50 === '') {
    $Pay_50 = 0;
}
$Pay_30 = $data['biPay30Input'];
if ($Pay_30 === '') {
    $Pay_30 = 0;
}
$Pay_20 = $data['biPay20Input'];
if ($Pay_20 === '') {
    $Pay_20 = 0;
}
$Status_50 = $data['biStatus50Input'];
$Status_30 = $data['biStatus30Input'];
$Status_20 = $data['biStatus20Input'];
$DatePay_50 = $data['biDatePay50Input'];
if ($DatePay_50 === '') {
    $DatePay_50 = null;
}

$DatePay_30 = $data['biDatePay30Input'];
if ($DatePay_30 === '') {
    $DatePay_30 = null;
}

$DatePay_20 = $data['biDatapay20Input'];
if ($DatePay_20 === '') {
    $DatePay_20 = null;
}

$Cus_ID = $data['cusIdSelect'];
if ($Cus_ID === '') {
    $Cus_ID = null;
}
try {
    $stmt = $PDOconn->prepare("UPDATE Bill 
                           SET Bill_ID = :Bill_ID, 
                                Pay_50 = :Pay_50, 
                                Pay_30 = :Pay_30, 
                                Pay_20 = :Pay_20, 
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
    $stmt->bindParam(':Pay_50', $Pay_50);
    $stmt->bindParam(':Pay_30', $Pay_30);
    $stmt->bindParam(':Pay_20', $Pay_20);
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
