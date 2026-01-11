<?php require_once('db/connection.php'); ?>
<footer class="footer appear-animate">
    <div class="container">
        <div class="footer-middle">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">About Shopercity</h4>
                        <ul class="widget-body">
                            <li><a href="plan.php">Plan</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="mission.php">Mission & Vision</a></li>
                            <li><a href="licensing.php">Licensing, Compliance & Certification </a></li>
                            <li><a href="contact-us.php">Contact Us</a></li>
                        </ul>
                    </div>

                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">Customer Service</h4>
                        <ul class="widget-body">
                            <li><a href="privacy-policy.php">Privacy - Policy</a></li>
                            <li><a href="terms.php">Terms & Condition</a></li>
                            <li><a href="refund.php">Refund</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- <div class="row justified-content-center">
                <div class="col-md-12">
                    <div class="widget d-flex align-items-center flex-column">
                        <h4 class="widget-title p-0">Add your business</h4>
                        <ul class="widget-body p-0">
                            <li><a href="user/index.php" class="btn">Add Now</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->
        </div>

        <div class="footer-bottom">
            <div class="footer-left">
                <figure class="payment">
                    <img src="images/payment.png" alt="payment" width="159" height="29" />
                </figure>
            </div>
            <div class="footer-center">
                <p class="copyright">Shopercity &copy; <?php echo date('Y'); ?>. All Rights Reserved</p>
            </div>
            <div class="footer-right">
                <div class="social-links">
                    <a href="#" title="social-link" class="social-link social-facebook fab fa-facebook-f"></a>
                    <a href="#" title="social-link" class="social-link social-twitter fab fa-twitter"></a>
                    <a href="#" title="social-link" class="social-link social-linkedin fab fa-linkedin-in"></a>
                </div>
            </div>
        </div>

    </div>
</footer>
<div class="modal-overlay" id="mainModal">
    <div class="notification-modal">
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
                    <button class="btn btn-primary allow-notifications-btn">
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
                    <button class="btn btn-success" onclick="requestNotificationPermission()">
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
                            <?php
                            if ($conn) {
                                $states = $conn->query("SELECT * FROM state");
                                while ($row = $states->fetch_assoc()) {
                                    echo "<option value='{$row['state_code']}'>{$row['name']}</option>";
                                }
                            }
                            ?>
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
                    <button class="btn btn-success" id="submitLocationBtn" disabled>
                        <i class="fas fa-paper-plane"></i> Submit Location
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal-overlay" id="successModal">
    <div class="notification-modal success-modal">
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