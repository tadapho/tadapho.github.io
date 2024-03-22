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

$AMS_ID = $data['areaIdInput'];
$AMS_time = $data['areaTimeInput'];
$AMS_date = $data['areaDateInput'];
if ($AMS_date === '') {
    $AMS_date = null;
}
$Loc_HNo = $data['areaHnoInput'];
$Loc_city = $data['areaStreetInput'];
$Loc_street = $data['areaCityInput'];
$loc_zipcode = $data['areaZipcodeInput'];
$Project_ID = $data['projectIdSelect'];
$Quot_ID = $data['quotationIdSelect'];
$M_SKU = $data['materialIdSelect'];
$Measurement = $data['areaMeasurementInput'];

try {
    // Check if the AMS_ID already exists
    $stmt_check = $PDOconn->prepare("SELECT COUNT(*) FROM Area_Measurement_Sheet WHERE AMS_ID = :AMS_ID");
    $stmt_check->bindParam(':AMS_ID', $AMS_ID);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();
    if ($count > 0) {
        http_response_code(409); // Conflict
        echo json_encode(array("message" => "AMS_ID already exists."));
        exit;
    } else {
        // Insert new data into Area_Measurement_Sheet table
        $stmt = $PDOconn->prepare("INSERT INTO Area_Measurement_Sheet (AMS_ID, AMS_time, AMS_date, Loc_HNo, Loc_street, loc_zipcode, Quot_ID) 
                                    VALUES (:AMS_ID, :AMS_time, :AMS_date, :Loc_HNo, :Loc_street, :loc_zipcode, :Quot_ID)");
        $stmt->bindParam(':AMS_ID', $AMS_ID);
        $stmt->bindParam(':AMS_time', $AMS_time);
        $stmt->bindParam(':AMS_date', $AMS_date);
        $stmt->bindParam(':Loc_HNo', $Loc_HNo);
        $stmt->bindParam(':Loc_street', $Loc_street);
        $stmt->bindParam(':loc_zipcode', $loc_zipcode);
        $stmt->bindParam(':Quot_ID', $Quot_ID);
        $stmt->execute();
        // Insert new data into AMS_Project table
        $stmt = $PDOconn->prepare("INSERT INTO AMS_Project (AMS_ID, Project_ID,  Measurement) 
                                    VALUES (:AMS_ID, :Project_ID, :Measurement)");
        $stmt->bindParam(':AMS_ID', $AMS_ID);
        $stmt->bindParam(':Project_ID', $Project_ID);
        $stmt->bindParam(':Measurement', $Measurement);
        $stmt->execute();
        // Insert new data into Material_Area_Measurement_Sheet table
        $stmt = $PDOconn->prepare("INSERT INTO Material_Area_Measurement_Sheet (AMS_ID, M_SKU) 
                                    VALUES (:AMS_ID, :M_SKU)");
        $stmt->bindParam(':AMS_ID', $AMS_ID);
        $stmt->bindParam(':M_SKU', $M_SKU);
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
