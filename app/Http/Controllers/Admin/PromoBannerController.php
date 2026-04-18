<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoBanner;
use Illuminate\Http\Request;

class PromoBannerController extends Controller
{
    public function index()
    {
        $banners = PromoBanner::all();
        $offerBanners = \App\Models\OfferBanner::orderBy('order_column')->get();
        return view('admin.home.promo_banners.index', compact('banners', 'offerBanners'));
    }

    public function create()
    {
        return view('admin.home.promo_banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|max:10240',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('assets/img/offer'), $imageName);
            $data['image'] = 'assets/img/offer/'.$imageName;
        }

        PromoBanner::create($data);
        return redirect()->route('admin.home_promo_banners.index')->with('success', 'Promo banner created.');
    }

    public function edit($id)
    {
        $banner = PromoBanner::findOrFail($id);
        return view('admin.home.promo_banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = PromoBanner::findOrFail($id);
        $request->validate([
            'title' => 'required',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('assets/img/offer'), $imageName);
            $data['image'] = 'assets/img/offer/'.$imageName;
        }

        $banner->update($data);
        return redirect()->route('admin.home_promo_banners.index')->with('success', 'Promo banner updated.');
    }

    public function destroy($id)
    {
        $banner = PromoBanner::findOrFail($id);
        $banner->delete();
        return redirect()->route('admin.home_promo_banners.index')->with('success', 'Promo banner deleted.');
    }
}
