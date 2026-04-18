<?php

namespace App\Http\Controllers;

use App\Models\NavbarItem;
use App\Models\PageSetting;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display the restaurant page.
     */
    public function index()
    {
        $navbarItems = NavbarItem::where('is_active', true)->orderBy('order_column')->get();
        $restaurantSettings = PageSetting::getPage('restaurant');
        $restaurants = Restaurant::where('is_active', true)->get();
        
        return view('restaurant', compact('navbarItems', 'restaurantSettings', 'restaurants'));
    }
}
