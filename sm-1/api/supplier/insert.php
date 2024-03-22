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

$Sup_ID = $data['supIdInput'];
$Sup_name = $data['supNameInput'];
$Sup_Tel = $data['supTelInput'];
$Sup_HNo = $data['supHnoInput'];
$Sup_street = $data['supStreetInput'];
$Sup_zipcode = $data['supZipcodeInput'];
$Sup_city = $data['supCityInput'];
$Project_ID = $data['supProjectSelect'];
if ($Project_ID === '') {
    $Project_ID = null;
}

try {
    // Check if the Sup_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Supplier WHERE Sup_ID = :Sup_ID");
    $stmt_check->bindParam(':Sup_ID', $Sup_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "Sup_ID already exists."));
        exit;
    } else {
        // Insert new data
        $stmt = $PDOconn->prepare("INSERT INTO Supplier (Sup_ID, Sup_name, Sup_Tel, Sup_HNo, Sup_street, Sup_zipcode, Sup_city, Project_ID) 
                                    VALUES (:Sup_ID, :Sup_name, :Sup_Tel, :Sup_HNo, :Sup_street, :Sup_zipcode, :Sup_city, :Project_ID)");
        $stmt->bindParam(':Sup_ID', $Sup_ID);
        $stmt->bindParam(':Sup_name', $Sup_name);
        $stmt->bindParam(':Sup_Tel', $Sup_Tel);
        $stmt->bindParam(':Sup_HNo', $Sup_HNo);
        $stmt->bindParam(':Sup_street', $Sup_street);
        $stmt->bindParam(':Sup_zipcode', $Sup_zipcode);
        $stmt->bindParam(':Sup_city', $Sup_city);
        $stmt->bindParam(':Project_ID', $Project_ID);
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
