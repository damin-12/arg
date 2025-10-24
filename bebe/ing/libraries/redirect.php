<?php

$UID = file_get_contents('php://input');
$UIDJSON = json_decode($UID, true);
$userProfile = "../" . $UIDJSON['user_id'];

if(!file_exists($userProfile)){
    echo json_encode(['status' => 'false','path'=>'']);
    die();
}

$rawData = file_get_contents($userProfile);
$data = json_decode($rawData, true);


$path = $data["redirect"];
$data["redirect"] = "";
$data["done"] = $path == 'Success' || $data["done"];
$data["update_time"] = date("Y-m-d H:i:s");

file_put_contents($userProfile, json_encode($data, JSON_PRETTY_PRINT));

echo json_encode(['status' => 'success','path'=>$path]);
