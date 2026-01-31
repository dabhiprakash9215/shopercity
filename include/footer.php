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

<div class="modal-overlay location-modal" id="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Select Your Location</h2>
            <button class="close-btn" id="close-modal">×</button>
        </div>
        <form method="post" action="db/location.php">
            <div class="modal-content">
                <!-- State Selection -->
                <div class="form-group">
                    <label class="form-label">Select State</label>
                    <div class="select-container">
                        <select class="form-select" name="state" id="state-select">
                            <option value="">-- Loading States --</option>
                        </select>
                        <div class="select-icon">▼</div>
                    </div>
                    <div class="loading" id="state-loading" style="display: none;">
                        <div class="spinner"></div>
                        Loading states...
                    </div>
                </div>

                <!-- District Selection -->
                <div class="form-group">
                    <label class="form-label">Select District</label>
                    <div class="select-container">
                        <select class="form-select" name="district" id="district-select" disabled>
                            <option value="">-- First select a State --</option>
                        </select>
                        <div class="select-icon">▼</div>
                    </div>
                    <div class="loading" id="district-loading" style="display: none;">
                        <div class="spinner"></div>
                        Loading districts...
                    </div>
                </div>

                <!-- City Selection -->
                <div class="form-group">
                    <label class="form-label">Select City</label>
                    <div class="select-container">
                        <select class="form-select" name="city" id="city-select" disabled>
                            <option value="">-- First select a District --</option>
                        </select>
                        <div class="select-icon">▼</div>
                    </div>
                    <div class="loading" id="city-loading" style="display: none;">
                        <div class="spinner"></div>
                        Loading cities...
                    </div>
                </div>

                <!-- Error Message -->
                <div class="error-message" id="error-message"></div>

                <!-- Selection Summary -->
                <div class="instructions" style="margin-top: 25px; display: none;" id="selection-summary">
                    <h3>Selection Summary</h3>
                    <p><strong>State ID:</strong> <span id="summary-state-id">-</span> | <strong>Name:</strong> <span id="summary-state-name">-</span></p>
                    <p><strong>District ID:</strong> <span id="summary-district-id">-</span> | <strong>Name:</strong> <span id="summary-district-name">-</span></p>
                    <p><strong>City ID:</strong> <span id="summary-city-id">-</span> | <strong>Name:</strong> <span id="summary-city-name">-</span></p>
                </div>
            </div>

            <div class="modal-actions">
                <button class="btn btn-cancel" id="cancel-modal">Cancel</button>
                <button class="btn btn-submit" type="submit" id="confirm-location" disabled>Confirm Location</button>
            </div>
        </form>
    </div>
</div>