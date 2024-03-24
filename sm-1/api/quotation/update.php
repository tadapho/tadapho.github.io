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
$Quot_ID = $data['quoIdInput'];
$Net_Price = $data['quoNetpriceInput'];
if ($Net_Price === '') {
    $Net_Price = 0;
}
$Quot_date = $data['quoDateInput'];
if ($Quot_date === '') {
    $Quot_date = null;
}

$Quot_detail = $data['quoDetailInput'];
$Cus_ID = $data['cusIdSelect'];
if ($Cus_ID === '') {
    $Cus_ID = null;
}
$M_SKU = $data['maSkuSelect'];
$Use_num = $data['useNumInput'];
$Emp_ID = $data['empIdSelect'];
if ($Emp_ID === '') {
    $Emp_ID = null;
}
$Project_ID = $data['ProjectIdSelect'];
if ($Project_ID === '') {
    $Project_ID = null;
}
$Bill_ID = $data['billIdSelect'];
if ($Bill_ID === '') {
    $Bill_ID = null;
}

try {
    $stmt = $PDOconn->prepare("UPDATE Quotation 
                                SET Quot_ID = :Quot_ID, 
                                    Net_Price = :Net_Price, 
                                    Quot_date = :Quot_date, 
                                    Quot_detail = :Quot_detail,
                                    Project_ID = :Project_ID,
                                    Bill_ID = :Bill_ID
                                WHERE Quot_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':Quot_ID', $Quot_ID);
    $stmt->bindParam(':Net_Price', $Net_Price);
    $stmt->bindParam(':Quot_date', $Quot_date);
    $stmt->bindParam(':Quot_detail', $Quot_detail);
    $stmt->bindParam(':Project_ID', $Project_ID);
    $stmt->bindParam(':Bill_ID', $Bill_ID);
    $stmt->execute();

    $stmt = $PDOconn->prepare("UPDATE Material_Use 
    SET M_SKU = :M_SKU,
        Use_num = :Use_num
    WHERE Quot_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':M_SKU', $M_SKU);
    $stmt->bindParam(':Use_num', $Use_num);
    $stmt->execute();
    
    $stmt = $PDOconn->prepare("UPDATE Managment_Quottaiont_Employee 
                                SET Emp_ID = :Emp_ID
                                WHERE Quot_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':Emp_ID', $Emp_ID);
    $stmt->execute();

    $stmt = $PDOconn->prepare("UPDATE Quot_Cus 
                                SET Cus_ID = :Cus_ID
                                WHERE Quot_ID = :ID");
    $stmt->bindParam(':ID', $ID);
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
