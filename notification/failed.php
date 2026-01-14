<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>भुगतान विफल | Payment Failed</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'Noto Sans Devanagari', sans-serif;
        }

        body {
            background-color: #fff5f5;
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

        .failure-card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(244, 67, 54, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 40px 30px;
            position: relative;
            border-top: 5px solid #F44336;
        }

        .failure-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #F44336, #D32F2F);
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            animation: shake 0.8s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        h1 {
            color: #D32F2F;
            margin-bottom: 15px;
            font-size: 32px;
        }

        .subtitle {
            color: #666;
            font-size: 18px;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .error-message {
            background-color: #FFEBEE;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
            border-left: 5px solid #F44336;
        }

        .error-title {
            color: #D32F2F;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
        }

        .error-desc {
            color: #666;
            line-height: 1.5;
        }

        .payment-details {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
            border: 1px solid #e0e0e0;
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
            color: #D32F2F;
            font-weight: 700;
            font-size: 22px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            background-color: #FFCDD2;
            color: #D32F2F;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
        }

        .possible-reasons {
            background-color: #FFF8E1;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }

        .possible-reasons h3 {
            color: #FF9800;
            margin-bottom: 15px;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .reasons-list {
            list-style-type: none;
            padding-left: 10px;
        }

        .reasons-list li {
            padding: 8px 0;
            color: #666;
            position: relative;
            padding-left: 30px;
        }

        .reasons-list li:before {
            content: "•";
            color: #F44336;
            font-size: 24px;
            position: absolute;
            left: 0;
            top: 2px;
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
            min-width: 180px;
        }

        .btn-retry {
            background-color: #F44336;
            color: white;
        }

        .btn-retry:hover {
            background-color: #D32F2F;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);
        }

        .btn-alternate {
            background-color: white;
            color: #2196F3;
            border: 2px solid #2196F3;
        }

        .btn-alternate:hover {
            background-color: #E3F2FD;
            transform: translateY(-3px);
        }

        .btn-secondary {
            background-color: #f5f5f5;
            color: #666;
            border: 2px solid #ddd;
        }

        .btn-secondary:hover {
            background-color: #eeeeee;
            transform: translateY(-3px);
        }

        .support-section {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px dashed #ddd;
        }

        .support-title {
            color: #666;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
        }

        .contact-item i {
            color: #F44336;
            font-size: 18px;
        }

        @media (max-width: 600px) {
            .failure-card {
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

            .contact-info {
                flex-direction: column;
                gap: 15px;
                align-items: center;
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="failure-card">
            <div class="failure-icon">
                <i class="fas fa-times"></i>
            </div>

            <h1>भुगतान विफल हुआ</h1>
            <p class="subtitle">आपका भुगतान प्रसंस्करण के दौरान असफल रहा। कृपया नीचे दिए गए विवरण जांचें और पुनः प्रयास करें।</p>

            <div class="error-message">
                <div class="error-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    त्रुटि संदेश
                </div>
                <p class="error-desc" id="errorText">इंसफीसिएंट फंड्स: आपके खाते में पर्याप्त शेष राशि नहीं है। कृपया किसी अन्य भुगतान विधि का उपयोग करने का प्रयास करें।</p>
            </div>

            <div class="payment-details">
                <div class="detail-row">
                    <span class="detail-label">लेन-देन आईडी:</span>
                    <span class="detail-value">TXN20240528142536</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">तिथि और समय:</span>
                    <span class="detail-value">28 मई 2024, 14:25 बजे</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">भुगतान विधि:</span>
                    <span class="detail-value">डेबिट कार्ड (XXXX-XXXX-XXXX-1234)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">भुगतान राशि:</span>
                    <span class="detail-value highlight">₹3,750.00</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">स्थिति:</span>
                    <span class="detail-value">
                        <span class="status-badge">विफल</span>
                    </span>
                </div>
            </div>

            <div class="possible-reasons">
                <h3><i class="fas fa-lightbulb"></i> संभावित कारण</h3>
                <ul class="reasons-list">
                    <li>अपर्याप्त खाता शेष या क्रेडिट सीमा</li>
                    <li>गलत कार्ड विवरण (संख्या, समाप्ति तिथि, CVV)</li>
                    <li>कार्ड सीमा या प्रतिबंध से अधिक</li>
                    <li>नेटवर्क त्रुटि या कनेक्टिविटी समस्या</li>
                    <li>बैंक द्वारा लेनदेन अस्वीकृत</li>
                </ul>
            </div>

            <div class="actions">
                <button class="btn btn-retry pulse" onclick="retryPayment()">
                    <i class="fas fa-redo-alt"></i> भुगतान पुनः प्रयास करें
                </button>
                <button class="btn btn-alternate" onclick="changePaymentMethod()">
                    <i class="fas fa-credit-card"></i> भुगतान विधि बदलें
                </button>
                <a href="#" class="btn btn-secondary">
                    <i class="fas fa-home"></i> होम पेज पर जाएं
                </a>
            </div>

            <div class="support-section">
                <div class="support-title">अभी भी समस्या है? हमसे संपर्क करें</div>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <span>ग्राहक सेवा: 1800-123-4567</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>support@example.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-comments"></i>
                        <span>लाइव चैट सहायता</span>
                    </div>
                </div>
            </div>

            <p style="margin-top: 30px; color: #777; font-size: 14px; line-height: 1.5;">
                <i class="fas fa-info-circle" style="color: #F44336;"></i>
                <strong>नोट:</strong> यदि राशि आपके खाते से कट गई है, तो यह 7-10 कार्यदिवसों में वापस आ जाएगी। किसी भी प्रश्न के लिए कृपया हमारी ग्राहक सेवा से संपर्क करें।
            </p>
        </div>
    </div>

    <script>
        // संभावित त्रुटि संदेश
        const errorMessages = [
            "इंसफीसिएंट फंड्स: आपके खाते में पर्याप्त शेष राशि नहीं है। कृपया किसी अन्य भुगतान विधि का उपयोग करने का प्रयास करें।",
            "कार्ड अस्वीकृत: आपका बैंक इस लेनदेन को अस्वीकार कर दिया है। कृपया अपने बैंक से संपर्क करें।",
            "समय समाप्त: भुगतान प्रक्रिया समय सीमा से अधिक समय ले रही थी। कृपया पुनः प्रयास करें।",
            "अमान्य विवरण: कार्ड विवरण गलत प्रतीत होते हैं। कृपया अपना विवरण जांचें और पुनः प्रयास करें।",
            "सुरक्षा जांच विफल: 3D सिक्योरिटी सत्यापन विफल रहा। कृपया पुनः प्रयास करें या अपने बैंक से संपर्क करें।"
        ];

        // पृष्ठ लोड होने पर यादृच्छिक त्रुटि संदेश दिखाएं
        window.addEventListener('load', function() {
            const randomError = errorMessages[Math.floor(Math.random() * errorMessages.length)];
            document.getElementById('errorText').textContent = randomError;

            // विफलता आइकन को हिलाने की एनिमेशन
            const icon = document.querySelector('.failure-icon');
            setTimeout(() => {
                icon.style.animation = 'none';
                setTimeout(() => {
                    icon.style.animation = 'shake 0.8s ease-in-out';
                }, 10);
            }, 1000);
        });

        // भुगतान पुनः प्रयास फ़ंक्शन
        function retryPayment() {
            const retryBtn = document.querySelector('.btn-retry');
            const originalText = retryBtn.innerHTML;

            // बटन स्टेट बदलें
            retryBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> प्रोसेसिंग...';
            retryBtn.disabled = true;

            // सिम्युलेटेड प्रोसेसिंग
            setTimeout(() => {
                // असफल होने का नकल करें (वास्तविक एप्लिकेशन में, यहां API कॉल होगा)
                const isSuccess = Math.random() > 0.5; // 50% सफलता दर

                if (isSuccess) {
                    // सफलता के मामले में रीडायरेक्ट
                    alert("भुगतान सफल! आपको पुष्टि पृष्ठ पर पुनर्निर्देशित किया जा रहा है...");
                    // वास्तविक एप्लिकेशन में: window.location.href = "payment-success.html";
                } else {
                    // विफलता के मामले में
                    alert("भुगतान फिर से विफल रहा। कृपया किसी अन्य विधि का प्रयास करें।");
                    retryBtn.innerHTML = originalText;
                    retryBtn.disabled = false;

                    // त्रुटि संदेश अपडेट करें
                    const newError = errorMessages[Math.floor(Math.random() * errorMessages.length)];
                    document.getElementById('errorText').textContent = newError;
                }
            }, 2000);
        }

        // भुगतान विधि बदलें
        function changePaymentMethod() {
            alert("भुगतान विधि चयन पृष्ठ पर पुनर्निर्देशित किया जा रहा है...\n\nउपलब्ध विकल्प:\n• क्रेडिट/डेबिट कार्ड\n• नेट बैंकिंग\n• UPI\n• डिजिटल वॉलेट");
            // वास्तविक एप्लिकेशन में: window.location.href = "select-payment-method.html";
        }

        // पल्स एनिमेशन बटन पर जोड़ें
        document.querySelector('.btn-retry').addEventListener('mouseenter', function() {
            this.classList.remove('pulse');
        });

        document.querySelector('.btn-retry').addEventListener('mouseleave', function() {
            this.classList.add('pulse');
        });
    </script>
</body>

</html>