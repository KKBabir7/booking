<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order_column')->get();
        return view('admin.home.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.home.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/offer'), $imageName);
            $data['image'] = 'assets/img/offer/' . $imageName;
        }

        Banner::create($data);

        return redirect()->route('admin.home_banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.home.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/offer'), $imageName);
            $data['image'] = 'assets/img/offer/' . $imageName;
        }

        $banner->update($data);

        return redirect()->route('admin.home_banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.home_banners.index')->with('success', 'Banner deleted successfully.');
    }
}
