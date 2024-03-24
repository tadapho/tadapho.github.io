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

$Emp_ID = $data['empIdInput'];
$Emp_Fname = $data['empFnameInput'];
$Emp_Lname = $data['empLnameInput'];
$Emp_Tel = $data['empTelInput'];
$Emp_role = $data['empRoleInput'];
$Emp_salary = $data['empSalaryInput'];
if ($Emp_salary === '') {
    $Emp_salary = 0;
}
$Emp_HNo = $data['empHnoInput'];
$Emp_city = $data['empCityInput'];
$Emp_street = $data['empStreetInput'];
$Emp_zipcode = $data['empZipcodeInput'];
$Emp_manager = $data['empManagerSelect'];
if ($Emp_manager === '') {
    $Emp_manager = null;
}
$Dept_ID = $data['depIpSelect'];
if ($Dept_ID === '') {
    $Dept_ID = null;
}
try {
    // Check if the Emp_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Employee WHERE Emp_ID = :Emp_ID");
    $stmt_check->bindParam(':Emp_ID', $Emp_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "Emp_ID already exists."));
        exit;
    } else {
        // Insert new data into Employee table
        // $stmt = $PDOconn->prepare("INSERT INTO Department_Manager (Emp_manager, Dept_ID) 
        //                             VALUES (:Emp_manager, :Dept_ID)");
        // $stmt->bindParam(':Emp_manager', $Emp_ID);
        // $stmt->bindParam(':Dept_ID', $Dept_ID);
        // $stmt->execute();
        // Insert new data into Employee table
        $stmt = $PDOconn->prepare("INSERT INTO Employee (Emp_ID, Emp_Fname, Emp_Lname, Emp_Tel, Emp_role, Emp_salary, Emp_HNo, Emp_city, Emp_street, Emp_zipcode, Dept_ID, Emp_manager) 
                                    VALUES (:Emp_ID, :Emp_Fname, :Emp_Lname, :Emp_Tel, :Emp_role, :Emp_salary, :Emp_HNo, :Emp_city, :Emp_street, :Emp_zipcode, :Dept_ID, :Emp_manager)");
        $stmt->bindParam(':Emp_ID', $Emp_ID);
        $stmt->bindParam(':Emp_Fname', $Emp_Fname);
        $stmt->bindParam(':Emp_Lname', $Emp_Lname);
        $stmt->bindParam(':Emp_Tel', $Emp_Tel);
        $stmt->bindParam(':Emp_role', $Emp_role);
        $stmt->bindParam(':Emp_salary', $Emp_salary);
        $stmt->bindParam(':Emp_HNo', $Emp_HNo);
        $stmt->bindParam(':Emp_city', $Emp_city);
        $stmt->bindParam(':Emp_street', $Emp_street);
        $stmt->bindParam(':Emp_zipcode', $Emp_zipcode);
        $stmt->bindParam(':Dept_ID', $Dept_ID);
        $stmt->bindParam(':Emp_manager', $Emp_manager);
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
