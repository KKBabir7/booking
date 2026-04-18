<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrencyMiddleware
{
    protected $currencyService;

    public function __construct(\App\Services\CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Initialize currency session if not set
        $this->currencyService->getCurrentCurrency();

        return $next($request);
    }
}
