<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Eagerly load valid bookings to avoid N+1 queries, without caching to ensure time-sensitive "Not Available" statuses are accurate
        $featuredRooms = Room::with(['bookings' => function($q) {
            $q->whereIn('status', ['confirmed', 'pending', 'paid'])
              ->where('check_out', '>', \Carbon\Carbon::now());
        }])->where('is_360_available', true)->take(6)->get();

        $services = \Illuminate\Support\Facades\Cache::remember('home_services', 86400, fn() => \App\Models\Service::all());
        $clients = \Illuminate\Support\Facades\Cache::remember('home_clients', 86400, fn() => \App\Models\Client::all());
        $banners = \Illuminate\Support\Facades\Cache::remember('home_banners', 86400, fn() => \App\Models\Banner::where('is_active', true)->orderBy('order_column')->get());
        $promoBanner = \Illuminate\Support\Facades\Cache::remember('home_promo_banner', 86400, fn() => \App\Models\PromoBanner::where('is_active', true)->first());
        $offerBanners = \Illuminate\Support\Facades\Cache::remember('home_offer_banners', 86400, fn() => \App\Models\OfferBanner::where('is_active', true)->orderBy('order_column')->get());
        
        $restaurantSettings = \App\Models\PageSetting::getPage('home_restaurant');
        $conferenceSettings = \App\Models\PageSetting::getPage('home_conference');
        
        return view('home', compact('featuredRooms', 'services', 'clients', 'banners', 'promoBanner', 'offerBanners', 'restaurantSettings', 'conferenceSettings'));
    }

    public function rooms(Request $request)
    {
        $query = Room::query();

        if ($request->filled('adults') && $request->adults > 0) {
            $query->where('capacity_adults', '>=', $request->adults);
        }

        if ($request->filled('children') && $request->children > 0) {
            $query->where('capacity_children', '>=', $request->children);
        }

        if ($request->filled('dates')) {
            $dates = explode(' to ', $request->dates);
            if (count($dates) == 2) {
                $checkIn = $dates[0];
                $checkOut = $dates[1];

                $query->whereDoesntHave('bookings', function($q) use ($checkIn, $checkOut) {
                    $q->where(function ($sub) use ($checkIn, $checkOut) {
                        $sub->where('check_in', '<', $checkOut)
                            ->where('check_out', '>', $checkIn);
                    })->whereIn('status', ['confirmed', 'pending', 'paid']); 
                });
            }
        }

        $rooms = $query->with(['bookings' => function($q) {
            $q->whereIn('status', ['confirmed', 'pending', 'paid'])
              ->where('check_out', '>', \Carbon\Carbon::now());
        }])->get();
        $pageSettings = \App\Models\PageSetting::getPage('rooms');
        return view('rooms.index', compact('rooms', 'pageSettings'));
    }

    public function roomDetails($slug)
    {
        $room = Room::with(['reviews' => function($q) {
            $q->latest();
        }, 'reviews.user'])->where('slug', $slug)->firstOrFail();
        
        $relatedRooms = Room::where('id', '!=', $room->id)->take(4)->get();
        return view('rooms.show', compact('room', 'relatedRooms'));
    }

    public function about()
    {
        $settings = \App\Models\PageSetting::getPage('about');
        return view('about', compact('settings'));
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function contact()
    {
        $settings = \App\Models\PageSetting::getPage('contact_information');
        return view('contact', compact('settings'));
    }

    public function ourClients()
    {
        $clients = \App\Models\Client::all();
        return view('our-clients', compact('clients'));
    }

    public function faq()
    {
        $settings = \App\Models\PageSetting::getPage('faq');
        return view('faq', compact('settings'));
    }

    public function privacyPolicy()
    {
        $settings = \App\Models\PageSetting::getPage('privacy_policy');
        return view('privacy-policy', compact('settings'));
    }

    public function termsOfService()
    {
        $settings = \App\Models\PageSetting::getPage('terms_of_service');
        return view('terms-of-service', compact('settings'));
    }
}
