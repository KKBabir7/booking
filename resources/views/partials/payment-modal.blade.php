<!-- SSLCommerz Payment Percentage Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-5 shadow-2xl overflow-hidden" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.2) !important;">
      <div class="modal-body p-0">
        <!-- Top Illustration/Header Area -->
        <div class="p-5 text-center text-white" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
          <div class="mb-3">
            <i class="bi bi-shield-check" style="font-size: 3rem;"></i>
          </div>
          <h4 class="fw-bold mb-1 tracking-tight" style="font-family: 'Outfit', sans-serif;">Secure Reservation</h4>
          <p class="opacity-75 small px-4">Complete your stay confirmation by selecting your preferred payment amount.</p>
        </div>

        <div class="p-5">
          <!-- Booking Summary -->
          <div class="booking-summary-pill mb-4 p-3 rounded-4 d-flex justify-content-between align-items-center" style="background: #f8fafc; border: 1px solid #e2e8f0;">
            <div>
              <span class="text-slate-500 d-block small uppercase font-black tracking-widest" style="font-size: 10px;">Total Stay Amount</span>
              <h5 class="fw-black mb-0 text-slate-800 tracking-tighter" id="modalTotalAmount">0 TK</h5>
            </div>
            <div class="text-end">
              <span class="badge bg-indigo-100 text-indigo-700 rounded-pill px-3 py-2" id="modalStayNights">0 Nights</span>
            </div>
          </div>

          <!-- Payment Options -->
          <label class="text-slate-500 small uppercase font-black tracking-widest mb-3 d-block" style="font-size: 10px;">Select Payment Percentage</label>
          <div class="row g-2 mb-4" id="paymentPercentageContainer">
            <div class="col-4">
              <input type="radio" class="btn-check" name="payment_percent" id="pay50" value="50" autocomplete="off">
              <label class="btn btn-outline-indigo w-100 py-3 rounded-4 fw-bold" for="pay50">50%</label>
            </div>
            <div class="col-4">
              <input type="radio" class="btn-check" name="payment_percent" id="pay70" value="70" autocomplete="off">
              <label class="btn btn-outline-indigo w-100 py-3 rounded-4 fw-bold" for="pay70">70%</label>
            </div>
            <div class="col-4">
              <input type="radio" class="btn-check" name="payment_percent" id="pay100" value="100" autocomplete="off" checked>
              <label class="btn btn-outline-indigo w-100 py-3 rounded-4 fw-bold" for="pay100">100%</label>
            </div>
          </div>

          <!-- Dynamically Calculated Amount -->
          <div class="payable-area mb-5 text-center">
            <p class="text-slate-400 mb-1 small fw-medium">Amount to Pay Now</p>
            <h2 class="fw-black text-indigo-600 tracking-tighter mb-0" id="modalPayableAmount">0 TK</h2>
          </div>

          <!-- Actions -->
          <div class="d-grid gap-2">
            <button type="button" id="initiatePaymentBtn" class="btn btn-indigo-premium rounded-pill py-3 fw-bold shadow-lg transition-all">
              <i class="bi bi-credit-card-2-front me-2"></i> Pay & Confirm Now
            </button>
            <button type="button" class="btn btn-link text-slate-400 small text-decoration-none fw-medium" data-bs-dismiss="modal">Modify Booking Dates</button>
          </div>

          <div class="text-center mt-4">
            <img src="https://securepay.sslcommerz.com/gw/asset/img/sslcommerz-logo.png" alt="SSLCommerz" style="height: 20px; opacity: 0.5;">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
  .text-slate-400 { color: #94a3b8; }
  .text-slate-500 { color: #64748b; }
  .text-slate-800 { color: #1e293b; }
  .text-indigo-600 { color: #4f46e5; }
  .text-indigo-700 { color: #4338ca; }
  .bg-indigo-100 { background-color: #e0e7ff; }
  .btn-outline-indigo {
    border-color: #e2e8f0;
    color: #64748b;
    background: #fff;
    transition: all 0.2s ease;
  }
  .btn-check:checked + .btn-outline-indigo {
    background-color: #4f46e5;
    border-color: #4f46e5;
    color: #fff;
    transform: scale(1.05);
    box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
  }
  .btn-indigo-premium {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    color: white;
    border: none;
  }
  .btn-indigo-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(79, 70, 229, 0.4);
    color: white;
  }
  .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
</style>
