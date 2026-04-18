<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavbarItem;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function index()
    {
        $items = NavbarItem::orderBy('order_column')->get();
        return view('admin.navbar.index', compact('items'));
    }

    public function create()
    {
        return view('admin.navbar.create');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'navbar_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('navbar_logo')) {
            $imageName = 'logo-' . time() . '.' . $request->navbar_logo->extension();
            $request->navbar_logo->move(public_path('assets/img/logo'), $imageName);
            $path = 'assets/img/logo/' . $imageName;
            \App\Models\PageSetting::set('navbar', 'navbar_logo', $path);
            return redirect()->back()->with('success', 'Navbar logo updated successfully.');
        }

        return redirect()->back()->with('error', 'Failed to update logo.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required',
            'url' => 'required',
            'position' => 'required|in:top,dropdown',
        ]);

        NavbarItem::create($request->all());
        return redirect()->route('admin.navbar.index')->with('success', 'Navbar item created.');
    }

    public function edit(NavbarItem $navbar)
    {
        return view('admin.navbar.edit', ['item' => $navbar]);
    }

    public function update(Request $request, NavbarItem $navbar)
    {
        $request->validate([
            'label' => 'required',
            'url' => 'required',
            'position' => 'required|in:top,dropdown',
        ]);

        $navbar->update($request->all());
        return redirect()->route('admin.navbar.index')->with('success', 'Navbar item updated.');
    }

    public function destroy(NavbarItem $navbar)
    {
        $navbar->delete();
        return redirect()->route('admin.navbar.index')->with('success', 'Navbar item deleted.');
    }
}
