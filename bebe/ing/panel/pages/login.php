<?php
session_start();

$users_file = 'private/users.json';
$users = [];

if (file_exists($users_file)) {
    $users = json_decode(file_get_contents($users_file), true);
}

if (!!$_POST) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (array_key_exists($username, $users)) {
            if (password_verify($password, $users[$username])) {
                $_SESSION['user_id'] = $username;
                $_SESSION['is_logged_in'] = true;

                header("Location: index.php");
                exit();
            } else {
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Please enter both username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .login-container {
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
            .login-container {
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
            .login-container {
                width: 90%;
                margin: 20px auto;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group form-group-btn">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
