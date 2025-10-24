<?php
$user = $users[$action];


$buttonColors = [
    '#9B59B6',
];



foreach ($settings['pages'] as $page)
    $buttonDescriptions[] = ["name"=>$page['name'],"token"=>$page['token']];

$buttons = [];
for ($i = 0; $i < count($buttonDescriptions); $i++) {
    global $buttonColors, $buttonDescriptions;
    $color = $buttonColors[array_rand($buttonColors)];
    $description = $buttonDescriptions[$i]["name"];
    $token = $buttonDescriptions[$i]["token"];
    $buttons[] = ['color' => $color, 'description' => $description,'token' => $token];
}

$lastUpdateTime = $user['update_time'];
$xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".str_replace('_','.',$action));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(str_replace('_','.',$action)); ?> - Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #000;
            color: #E0E0E0;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-image: url('img/bg.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        .container {
            width: 70%;
            margin: 50px auto;
            padding: 30px;
            background-color: #2C2C2CCC;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h1 {
            text-align: center;
            color: #FFF;
            font-size: 2.4rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .user-info,
        .current-page {
            text-align: center;
            margin-bottom: 30px;
        }

        .status {
            font-size: 1.2rem;
            margin-top: 10px;
            color: #bbb;
        }

        .button-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .button-item {
            padding: 12px 24px;
            margin: 8px;
            border-radius: 8px;
            text-align: center;
            color: white;
            background-color: #4CAF50;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: auto;
            flex: 1 1 200px;
        }

        .button-item:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .button-item:active {
            transform: scale(0.98);
        }

        .description-container {
            margin-top: 30px;
        }

        .description-box {
            width: 100%;
            height: 200px;
            padding: 15px;
            font-size: 1rem;
            background-color: #333;
            color: #E0E0E0;
            border: none;
            border-radius: 10px;
            resize: none;
            box-sizing: border-box;
            overflow-y: auto;
            transition: background-color 0.3s ease;
        }

        .description-box:focus {
            outline: none;
            background-color: #444;
        }

        .update-time {
            margin-top: 20px;
            color: #999;
            font-size: 0.9rem;
            text-align: center;
        }

        .bl {
            display: inline-block;
            padding: 12px 25px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .bl:hover {
            background-color: #555;
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .bl:focus {
            outline: 2px solid #ff9800;
            outline-offset: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #E0E0E0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
            white-space: nowrap;
        }

        th {
            background-color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #444;
        }

        tr:hover {
            background-color: #555;
        }

        .responsive-table {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .token-input {
            background-color: #333;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            width: 100%;
        }

        .token-input label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #bbb;
        }

        .token-input input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #444;
            background-color: #222;
            color: #fff;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        .token-input input[type="text"]:focus {
            border-color: #4CAF50; /* Green on focus */
            outline: none;
        }

        .token-input input[type="text"]:hover {
            border-color: #555;
        }

        /* Container styles */
        .token-input {
            background-color: #333;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
        }

        .token-input label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #bbb;
        }

        .token-input input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #444;
            background-color: #222;
            color: #fff;
            border-radius: 4px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .token-input input[type="text"]:focus {
            border-color: #4CAF50; /* Green on focus */
            outline: none;
        }

        .token-input input[type="text"]:hover {
            border-color: #555;
        }

        /* Media Query for smaller screens */
        @media (max-width: 480px) {
            .token-input {
                padding: 15px;
            }

            .token-input input[type="text"] {
                padding: 12px;
            }
        }


        @media (max-width: 600px) {
            th, td {
                font-size: 14px;
                padding: 8px;
            }
        }


        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .button-item {
                font-size: 1rem;
                padding: 10px 20px;
                flex: 1 1 45%;
            }

            .bl {
                font-size: 16px;
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.8rem;
            }

            .bl {
                font-size: 14px;
                padding: 8px 16px;
            }

            .button-item {
                font-size: 0.9rem;
                padding: 8px 16px;
                flex: 1 1 100%;
            }
        }

    </style>
</head>
<body>

<div class="container">
    <a href="./" class="bl">Home</a>
    <a href="./bl?ip=<?=str_replace('_','.',$action)?>" class="bl">Black List</a>
    <a href="./clear?ip=<?=$action?>" class="bl">Clear Data</a>
    <h1><?php echo str_replace('_','.',$action); ?>'s Profile From <?php echo $xml->geoplugin_countryName; ?></h1>
    <div class="update-time">
        Last updated: <?php echo $lastUpdateTime; ?>
    </div>
    <h3 class="current-page"> Current Page : <?= $user['current_page'] ?></h3>
    
    <h2 class="current-page">Actions:</h2>
    <ul class="button-list">
        <?php foreach ($buttons as $button): ?>
            <?php
            if($button['token'])
                continue;
            $buttonColor = $button['color'];
            if (stripos($button['description'], 'Success') !== false) {
                $buttonColor = '#28a745';
            } elseif (stripos($button['description'], 'Loading') !== false) {
                $buttonColor = '#007bff';
            } elseif (stripos($button['description'], '404') !== false) {
                $buttonColor = '#de996f';
            }
            elseif (substr($button['description'], -5) === 'error') {
                $buttonColor = '#E74C3C';
            }
            ?>

            <li class="button-item" style="background-color: <?php echo $buttonColor; ?>;"
                onclick="handleButtonClick('<?php echo urlencode($button['description']); ?>')">
                <?php echo htmlspecialchars($button['description']); ?>
            </li>
        <?php endforeach; ?>
        <li class="button-item" style="background-color: #de996f;"
            onclick="handleButtonClick('Logout')">
            Logout
        </li>
    </ul>
    <h2 class="current-page">Token Actions:</h2>
    <div class="token-input">
        <label for="token">Token</label>
        <input type="text" id="token">
    </div>
    <ul class="button-list">
        <?php foreach ($buttons as $button): ?>
            <?php
            if(!$button['token'])
                continue;
            $buttonColor = $button['color'];
            if (stripos($button['description'], 'Success') !== false) {
                $buttonColor = '#28a745';
            } elseif (stripos($button['description'], 'Loading') !== false) {
                $buttonColor = '#007bff';
            } elseif (stripos($button['description'], '404') !== false) {
                $buttonColor = '#de996f';
            }
            elseif (substr($button['description'], -5) === 'error') {
                $buttonColor = '#E74C3C';
            }
            ?>

            <li class="button-item" style="background-color: <?php echo $buttonColor; ?>;"
                onclick="handleButtonClick('<?php echo urlencode($button['description']); ?>',true)">
                <?php echo htmlspecialchars($button['description']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <div class="responsive-table">
        <table>
            <thead>
                <tr>
                    <th>Client IP</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Current Page</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars(str_replace('_','.',$action)); ?></td>
                    <td><?php echo $xml->geoplugin_countryName; ?></td>
                    <td class="statust"><?php echo $user['online'] ? "ONLINE" : 'OFFLINE'; ?></td>
                    <td class="current-paget"><?php echo htmlspecialchars($user['current_page']); ?></td>
                    <td class="update-timet"><?php echo $lastUpdateTime; ?></td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="user-info">
        <div class="status">
            Status: <strong><?php echo $user['online'] ? "ONLINE" : 'OFFLINE'; ?></strong>
        </div>

        <div class="description-container">
            <strong>Data:</strong>
            <textarea class="description-box" readonly><?=$user['data']?></textarea>
        </div>
        
    </div>

</div>
<script>
    function handleButtonClick(action,istoken=false) {
        var xhr = new XMLHttpRequest();
        token="";
        if(istoken)
            token = "&token="+document.querySelector('#token').value;
        console.log(token);
        xhr.open('GET', '?redirect=' + action + token, true);
        xhr.send();
    }

    setInterval(function() {
        if (document.visibilityState === 'visible') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?json=', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.querySelector('.current-page').innerHTML = 'Current Page : ' + response.current_page;
                    document.querySelector('.current-paget').innerHTML = response.current_page;
                    document.querySelector('.status').innerHTML = 'Status: <strong>' + (response.online ? 'ONLINE' : 'OFFLINE') + '</strong>';
                    document.querySelector('.statust').innerHTML = (response.online ? 'ONLINE' : 'OFFLINE');
                    document.querySelector('.description-box').value = response.data;
                    document.querySelector('.update-time').innerHTML = 'Last updated: ' + response.update_time;
                    document.querySelector('.update-timet').innerHTML = response.update_time;
                }
            };
            xhr.send();
        }
    }, 1000);
</script>

</body>
</html>
