<?php
    session_start();

    include "libraries/antibots.php";
    include "libraries/tools.php";

    check_restriction();

    $ip = get_client_ip();
    $user_profile = 'data/'.str_replace(".", "_", $ip) . '.json';
