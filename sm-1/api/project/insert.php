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

$Project_ID = $data['proIdInput'];
$P_name = $data['proNameInput'];
$P_num = $data['proNumInput'];

try {
    // Check if the Project_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Project WHERE Project_ID = :Project_ID");
    $stmt_check->bindParam(':Project_ID', $Project_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "Project_ID already exists."));
        exit;
    } else {
        // Insert new data
        $stmt = $PDOconn->prepare("INSERT INTO Project (Project_ID, P_name, P_num) VALUES (:Project_ID, :P_name, :P_num)");
        $stmt->bindParam(':Project_ID', $Project_ID);
        $stmt->bindParam(':P_name', $P_name);
        $stmt->bindParam(':P_num', $P_num);
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
