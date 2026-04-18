<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $currencies = Currency::orderBy('is_default', 'desc')->get();
        return view('admin.page.currencies.index', compact('currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:currencies,code|max:3|uppercase',
            'name' => 'required|string|max:50',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        Currency::create($validated);

        return back()->with('success', 'Currency created successfully.');
    }

    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'code' => 'required|max:3|uppercase|unique:currencies,code,'.$currency->id,
            'name' => 'required|string|max:50',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Safety: if it was default, it must stay active
        if ($currency->is_default) {
            $validated['is_active'] = true;
        }

        $currency->update($validated);

        return back()->with('success', 'Currency updated successfully.');
    }

    public function destroy(Currency $currency)
    {
        if ($currency->is_default) {
            return back()->with('error', 'The default currency (Base) cannot be deleted.');
        }
        
        if ($currency->code === 'BDT') {
            return back()->with('error', 'BDT cannot be deleted as it is the system base currency.');
        }

        $currency->delete();
        return back()->with('success', 'Currency deleted successfully.');
    }

    public function refreshRates()
    {
        if ($this->currencyService->updateExchangeRates()) {
            return back()->with('success', 'Exchange rates updated successfully.');
        }
        return back()->with('error', 'Failed to update exchange rates.');
    }

    public function setAsDefault(Currency $currency)
    {
        Currency::where('is_default', true)->update(['is_default' => false]);
        $currency->update([
            'is_default' => true,
            'is_active' => true // A default currency must be active
        ]);

        return back()->with('success', $currency->code . ' set as default currency.');
    }

    public function toggleStatus(Currency $currency)
    {
        if ($currency->is_default && $currency->is_active) {
            return back()->with('error', 'Default currency must be active.');
        }
        $currency->update(['is_active' => !$currency->is_active]);
        return back()->with('success', 'Currency status updated.');
    }
}
