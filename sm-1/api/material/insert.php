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

$M_SKU = $data['maSkuInput'];
$M_name = $data['maNameInput'];
$M_Stock = $data['maStockInput'];
if($M_Stock === '') {
    $M_Stock = 0;
}
$M_price = $data['maPriceInput'];
if($M_price === '') {
    $M_price = 0;
}
$Sup_ID = $data['subIdSelect'];

try {
    // Check if the M_SKU already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Material WHERE M_SKU = :M_SKU");
    $stmt_check->bindParam(':M_SKU', $M_SKU);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "M_SKU already exists."));
        exit;
    } else {
        // Insert new data
        $stmt = $PDOconn->prepare("INSERT INTO Material (M_SKU, M_name, M_Stock, M_price) VALUES (:M_SKU, :M_name, :M_Stock, :M_price)");
        $stmt->bindParam(':M_SKU', $M_SKU, PDO::PARAM_STR);
        $stmt->bindParam(':M_name', $M_name, PDO::PARAM_STR);
        $stmt->bindParam(':M_Stock', $M_Stock, PDO::PARAM_INT);
        $stmt->bindParam(':M_price', $M_price, PDO::PARAM_INT);
        $stmt->execute();
        // Insert new data
        // $stmt = $PDOconn->prepare("INSERT INTO Sending_Materal (M_SKU, Sup_ID) VALUES (:M_SKU, :Sup_ID)");
        // $stmt->bindParam(':M_SKU', $M_SKU, PDO::PARAM_STR);
        // $stmt->bindParam(':Sup_ID', $Sup_ID, PDO::PARAM_STR);
        // $stmt->execute();
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
