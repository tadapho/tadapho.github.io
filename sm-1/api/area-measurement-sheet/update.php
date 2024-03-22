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
if ($Project_ID === '') {
    $Project_ID = null;
}
if ($Quot_ID === '') {
    $Quot_ID = null;
}
if ($M_SKU === '') {
    $M_SKU = null;
}

try {
    $stmt = $PDOconn->prepare("UPDATE Area_Measurement_Sheet 
                                SET AMS_ID = :AMS_ID,
                                AMS_time = :AMS_time, 
                                AMS_date = :AMS_date, 
                                Loc_HNo = :Loc_HNo, 
                                Loc_city = :Loc_city,
                                Loc_street = :Loc_street,
                                loc_zipcode = :loc_zipcode,
                                Quot_ID = :Quot_ID
                                WHERE AMS_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':AMS_ID', $AMS_ID);
    $stmt->bindParam(':AMS_time', $AMS_time);
    $stmt->bindParam(':AMS_date', $AMS_date);
    $stmt->bindParam(':Loc_HNo', $Loc_HNo);
    $stmt->bindParam(':Loc_city', $Loc_city);
    $stmt->bindParam(':Loc_street', $Loc_street);
    $stmt->bindParam(':loc_zipcode', $loc_zipcode);
    $stmt->bindParam(':Quot_ID', $Quot_ID);
    $stmt->execute();
    $stmt = $PDOconn->prepare("UPDATE AMS_Project 
                                SET AMS_ID = :AMS_ID,
                                    Project_ID = :Project_ID, 
                                    Measurement = :Measurement
                                WHERE AMS_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':AMS_ID', $AMS_ID);
    $stmt->bindParam(':Project_ID', $Project_ID);
    $stmt->bindParam(':Measurement', $Measurement);
    $stmt->execute();
    $stmt = $PDOconn->prepare("UPDATE Material_Area_Measurement_Sheet 
                                SET M_SKU = :M_SKU
                                WHERE AMS_ID = :ID");
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':M_SKU', $M_SKU);
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
