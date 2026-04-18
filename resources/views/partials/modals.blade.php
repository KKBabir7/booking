<!-- 3D 360 Viewer Modal -->
<div class="modal fade" id="viewer3DModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 bg-dark overflow-hidden">
      <div class="modal-header border-0 position-absolute top-0 end-0 z-3">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div id="panorama-container" style="width: 100%; height: 75vh;"></div>
        <div class="viewer-info p-3 text-white">
          <h5 class="mb-0 fw-bold" id="viewerHallTitle">Conference Hall 3D View</h5>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Hall Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="bookingModalLabel">
          <i class="bi bi-calendar-check-fill me-2 text-primary"></i>
          Book Conference Hall
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form id="hallBookingForm">
          <div class="hall-info-display p-3 mb-4 rounded" style="background: #f8f9fa;">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="mb-1 fw-bold" id="selectedHallName">Select a hall</h6>
                <p class="mb-0 small text-muted">
                  <i class="bi bi-people-fill me-1"></i>
                  Capacity: <span id="selectedHallCapacity">-</span> persons
                </p>
              </div>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label for="eventDate" class="form-label fw-semibold"><i class="bi bi-calendar3 me-1"></i> Event Date</label>
              <input type="text" class="form-control" id="eventDate" placeholder="Select date" required>
            </div>
            <div class="col-md-6">
              <label for="guestCount" class="form-label fw-semibold"><i class="bi bi-people me-1"></i> Number of Guests</label>
              <input type="number" class="form-control" id="guestCount" placeholder="Enter guest count" min="1" required>
            </div>
            <div class="col-md-6">
              <label for="startTime" class="form-label fw-semibold"><i class="bi bi-clock me-1"></i> Start Time</label>
              <select class="form-select" id="startTime" required>
                <option value="">Select start time</option>
                <option value="08:00">08:00 AM</option>
                <option value="09:00">09:00 AM</option>
                <option value="10:00">10:00 AM</option>
                <!-- ... other options ... -->
              </select>
            </div>
            <div class="col-md-6">
              <label for="endTime" class="form-label fw-semibold"><i class="bi bi-clock-fill me-1"></i> End Time</label>
              <select class="form-select" id="endTime" required>
                <option value="">Select end time</option>
                <option value="09:00">09:00 AM</option>
                <!-- ... other options ... -->
              </select>
            </div>
            <div class="col-md-6">
              <label for="customerName" class="form-label fw-semibold"><i class="bi bi-person me-1"></i> Full Name</label>
              <input type="text" class="form-control" id="customerName" placeholder="Enter your name" required>
            </div>
            <div class="col-md-6">
              <label for="customerEmail" class="form-label fw-semibold"><i class="bi bi-envelope me-1"></i> Email Address</label>
              <input type="email" class="form-control" id="customerEmail" placeholder="Enter your email" required>
            </div>
            <div class="col-md-6">
              <label for="customerPhone" class="form-label fw-semibold"><i class="bi bi-telephone me-1"></i> Phone Number</label>
              <input type="tel" class="form-control" id="customerPhone" placeholder="Enter your phone" required>
            </div>
            <div class="col-md-6">
              <label for="eventType" class="form-label fw-semibold"><i class="bi bi-tag me-1"></i> Event Type</label>
              <select class="form-select" id="eventType" required>
                <option value="">Select event type</option>
                <option value="Board Meeting">Board Meeting</option>
                <option value="Conference">Conference</option>
                <!-- ... other options ... -->
              </select>
            </div>
            <div class="col-12">
              <label for="specialRequests" class="form-label fw-semibold"><i class="bi bi-chat-left-text me-1"></i> Special Requests (Optional)</label>
              <textarea class="form-control" id="specialRequests" rows="3" placeholder="Any special requirements..."></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="hallBookingForm" class="btn btn-primary px-4">
          <i class="bi bi-check-circle me-2"></i> Confirm Booking
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Premium Validation Modal -->
<div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-5 shadow-2xl overflow-hidden" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
      <div class="modal-body p-5 text-center position-relative">
        <!-- Decoration Background -->
        <div class="position-absolute top-0 start-50 translate-middle-x bg-indigo-50 w-100 h-25 opacity-25" style="border-radius: 0 0 100% 100%;"></div>
        
        <div class="mb-4 position-relative">
          <div class="pulse-ring bg-indigo-100 rounded-circle position-absolute top-50 start-50 translate-middle" style="width: 100px; height: 100px;"></div>
          <i class="bi bi-info-circle-fill text-indigo-600 position-relative" style="font-size: 3.5rem;"></i>
        </div>
        
        <h4 class="fw-bold mb-3 tracking-tight text-slate-900" id="validationModalTitle" style="font-family: 'Poppins', sans-serif;">Information Required</h4>
        <p class="text-slate-500 mb-4 px-3" id="validationModalMessage" style="font-size: 0.95rem; line-height: 1.6;">Please review your entry and try again.</p>
        
        <button type="button" class="btn btn-indigo-premium rounded-pill px-5 py-2 fw-bold w-100 border-0 shadow-sm" data-bs-dismiss="modal">
          Got it, thanks!
        </button>
      </div>
    </div>
  </div>
</div>

<style>
  .btn-indigo-premium {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    color: white;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .btn-indigo-premium:hover {
    background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
    color: white;
  }
  .bg-indigo-50 { background-color: #eef2ff; }
  .bg-indigo-100 { background-color: #e0e7ff; }
  .text-indigo-600 { color: #4f46e5; }
  .text-slate-900 { color: #0f172a; }
  .text-slate-500 { color: #64748b; }
  
  .pulse-ring {
    animation: pulser 2s infinite;
  }
  @keyframes pulser {
    0% { transform: translate(-50%, -50%) scale(0.95); opacity: 0.7; }
    50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.3; }
    100% { transform: translate(-50%, -50%) scale(0.95); opacity: 0.7; }
  }
</style>
