<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.page.edit', 'restaurant');
    }

    public function create()
    {
        return view('admin.restaurants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'advance_amount' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('restaurants', 'public');
        }

        Restaurant::create($data);

        return redirect()->route('admin.page.edit', 'restaurant')->with('success', 'Restaurant added successfully!');
    }

    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'advance_amount' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($restaurant->image) {
                Storage::delete('public/' . $restaurant->image);
            }
            $data['image'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant->update($data);

        return redirect()->route('admin.page.edit', 'restaurant')->with('success', 'Restaurant updated successfully!');
    }

    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->image) {
            Storage::delete('public/' . $restaurant->image);
        }
        $restaurant->delete();
        return back()->with('success', 'Restaurant deleted successfully!');
    }
}
