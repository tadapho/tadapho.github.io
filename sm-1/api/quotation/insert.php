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
if ($M_SKU === '') {
    $M_SKU = null;
}
$Use_num = $data['useNumInput'];
if ($Use_num === '') {
    $Use_num = 0;
}
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
    // Check if the Quot_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Quotation WHERE Quot_ID = :Quot_ID");
    $stmt_check->bindParam(':Quot_ID', $Quot_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "Quot_ID already exists."));
        exit;
    } else {
        // Insert new data into Employee table
        $stmt = $PDOconn->prepare("INSERT INTO Quotation (Quot_ID, Net_Price, Quot_date, Quot_detail, Project_ID, Bill_ID) 
                                    VALUES (:Quot_ID, :Net_Price, :Quot_date, :Quot_detail, :Project_ID, :Bill_ID)");
        $stmt->bindParam(':Quot_ID', $Quot_ID);
        $stmt->bindParam(':Net_Price', $Net_Price);
        $stmt->bindParam(':Quot_date', $Quot_date);
        $stmt->bindParam(':Quot_detail', $Quot_detail);
        $stmt->bindParam(':Project_ID', $Project_ID);
        $stmt->bindParam(':Bill_ID', $Bill_ID);
        $stmt->execute();
        // Insert new data into Managment_Quottaiont_Employee table
        $stmt = $PDOconn->prepare("INSERT INTO Managment_Quottaiont_Employee (Quot_ID, Emp_ID) 
                                    VALUES (:Quot_ID, :Emp_ID)");
        $stmt->bindParam(':Quot_ID', $Quot_ID);
        $stmt->bindParam(':Emp_ID', $Emp_ID);
        $stmt->execute();
        // Insert new data into Managment_Quottaiont_Employee table
        $stmt = $PDOconn->prepare("INSERT INTO Quot_Cus (Quot_ID, Cus_ID) 
                                    VALUES (:Quot_ID, :Cus_ID)");
        $stmt->bindParam(':Quot_ID', $Quot_ID);
        $stmt->bindParam(':Cus_ID', $Cus_ID);
        $stmt->execute();
        // Insert new data into Managment_Quottaiont_Employee table
        $stmt = $PDOconn->prepare("INSERT INTO Material_Use (Quot_ID, M_SKU, Use_num) 
                                    VALUES (:Quot_ID, :M_SKU, :Use_num)");
        $stmt->bindParam(':Quot_ID', $Quot_ID);
        $stmt->bindParam(':M_SKU', $M_SKU);
        $stmt->bindParam(':Use_num', $Use_num);
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
