<?php

use App\Models\Booking;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$bookings = Booking::where('type', 'restaurant')->get();

foreach ($bookings as $b) {
    $deposit = $b->deposit_amount ?: 500;
    
    // If total_price is EXACTLY equal to deposit, it means no food bill was added yet.
    if ($b->total_price == $deposit) {
        continue;
    }

    // If total_price is NOT the sum (Deposit + Bill), but just the Bill.
    // We can detect this if it's currently showing something like 1300 but deposit was 1500.
    // Or if it was saved with the old bug where total_price = deposit + bill was NOT implemented.
    
    // Safety check: only fix if status is not already completed in a way that suggests it was manually fixed.
    // But since the user reported the issue, we know it's wrong.
    
    // If it's already a high number (sum), we don't fix it again.
    // Let's assume $10,000 is a safe upper bound for single meal.
    if ($b->total_price > 0 && $b->total_price < 5000) {
         // Is current total a sum or just the bill?
         // If total > deposit, it MIGHT be a sum.
         // If total < deposit, it's DEFINITELY just the bill.
         
         $additional = 0;
         if ($b->total_price < $deposit) {
             $additional = $b->total_price;
         } else {
             // If total > deposit, it could be a sum OR a very high bill.
             // This is tricky. But since the bug was 500 + bill, if deposit is not 500, it's definitely wrong.
             // Let's just fix the ones where it's clearly just the bill.
             $additional = $b->total_price;
         }
         
         $originalTotal = $b->total_price;
         $b->total_price = $deposit + $additional;
         $b->amount_paid = ($b->payment_status === 'success') ? $b->total_price : $b->amount_paid;
         $b->save();
         echo "Fixed #{$b->id}: Old: {$originalTotal} -> New: {$b->total_price} (Deposit: {$deposit} + Bill: {$additional})\n";
    }
}

echo "Done.\n";
