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
    // $stmt = $PDOconn->prepare("UPDATE Department_Manager 
    //                             SET Dept_ID = :Dept_ID
    //                             WHERE Emp_manager = :ID");
    // $stmt->bindParam(':ID', $ID);
    // $stmt->bindParam(':Dept_ID', $Dept_ID);
    // $stmt->execute();

    $stmt = $PDOconn->prepare("UPDATE Employee 
                                SET Emp_ID = :Emp_ID, 
                                    Emp_Fname = :Emp_Fname, 
                                    Emp_Lname = :Emp_Lname, 
                                    Emp_Tel = :Emp_Tel, 
                                    Emp_role = :Emp_role, 
                                    Emp_salary = :Emp_salary, 
                                    Emp_HNo = :Emp_HNo, 
                                    Emp_city = :Emp_city, 
                                    Emp_street = :Emp_street, 
                                    Emp_zipcode = :Emp_zipcode, 
                                    Dept_ID = :Dept_ID ,
                                    Emp_manager = :Emp_manager
                                WHERE Emp_ID = :ID");
    $stmt->bindParam(':ID', $ID);
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
