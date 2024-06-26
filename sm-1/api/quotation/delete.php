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
if (!isset($data['ID']) && empty($data['ID'])) {
    http_response_code(422);
    echo json_encode(array("error" => "ID is required."));
    exit;
}

$ID = $data['ID'];

try {
    $PDOconn->beginTransaction();

    $stmt = $PDOconn->prepare("DELETE FROM Quotation WHERE Quot_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();

    $stmt = $PDOconn->prepare("DELETE FROM Managment_Quottaiont_Employee WHERE Quot_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();

    $stmt = $PDOconn->prepare("DELETE FROM Quot_Cus WHERE Quot_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();

    $stmt = $PDOconn->prepare("DELETE FROM Material_Use WHERE Quot_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();
    
    $PDOconn->commit();
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
