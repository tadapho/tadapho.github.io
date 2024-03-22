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

$Cus_ID = $data['cusIdInput'];
$Cus_Fname = $data['cusFnameInput'];
$Cus_Lname = $data['cusLnameInput'];
$Cus_Tel = $data['cusTelInput'];
$Cus_Content = $data['cusContentInput'];
$Cus_HNo = $data['cusHnoInput'];
$Cus_city = $data['cusCityInput'];
$Cus_street = $data['cusStreetInput'];
$Cus_zipcode = $data['cusZipcodeInput'];
$Emp_ID = $data['empIdSelect'];
if ($Emp_ID === '') {
    $Emp_ID = null;
}

try {
    // Check if the Quot_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Customer WHERE Cus_ID = :Cus_ID");
    $stmt_check->bindParam(':Cus_ID', $Cus_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "Cus_ID already exists."));
        exit;
    } else {
        // Check if the Quot_ID already exists
        $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Customer WHERE Cus_ID = :Cus_ID");
        $stmt_check->bindParam(':Cus_ID', $Cus_ID);
        $stmt_check->execute();
        $count = $stmt_check->fetchColumn();
        if ($count > 0) {
            http_response_code(409); // Conflict
            echo json_encode(array("message" => "Quot_ID already exists."));
            exit;
        } else {
            // Insert new data into Employee table
            $stmt = $PDOconn->prepare("INSERT INTO Customer (Cus_ID, Cus_Fname, Cus_Lname, Cus_Tel, Cus_Content, Cus_HNo, Cus_city, Cus_street, Cus_zipcode, Emp_ID) 
                                    VALUES (:Cus_ID, :Cus_Fname, :Cus_Lname, :Cus_Tel, :Cus_Content, :Cus_HNo, :Cus_city, :Cus_street, :Cus_zipcode, :Emp_ID)");
            $stmt->bindParam(':Cus_ID', $Cus_ID);
            $stmt->bindParam(':Cus_Fname', $Cus_Fname);
            $stmt->bindParam(':Cus_Lname', $Cus_Lname);
            $stmt->bindParam(':Cus_Tel', $Cus_Tel);
            $stmt->bindParam(':Cus_Content', $Cus_Content);
            $stmt->bindParam(':Cus_HNo', $Cus_HNo);
            $stmt->bindParam(':Cus_city', $Cus_city);
            $stmt->bindParam(':Cus_street', $Cus_street);
            $stmt->bindParam(':Cus_zipcode', $Cus_zipcode);
            $stmt->bindParam(':Emp_ID', $Emp_ID);
            $stmt->execute();
        }
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
