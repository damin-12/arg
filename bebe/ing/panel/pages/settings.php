<?php
session_start();

$users_file = 'private/users.json';
$users = [];

if (file_exists($users_file)) {
    $users = json_decode(file_get_contents($users_file), true);
}

$current_username = $_SESSION['user_id'];
$current_password = isset($users[$current_username]) ? $users[$current_username] : null;

if (!!$_POST) {
    if (isset($_POST['current_password']) && isset($_POST['new_username']) && isset($_POST['new_password'])) {
        $current_input_password = $_POST['current_password'];
        $new_username = $_POST['new_username'];
        $new_password = $_POST['new_password'];

        if (!password_verify($current_input_password, $current_password)) {
            $error_message = "The current password you entered is incorrect.";
        } else {
            if (array_key_exists($new_username, $users) && $new_username !== $current_username) {
                $error_message = "The new username is already taken.";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                unset($users[$current_username]);
                $users[$new_username] = $hashed_password;

                file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));

                session_destroy();

                $success_message = "Your credentials have been updated successfully!";
            }
        }
    } else {
        $error_message = "Please fill out all the fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Credentials</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('img/bg.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
        }

        .form-container {
            width: 100%;
            max-width: 450px;
            margin: 20px;
            padding: 40px;
            background-color: #1f1f1fCC;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h2 {
            margin-bottom: 30px;
            color: #fff;
            font-size: 28px;
            letter-spacing: 1px;
        }

        .form-group {
            width: 100%;
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group-btn {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        label {
            display: block;
            font-weight: bold;
            color: #bbb;
            margin-bottom: 8px;
        }

        input {
            padding: 16px;
            margin-top: 8px;
            border: 1px solid #444;
            border-radius: 8px;
            background-color: #333;
            color: #fff;
            font-size: 18px;
            transition: all 0.3s;
        }

        input:focus {
            border-color: #6200ea;
            outline: none;
            background-color: #444;
        }

        button {
            width: 80%;
            padding: 16px;
            background-color: #6200ea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3700b3;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            color: #bbb;
            font-size: 14px;
        }

        a {
            color: #6200ea;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 30px;
            }

            h2 {
                font-size: 24px;
            }

            input, button {
                padding: 14px;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                width: 90%;
                margin: 20px auto;
            }

            h2 {
                font-size: 22px;
            }
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

        @media (max-width: 768px) {
            .bl {
                font-size: 16px;
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            .bl {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <a href="./" class="bl">Home</a>
        <h2>Change Credentials</h2>

        <?php if (isset($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)) : ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_username">New Username:</label>
                <input type="text" id="new_username" name="new_username" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>

            <div class="form-group form-group-btn">
                <button type="submit">Update Credentials</button>
            </div>
        </form>
    </div>
</body>
</html>
