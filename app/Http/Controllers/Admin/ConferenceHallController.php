<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConferenceHall;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class ConferenceHallController extends Controller
{
    public function index()
    {
        $halls = ConferenceHall::latest()->paginate(10);
        $settings = PageSetting::getPage('conference');
        return view('admin.page.conference.index', compact('halls', 'settings'));
    }

    public function create()
    {
        return view('admin.page.conference.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'nullable|integer',
            'price' => 'nullable|numeric|min:0',
            'badge_text' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'panorama_url' => 'nullable|url',
            'partial_payments' => 'nullable|array',
            'service_charge' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except(['image_file', 'status', 'partial_payments']);
        $data['partial_payments'] = array_values(array_filter($request->input('partial_payments', []), 'strlen'));
        $data['status'] = $request->input('status') == '1';

        if ($request->hasFile('image_file')) {
            $imageName = time() . '.' . $request->image_file->extension();
            $request->image_file->move(public_path('assets/img/conference'), $imageName);
            $data['image'] = 'assets/img/conference/' . $imageName;
        }

        ConferenceHall::create($data);

        return redirect()->route('admin.conference.index')->with('success', 'Conference Hall created successfully.');
    }

    public function edit(ConferenceHall $conference_hall)
    {
        return view('admin.page.conference.edit', compact('conference_hall'));
    }

    public function update(Request $request, ConferenceHall $conference_hall)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'nullable|integer',
            'price' => 'nullable|numeric|min:0',
            'badge_text' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'panorama_url' => 'nullable|url',
            'partial_payments' => 'nullable|array',
            'service_charge' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except(['image_file', 'status', 'partial_payments']);
        $data['partial_payments'] = array_values(array_filter($request->input('partial_payments', []), 'strlen'));
        $data['status'] = $request->input('status') == '1';

        if ($request->hasFile('image_file')) {
            $imageName = time() . '.' . $request->image_file->extension();
            $request->image_file->move(public_path('assets/img/conference'), $imageName);
            $data['image'] = 'assets/img/conference/' . $imageName;
        }

        $conference_hall->update($data);

        return redirect()->route('admin.conference.index')->with('success', 'Conference Hall updated successfully.');
    }

    public function destroy(ConferenceHall $conference_hall)
    {
        $conference_hall->delete();
        return redirect()->route('admin.conference.index')->with('success', 'Conference Hall deleted successfully.');
    }

    public function toggleStatus(ConferenceHall $conference_hall)
    {
        $conference_hall->update(['status' => !$conference_hall->status]);
        return back()->with('success', 'Status toggled successfully.');
    }
}
