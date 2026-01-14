<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="assets/js/toastr.min.js"></script> -->
<!-- <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> -->

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/toastr/toastr.min.js"></script>
<script src="vendor/parallax/parallax.min.js"></script>
<script src="vendor/elevatezoom/jquery.elevatezoom.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="vendor/owl-carousel/owl.carousel.min.js"></script>
<script src="vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="vendor/isotope/isotope.pkgd.min.js"></script>
<script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="js/main.min.js"></script>
<script src="js/script.js"></script>

<!-- <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"></script> -->

<script type="text/javascript">
    // Default Configuration
    $(document).ready(function() {
        // const isSetupComplete = localStorage.getItem('setup_completed');
        // if (!isSetupComplete) {
        //     // openModal();
        // }
        // console.log(isSetupComplete);
        toastr.options = {
            'closeButton': true,
            'debug': false,
            'newestOnTop': false,
            'progressBar': false,
            'positionClass': 'toast-top-right',
            'preventDuplicates': false,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'swing',
            'hideEasing': 'linear',
            'showMethod': 'fadeIn',
            'hideMethod': 'fadeOut',
        }
        <?php
        if (!empty($_SESSION['success_msg'])) {
        ?>
            toastr.success('<?php echo $_SESSION['success_msg']; ?>');
        <?php
            unset($_SESSION['success_msg']);
        }

        if (!empty($_SESSION['error_msg'])) {
        ?>
            toastr.error('<?php echo $_SESSION['error_msg']; ?>');
            <?php
            unset($_SESSION['error_msg']);
            ?>
        <?php
        }
        ?>
        $('.alrady-buy').click(function() {
            toastr.error('you plan is alrady purchase');
        });
    });

    function showStep(stepNumber) {
        currentStep = stepNumber;

        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.step').forEach((el, index) => {
            el.classList.remove('active', 'completed');
            if (index + 1 < stepNumber) el.classList.add('completed');
            if (index + 1 === stepNumber) el.classList.add('active');
        });

        document.getElementById(`step${stepNumber}`).classList.add('active');
    }

    function closeModal() {
        if (!modalCanClose && isSetupStarted) {
            toastr.error('Please complete the setup first.');
            return;
        }
        mainModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function closeSuccessModal() {
        successModal.classList.remove('active');
        modalCanClose = true;
        closeModal();
        localStorage.setItem('setup_completed', 'true');
    }
</script>
<script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
    import {
        getMessaging,
        getToken,
        isSupported
    } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging.js";

    /* ================= FIREBASE CONFIG ================= */

    const firebaseConfig = {
        apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
        authDomain: "shopercity-ea0ae.firebaseapp.com",
        projectId: "shopercity-ea0ae",
        storageBucket: "shopercity-ea0ae.firebasestorage.app",
        messagingSenderId: "54041175730",
        appId: "1:54041175730:web:75b62e47e74bf469efcbab"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    let messaging = null;

    let notificationPermission = false;
    let currentStep = 1;
    let modalCanClose = false;
    let fcmToken = null;
    let isSetupStarted = false;

    const mainModal = document.getElementById('mainModal');
    const successModal = document.getElementById('successModal');
    $(document).ready(function() {
        if (getNotificationStatus() === 'default') {
            localStorage.clear();
            alert('Notification permission reset. Please complete the setup again.');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const hasCompleted = localStorage.getItem('setup_completed');
        // Check if setup is already completed
        if (hasCompleted === 'true') {
            console.log('Setup already completed');
            return;
        }

        checkNotificationAndSetup();
    });

    async function checkNotificationAndSetup() {
        // First check if Firebase Messaging is supported
        const isFirebaseMessagingSupported = await isSupported();

        if (!isFirebaseMessagingSupported) {
            console.log('Firebase Messaging not supported in this browser');
            toastr.warning('Push notifications not supported in your browser');
            setTimeout(() => {
                openModal();
                showStep(3);
                loadStates();
            }, 1200);
            return;
        }

        // Check browser notification permission
        if ('Notification' in window) {
            notificationPermission = Notification.permission === 'granted';

            if (notificationPermission) {
                console.log('Notifications already allowed');

                // Check if we have FCM token
                const storedToken = localStorage.getItem('fcmToken');
                if (storedToken) {
                    fcmToken = storedToken;
                    console.log('FCM token found');

                    setTimeout(() => {
                        openModal();
                        showStep(3);
                        loadStates();
                    }, 1200);
                } else {
                    console.log('No FCM token, generating...');
                    setTimeout(() => {
                        openModal();
                        initFirebaseAndShowForm();
                    }, 1200);
                }
            } else {
                console.log('Notifications not allowed');
                setTimeout(() => {
                    openModal();
                }, 1200);
            }
        } else {
            console.log('Browser does not support notifications');
            setTimeout(() => {
                openModal();
                showStep(3);
                loadStates();
            }, 1200);
        }
    }

    /* ================= MODAL FUNCTIONS ================= */

    function openModal() {
        mainModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        modalCanClose = false;
        isSetupStarted = true;

        setTimeout(() => {
            initDropdownEvents();
        }, 100);
    }

    function closeModal() {
        if (!modalCanClose && isSetupStarted) {
            toastr.error('Please complete the setup first.');
            return;
        }
        mainModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function closeSuccessModal() {
        successModal.classList.remove('active');
        modalCanClose = true;
        closeModal();
        localStorage.setItem('setup_completed', 'true');
    }

    /* ================= STEP MANAGEMENT ================= */

    function showStep(stepNumber) {
        currentStep = stepNumber;

        document.querySelectorAll('.step-content').forEach(el => {
            el.classList.remove('active');
        });

        document.querySelectorAll('.step').forEach((el, index) => {
            el.classList.remove('active', 'completed');
            if (index + 1 < stepNumber) {
                el.classList.add('completed');
            }
            if (index + 1 === stepNumber) {
                el.classList.add('active');
            }
        });

        const stepElement = document.getElementById(`step${stepNumber}`);
        if (stepElement) {
            stepElement.classList.add('active');

            if (stepNumber === 3) {
                setTimeout(() => {
                    checkSubmitButton();
                }, 300);
            }
        }
    }

    /* ================= NOTIFICATION PERMISSION ================= */

    async function requestNotificationPermission() {
        if (!('Notification' in window)) {
            toastr.error('Notifications not supported in your browser.');
            return;
        }

        try {
            const permission = await Notification.requestPermission();
            console.log(permission, 'permission')
            if (permission === 'granted') {
                notificationPermission = true;
                localStorage.setItem('notification_status', 'granted');
                toastr.success('Notifications allowed!');

                // Send welcome notification
                sendWelcomeNotification();

                // Initialize Firebase and show location form
                await initFirebaseAndShowForm();

            } else {
                toastr.error('Please allow notifications to continue.');
                showStep(1);
            }
        } catch (error) {
            console.error('Error requesting notification permission:', error);
            toastr.error('Failed to request notification permission.');
        }
    }

    function sendWelcomeNotification() {
        if (Notification.permission === 'granted') {
            try {
                new Notification('Welcome!', {
                    body: 'Please select your location to complete setup.',
                    icon: 'https://cdn-icons-png.flaticon.com/512/411/411745.png'
                });
            } catch (error) {
                console.warn('Could not send welcome notification:', error);
            }
        }
    }

    /* ================= FIREBASE & TOKEN MANAGEMENT ================= */

    async function initFirebaseAndShowForm() {
        try {
            // Check if messaging is supported
            const messagingSupported = await isSupported();
            if (!messagingSupported) {
                throw new Error('Firebase Messaging not supported');
            }

            // Initialize messaging WITHOUT service worker
            messaging = getMessaging(app);

            // Get FCM token WITHOUT service worker requirement
            // const token = await getToken(messaging, {
            //     vapidKey: "BALA3EAA75KX1OcNiYCaA3EhYHbEt7njsfk8LkqrlEbBxNccc3Sxm_NmQCxqRs5MMR6SAfesgdsl8UyCUa2Zmis",
            // });

            const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');

            const token = await getToken(messaging, {
                vapidKey: "BALA3EAA75KX1OcNiYCaA3EhYHbEt7njsfk8LkqrlEbBxNccc3Sxm_NmQCxqRs5MMR6SAfesgdsl8UyCUa2Zmis",
                serviceWorkerRegistration: registration
            });

            if (token) {
                fcmToken = token;
                localStorage.setItem('fcmToken', token);
                console.log('FCM token generated:', token.substring(0, 20) + '...');
                toastr.success('Notifications enabled successfully!');

                showStep(3);
                loadStates();

            } else {
                toastr.error('Unable to generate notification token.');
                showStep(1);
            }
        } catch (error) {
            console.error('Firebase error:', error);

            // Handle specific errors
            if (error.code === 'messaging/permission-blocked') {
                toastr.warning('Notifications blocked. You can still proceed with location setup.');
                showStep(3);
                loadStates();
            } else if (error.code === 'messaging/permission-default') {
                toastr.error('Notification permission not granted.');
                showStep(1);
            } else if (error.message.includes('service-worker')) {
                // Service worker error - fallback to basic notifications
                toastr.warning('Using basic notifications. Some features may be limited.');
                showStep(3);
                loadStates();

                // Store a dummy token for form submission
                const dummyToken = 'no-service-worker-' + Date.now();
                fcmToken = dummyToken;
                localStorage.setItem('fcmToken', dummyToken);
            } else {
                toastr.error('Notification setup failed. Please refresh and try again.');
                showStep(3);
                loadStates();
            }
        }
    }

    /* ================= LOCATION FORM FUNCTIONS ================= */

    function loadStates() {
        $.ajax({
            url: 'db/get_state.php',
            type: 'GET',
            success: function(data) {
                $('#stateSelect').html(data);
                checkSubmitButton();
            },
            error: function() {
                // Fallback
                $('#stateSelect').html(`
                <option value="">Select State</option>
                <option value="1">Demo State 1</option>
                <option value="2">Demo State 2</option>
                <option value="3">Demo State 3</option>
            `);
                toastr.warning('Using demo states.');
                checkSubmitButton();
            }
        });
    }

    function initDropdownEvents() {
        function saveLocationDraft() {
            const locationDraft = {
                state_id: $('#stateSelect').val(),
                district_id: $('#districtSelect').val(),
                city_id: $('#citySelect').val()
            };
            localStorage.setItem('user_location_draft', JSON.stringify(locationDraft));
        }

        $('#stateSelect').off('change').on('change', function() {
            const state_id = this.value;

            $('#districtSelect').html('<option value="">Select District</option>').prop('disabled', true);
            $('#citySelect').html('<option value="">Select City</option>').prop('disabled', true);

            saveLocationDraft();
            checkSubmitButton();

            if (!state_id) return;

            $('#districtSelect').html('<option value="">Loading...</option>').prop('disabled', true);

            $.ajax({
                url: 'db/get_districts.php',
                type: 'POST',
                data: {
                    state_id: state_id
                },
                success: function(data) {
                    $('#districtSelect').html(data).prop('disabled', false);
                    saveLocationDraft();
                    checkSubmitButton();
                },
                error: function() {
                    $('#districtSelect').html('<option value="">Error</option>').prop('disabled', true);
                    toastr.error('Failed to load districts');
                }
            });
        });

        $('#districtSelect').off('change').on('change', function() {
            const district_id = this.value;

            $('#citySelect').html('<option value="">Select City</option>').prop('disabled', true);

            saveLocationDraft();
            checkSubmitButton();

            if (!district_id) return;

            $('#citySelect').html('<option value="">Loading...</option>').prop('disabled', true);

            $.ajax({
                url: 'db/get_cities.php',
                type: 'POST',
                data: {
                    district_id: district_id
                },
                success: function(data) {
                    $('#citySelect').html(data).prop('disabled', false);
                    saveLocationDraft();
                    checkSubmitButton();
                },
                error: function() {
                    $('#citySelect').html('<option value="">Error</option>').prop('disabled', true);
                    toastr.error('Failed to load cities');
                }
            });
        });

        $('#citySelect').off('change').on('change', function() {
            saveLocationDraft();
            checkSubmitButton();
        });
    }

    function checkSubmitButton() {
        const state = $('#stateSelect').val();
        const district = $('#districtSelect').val();
        const city = $('#citySelect').val();

        const isEnabled = state && district && city;
        $('#submitLocationBtn').prop('disabled', !isEnabled);
    }

    $('#submitLocationBtn').off('click').on('click', function(e) {
        e.preventDefault();

        const state = $('#stateSelect').val();
        const district = $('#districtSelect').val();
        const city = $('#citySelect').val();

        if (!state || !district || !city) {
            toastr.error('Please select state, district, and city');
            return;
        }

        const notificationToken = localStorage.getItem('fcmToken') || fcmToken;

        if (!notificationToken) {
            toastr.warning('Notification token not found.');
        }

        const payload = {
            notification_token: notificationToken,
            state_id: state,
            district_id: district,
            city_id: city
        };

        const submitBtn = $(this);
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

        $.ajax({
            url: 'db/save_location.php',
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    toastr.success(res.message);
                    localStorage.setItem('setup_completed', 'true');
                    localStorage.removeItem('user_location_draft');
                    localStorage.setItem('user_location', JSON.stringify(payload));
                    successModal.classList.add('active');
                    modalCanClose = true;
                } else {
                    toastr.error(res.message || 'Failed to save location');
                    submitBtn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                toastr.error('Server error. Please try again.');
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    /* ================= EVENT LISTENERS ================= */

    // Button event listeners
    $(document).on('click', '.allow-notifications-btn', function() {
        requestNotificationPermission();
    });

    $(document).on('click', '#step2 button.btn-success', function() {
        requestNotificationPermission();
    });

    $(document).on('click', '#step2 button.btn-secondary', function() {
        showStep(1);
    });

    $(document).on('click', '#step3 button.btn-secondary', function() {
        if (notificationPermission) {
            showStep(1);
        } else {
            showStep(2);
        }
    });

    $(document).on('click', '#step1 button.btn-outline', function() {
        showStep(2);
    });

    // Modal close prevention
    mainModal.addEventListener('click', function(e) {
        if (e.target === mainModal && !modalCanClose && isSetupStarted) {
            e.preventDefault();
            toastr.error('Please complete the setup before closing.');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mainModal.classList.contains('active') && !modalCanClose && isSetupStarted) {
            e.preventDefault();
            toastr.error('Please complete the setup first.');
        }
    });

    function getNotificationStatus() {
        if (!('Notification' in window)) {
            return 'not-supported';
        }
        return Notification.permission;
    }
</script>
<!-- <script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
    import {
        getMessaging,
        getToken
    } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging.js";

    /* ================= FIREBASE CONFIG ================= */

    const firebaseConfig = {
        apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
        authDomain: "shopercity-ea0ae.firebaseapp.com",
        projectId: "shopercity-ea0ae",
        messagingSenderId: "54041175730",
        appId: "1:54041175730:web:75b62e47e74bf469efcbab"
    };


    let notificationPermission = false;
    let currentStep = 1;
    let modalCanClose = false;
    // const messaging = firebase.messaging();

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);
    const mainModal = document.getElementById('mainModal');
    const successModal = document.getElementById('successModal');

    document.addEventListener('DOMContentLoaded', function() {

        const hasCompleted = localStorage.getItem('setup_completed');

        if (!hasCompleted) {
            setTimeout(() => {
                openModal();
            }, 1200);
        }

        if ('Notification' in window && Notification.permission === 'granted') {
            notificationPermission = true;
            showStep(3);
        }

        // loadStates();
    });

    /* ================= MODAL ================= */

    function openModal() {
        mainModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        if (!modalCanClose) {
            toastr.error('Please complete the setup first.');
            return;
        }
        mainModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function closeSuccessModal() {
        successModal.classList.remove('active');
        closeModal();
    }

    /* ================= STEPS ================= */

    function showStep(stepNumber) {
        currentStep = stepNumber;

        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.step').forEach((el, index) => {
            el.classList.remove('active', 'completed');
            if (index + 1 < stepNumber) el.classList.add('completed');
            if (index + 1 === stepNumber) el.classList.add('active');
        });

        document.getElementById(`step${stepNumber}`).classList.add('active');
    }

    /* ================= NOTIFICATION ================= */

    // function requestNotificationPermission() {
    //     if (!('Notification' in window)) {
    //         toastr.error('Notifications not supported.');
    //         return;
    //     }

    //     Notification.requestPermission().then(permission => {
    //         if (permission === 'granted') {
    //             notificationPermission = true;
    //             localStorage.setItem('notification_status', 'granted');
    //             sendWelcomeNotification();
    //             showStep(3);
    //         } else {
    //             toastr.error('Please allow notification to continue.');
    //         }
    //     });
    // }

    function sendWelcomeNotification() {
        new Notification('Welcome!', {
            body: 'Please select your location.',
            icon: 'https://cdn-icons-png.flaticon.com/512/411/411745.png'
        });
    }

    /* ================= LOCATION AJAX ================= */

    // function loadStates() {
    //     $.ajax({
    //         url: 'db/get_states.php',
    //         type: 'GET',
    //         success: function(data) {
    //             $('#stateSelect').html(data);
    //         }
    //     });
    // }

    $('#stateSelect').on('change', function() {
        const state_id = this.value;

        $('#districtSelect').html('<option value="">Loading...</option>').prop('disabled', true);
        $('#citySelect').html('<option value="">Select City</option>').prop('disabled', true);

        if (!state_id) return;

        $.post('db/get_districts.php', {
            state_id
        }, function(data) {
            $('#districtSelect').html(data).prop('disabled', false);
        });
    });

    $('#districtSelect').on('change', function() {
        const district_id = this.value;

        $('#citySelect').html('<option value="">Loading...</option>').prop('disabled', true);

        if (!district_id) return;

        $.post('db/get_cities.php', {
            district_id
        }, function(data) {
            $('#citySelect').html(data).prop('disabled', false);
        });
    });

    $('#citySelect').on('change', checkSubmitButton);

    /* ================= SUBMIT ================= */

    function checkSubmitButton() {
        const enabled =
            $('#stateSelect').val() &&
            $('#districtSelect').val() &&
            $('#citySelect').val();

        $('#submitLocationBtn').prop('disabled', !enabled);
    }

    function requestNotificationPermission() {

        if (!('Notification' in window)) {
            toastr.error('Notifications not supported.');
            return;
        }

        Notification.requestPermission().then(permission => {

            if (permission !== 'granted') {
                toastr.error('Please allow notification to continue.');
                return;
            }

            notificationPermission = true;
            localStorage.setItem('notification_status', 'granted');

            sendWelcomeNotification();

            // 🔥 IMPORTANT: Firebase token generate here
            generateFirebaseToken();

            showStep(3);
            notificationPermission = true;
            localStorage.setItem('notification_status', 'granted');
            sendWelcomeNotification();
        });
    }

    // function initFirebaseMessaging() {
    //     messaging.requestPermission()
    //         .then(() => messaging.getToken({
    //             vapidKey: "YOUR_VAPID_KEY"
    //         }))
    //         .then(token => {
    //             console.log("FCM Token:", token);
    //             // 👉 YAHI TOKEN BACKEND KO SEND KARNA HAI
    //         })
    //         .catch(err => {
    //             console.error("Permission denied", err);
    //         });
    // }

    /* ================= SAFETY ================= */

    mainModal.addEventListener('click', function(e) {
        if (e.target === mainModal && !modalCanClose) {
            e.preventDefault();
            toastr.error('Complete setup before closing.');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mainModal.classList.contains('active')) {
            closeModal();
        }
    });


    async function initFirebaseMessaging() {
        try {
            const token = await getToken(messaging, {
                vapidKey: "BALA3EAA75KX1OcNiYCaA3EhYHbEt7njsfk8LkqrlEbBxNccc3Sxm_NmQCxqRs5MMR6SAfesgdsl8UyCUa2Zmis",
            });

            if (!token) {
                toastr.error('Unable to generate notification token');
                return;
            }
            if (token) {
                fcmToken = token;
                showStep(3);
                localStorage.setItem('fcmToken', token);

                toastr.success('Notifications enabled');
                showLocationForm();
            } else {
                showStep(1);
            }

        } catch (err) {
            console.error('FCM Error:', err);
            toastr.error('Notification setup failed');
            showStep(1);
        }
    }
    $('.allow-notifications-btn').on('click', async () => {
        try {
            const permission = await Notification.requestPermission();

            if (permission !== 'granted') {
                toastr.error('Notification permission is mandatory');
                return;
            }

            await initFirebaseAndShowForm();

        } catch (err) {
            console.error(err);
            toastr.error('Failed to enable notifications');
        }
    });

    $('#submitLocationBtn').on('click', function() {

        const payload = {
            notification_token: localStorage.getItem('fcmToken'),
            state_id: $('#stateSelect').val(),
            district_id: $('#districtSelect').val(),
            city_id: $('#citySelect').val()
        };

        if (!payload.notification_token) {
            toastr.error('Notification token missing');
            return;
        }

        $.ajax({
            url: 'db/save_location.php',
            type: 'POST',
            data: payload,
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    localStorage.setItem('setup_completed', 'true');
                    toastr.success(res.message);
                    successModal.classList.add('active');
                } else {
                    toastr.error(res.message);
                }
            },
            error: function() {
                toastr.error('Server error. Try again.');
            }
        });
    });

    async function initFirebaseAndShowForm() {
        try {
            const token = await getToken(messaging, {
                vapidKey: "BALA3EAA75KX1OcNiYCaA3EhYHbEt7njsfk8LkqrlEbBxNccc3Sxm_NmQCxqRs5MMR6SAfesgdsl8UyCUa2Zmis",
            });

            if (!token) {
                toastr.error('Unable to generate notification token');
                return;
            }
            if (token) {
                fcmToken = token;
                showStep(3);
                localStorage.setItem('fcmToken', token);

                toastr.success('Notifications enabled');
                showLocationForm();
            } else {
                showStep(1);
            }

        } catch (err) {
            console.error('FCM Error:', err);
            toastr.error('Notification setup failed');
            showStep(1);
        }
    }
</script> -->

<!-- <script type="module">
    import {
        initializeApp
    } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
    import {
        getMessaging,
        getToken,
    } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging.js";

    let notificationGranted = false;
    let fcmToken = null;
    let modalLocked = true;

    const mainModal = document.getElementById('mainModal');
    const successModal = document.getElementById('successModal');

    /* ================= TOAST ================= */

    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 3500
    };

    /* ================= ON LOAD ================= */

    $(document).ready(() => {

        if (localStorage.getItem('setup_completed')) return;

        openModal();

        if ('Notification' in window && Notification.permission === 'granted') {
            startFirebase();
        }
    });

    /* ================= MODAL ================= */

    function openModal() {
        mainModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(force = false) {
        if (!force && modalLocked) {
            toastr.error('Complete notification & location setup first');
            return;
        }
        mainModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    /* ================= NOTIFICATION ================= */

    function requestNotificationPermission() {

        if (!('Notification' in window)) {
            toastr.error('Browser does not support notifications');
            return;
        }

        Notification.requestPermission().then(permission => {

            if (permission !== 'granted') {
                toastr.error('Notification is mandatory');
                return;
            }

            startFirebase();
        });
    }

    /* ================= FIREBASE ================= */

    firebase.initializeApp({
        apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
        authDomain: "shopercity-ea0ae.firebaseapp.com",
        projectId: "shopercity-ea0ae",
        messagingSenderId: "54041175730",
        appId: "1:54041175730:web:75b62e47e74bf469efcbab"
    });

    const messaging = firebase.messaging();

    function startFirebase() {

        messaging.getToken({
            vapidKey: "BALA3EAA75KX1OcNiYCaA3EhYHbEt7njsfk8LkqrlEbBxNccc3Sxm_NmQCxqRs5MMR6SAfesgdsl8UyCUa2Zmis"
        }).then(token => {

            if (!token) {
                toastr.error('Unable to get notification token');
                return;
            }

            fcmToken = token;
            notificationGranted = true;

            toastr.success('Notification enabled');
            $('#locationSection').removeClass('hidden');

        }).catch(() => {
            toastr.error('Notification permission error');
        });
    }

    /* ================= LOCATION DROPDOWNS ================= */

    $('#state').on('change', function() {
        $('#district').html('<option>Loading...</option>').prop('disabled', true);
        $('#city').prop('disabled', true);

        $.post('api/get_districts.php', {
            state_id: this.value
        }, html => {
            $('#district').html(html).prop('disabled', false);
        });
    });

    $('#district').on('change', function() {
        $('#city').html('<option>Loading...</option>').prop('disabled', true);

        $.post('api/get_cities.php', {
            district_id: this.value
        }, html => {
            $('#city').html(html).prop('disabled', false);
        });
    });

    /* ================= SUBMIT ================= */

    function submitLocation() {

        if (!notificationGranted || !fcmToken) {
            toastr.error('Notification required');
            return;
        }

        const data = {
            token: fcmToken,
            state_id: $('#state').val(),
            district_id: $('#district').val(),
            city_id: $('#city').val()
        };

        if (!data.state_id || !data.district_id || !data.city_id) {
            toastr.error('Please select complete location');
            return;
        }

        $.post('api/save_user_location.php', data, res => {

            if (res.status) {
                modalLocked = false;
                localStorage.setItem('setup_completed', 'true');
                successModal.classList.add('active');
            } else {
                toastr.error(res.message);
            }

        }, 'json');
    }

    /* ================= SAFETY ================= */

    mainModal.addEventListener('click', e => {
        if (e.target === mainModal && modalLocked) {
            toastr.error('Setup required');
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });
</script> -->
<script type="module">
    // import {
    //     initializeApp
    // } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
    // import {
    //     getMessaging,
    //     getToken
    // } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging.js";

    // /* ================= FIREBASE CONFIG ================= */

    // const firebaseConfig = {
    //     apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
    //     authDomain: "shopercity-ea0ae.firebaseapp.com",
    //     projectId: "shopercity-ea0ae",
    //     messagingSenderId: "54041175730",
    //     appId: "1:54041175730:web:75b62e47e74bf469efcbab"
    // };


    // $(document).ready(async () => {
    //     if (localStorage.getItem('setup_completed')) return;

    //     openModal();

    //     if ('Notification' in window && Notification.permission === 'granted') {
    //         await initFirebaseAndShowForm();
    //     } else {
    //         showNotificationUI();
    //     }
    // });

    // function closeSuccessModal() {
    //     successModal.classList.remove('active');
    //     closeModal();
    // }
    // const app = initializeApp(firebaseConfig);
    // const messaging = getMessaging(app);

    // /* ================= STATE ================= */

    // let fcmToken = null;
    // let modalLocked = true;
    // let currentStep = 1;

    // /* ================= ELEMENTS ================= */

    // const mainModal = document.getElementById('mainModal');
    // const successModal = document.getElementById('successModal');
    // const locationSection = document.getElementById('locationSection');
    // const notificationSection = document.querySelector('.notification-section');

    // /* ================= TOAST ================= */

    // toastr.options = {
    //     closeButton: true,
    //     progressBar: true,
    //     positionClass: "toast-top-right",
    //     timeOut: 3500
    // };

    // /* ================= INIT ================= */

    // document.addEventListener('DOMContentLoaded', async () => {
    //     if (localStorage.getItem('setup_completed')) return;

    //     showStep(1);

    //     if (!('Notification' in window)) {
    //         toastr.error('Browser does not support notifications');
    //         return;
    //     }

    //     openModal();

    //     if (Notification.permission === 'granted') {
    //         await initFirebaseAndShowForm();
    //     } else {
    //         showNotificationUI();
    //     }
    // });

    // /* ================= MODAL ================= */

    // function openModal() {
    //     mainModal.classList.add('active');
    //     document.body.style.overflow = 'hidden';
    // }

    // function closeModal(force = false) {
    //     if (!force && modalLocked) {
    //         toastr.error('Please complete setup');
    //         return;
    //     }
    //     mainModal.classList.remove('active');
    //     document.body.style.overflow = 'auto';
    // }

    // /* ================= UI HELPERS ================= */

    // function showNotificationUI() {
    //     notificationSection.classList.remove('hidden');
    //     locationSection.classList.add('hidden');
    // }

    // function showLocationForm() {
    //     notificationSection.classList.add('hidden');
    //     locationSection.classList.remove('hidden');
    // }

    // /* ================= NOTIFICATION FLOW ================= */

    // $('.allow-notifications-btn').on('click', async () => {
    //     try {
    //         const permission = await Notification.requestPermission();

    //         if (permission !== 'granted') {
    //             toastr.error('Notification permission is mandatory');
    //             return;
    //         }

    //         await initFirebaseAndShowForm();

    //     } catch (err) {
    //         console.error(err);
    //         toastr.error('Failed to enable notifications');
    //     }
    // });

    // /* ================= FIREBASE ================= */

    // async function initFirebaseAndShowForm() {
    //     try {
    //         const token = await getToken(messaging, {
    //             vapidKey: "BALA3EAA75KX1OcNiYCaA3EhYHbEt7njsfk8LkqrlEbBxNccc3Sxm_NmQCxqRs5MMR6SAfesgdsl8UyCUa2Zmis",
    //         });

    //         if (!token) {
    //             toastr.error('Unable to generate notification token');
    //             return;
    //         }
    //         if (token) {
    //             fcmToken = token;
    //             showStep(3);
    //             localStorage.setItem('fcmToken', token);

    //             toastr.success('Notifications enabled');
    //             showLocationForm();
    //         } else {
    //             showStep(1);
    //         }

    //     } catch (err) {
    //         console.error('FCM Error:', err);
    //         toastr.error('Notification setup failed');
    //         showStep(1);
    //     }
    // }

    // /* ================= LOCATION DROPDOWNS ================= */

    // $('#state').on('change', function() {
    //     $('#district').html('<option>Loading...</option>').prop('disabled', true);
    //     $('#city').prop('disabled', true);

    //     $.post('api/get_districts.php', {
    //         state_id: this.value
    //     }, html => {
    //         $('#district').html(html).prop('disabled', false);
    //     });
    // });

    // $('#district').on('change', function() {
    //     $('#city').html('<option>Loading...</option>').prop('disabled', true);

    //     $.post('api/get_cities.php', {
    //         district_id: this.value
    //     }, html => {
    //         $('#city').html(html).prop('disabled', false);
    //     });
    // });

    // /* ================= SUBMIT ================= */

    // window.submitLocation = function() {

    //     if (!fcmToken) {
    //         toastr.error('Notification token missing');
    //         return;
    //     }

    //     const data = {
    //         token: fcmToken,
    //         state_id: $('#state').val(),
    //         district_id: $('#district').val(),
    //         city_id: $('#city').val()
    //     };

    //     if (!data.state_id || !data.district_id || !data.city_id) {
    //         toastr.error('Please select complete location');
    //         return;
    //     }

    //     $.post('api/save_user_location.php', data, res => {

    //         if (res.status) {
    //             modalLocked = false;
    //             localStorage.setItem('setup_completed', 'true');
    //             successModal.classList.add('active');
    //         } else {
    //             toastr.error(res.message || 'Something went wrong');
    //         }

    //     }, 'json');
    // };

    // /* ================= SAFETY ================= */

    // mainModal.addEventListener('click', e => {
    //     if (e.target === mainModal && modalLocked) {
    //         toastr.error('Setup required');
    //     }
    // });

    // document.addEventListener('keydown', e => {
    //     if (e.key === 'Escape' && !modalLocked) {
    //         closeModal();
    //     }
    // });

    // function showStep(stepNumber) {
    //     currentStep = stepNumber;

    //     document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    //     document.querySelectorAll('.step').forEach((el, index) => {
    //         el.classList.remove('active', 'completed');
    //         if (index + 1 < stepNumber) el.classList.add('completed');
    //         if (index + 1 === stepNumber) el.classList.add('active');
    //     });

    //     document.getElementById(`step${stepNumber}`).classList.add('active');
    // }
</script>