/* ==========================================================================
   Room Details Interaction Logic
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Initialize Date Range Picker (Flatpickr)
    const dateInput = document.getElementById('booking-dates');
    const nightCountEl = document.getElementById('nightCount');
    const subtotalEl = document.getElementById('subtotalAmount');
    const serviceChargeEl = document.getElementById('serviceChargeAmount');
    const taxEl = document.getElementById('taxAmount');
    const totalEl = document.getElementById('totalAmount');
    const basePrice = window.roomPrice || 299;

    const bookingCard = document.querySelector('.booking-card');

    const updatePriceBreakdown = (days) => {
        if (!nightCountEl || !subtotalEl || !serviceChargeEl || !taxEl || !totalEl) return;
        
        const rate = window.exchangeRate || 1;
        const subtotal = Math.round(basePrice * days * rate);
        
        // Calculate dynamic charges per night
        const dynamicServiceCharge = Math.round((window.roomServiceCharge || 0) * days * rate);
        const dynamicTax = Math.round((window.roomTax || 0) * days * rate);
        const totalCharges = dynamicServiceCharge + dynamicTax;
        
        const total = subtotal + totalCharges;

        nightCountEl.textContent = days;
        subtotalEl.textContent = subtotal.toLocaleString();
        serviceChargeEl.textContent = dynamicServiceCharge.toLocaleString();
        taxEl.textContent = dynamicTax.toLocaleString();
        totalEl.textContent = total.toLocaleString();

        // Update the per-night base price display in the small text
        const basePriceDisplay = document.getElementById('basePriceDisplay');
        if (basePriceDisplay) {
            basePriceDisplay.textContent = Math.round(basePrice * rate).toLocaleString();
        }
    };

    const datePicker = flatpickr(dateInput, {
        mode: "range",
        minDate: "today",
        dateFormat: "Y-m-d",
        showMonths: window.innerWidth < 768 ? 1 : 2,
        appendTo: bookingCard,
        positionElement: dateInput,
        position: "above",
        onReady: function(selectedDates, dateStr, instance) {
            // Initialize Select2 on the month dropdown for mobile views
            if (window.innerWidth < 768) {
                const $monthDropdowns = $(instance.calendarContainer).find('.flatpickr-monthDropdown-months');
                if ($monthDropdowns.length && $.fn.select2) {
                    $monthDropdowns.select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $(instance.calendarContainer),
                        width: 'auto'
                    });
                    
                    // Propagate Select2 changes back to Flatpickr
                    $monthDropdowns.on('select2:select', function (e) {
                        this.dispatchEvent(new Event('change'));
                    });
                }
            }
        },
        onMonthChange: function(selectedDates, dateStr, instance) {
            if (window.innerWidth < 768) {
                const $monthDropdowns = $(instance.calendarContainer).find('.flatpickr-monthDropdown-months');
                if ($monthDropdowns.length && $monthDropdowns.hasClass('select2-hidden-accessible')) {
                    $monthDropdowns.val(instance.currentMonth).trigger('change.select2');
                }
            }
        },
        onYearChange: function(selectedDates, dateStr, instance) {
            if (window.innerWidth < 768) {
                const $monthDropdowns = $(instance.calendarContainer).find('.flatpickr-monthDropdown-months');
                if ($monthDropdowns.length && $monthDropdowns.hasClass('select2-hidden-accessible')) {
                    $monthDropdowns.val(instance.currentMonth).trigger('change.select2');
                }
            }
        },
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                updatePriceBreakdown(diffDays);
            }
        }
    });

    // 2. Guest Counter Logic (Sidebar)
    const guestDisplay = document.getElementById('guestDisplaySidebar');
    const counters = {
        adults: parseInt(document.getElementById('adults-count-input')?.value || 2),
        children: parseInt(document.getElementById('children-count-input')?.value || 0),
        infants: parseInt(document.getElementById('infants-count-input')?.value || 0),
        pets: parseInt(document.getElementById('pets-count-input')?.value || 0)
    };

    // Initialize Capacity Modal
    const capacityModalEl = document.getElementById('capacityWarningModal');
    const capacityModal = capacityModalEl ? new bootstrap.Modal(capacityModalEl) : null;

    document.querySelectorAll('.booking-card .counter-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            const type = this.getAttribute('data-type');
            const isPlus = this.classList.contains('plus');
            
            if (isPlus) {
                counters[type]++;
            } else if (counters[type] > (type === 'adults' ? 1 : 0)) {
                counters[type]--;
            }

            // Update UI
            const countEl = document.getElementById(`count-${type}-sidebar`);
            if (countEl) countEl.textContent = counters[type];

            // Update hidden inputs
            const inputEl = document.getElementById(`${type}-count-input`);
            if (inputEl) inputEl.value = counters[type];
            
            updateGuestText();
        });
    });

    function updateGuestText() {
        const total = counters.adults + counters.children;
        let text = `${total} guest${total > 1 ? 's' : ''}`;
        if (counters.infants > 0) {
            text += `, ${counters.infants} infant${counters.infants > 1 ? 's' : ''}`;
        }
        if (counters.pets > 0) {
            text += `, ${counters.pets} pet${counters.pets > 1 ? 's' : ''}`;
        }
        if (guestDisplay) {
            guestDisplay.textContent = text;
        }
    }

    // 3. Form Submission & Payment Modal
    const bookingForm = document.getElementById('bookingFormSidebar');
    const reserveBtn = document.getElementById('reserveBtn');
    const paymentModalEl = document.getElementById('paymentModal');
    const paymentModal = paymentModalEl ? new bootstrap.Modal(paymentModalEl) : null;
    
    // Payment Modal Elements
    const modalTotalAmount = document.getElementById('modalTotalAmount');
    const modalPayableAmount = document.getElementById('modalPayableAmount');
    const modalStayNights = document.getElementById('modalStayNights');
    const initiatePaymentBtn = document.getElementById('initiatePaymentBtn');
    const paymentPercentageInput = document.getElementById('payment_percentage_input');
    const amountToPayInput = document.getElementById('amount_to_pay_input');

    if (reserveBtn && bookingForm) {
        // Initialize Validation Modal
        const validationModalEl = document.getElementById('validationModal');
        const validationModal = validationModalEl ? new bootstrap.Modal(validationModalEl) : null;

        reserveBtn.addEventListener('click', function(e) {
            // Check for Selected Dates
            const datesVal = dateInput.value;
            if (!datesVal || datesVal.indexOf('to') === -1) {
                if (validationModal) {
                    document.getElementById('validationModalTitle').textContent = 'Dates Required';
                    document.getElementById('validationModalMessage').innerHTML = 'Please select your stay period (Check-in and Check-out dates) before proceeding.';
                    validationModal.show();
                } else {
                    alert('Please select your stay period.');
                }
                return;
            }

            // Check Capacity
            let overCapacity = false;
            let overMsg = '';
            if (counters.adults > window.roomMaxAdults) {
                overCapacity = true;
                overMsg = `The number of adults (${counters.adults}) exceeds the maximum allowed for this room (${window.roomMaxAdults}).`;
            } else if (counters.children > window.roomMaxChildren) {
                overCapacity = true;
                overMsg = `The number of children (${counters.children}) exceeds the maximum allowed for this room (${window.roomMaxChildren}).`;
            }

            if (overCapacity) {
                if (validationModal) {
                    document.getElementById('validationModalTitle').textContent = 'Room Capacity Exceeded';
                    document.getElementById('validationModalMessage').innerHTML = `<div class="mb-3">${overMsg}</div>`;
                    validationModal.show();
                } else {
                    alert(overMsg);
                }
                return;
            }

            // If valid, show the Payment Modal
            if (paymentModal) {
                const total = totalEl.textContent.replace(/,/g, '');
                const nights = nightCountEl.textContent;
                
                modalTotalAmount.textContent = total + ' ' + (window.currencySymbol || 'TK');
                modalStayNights.textContent = nights + ' Night' + (nights > 1 ? 's' : '');

                // Dynamically Render Payment Percentages
                const container = document.getElementById('paymentPercentageContainer');
                if (container && window.roomPayments) {
                    container.innerHTML = '';
                    window.roomPayments.forEach((percent, index) => {
                        const col = document.createElement('div');
                        col.className = 'col-4';
                        col.innerHTML = `
                            <input type="radio" class="btn-check" name="payment_percent" id="pay${percent}" value="${percent}" autocomplete="off" ${index === window.roomPayments.length - 1 ? 'checked' : ''}>
                            <label class="btn btn-outline-indigo w-100 py-3 rounded-4 fw-bold" for="pay${percent}">${percent}%</label>
                        `;
                        container.appendChild(col);
                    });

                    // Re-attach listeners to new radio buttons
                    container.querySelectorAll('input[name="payment_percent"]').forEach(radio => {
                        radio.addEventListener('change', function() {
                            updatePayableAmount(this.value);
                        });
                    });
                }
                
                // Set default (usually the last/100%)
                const defaultPercent = window.roomPayments ? window.roomPayments[window.roomPayments.length - 1] : 100;
                updatePayableAmount(defaultPercent);
                paymentModal.show();
            }
        });

        function updatePayableAmount(percent) {
            const totalStr = totalEl.textContent.trim().replace(/[^0-9.]/g, '');
            const total = parseFloat(totalStr);
            if (isNaN(total)) return;
            
            const payable = Math.round((total * percent) / 100);
            
            modalPayableAmount.textContent = payable.toLocaleString() + ' ' + (window.currencySymbol || 'TK');
            
            // Store in hidden inputs for form submission
            if (paymentPercentageInput) paymentPercentageInput.value = percent;
            if (amountToPayInput) amountToPayInput.value = payable;
        }

        // Handle Initiate Payment
        if (initiatePaymentBtn) {
            initiatePaymentBtn.addEventListener('click', function() {
                // Ensure the final values are set one last time
                const selectedRadio = document.querySelector('input[name="payment_percent"]:checked');
                if (selectedRadio) {
                    updatePayableAmount(selectedRadio.value);
                }
                
                // Change button state
                this.disabled = true;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                
                // Submit the main booking form
                bookingForm.submit();
            });
        }
    }

    // 4. Reviews Tab Auto-scroll
    const reviewsTabLink = document.getElementById('reviews-tab-link');
    const reviewsSection = document.querySelector('.reviews-section');
    
    if (reviewsTabLink && reviewsSection) {
        reviewsTabLink.addEventListener('click', function(e) {
            e.preventDefault();
            const offset = 100; // Account for fixed navbar
            const bodyRect = document.body.getBoundingClientRect().top;
            const elementRect = reviewsSection.getBoundingClientRect().top;
            const elementPosition = elementRect - bodyRect;
            const offsetPosition = elementPosition - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        });
    }

    // 5. Review Modal Management
    const showMoreReviewsBtn = document.getElementById('showMoreReviews');
    const reviewModalEl = document.getElementById('reviewModal');
    
    if (showMoreReviewsBtn && reviewModalEl) {
        const reviewModal = new bootstrap.Modal(reviewModalEl);
        showMoreReviewsBtn.addEventListener('click', function() {
            reviewModal.show();
        });
    }

    // 6. Initialize Related Rooms Carousel (Slick Slider)
    const $slider = $('.related-rooms-slider');
    if ($slider.length) {
        $slider.slick({
            dots: false,
            infinite: true,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 1,
            prevArrow: $('.slider-prev'),
            nextArrow: $('.slider-next'),
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    }

    // 7. Initialize Room Gallery Zooming (PhotoSwipe v5)
    const initZoomGallery = () => {
        if (window.PhotoSwipeLightbox) {
            const lightbox = new PhotoSwipeLightbox({
                gallery: '#room-gallery',
                children: '.gallery-link',
                pswpModule: window.PhotoSwipe,
                padding: { top: 20, bottom: 20, left: 20, right: 20 }
            });
            lightbox.init();

            const openGalleryBtn = document.getElementById('openMainGallery');
            if (openGalleryBtn) {
                openGalleryBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    lightbox.loadAndOpen(0);
                });
            }
        } else {
            setTimeout(initZoomGallery, 50);
        }
    };
    initZoomGallery();
});
