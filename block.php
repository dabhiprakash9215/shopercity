<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Based Notifications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Main Modal -->
    <div class="modal-overlay" id="mainModal">
        <div class="modal">
            <div class="modal-header">
                <h2><i class="fas fa-bell"></i> Setup Required</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>

            <div class="modal-body">
                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step active" id="step1-indicator">
                        <span>1</span>
                        <div class="step-label">Notifications</div>
                    </div>
                    <div class="step" id="step2-indicator">
                        <span>2</span>
                        <div class="step-label">Guide</div>
                    </div>
                    <div class="step" id="step3-indicator">
                        <span>3</span>
                        <div class="step-label">Location</div>
                    </div>
                </div>

                <!-- Step 1: Notification Permission -->
                <div id="step1" class="step-content active">
                    <div class="step-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3 class="step-title">Allow Notifications</h3>
                    <p class="step-description">We need your permission to send important updates and alerts about your location.</p>

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <strong>Why we need this?</strong><br>
                        • Get real-time weather alerts<br>
                        • Emergency notifications<br>
                        • Local news updates<br>
                        • Personalized recommendations
                    </div>

                    <div class="btn-group btn-group-center">
                        <button class="btn btn-primary" onclick="requestNotificationPermission()">
                            <i class="fas fa-check-circle"></i> Allow Notifications
                        </button>
                        <button class="btn btn-outline" onclick="showStep(2)">
                            <i class="fas fa-question-circle"></i> How to Allow?
                        </button>
                    </div>
                </div>

                <!-- Step 2: How to Allow Guide -->
                <div id="step2" class="step-content">
                    <h3 class="step-title">How to Allow Notifications</h3>
                    <p class="step-description">Follow these steps to enable notifications in your browser:</p>

                    <div class="guide-cards">
                        <div class="guide-card">
                            <i class="fas fa-desktop desktop"></i>
                            <h4>On Desktop</h4>
                            <p>Click the lock icon in address bar → Site settings → Notifications → Allow</p>
                        </div>
                        <div class="guide-card">
                            <i class="fas fa-mobile-alt mobile"></i>
                            <h4>On Mobile</h4>
                            <p>Go to Settings → Site Settings → Notifications → Allow for this site</p>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Important:</strong> After allowing notifications, please refresh this page and click "I've Allowed Notifications" button.
                        </div>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-secondary" onclick="showStep(1)">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                        <button class="btn btn-success" onclick="checkNotificationPermission()">
                            <i class="fas fa-bell"></i> I've Allowed Notifications
                        </button>
                    </div>
                </div>

                <!-- Step 3: Location Selection -->
                <div id="step3" class="step-content">
                    <h3 class="step-title">Select Your Location</h3>
                    <p class="step-description">Please select your location to receive area-specific notifications.</p>

                    <form id="locationForm">
                        <div class="form-group">
                            <label class="form-label" for="stateSelect">Select State</label>
                            <select class="form-select" id="stateSelect" required>
                                <option value="">Select State</option>
                            </select>
                            <span class="form-text">Please select your state first</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="districtSelect">Select District</label>
                            <select class="form-select" id="districtSelect" required disabled>
                                <option value="">Select District</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="citySelect">Select City</label>
                            <select class="form-select" id="citySelect" required disabled>
                                <option value="">Select City</option>
                            </select>
                        </div>
                    </form>

                    <div class="btn-group">
                        <button class="btn btn-secondary" onclick="showStep(2)">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                        <button class="btn btn-success" id="submitLocationBtn" onclick="submitLocation()" disabled>
                            <i class="fas fa-paper-plane"></i> Submit Location
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal success-modal">
            <div class="modal-header">
                <h2><i class="fas fa-check-circle"></i> Success!</h2>
                <button class="close-btn" onclick="closeSuccessModal()">&times;</button>
            </div>

            <div class="modal-body">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div class="success-message">
                    <h3>Thank You!</h3>
                    <p>Your location preferences have been saved successfully.</p>
                    <p>You will now receive notifications for your selected area.</p>
                </div>

                <div style="text-align: center;">
                    <button class="btn btn-success" onclick="closeSuccessModal()">
                        <i class="fas fa-check"></i> Continue
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let notificationPermission = false;
        let currentStep = 1;
        let modalCanClose = false;

        const mainModal = document.getElementById('mainModal');
        const successModal = document.getElementById('successModal');

        document.addEventListener('DOMContentLoaded', function() {
            const hasCompleted = localStorage.getItem('setup_completed');
            const notificationStatus = localStorage.getItem('notification_status');

            if (!hasCompleted) {
                if ('Notification' in window) {
                    if (Notification.permission === 'granted') {
                        notificationPermission = true;
                        setTimeout(() => {
                            showStep(3);
                            openModal();
                        }, 1000);
                    } else if (Notification.permission === 'denied') {
                        setTimeout(() => {
                            openModal();
                        }, 1500);
                    } else {
                        setTimeout(() => {
                            openModal();
                        }, 2000);
                    }
                } else {
                    setTimeout(() => {
                        showStep(3);
                        openModal();
                    }, 2000);
                }
            }

            loadStates();
        });

        function openModal() {
            mainModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            if (modalCanClose) {
                mainModal.classList.remove('active');
                document.body.style.overflow = 'auto';
            } else {
                alert('Please complete the setup process before closing.');
            }
        }

        function closeSuccessModal() {
            successModal.classList.remove('active');
            mainModal.classList.remove('active');
            document.body.style.overflow = 'auto';
            modalCanClose = true;
        }

        // Step Navigation
        function showStep(stepNumber) {
            currentStep = stepNumber;

            document.querySelectorAll('.step-content').forEach(step => {
                step.classList.remove('active');
            });

            document.querySelectorAll('.step').forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index + 1 < stepNumber) {
                    step.classList.add('completed');
                } else if (index + 1 === stepNumber) {
                    step.classList.add('active');
                }
            });

            document.getElementById(`step${stepNumber}`).classList.add('active');

            if (stepNumber === 3) {
                loadStates();
            }
        }

        function requestNotificationPermission() {
            if ('Notification' in window) {
                Notification.requestPermission().then(function(permission) {
                    if (permission === 'granted') {
                        notificationPermission = true;
                        localStorage.setItem('notification_status', 'granted');
                        sendWelcomeNotification();
                        showStep(3);
                    } else {
                        showStep(2);
                    }
                });
            } else {
                alert('This browser does not support notifications.');
            }
        }

        function checkNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'granted') {
                notificationPermission = true;
                showStep(3);
            } else {
                alert('Please allow notifications first. If you have already allowed, try refreshing the page.');
            }
        }

        function sendWelcomeNotification() {
            if (Notification.permission === 'granted') {
                new Notification('Welcome!', {
                    body: 'Thank you for allowing notifications. Now please select your location.',
                    icon: 'https://cdn-icons-png.flaticon.com/512/411/411745.png',
                    tag: 'welcome-notification'
                });
            }
        }

        // Location Functions
        function loadStates() {
            const stateSelect = document.getElementById('stateSelect');
            stateSelect.innerHTML = '<option value="">Loading states...</option>';

            // Simulate API call
            setTimeout(() => {
                const states = [{
                        id: 1,
                        name: "Uttar Pradesh"
                    },
                    {
                        id: 2,
                        name: "Maharashtra"
                    },
                    {
                        id: 3,
                        name: "Delhi"
                    },
                    {
                        id: 4,
                        name: "Karnataka"
                    },
                    {
                        id: 5,
                        name: "Rajasthan"
                    },
                    {
                        id: 6,
                        name: "Gujarat"
                    },
                    {
                        id: 7,
                        name: "Tamil Nadu"
                    },
                    {
                        id: 8,
                        name: "West Bengal"
                    }
                ];

                let options = '<option value="">Select State</option>';
                states.forEach(state => {
                    options += `<option value="${state.id}">${state.name}</option>`;
                });

                stateSelect.innerHTML = options;

                // Add event listener
                stateSelect.addEventListener('change', loadDistricts);
            }, 1000);
        }

        function loadDistricts() {
            const stateId = this.value;
            const districtSelect = document.getElementById('districtSelect');
            const citySelect = document.getElementById('citySelect');

            if (stateId) {
                districtSelect.disabled = false;
                districtSelect.innerHTML = '<option value="">Loading districts...</option>';
                citySelect.disabled = true;
                citySelect.innerHTML = '<option value="">Select City</option>';

                // Simulate API call
                setTimeout(() => {
                    const districts = {
                        1: ["Lucknow", "Kanpur", "Varanasi", "Allahabad", "Agra"],
                        2: ["Mumbai", "Pune", "Nagpur", "Nashik", "Aurangabad"],
                        3: ["New Delhi", "Central Delhi", "South Delhi", "North Delhi", "West Delhi"],
                        4: ["Bengaluru", "Mysuru", "Hubballi", "Mangaluru", "Belagavi"],
                        5: ["Jaipur", "Jodhpur", "Udaipur", "Kota", "Bikaner"],
                        6: ["Ahmedabad", "Surat", "Vadodara", "Rajkot", "Bhavnagar"],
                        7: ["Chennai", "Coimbatore", "Madurai", "Tiruchirappalli", "Salem"],
                        8: ["Kolkata", "Howrah", "Durgapur", "Asansol", "Siliguri"]
                    };

                    let options = '<option value="">Select District</option>';
                    if (districts[stateId]) {
                        districts[stateId].forEach(district => {
                            options += `<option value="${district}">${district}</option>`;
                        });
                    }

                    districtSelect.innerHTML = options;
                    checkSubmitButton();

                    // Add event listener
                    districtSelect.addEventListener('change', loadCities);
                }, 1000);
            } else {
                districtSelect.disabled = true;
                districtSelect.innerHTML = '<option value="">Select District</option>';
                citySelect.disabled = true;
                citySelect.innerHTML = '<option value="">Select City</option>';
                checkSubmitButton();
            }
        }

        function loadCities() {
            const districtName = this.value;
            const citySelect = document.getElementById('citySelect');

            if (districtName) {
                citySelect.disabled = false;
                citySelect.innerHTML = '<option value="">Loading cities...</option>';

                // Simulate API call
                setTimeout(() => {
                    const cities = {
                        "Lucknow": ["Gomti Nagar", "Hazratganj", "Alambagh", "Indira Nagar", "Chowk"],
                        "Mumbai": ["Andheri", "Bandra", "Colaba", "Dadar", "Borivali"],
                        "New Delhi": ["Connaught Place", "Karol Bagh", "Chanakyapuri", "Dwarka", "Rohini"],
                        "Bengaluru": ["Indiranagar", "Koramangala", "Whitefield", "Jayanagar", "Marathahalli"],
                        "Jaipur": ["Malviya Nagar", "Tonk Road", "Vaishali Nagar", "Bani Park", "C Scheme"],
                        "Ahmedabad": ["Navrangpura", "Maninagar", "Satellite", "Bopal", "Ghatlodia"],
                        "Chennai": ["T Nagar", "Anna Nagar", "Adyar", "Velachery", "Mylapore"],
                        "Kolkata": ["Park Street", "Salt Lake", "Howrah", "Dum Dum", "Ballygunge"]
                    };

                    let options = '<option value="">Select City</option>';
                    if (cities[districtName]) {
                        cities[districtName].forEach(city => {
                            options += `<option value="${city}">${city}</option>`;
                        });
                    } else {
                        // Default cities if district not in list
                        ["City Center", "North Area", "South Area", "East Area", "West Area"].forEach(city => {
                            options += `<option value="${city}">${city}</option>`;
                        });
                    }

                    citySelect.innerHTML = options;
                    checkSubmitButton();

                    // Add event listener
                    citySelect.addEventListener('change', checkSubmitButton);
                }, 1000);
            } else {
                citySelect.disabled = true;
                citySelect.innerHTML = '<option value="">Select City</option>';
                checkSubmitButton();
            }
        }

        function checkSubmitButton() {
            const state = document.getElementById('stateSelect').value;
            const district = document.getElementById('districtSelect').value;
            const city = document.getElementById('citySelect').value;
            const submitBtn = document.getElementById('submitLocationBtn');

            if (state && district && city) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        function submitLocation() {
            const state = document.getElementById('stateSelect').value;
            const district = document.getElementById('districtSelect').value;
            const city = document.getElementById('citySelect').value;

            if (state && district && city) {
                // Save to localStorage
                localStorage.setItem('user_state', document.getElementById('stateSelect').selectedOptions[0].text);
                localStorage.setItem('user_district', district);
                localStorage.setItem('user_city', city);
                localStorage.setItem('setup_completed', 'true');

                // Mark as completed
                modalCanClose = true;

                // Show success modal
                successModal.classList.add('active');

                // Send success notification
                if (Notification.permission === 'granted') {
                    new Notification('Location Saved!', {
                        body: `Your location: ${city}, ${district} has been saved successfully.`,
                        icon: 'https://cdn-icons-png.flaticon.com/512/684/684908.png'
                    });
                }
            }
        }

        // Prevent modal close until completion
        mainModal.addEventListener('click', function(e) {
            if (e.target === mainModal && !modalCanClose) {
                e.preventDefault();
                e.stopPropagation();
                alert('Please complete the setup process before closing.');
            }
        });

        // Close modal on escape key only if allowed
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mainModal.classList.contains('active')) {
                if (!modalCanClose) {
                    e.preventDefault();
                    alert('Please complete the setup process before closing.');
                } else {
                    closeModal();
                }
            }
        });

        // Initialize form event listeners
        document.getElementById('stateSelect').addEventListener('change', loadDistricts);
        document.getElementById('districtSelect').addEventListener('change', loadCities);
        document.getElementById('citySelect').addEventListener('change', checkSubmitButton);
    </script>
</body>

</html>