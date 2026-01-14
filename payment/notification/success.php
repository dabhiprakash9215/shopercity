<?php
print_r($_POST);
die;
?>
<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>पेमेंट सफलतापूर्वक प्राप्त</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'Noto Sans Devanagari', sans-serif;
        }

        body {
            background-color: #f5f9ff;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }

        .success-card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 100, 255, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 40px 30px;
            position: relative;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        h1 {
            color: #2E7D32;
            margin-bottom: 15px;
            font-size: 32px;
        }

        .subtitle {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .payment-details {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
            border-left: 5px solid #4CAF50;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #ddd;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        .highlight {
            color: #2E7D32;
            font-weight: 700;
            font-size: 22px;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-primary:hover {
            background-color: #388E3C;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-secondary {
            background-color: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
        }

        .btn-secondary:hover {
            background-color: #f1f8e9;
            transform: translateY(-3px);
        }

        .footer-note {
            margin-top: 30px;
            color: #777;
            font-size: 14px;
            line-height: 1.5;
        }

        .confetti {
            position: absolute;
            width: 15px;
            height: 15px;
            background-color: #ffeb3b;
            border-radius: 50%;
            opacity: 0;
        }

        @media (max-width: 600px) {
            .success-card {
                padding: 30px 20px;
            }

            h1 {
                font-size: 26px;
            }

            .actions {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>

            <h1>पेमेंट सफलतापूर्वक प्राप्त!</h1>
            <p class="subtitle">आपका भुगतान प्राप्त कर लिया गया है। आपके लेन-देन की पुष्टि नीचे दी गई है।</p>

            <div class="payment-details">
                <div class="detail-row">
                    <span class="detail-label">लेन-देन आईडी:</span>
                    <span class="detail-value">TXN20240528124536</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">तिथि और समय:</span>
                    <span class="detail-value">28 मई 2024, 12:45 बजे</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">भुगतान विधि:</span>
                    <span class="detail-value">क्रेडिट कार्ड (VISA)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">भुगतान राशि:</span>
                    <span class="detail-value highlight">₹2,500.00</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">स्थिति:</span>
                    <span class="detail-value" style="color: #2E7D32; font-weight: 700;">सफल</span>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-primary" onclick="downloadReceipt()">
                    <i class="fas fa-download"></i> रसीद डाउनलोड करें
                </button>
                <a href="#" class="btn btn-secondary">
                    <i class="fas fa-home"></i> होम पेज पर जाएं
                </a>
                <a href="#" class="btn btn-secondary">
                    <i class="fas fa-history"></i> लेन-देन इतिहास
                </a>
            </div>

            <p class="footer-note">
                एक पुष्टि ईमेल आपके पंजीकृत ईमेल पते पर भेज दिया गया है। यदि आपको कोई समस्या आती है, तो कृपया हमारे सहायता केंद्र से संपर्क करें।
            </p>
        </div>
    </div>

    <script>
        // कन्फेटी एनिमेशन जोड़ें
        function createConfetti() {
            const card = document.querySelector('.success-card');
            const colors = ['#4CAF50', '#FFC107', '#2196F3', '#E91E63', '#9C27B0'];

            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.top = Math.random() * 100 + '%';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = Math.random() * 10 + 8 + 'px';
                confetti.style.height = confetti.style.width;
                confetti.style.opacity = '0.8';
                card.appendChild(confetti);

                // एनिमेशन
                confetti.animate([{
                        transform: 'translateY(0) rotate(0deg)',
                        opacity: 0.8
                    },
                    {
                        transform: `translateY(${Math.random() * 200 - 100}px) rotate(${Math.random() * 360}deg)`,
                        opacity: 0
                    }
                ], {
                    duration: Math.random() * 1000 + 1000,
                    delay: Math.random() * 500
                });

                // एलिमेंट हटाएं
                setTimeout(() => {
                    confetti.remove();
                }, 2000);
            }
        }

        // पेज लोड होने पर कन्फेटी दिखाएं
        window.addEventListener('load', function() {
            setTimeout(createConfetti, 300);
        });

        // रसीद डाउनलोड फ़ंक्शन
        function downloadReceipt() {
            alert("रसीद डाउनलोड शुरू हो रही है...\n\nलेन-देन आईडी: TXN20240528124536\nराशि: ₹2,500.00\nतिथि: 28 मई 2024");
            // वास्तविक कार्यान्वयन में, यहाँ PDF जनरेशन और डाउनलोड कोड होगा
        }

        // पृष्ठ पर पहुंचने पर अतिरिक्त कन्फेटी ट्रिगर करें
        document.querySelector('.success-card').addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-primary')) {
                setTimeout(createConfetti, 100);
            }
        });
    </script>
</body>

</html>