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
$PO_ID = $data['proIdInput'];
$PO_month = $data['proMonthInput'];
$PO_detail = $data['proDetailInput'];
$M_SKU = $data['maSkuSelect'];
if($M_SKU === '') {
    $M_SKU = null;
}

try {
    $PDOconn->beginTransaction();
    $stmt = $PDOconn->prepare("UPDATE Production_Order 
                                SET PO_ID = :PO_ID,
                                    PO_month = :PO_month, 
                                    PO_detail = :PO_detail
                                WHERE PO_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':PO_ID', $PO_ID);
    $stmt->bindParam(':PO_month', $PO_month);
    $stmt->bindParam(':PO_detail', $PO_detail);
    $stmt->execute();
    $stmt = $PDOconn->prepare("UPDATE Material_PO 
                                SET M_SKU = :M_SKU
                                WHERE PO_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':M_SKU', $M_SKU);
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
