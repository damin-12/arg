<?php


session_start();

if (!isset($_SESSION['user_id']) && $action !== "login") {
    header("Location: login");
    exit();
}

include "templates/header.php";

$dataDir = '../data/';

$files = glob($dataDir . '*.json');

$users = getUserData($files);
$updated_users = [];

foreach ($users as $id=>$user) {
    $current_time = time();
    $update_time = strtotime($user['update_time']);

    if (($current_time - $update_time) <= 5) {
        $user['online'] = true;
    } else {
        $user['online'] = false;
    }
    
    $updated_users[$id] = $user;
}

$users = $updated_users;

$jsonFile = '../settings.json';

if (!file_exists($jsonFile)) {
    die("JSON file not found!");
}

$jsonContent = file_get_contents($jsonFile);

$settings = json_decode($jsonContent, true);


if(isset($_GET['redirect']))
    update_redirect('../data/'.$action.'.json', $_GET['redirect'],isset($_GET['token']) ? $_GET['token'] : "123324");
if(isset($_GET['json']))
    die(json_encode($users[$action]));


ob_start();

switch($action){
    case "":
        require "pages/home.php";
        break;
    case "login":
        require "pages/login.php";
        break;
    case "settings":
        require "pages/settings.php";
        break;
    case "restrictions":
        require "pages/restriction.php";
        break;
    case "bl":
        $_POST['mode'] = 'add';
        $_POST['ip'] = $_GET['ip'];
        require "pages/restriction.php";
        header('location:./');
        break;
    case "clear":
        clear_data('../data/'.$_GET['ip'].'.json');
        header('location:./'.$_GET['ip']);
        break;
    case "del":
        unlink('../data/'.$_GET['ip'].'.json');
        echo "<script>window.close();</script>";
        break;
    case "clearall":
        foreach ($users as $k=>$val){
            unlink('../data/'.$k.'.json');
        }
        echo "<script>window.close();</script>";
        break;
    default:
        require "pages/profile.php";
        break;
}


$html = ob_get_clean();

$html = preg_replace_callback('/<([a-z1-6]+)([^>]*)>/i', function ($matches) {
    
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    $tag = $matches[1];
    $attrs = $matches[2];
    
    if (preg_match('/^(br|hr|img|input|meta|link)$/i', $tag)) {
        return $matches[0];
    }
    $randomClass = substr(str_shuffle($alphabet), 0, 6);
    
    if (preg_match('/class=["\']([^"\']*)["\']/i', $attrs, $classMatch)) {
        $newClass = $classMatch[1] . " " . $randomClass;
        $attrs = preg_replace('/class=["\'][^"\']*["\']/i', 'class="' . $newClass . '"', $attrs);
    } else {
        $attrs .= ' class="' . $randomClass . '"';
    }
    
    return "<$tag$attrs>";
}, $html);

echo $html;
?>
