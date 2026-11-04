<?php
require_once __DIR__ . '/guard.php';
header('Content-Type: application/json');

$token = getToken();
if (!$token) {
    echo json_encode(['error' => 'no_session']);
    exit;
}

$db = getDb();
$data = $db[$token] ?? null;

if (!$data) {
    echo json_encode([$token => ['status' => 'online']]);
    exit;
}

// Update heartbeat
$db[$token]['last_seen'] = time();
saveDb($db);

echo json_encode([$token => $data]);
?>