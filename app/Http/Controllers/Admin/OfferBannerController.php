<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfferBanner; // Added this line

class OfferBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.home.offer_banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
            'link' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/offer'), $imageName);
            $data['image'] = 'assets/img/offer/' . $imageName;
        }

        OfferBanner::create($data);
        return redirect()->route('admin.home_promo_banners.index')->with('success', 'Offer banner created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfferBanner $offerBanner)
    {
        return view('admin.home.offer_banners.edit', compact('offerBanner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfferBanner $offerBanner)
    {
        $request->validate([
            'image' => 'nullable|image|max:10240',
            'link' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/offer'), $imageName);
            $data['image'] = 'assets/img/offer/' . $imageName;
        }

        $offerBanner->update($data);
        return redirect()->route('admin.home_promo_banners.index')->with('success', 'Offer banner updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfferBanner $offerBanner)
    {
        $offerBanner->delete();
        return redirect()->route('admin.home_promo_banners.index')->with('success', 'Offer banner deleted.');
    }
}
