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
if (!isset($data['deptIdInput']) && empty($data['deptIdInput'])) {
    http_response_code(422);
    echo json_encode(array("error" => "deptIdInput is required."));
    exit;
}
if (!isset($data['deptNameInput']) && empty($data['deptNameInput'])) {
    http_response_code(422);
    echo json_encode(array("error" => "deptNameInput is required."));
    exit;
}

$Dept_ID = $data['deptIdInput'];
$Dept_name = $data['deptNameInput'];

try {
    // Check if the Dept_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Department WHERE Dept_ID = :Dept_ID");
    $stmt_check->bindParam(':Dept_ID', $Dept_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "Dept_ID already exists."));
        exit;
    } else {
        // Insert new data
        $stmt = $PDOconn->prepare("INSERT INTO Department (Dept_ID, Dept_name) VALUES (:Dept_ID, :Dept_name)");
        $stmt->bindParam(':Dept_ID', $Dept_ID);
        $stmt->bindParam(':Dept_name', $Dept_name);
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
