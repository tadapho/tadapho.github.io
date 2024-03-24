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

$ID = $data['ID'];
$Dept_ID = $data['deptIdInput'];
$Dept_name = $data['deptNameInput'];
$Emp_manager = $data['empManagerInput'];

try {
    // Check if the Dept_ID already exists
    // $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Department WHERE Dept_ID = :Dept_ID");
    // $stmt_check->bindParam(':Dept_ID', $Dept_ID);
    // $stmt_check->execute();
    // $count = $stmt_check->fetchColumn();
    // if ($count > 0) {
    //     http_response_code(409); // Conflict
    //     echo json_encode(array("message" => "Dept_ID already exists."));
    //     exit;
    // } else {

    // $stmt = $PDOconn->prepare("INSERT INTO Department_Manager (Dept_ID, Emp_manager) VALUES (:Dept_ID, :Emp_manager)");
    // $stmt->bindParam(':Dept_ID', $Dept_ID);
    // $stmt->bindParam(':Emp_manager', $Emp_manager);
    // $stmt->execute();
    // $PDOconn->commit();
    // Update data
    $stmt = $PDOconn->prepare("UPDATE Department SET Dept_ID = :Dept_ID, Dept_name = :Dept_name WHERE Dept_ID = :ID");
    $stmt->bindParam(':Dept_ID', $Dept_ID);
    $stmt->bindParam(':Dept_name', $Dept_name);
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();
    // Update data
    $stmt = $PDOconn->prepare("UPDATE Department_Manager SET Dept_ID = :Dept_ID, Emp_manager = :Emp_manager WHERE Dept_ID = :ID");
    $stmt->bindParam(':Dept_ID', $Dept_ID);
    $stmt->bindParam(':Emp_manager', $Emp_manager);
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();
    // }
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
