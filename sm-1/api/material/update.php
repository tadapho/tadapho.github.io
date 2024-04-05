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
$M_SKU = $data['maSkuInput'];
$M_name = $data['maNameInput'];
$M_Stock = $data['maStockInput'];
$M_price = $data['maPriceInput'];
$Sup_ID = $data['subIdSelect'];
if($Sup_ID === '') {
    $Sup_ID = null;
}

try {
    $PDOconn->beginTransaction();
    $stmt = $PDOconn->prepare("UPDATE Material 
                                SET M_SKU = :M_SKU,
                                    M_name = :M_name, 
                                    M_Stock = :M_Stock,
                                    M_price = :M_price
                                WHERE M_SKU = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':M_SKU', $M_SKU);
    $stmt->bindParam(':M_name', $M_name);
    $stmt->bindParam(':M_Stock', $M_Stock);
    $stmt->bindParam(':M_price', $M_price);
    $stmt->execute();
    $stmt = $PDOconn->prepare("UPDATE Sending_Materal 
                                SET M_SKU = :M_SKU,
                                    Sup_ID = :Sup_ID
                                WHERE M_SKU = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':M_SKU', $M_SKU, PDO::PARAM_STR);
    $stmt->bindParam(':Sup_ID', $Sup_ID, PDO::PARAM_STR);
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
