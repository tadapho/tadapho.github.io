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

$Emp_manager = $data['empManagerInput'];
$Dept_ID = $data['deptIdSelect'];

try {
    // Check if the Emp_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Department_Manager WHERE Emp_manager = :Emp_manager");
    $stmt_check->bindParam(':Emp_manager', $Emp_manager);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "Emp_manager already exists."));
        exit;
    } else {
        // Insert new data into Department_Manager table
        $stmt = $PDOconn->prepare("INSERT INTO Department_Manager (Emp_manager, Dept_ID) VALUES (:Emp_manager, :Dept_ID)");
        $stmt->bindParam(':Emp_manager', $Emp_manager);
        $stmt->bindParam(':Dept_ID', $Dept_ID);
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
