<?php
$jsonFile = '../restricted.json';

function readIps() {
    global $jsonFile;
    if (file_exists($jsonFile)) {
        return json_decode(file_get_contents($jsonFile), true);
    }
    return [];
}

function writeIps($ips) {
    global $jsonFile;
    file_put_contents($jsonFile, json_encode($ips, JSON_PRETTY_PRINT));
}

if (isset($_POST['mode']) && $_POST['mode'] == 'add') {
    $ip = $_POST['ip'];
    $ips = readIps();

    if (!in_array($ip, $ips)) {
        $ips[] = $ip;
        writeIps($ips);
    }
}

if (isset($_POST['mode']) && $_POST['mode'] == 'delete') {
    $ip = $_POST['ip'];
    $ips = readIps();

    $ips = array_filter($ips, function($existingIp) use ($ip) {
        return $existingIp !== $ip;
    });

    $ips = array_values($ips);
    
    writeIps($ips);
}

$ips = readIps();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restricted IPs Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('img/bg.png');
            background-size: cover;
            background-position: center center;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            color: #ff9800;
            margin-bottom: 20px;
        }

        h2 {
            color: #fff;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        form {
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        input[type="text"], button {
            padding: 12px;
            font-size: 16px;
            margin: 5px 0;
            border-radius: 5px;
            border: none;
            width: 100%;
        }

        input[type="text"] {
            background-color: #333;
            color: white;
        }

        button {
            cursor: pointer;
            background-color: #ff9800;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #e68900;
            transform: scale(1.05);
        }

        button:focus {
            outline: none;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 20px;
        }

        li {
            padding: 15px;
            margin: 8px 0;
            background-color: #333;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        li form {
            display: inline-block;
        }

        .bl {
            display: inline-block;
            padding: 12px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin-bottom: 20px;
        }

        .bl:hover {
            background-color: #555;
            transform: scale(1.05);
        }

        .Ip{
            display:flex;
            align-items:center;
            justify-content: center;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            input[type="text"], button {
                font-size: 14px;
                padding: 10px;
            }

            .bl {
                font-size: 14px;
                padding: 10px 16px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Manage Restricted IPs</h1>
        <a href="./" class="bl">Home</a>

        <h2>Add New IP</h2>
        <form method="POST" class="Ip">
            <input type="text" name="ip" required placeholder="Enter IP Address">
            <input type="hidden" name="mode" value="add">
            <button type="submit">Add IP</button>
        </form>

        <h2>Restricted IPs</h2>
        <ul>
            <?php foreach ($ips as $ip): ?>
                <li>
                    <?php echo $ip; ?>
                    <form method="POST" style="display:inline;" class="Ip">
                        <input type="hidden" name="ip" value="<?php echo $ip; ?>">
                        <input type="hidden" name="mode" class="btndel" value="delete">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</body>
</html>
