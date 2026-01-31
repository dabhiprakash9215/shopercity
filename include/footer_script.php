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
</script>

<script>
    // DOM Elements
    const modalOverlay = document.getElementById('modal-overlay');
    const closeModalBtn = document.getElementById('close-modal');
    const cancelModalBtn = document.getElementById('cancel-modal');
    const selectLocationCard = document.getElementById('select-location');
    const changeLocationCard = document.getElementById('change-location');
    const viewLocationCard = document.getElementById('view-location');
    const changeLocationBtn = document.getElementById('change-location-btn');
    const stateSelect = document.getElementById('state-select');
    const districtSelect = document.getElementById('district-select');
    const citySelect = document.getElementById('city-select');
    const confirmLocationBtn = document.getElementById('confirm-location');
    const selectedLocationDisplay = document.getElementById('selected-location-display');
    const displayState = document.getElementById('display-state');
    const displayDistrict = document.getElementById('display-district');
    const displayCity = document.getElementById('display-city');
    const selectionSummary = document.getElementById('selection-summary');
    const errorMessage = document.getElementById('error-message');

    // Loading elements
    const stateLoading = document.getElementById('state-loading');
    const districtLoading = document.getElementById('district-loading');
    const cityLoading = document.getElementById('city-loading');

    $(document).ready(function() {
        $.ajax({
            url: 'db/get_state.php',
            type: 'GET',
            success: function(data) {
                $('#state-select').html(data);
            }
        });
    });

    $('#state-select').on('change', function() {
        $('#district-select').html('<option>Loading...</option>').prop('disabled', true);
        $('#city-select').prop('disabled', true);

        $.post('db/get_districts.php', {
            state_id: this.value
        }, html => {
            $('#district-select').html(html).prop('disabled', false);
        });
    });

    $('#district-select').on('change', function() {
        $('#city-select').html('<option>Loading...</option>').prop('disabled', true);

        $.post('db/get_cities.php', {
            district_id: this.value
        }, html => {
            $('#city-select').html(html).prop('disabled', false);
        });
    });

    $('#city-select').on('change', function() {
        confirmLocationBtn.disabled = false;
    });
    let currentSelection = {
        state_id: '',
        state_name: '',
        district_id: '',
        district_name: '',
        city_id: '',
        city_name: ''
    };

    // Event Listeners
    selectLocationCard.addEventListener('click', openModal);
    changeLocationCard.addEventListener('click', openModal);
    viewLocationCard.addEventListener('click', () => {
        if (currentSelection.state_id) {
            selectedLocationDisplay.classList.add('show');
        } else {
            openModal();
        }
    });
    changeLocationBtn.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);
    cancelModalBtn.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) closeModal();
    });

    // State Selection Change
    // stateSelect.addEventListener('change', function() {
    //     const stateId = this.value;
    //     const stateName = this.options[this.selectedIndex].text;

    //     if (!stateId) {
    //         districtSelect.disabled = true;
    //         districtSelect.innerHTML = '<option value="">-- First select a State --</option>';
    //         citySelect.disabled = true;
    //         citySelect.innerHTML = '<option value="">-- First select a District --</option>';
    //         confirmLocationBtn.disabled = true;
    //         selectionSummary.style.display = 'none';
    //         return;
    //     }

    //     currentSelection.state_id = stateId;
    //     currentSelection.state_name = stateName;
    //     currentSelection.district_id = '';
    //     currentSelection.district_name = '';
    //     currentSelection.city_id = '';
    //     currentSelection.city_name = '';

    //     // Show loading for districts
    //     districtLoading.style.display = 'block';
    //     districtSelect.disabled = true;

    //     // Reset city select
    //     citySelect.disabled = true;
    //     citySelect.innerHTML = '<option value="">-- First select a District --</option>';

    //     // Reset confirm button
    //     confirmLocationBtn.disabled = true;
    //     selectionSummary.style.display = 'none';
    //     errorMessage.style.display = 'none';

    //     // Fetch districts via AJAX
    //     fetch('get_district.php', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/x-www-form-urlencoded',
    //             },
    //             body: `state_id=${stateId}`
    //         })
    //         .then(response => response.text())
    //         .then(data => {
    //             districtSelect.innerHTML = data;
    //             districtSelect.disabled = false;
    //             districtLoading.style.display = 'none';

    //             // Update summary
    //             document.getElementById('summary-state-id').textContent = stateId;
    //             document.getElementById('summary-state-name').textContent = stateName;

    //             // If we have a previously selected district for this state, select it
    //             if (currentSelection.district_id && currentSelection.state_id === stateId) {
    //                 districtSelect.value = currentSelection.district_id;
    //                 districtSelect.dispatchEvent(new Event('change'));
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error loading districts:', error);
    //             districtSelect.innerHTML = '<option value="">Error loading districts</option>';
    //             districtLoading.style.display = 'none';
    //             errorMessage.textContent = 'Failed to load districts. Please try again.';
    //             errorMessage.style.display = 'block';
    //         });
    // });

    // District Selection Change
    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        const districtName = this.options[this.selectedIndex].text;

        if (!districtId) {
            citySelect.disabled = true;
            citySelect.innerHTML = '<option value="">-- First select a District --</option>';
            confirmLocationBtn.disabled = true;
            selectionSummary.style.display = 'none';
            return;
        }

        currentSelection.district_id = districtId;
        currentSelection.district_name = districtName;
        currentSelection.city_id = '';
        currentSelection.city_name = '';

        // Show loading for cities
        cityLoading.style.display = 'block';
        citySelect.disabled = true;

        // Reset confirm button
        confirmLocationBtn.disabled = true;
        selectionSummary.style.display = 'none';
        errorMessage.style.display = 'none';

        // Fetch cities via AJAX
        fetch('get_cities.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `district_id=${districtId}`
            })
            .then(response => response.text())
            .then(data => {
                citySelect.innerHTML = data;
                citySelect.disabled = false;
                cityLoading.style.display = 'none';

                // Update summary
                document.getElementById('summary-district-id').textContent = districtId;
                document.getElementById('summary-district-name').textContent = districtName;
                selectionSummary.style.display = 'block';

                // If we have a previously selected city for this district, select it
                if (currentSelection.city_id && currentSelection.district_id === districtId) {
                    citySelect.value = currentSelection.city_id;
                    citySelect.dispatchEvent(new Event('change'));
                }
            })
            .catch(error => {
                console.error('Error loading cities:', error);
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
                cityLoading.style.display = 'none';
                errorMessage.textContent = 'Failed to load cities. Please try again.';
                errorMessage.style.display = 'block';
            });
    });

    // City Selection Change
    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        const cityName = this.options[this.selectedIndex].text;

        if (!cityId) {
            confirmLocationBtn.disabled = true;
            return;
        }

        currentSelection.city_id = cityId;
        currentSelection.city_name = cityName;

        // Update summary
        document.getElementById('summary-city-id').textContent = cityId;
        document.getElementById('summary-city-name').textContent = cityName;

        // Enable confirm button
        confirmLocationBtn.disabled = false;
    });

    // Confirm Location
    confirmLocationBtn.addEventListener('click', function() {
        if (currentSelection.state_id && currentSelection.district_id && currentSelection.city_id) {
            // Disable button to prevent multiple clicks
            confirmLocationBtn.disabled = true;
            confirmLocationBtn.textContent = 'Saving...';

            // Save to session via AJAX
            fetch('save_location.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(currentSelection)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update display
                        displayState.textContent = `${currentSelection.state_name} (ID: ${currentSelection.state_id})`;
                        displayDistrict.textContent = `${currentSelection.district_name} (ID: ${currentSelection.district_id})`;
                        displayCity.textContent = `${currentSelection.city_name} (ID: ${currentSelection.city_id})`;

                        // Show selected location display
                        selectedLocationDisplay.classList.add('show');

                        // Close modal
                        closeModal();
                    } else {
                        errorMessage.textContent = data.message || 'Failed to save location';
                        errorMessage.style.display = 'block';
                    }

                    // Reset button
                    confirmLocationBtn.disabled = false;
                    confirmLocationBtn.textContent = 'Confirm Location';
                })
                .catch(error => {
                    console.error('Error saving location:', error);
                    errorMessage.textContent = 'Failed to save location. Please try again.';
                    errorMessage.style.display = 'block';

                    // Reset button
                    confirmLocationBtn.disabled = false;
                    confirmLocationBtn.textContent = 'Confirm Location';
                });
        }
    });

    // Open Modal Function
    function openModal() {
        modalOverlay.classList.add('active');

        // Load states if not already loaded
        if (stateSelect.options.length <= 1) {
            stateLoading.style.display = 'block';

            fetch('get_state.php')
                .then(response => response.text())
                .then(data => {
                    stateSelect.innerHTML = data;
                    stateLoading.style.display = 'none';

                    // If we have a previously selected state, select it
                    if (currentSelection.state_id) {
                        stateSelect.value = currentSelection.state_id;
                        stateSelect.dispatchEvent(new Event('change'));
                    }
                })
                .catch(error => {
                    console.error('Error loading states:', error);
                    stateSelect.innerHTML = '<option value="">Error loading states</option>';
                    stateLoading.style.display = 'none';
                    errorMessage.textContent = 'Failed to load states. Please try again.';
                    errorMessage.style.display = 'block';
                });
        } else {
            // If we have a previously selected state, select it
            if (currentSelection.state_id) {
                stateSelect.value = currentSelection.state_id;
                stateSelect.dispatchEvent(new Event('change'));
            }
        }

        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    // Close Modal Function
    function closeModal() {
        modalOverlay.classList.remove('active');

        // Reset button text
        confirmLocationBtn.textContent = 'Confirm Location';

        // Restore body scroll
        document.body.style.overflow = 'auto';
    }

    // Check for existing session data on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetch('get_session_location.php')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.location) {
                    currentSelection = data.location;

                    // Update display
                    displayState.textContent = `${currentSelection.state_name} (ID: ${currentSelection.state_id})`;
                    displayDistrict.textContent = `${currentSelection.district_name} (ID: ${currentSelection.district_id})`;
                    displayCity.textContent = `${currentSelection.city_name} (ID: ${currentSelection.city_id})`;

                    // Show selected location display
                    selectedLocationDisplay.classList.add('show');
                }
            })
            .catch(error => {
                console.error('Error loading session data:', error);
            });
    });
</script>