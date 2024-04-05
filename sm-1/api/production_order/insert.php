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

$PO_ID = $data['proIdInput'];
$PO_month = $data['proMonthInput'];
$PO_detail = $data['proDetailInput'];
$M_SKU = $data['maSkuSelect'];
if($M_SKU === '') {
    $M_SKU = null;
}

try {
    // Check if the PO_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Production_Order WHERE PO_ID = :PO_ID");
    $stmt_check->bindParam(':PO_ID', $PO_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "PO_ID already exists."));
        exit;
    } else {
        $PDOconn->beginTransaction();
        // Insert new data
        $stmt = $PDOconn->prepare("INSERT INTO Production_Order (PO_ID, PO_month, PO_detail) VALUES (:PO_ID, :PO_month, :PO_detail)");
        $stmt->bindParam(':PO_ID', $PO_ID);
        $stmt->bindParam(':PO_month', $PO_month);
        $stmt->bindParam(':PO_detail', $PO_detail);
        $stmt->execute();

        // Insert new data
        $stmt = $PDOconn->prepare("INSERT INTO Material_PO (PO_ID, M_SKU) VALUES (:PO_ID, :M_SKU)");
        $stmt->bindParam(':PO_ID', $PO_ID);
        $stmt->bindParam(':M_SKU', $M_SKU);
        $stmt->execute();
        $PDOconn->commit();
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
