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
$Emp_manager = $data['empManagerInput'];
$Dept_ID = $data['deptIdSelect'];

try {
    $stmt = $PDOconn->prepare("UPDATE Department_Manager 
                                SET Emp_manager = :Emp_manager, 
                                    Dept_ID = :Dept_ID
                                WHERE Emp_manager = :ID");

    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':Emp_manager', $Emp_manager);
    $stmt->bindParam(':Dept_ID', $Dept_ID);
    $stmt->execute();
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
