<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.home.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.home.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'icon' => 'nullable|string'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/hero'), $imageName);
            $data['image'] = 'assets/img/hero/' . $imageName;
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.home.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'icon' => 'nullable|string'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if needed (optional)
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img/hero'), $imageName);
            $data['image'] = 'assets/img/hero/' . $imageName;
        }

        $service->update($data);

        return redirect()->route('admin.home_services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.home_services.index')->with('success', 'Service deleted successfully.');
    }
}
