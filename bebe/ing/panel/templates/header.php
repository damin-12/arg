<?php
    error_reporting(0);
    session_start();

    include "../libraries/antibots.php";
    include "../libraries/tools.php";

    $ip = get_client_ip();
    $user_profile = 'data/'.str_replace(".", "_", $ip) . '.json';
