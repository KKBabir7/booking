// --- Hero Main Offer Slider (Slick) ---
$(document).ready(function () {
    $('#hero-main-slider').slick({
        dots: false, // Disabled as requested
        infinite: true,
        speed: 1200,
        fade: true,
        cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: true, // Enabled as requested
        draggable: true,
        swipe: true,
        pauseOnHover: false
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Desktop Dropdown Submenu Logic
    const submenus = document.querySelectorAll('.dropdown-submenu .dropdown-toggle');
    submenus.forEach(submenu => {
        submenu.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const sub = submenu.nextElementSibling;
            if (sub) {
                sub.classList.toggle('show');
            }
        });
    });

    // Close all when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
            document.querySelectorAll('.btn-menu-toggle').forEach(btn => {
                btn.classList.remove('active');
            });
        }
    });

    // --- Animated Hamburger Logic ---
    const animatedBtns = document.querySelectorAll('.animated-burger-btn');
    const offcanvasMenu = document.getElementById('offcanvasMenu');
    const desktopDropdown = document.getElementById('desktopMenuDropdown');

    // --- Desktop Dropdown & Burger Sync ---
    const desktopDropdownWrapper = document.querySelector('.desktop-dropdown');
    const dropdownBtn = document.getElementById('desktopMenuDropdown');
    const dropdownMenu = desktopDropdownWrapper?.querySelector('.dropdown-menu');

    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
            dropdownBtn.classList.toggle('active');
        });

        // Close on click outside
        document.addEventListener('click', (e) => {
            if (desktopDropdownWrapper && !desktopDropdownWrapper.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                dropdownBtn.classList.remove('active');
            }
        });
    }

    // Sync Mobile Offcanvas Icon
    if (offcanvasMenu) {
        const mobileToggle = document.querySelector('[data-bs-target="#offcanvasMenu"]');
        offcanvasMenu.addEventListener('show.bs.offcanvas', () => {
            if (mobileToggle) mobileToggle.classList.add('active');
        });
        offcanvasMenu.addEventListener('hide.bs.offcanvas', () => {
            if (mobileToggle) mobileToggle.classList.remove('active');
        });
    }

    // --- Dynamic Sticky Navbar Logic ---
    const mainNav = document.getElementById('main-nav');
    if (mainNav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                mainNav.classList.add('navbar-scrolled');
            } else {
                mainNav.classList.remove('navbar-scrolled');
            }
        });
    }

    // --- Functional Search Bar Logic ---
    const searchWhere = document.getElementById('search-where');
    const searchWhen = document.getElementById('search-when');
    const searchWho = document.getElementById('search-who');
    const locationInput = document.getElementById('location-input');
    const locationPanel = document.querySelector('.location-panel');
    const locationResults = document.getElementById('location-results');
    const guestPanel = document.querySelector('.guest-panel');
    const dateDisplay = document.getElementById('date-display');
    const guestDisplay = document.getElementById('guest-display');

    const clearWhere = document.getElementById('clear-where');
    const clearWhen = document.getElementById('clear-when');
    const clearWho = document.getElementById('clear-who');

    function toggleClearBtn(btn, show) {
        if (!btn) return;
        if (show) btn.classList.remove('d-none');
        else btn.classList.add('d-none');
    }
    // --- Dynamic Search Panel Positioning (Smart Flip) ---
    const NAVBAR_HEIGHT = 80;

    function updatePanelPosition(panel) {
        if (!panel) return;

        const parentItem = panel.closest('.search-item');
        if (!parentItem) return;

        const rect = parentItem.getBoundingClientRect();
        const viewportHeight = window.innerHeight;
        const panelHeight = 480; // Added buffer for safer flipping

        const spaceBottom = viewportHeight - rect.bottom;
        const spaceTop = rect.top - NAVBAR_HEIGHT;

        // Reset flip
        panel.classList.remove('flip-top');

        // If bottom space is less than panel height AND top has more space than bottom
        if (spaceBottom < panelHeight && spaceTop > spaceBottom) {
            panel.classList.add('flip-top');
        }
    }

    // Utility: Show a specific panel
    function showPanel(panelName) {
        // Hide all panels first
        document.querySelectorAll('.search-panel').forEach(p => p.classList.add('d-none'));
        document.querySelectorAll('.search-item').forEach(i => i.classList.remove('active-section'));

        if (panelName === 'where') {
            locationPanel.classList.remove('d-none');
            searchWhere.classList.add('active-section');
            updatePanelPosition(locationPanel);
            locationInput.focus();
        } else if (panelName === 'when') {
            searchWhen.classList.add('active-section');
            datePickerInstance.open();
        } else if (panelName === 'who') {
            guestPanel.classList.remove('d-none');
            searchWho.classList.add('active-section');
            updatePanelPosition(guestPanel);
        }
    }

    // Event Listeners for Tab Switching
    searchWhere.addEventListener('click', (e) => {
        e.stopPropagation();
        showPanel('where');
    });

    searchWhen.addEventListener('click', (e) => {
        e.stopPropagation();
        showPanel('when');
    });

    searchWho.addEventListener('click', (e) => {
        e.stopPropagation();
        showPanel('who');
    });

    // Close panels on outside click
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.hero-search-container') && !e.target.closest('.flatpickr-calendar')) {
            document.querySelectorAll('.search-panel').forEach(p => p.classList.add('d-none'));
            document.querySelectorAll('.search-item').forEach(i => i.classList.remove('active-section'));
        }
    });

    // 1. Location Search (Nominatim API)
    let debounceTimer;
    locationInput.addEventListener('input', (e) => {
        const query = e.target.value;
        toggleClearBtn(clearWhere, query.length > 0);
        clearTimeout(debounceTimer);
        if (query.length < 3) return;

        debounceTimer = setTimeout(() => {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&countrycodes=bd&limit=5`)
                .then(res => res.json())
                .then(data => {
                    locationResults.innerHTML = ''; // Clear suggestions
                    data.forEach(place => {
                        const item = document.createElement('div');
                        item.className = 'suggestion-item d-flex align-items-center px-4 py-3';
                        item.innerHTML = `
                            <div class="suggestion-icon me-3 bg-light rounded-3 p-2">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </div>
                            <div>
                                <div class="suggestion-title fw-bold">${place.display_name.split(',')[0]}</div>
                                <div class="suggestion-subtitle text-muted small">${place.display_name.split(',').slice(1, 3).join(',')}</div>
                            </div>
                        `;
                        item.addEventListener('click', (e) => {
                            e.stopPropagation();
                            locationInput.value = place.display_name.split(',')[0];
                            showPanel('when'); // Auto-switch to When
                        });
                        locationResults.appendChild(item);
                    });
                });
        }, 500);
    });

    // Static suggestion click logic
    document.querySelectorAll('.suggestion-item').forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const loc = item.getAttribute('data-location');
            if (loc !== 'nearby') {
                locationInput.value = loc.split(',')[0];
                toggleClearBtn(clearWhere, true);
                showPanel('when');
            }
        });
    });

    clearWhere.addEventListener('click', (e) => {
        e.stopPropagation();
        locationInput.value = '';
        locationResults.innerHTML = '';
        toggleClearBtn(clearWhere, false);
        locationPanel.classList.add('d-none');
    });

    // 2. Date Range Selection (Flatpickr)
    const datePickerInstance = flatpickr("#date-range-picker", {
        mode: "range",
        dateFormat: "Y-m-d",
        minDate: "today",
        showMonths: window.innerWidth < 768 ? 1 : 2,
        appendTo: document.querySelector('.hero-search-wrapper'),
        onOpen: function (selectedDates, dateStr, instance) {
            const wrapper = document.querySelector('.hero-search-wrapper');
            if (!wrapper) return;

            const rect = wrapper.getBoundingClientRect();
            const panelHeight = 500;
            const spaceBottom = window.innerHeight - rect.bottom;
            const spaceTop = rect.top - NAVBAR_HEIGHT;

            // If bottom space is tight AND top has more room
            if (spaceBottom < panelHeight && spaceTop > spaceBottom) {
                instance.calendarContainer.classList.add('flip-top-calendar');
            } else {
                instance.calendarContainer.classList.remove('flip-top-calendar');
            }
        },
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
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const start = instance.formatDate(selectedDates[0], "M d");
                const end = instance.formatDate(selectedDates[1], "M d");
                if (dateDisplay) {
                    dateDisplay.textContent = `${start} - ${end}`;
                    dateDisplay.classList.remove('text-muted');
                    dateDisplay.classList.add('text-dark', 'fw-bold');
                }
                toggleClearBtn(clearWhen, true);
                setTimeout(() => showPanel('who'), 300); // Auto-switch after selection
            }
        }
    });

    clearWhen.addEventListener('click', (e) => {
        e.stopPropagation();
        datePickerInstance.clear();
        dateDisplay.textContent = 'Add dates';
        dateDisplay.classList.add('text-muted');
        dateDisplay.classList.remove('text-dark', 'fw-bold');
        toggleClearBtn(clearWhen, false);
    });

    // 3. Guest Counter Logic
    const guestCounts = { 
        adults: parseInt(document.getElementById('count-adults')?.textContent || 0), 
        children: parseInt(document.getElementById('count-children')?.textContent || 0), 
        infants: parseInt(document.getElementById('count-infants')?.textContent || 0), 
        pets: parseInt(document.getElementById('count-pets')?.textContent || 0) 
    };
    document.querySelectorAll('.counter-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const type = btn.getAttribute('data-type');
            if (btn.classList.contains('plus')) {
                guestCounts[type]++;
            } else if (guestCounts[type] > 0) {
                if (type === 'adults' && guestCounts[type] <= 1) {
                    // Do nothing, adults cannot go below 1
                } else {
                    guestCounts[type]--;
                }
            }
            document.getElementById(`count-${type}`).textContent = guestCounts[type];
            updateGuestDisplay();
        });
    });

    function updateGuestDisplay() {
        const total = guestCounts.adults + guestCounts.children;
        const subTotal = total + guestCounts.infants + guestCounts.pets;
        toggleClearBtn(clearWho, subTotal > 0);

        if (total === 0) {
            guestDisplay.textContent = 'Add guests';
        } else {
            let text = `${total} guest${total > 1 ? 's' : ''}`;
            if (guestCounts.infants > 0) text += `, ${guestCounts.infants} infant${guestCounts.infants > 1 ? 's' : ''}`;
            guestDisplay.textContent = text;
        }
    }

    clearWho.addEventListener('click', (e) => {
        e.stopPropagation();
        Object.keys(guestCounts).forEach(k => {
            if (k === 'adults') {
                guestCounts[k] = 1;
                const countEl = document.getElementById(`count-${k}`);
                if (countEl) countEl.textContent = '1';
            } else {
                guestCounts[k] = 0;
                const countEl = document.getElementById(`count-${k}`);
                if (countEl) countEl.textContent = '0';
            }
        });
        updateGuestDisplay();
        toggleClearBtn(clearWho, false);
        guestPanel.classList.add('d-none');
    });

    // --- Featured Offers Slider Initialization ---
    $('.offers-slider, .available-offers-slider').slick({
        dots: false,
        infinite: true,
        speed: 600,
        slidesToShow: 3,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev shadow-sm d-flex align-items-center justify-content-center"><i class="bi bi-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next shadow-sm d-flex align-items-center justify-content-center"><i class="bi bi-chevron-right"></i></button>',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: false
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: false
                }
            }
        ]
    });

    // --- Hall Booking Modal Functionality ---
    const bookingModal = document.getElementById('bookingModal');
    const hallNameDisplay = document.getElementById('selectedHallName');
    const hallCapacityDisplay = document.getElementById('selectedHallCapacity');
    const bookingForm = document.getElementById('hallBookingForm');

    // When modal is triggered, populate hall information
    if (bookingModal) {
        bookingModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const hallName = button.getAttribute('data-hall-name');
            const hallCapacity = button.getAttribute('data-hall-capacity');

            // Update modal content
            hallNameDisplay.textContent = hallName;
            hallCapacityDisplay.textContent = hallCapacity;
        });
    }

    // Initialize Flatpickr for event date
    if (document.getElementById('eventDate')) {
        flatpickr("#eventDate", {
            minDate: "today",
            dateFormat: "Y-m-d",
            disableMobile: true
        });
    }

    // Handle form submission
    if (bookingForm) {
        bookingForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form values
            const formData = {
                hallName: hallNameDisplay.textContent,
                hallCapacity: hallCapacityDisplay.textContent,
                eventDate: document.getElementById('eventDate').value,
                guestCount: document.getElementById('guestCount').value,
                startTime: document.getElementById('startTime').value,
                endTime: document.getElementById('endTime').value,
                customerName: document.getElementById('customerName').value,
                customerEmail: document.getElementById('customerEmail').value,
                customerPhone: document.getElementById('customerPhone').value,
                eventType: document.getElementById('eventType').value,
                specialRequests: document.getElementById('specialRequests').value
            };

            // Basic validation
            if (!formData.eventDate || !formData.guestCount || !formData.startTime ||
                !formData.endTime || !formData.customerName || !formData.customerEmail ||
                !formData.customerPhone || !formData.eventType) {
                alert('Please fill in all required fields.');
                return;
            }

            // Validate guest count doesn't exceed capacity
            if (parseInt(formData.guestCount) > parseInt(formData.hallCapacity)) {
                alert(`Guest count exceeds hall capacity of ${formData.hallCapacity} persons.`);
                return;
            }

            // Log booking data (in production, this would be sent to a server)
            console.log('Booking submitted:', formData);

            // Show success message
            alert(`Booking request submitted successfully!\n\nHall: ${formData.hallName}\nDate: ${formData.eventDate}\nTime: ${formData.startTime} - ${formData.endTime}\nGuests: ${formData.guestCount}\n\nWe'll contact you at ${formData.customerEmail} to confirm your booking.`);

            // Reset form and close modal
            bookingForm.reset();
            const modalInstance = bootstrap.Modal.getInstance(bookingModal);
            modalInstance.hide();
        });
    }
});

// --- 3D 360 Viewer Module ---
let panoramaViewer = null;

function open3DViewer(imageUrl, hallName) {
    const modalElement = document.getElementById('viewer3DModal');
    const modal = new bootstrap.Modal(modalElement);

    document.getElementById('viewerHallTitle').textContent = hallName + ' - 360° 3D View';

    modal.show();

    // Destroy previous instance if exists
    if (panoramaViewer) {
        panoramaViewer.destroy();
    }

    // Initialize Pannellum after a short delay to ensure modal is rendered
    setTimeout(() => {
        panoramaViewer = pannellum.viewer('panorama-container', {
            "type": "equirectangular",
            "panorama": imageUrl,
            "autoLoad": true,
            "autoRotate": -2,
            "showControls": true
        });
    }, 500);
}

// Ensure viewer is cleaned up when modal is closed
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('viewer3DModal');
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', function () {
            if (panoramaViewer) {
                panoramaViewer.destroy();
                panoramaViewer = null;
            }
        });
    }
});

// =========================================================
// Mobile Search Modal Logic
// =========================================================
document.addEventListener('DOMContentLoaded', function() {
    const mobileSearchTrigger = document.getElementById('mobileSearchTrigger');
    const mobileSearchTriggerRooms = document.getElementById('mobileSearchTriggerRooms');
    const mobileSearchClose = document.getElementById('mobileSearchClose');
    const mobileSearchCloseRooms = document.getElementById('mobileSearchCloseRooms');

    function openSearchModal() {
        document.body.classList.add('search-modal-open');
    }

    function closeSearchModal() {
        document.body.classList.remove('search-modal-open');
    }

    if (mobileSearchTrigger) {
        mobileSearchTrigger.addEventListener('click', openSearchModal);
    }
    
    if (mobileSearchTriggerRooms) {
        mobileSearchTriggerRooms.addEventListener('click', openSearchModal);
    }

    if (mobileSearchClose) {
        mobileSearchClose.addEventListener('click', closeSearchModal);
    }
    
    if (mobileSearchCloseRooms) {
        mobileSearchCloseRooms.addEventListener('click', closeSearchModal);
    }
});

// ==========================================================================
// Google Translate Implementation
// ==========================================================================

function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,bn,hi',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false
    }, 'google_translate_element');
}

function changeLanguage(langCode) {
    // Save selection to localStorage for persistence
    localStorage.setItem('ngh_selected_lang', langCode);
    
    var select = document.querySelector('select.goog-te-combo');
    if (select) {
        select.value = langCode;
        select.dispatchEvent(new Event('change'));
    }
    
    // Cookie-based backup for persistence and reliability
    // Setting both with and without domain for maximum compatibility
    document.cookie = "googtrans=/en/" + langCode + "; path=/; domain=" + window.location.hostname;
    document.cookie = "googtrans=/en/" + langCode + "; path=/";
    
    // If the select isn't found (widget not loaded yet), reload to let Google pick up the cookie
    if (!select) {
        window.location.reload();
    }
}

// Auto-apply saved language on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedLang = localStorage.getItem('ngh_selected_lang');
    // Only auto-apply if it's NOT English (default)
    if (savedLang && savedLang !== 'en') {
        let attempts = 0;
        const maxAttempts = 60; // Try for 6 seconds
        const checkTranslateReady = setInterval(function() {
            attempts++;
            const select = document.querySelector('select.goog-te-combo');
            if (select) {
                clearInterval(checkTranslateReady);
                // Extra small delay to ensure Google Translate API is fully ready to receive events
                setTimeout(() => {
                    select.value = savedLang;
                    select.dispatchEvent(new Event('change'));
                }, 100);
            }
            if (attempts >= maxAttempts) {
                clearInterval(checkTranslateReady);
            }
        }, 100);
    }
});

// Manage Google Translate UI visibility/premium look
setInterval(function() {
    var banner = document.querySelector('.goog-te-banner-frame');
    if (banner) {
        banner.style.display = 'none';
        banner.style.visibility = 'hidden';
    }
    document.body.style.top = '0px';
    
    var skipTranslate = document.querySelectorAll('.skiptranslate');
    skipTranslate.forEach(function(el) {
        if (!el.querySelector('select')) {
            el.style.display = 'none';
        }
    });
}, 500);

// ==========================================================================
// Scroll to Top Logic
// ==========================================================================
document.addEventListener('DOMContentLoaded', function() {
    const scrollTop = document.querySelector('.scroll-top');
    
    if (scrollTop) {
        const toggleScrollTop = function() {
            if (window.scrollY > 200) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        };

        window.addEventListener('load', toggleScrollTop);
        document.addEventListener('scroll', toggleScrollTop);

        scrollTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});

// ==========================================================================
// Wishlist (Favorites) Logic & Toasts
// ==========================================================================
function showToast(message, type = 'success') {
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1060';
        document.body.appendChild(toastContainer);
    }

    const toastId = 'toast-' + Date.now();
    const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="bi ps-1 pe-2 ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'}"></i> 
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    const toastElement = document.getElementById(toastId);
    
    if (typeof bootstrap !== 'undefined') {
        const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
        toast.show();
        
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    } else {
        // Fallback if bootstrap JS is not loaded yet
        toastElement.classList.add('show');
        setTimeout(() => toastElement.remove(), 3000);
    }
}

function toggleFavorite(roomId, btn) {
    if (!window.Laravel || !window.Laravel.csrfToken) {
        console.error("CSRF token not found");
        return;
    }

    const icon = btn.querySelector('i');
    const isCurrentlyFavorited = icon.classList.contains('bi-heart-fill');
    
    // Optimistic UI update
    if (isCurrentlyFavorited) {
        icon.classList.replace('bi-heart-fill', 'bi-heart');
        icon.classList.remove('text-danger');
    } else {
        icon.classList.replace('bi-heart', 'bi-heart-fill');
        icon.classList.add('text-danger');
    }

    // Prepare proper base URL pathing
    const baseUrl = window.Laravel.baseUrl.replace(/\/$/, '');

    fetch(baseUrl + '/favorites/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.Laravel.csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ room_id: roomId })
    })
    .then(response => {
        if (!response.ok) {
            if(response.status === 401) {
                window.location.href = baseUrl + '/register';
            }
            throw new Error('Network error');
        }
        return response.json();
    })
    .then(data => {
        if (data && !data.success) {
            throw new Error('Server returned false success');
        } else if (data && data.success) {
            // Show toast notification
            showToast(data.message, 'success');

            // Update Header Favorites count badge dynamically
            const navBadge = document.getElementById('nav-favorites-count');
            if (navBadge) {
                let currentCount = parseInt(navBadge.textContent) || 0;
                let newCount = data.is_favorited ? currentCount + 1 : Math.max(0, currentCount - 1);
                navBadge.textContent = newCount;
                if (newCount > 0) {
                    navBadge.style.display = 'inline-block';
                } else {
                    navBadge.style.display = 'none';
                }
            }
        }
    })
    .catch(error => {
        console.error('Error toggling favorite:', error);
        showToast('Something went wrong. Please try again.', 'danger');
        
        // Revert UI on failure
        if (isCurrentlyFavorited) {
            icon.classList.replace('bi-heart', 'bi-heart-fill');
            icon.classList.add('text-danger');
        } else {
            icon.classList.replace('bi-heart-fill', 'bi-heart');
            icon.classList.remove('text-danger');
        }
    });
}

function removeFavorite(roomId, btn) {
    if (!window.Laravel || !window.Laravel.csrfToken) {
        console.error("CSRF token not found");
        return;
    }

    // UI update logic - fade and remove immediately for better UX
    const card = btn.closest('.col-md-6');
    if (card) {
        card.style.transition = "opacity 0.3s ease, transform 0.3s ease";
        card.style.opacity = "0";
        card.style.transform = "scale(0.9)";
        setTimeout(() => {
            card.remove();
            
            // Check if there are any remaining cards, if not reload to show empty state
            const row = document.querySelector('#tab-favorites .row');
            if (row && row.children.length === 0) {
                window.location.reload();
            }
        }, 300);
    }

    // Prepare proper base URL pathing
    const baseUrl = window.Laravel.baseUrl.replace(/\/$/, '');

    fetch(baseUrl + '/favorites/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.Laravel.csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ room_id: roomId })
    })
    .then(response => {
        if (!response.ok) {
            if(response.status === 401) {
                window.location.href = baseUrl + '/register';
            }
            throw new Error('Network error');
        }
        return response.json();
    })
    .then(data => {
        if (data && !data.success) {
            throw new Error('Server returned false success');
        } else if (data && data.success) {
            showToast('Room removed from wishlist.', 'success');

            // Update Header Favorites count badge dynamically
            const navBadge = document.getElementById('nav-favorites-count');
            if (navBadge) {
                let currentCount = parseInt(navBadge.textContent) || 0;
                let newCount = Math.max(0, currentCount - 1);
                navBadge.textContent = newCount;
                if (newCount > 0) {
                    navBadge.style.display = 'inline-block';
                } else {
                    navBadge.style.display = 'none';
                }
            }
            // Update sidebar badge
            const sidebarBadge = document.querySelector('.nav-link[data-tab="favorites"] .badge');
            if(sidebarBadge) {
                let currentCount = parseInt(sidebarBadge.textContent) || 0;
                let newCount = Math.max(0, currentCount - 1);
                sidebarBadge.textContent = newCount;
            }
        }
    })
    .catch(error => {
        console.error('Error removing favorite:', error);
        showToast('Something went wrong. Please try again.', 'danger');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const scrollTop = document.querySelector('.scroll-top');
    
    if (scrollTop) {
        const toggleScrollTop = function() {
            if (window.scrollY > 200) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        };

        window.addEventListener('load', toggleScrollTop);
        document.addEventListener('scroll', toggleScrollTop);

        scrollTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
