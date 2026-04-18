<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        $settings = \App\Models\PageSetting::getPage('rooms');
        return view('admin.page.rooms.index', compact('rooms', 'settings'));
    }

    public function create()
    {
        return view('admin.page.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'room_type' => 'required',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'capacity_adults' => 'nullable|integer',
            'capacity_children' => 'nullable|integer',
            'capacity_infants' => 'nullable|integer',
            'capacity_pets' => 'nullable|integer',
            'bed_type' => 'nullable|string',
            'room_size' => 'nullable|string',
            'view_type' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'panorama_url' => 'nullable|url',
            'badge_text' => 'nullable|string',
            'rating' => 'nullable|numeric|between:0,5',
            'review_count' => 'nullable|integer',
            'amenities' => 'nullable|array',
            'rules' => 'nullable|array',
            'faqs' => 'nullable|array',
            'attributes' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'partial_payments' => 'nullable|array',
        ]);

        $data = $request->except(['image_file', 'gallery_images', 'faqs', 'amenities', 'attributes', 'partial_payments']);
        
        $data['partial_payments'] = array_values(array_filter($request->input('partial_payments', []), 'strlen'));
        
        $data['is_360_available'] = $request->has('is_360_available');
        $data['is_featured'] = $request->has('is_featured');
        $data['rating'] = $request->rating ?? 0;
        $data['review_count'] = $request->review_count ?? 0;
        $data['rules'] = array_filter($request->input('rules', []), 'strlen');

        $amenities = [];
        if ($request->has('amenities')) {
            foreach ($request->input('amenities') as $amenity) {
                if (!empty($amenity['text'])) {
                    $amenities[] = ['icon' => $amenity['icon'] ?? 'bi-check-circle', 'text' => $amenity['text']];
                }
            }
        }
        $data['amenities'] = $amenities;

        $attributes = [];
        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attr) {
                if (!empty($attr['key']) && !empty($attr['value'])) {
                    $attributes[] = ['key' => $attr['key'], 'value' => $attr['value']];
                }
            }
        }
        $data['attributes'] = $attributes;

        $faqs = [];
        if ($request->has('faqs')) {
            foreach ($request->input('faqs') as $faq) {
                if (!empty($faq['question'])) {
                    $faqs[] = $faq;
                }
            }
        }
        $data['faqs'] = $faqs;

        if ($request->hasFile('image_file')) {
            $imageName = time().'.'.$request->image_file->extension();
            $request->image_file->move(public_path('assets/img/rooms'), $imageName);
            $data['image'] = 'assets/img/rooms/'.$imageName;
        }

        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('assets/img/rooms/gallery'), $name);
                $galleryImages[] = 'assets/img/rooms/gallery/' . $name;
            }
        }
        $data['gallery_images'] = $galleryImages;

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        return view('admin.page.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required',
            'room_type' => 'required',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'capacity_adults' => 'nullable|integer',
            'capacity_children' => 'nullable|integer',
            'capacity_infants' => 'nullable|integer',
            'capacity_pets' => 'nullable|integer',
            'bed_type' => 'nullable|string',
            'room_size' => 'nullable|string',
            'view_type' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'panorama_url' => 'nullable|url',
            'badge_text' => 'nullable|string',
            'rating' => 'nullable|numeric|between:0,5',
            'review_count' => 'nullable|integer',
            'amenities' => 'nullable|array',
            'rules' => 'nullable|array',
            'faqs' => 'nullable|array',
            'attributes' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'partial_payments' => 'nullable|array',
        ]);

        $data = $request->except(['image_file', 'gallery_images', 'faqs', 'amenities', 'attributes', 'delete_gallery_images', 'partial_payments']);

        $data['partial_payments'] = array_values(array_filter($request->input('partial_payments', []), 'strlen'));

        $data['is_360_available'] = $request->has('is_360_available');
        $data['is_featured'] = $request->has('is_featured');
        $data['rating'] = $request->rating ?? 0;
        $data['review_count'] = $request->review_count ?? 0;
        $data['rules'] = array_filter($request->input('rules', []), 'strlen');

        $amenities = [];
        if ($request->has('amenities')) {
            foreach ($request->input('amenities') as $amenity) {
                if (!empty($amenity['text'])) {
                    $amenities[] = ['icon' => $amenity['icon'] ?? 'bi-check-circle', 'text' => $amenity['text']];
                }
            }
        }
        $data['amenities'] = $amenities;

        $attributes = [];
        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attr) {
                if (!empty($attr['key']) && !empty($attr['value'])) {
                    $attributes[] = ['key' => $attr['key'], 'value' => $attr['value']];
                }
            }
        }
        $data['attributes'] = $attributes;

        $faqs = [];
        if ($request->has('faqs')) {
            foreach ($request->input('faqs') as $faq) {
                if (!empty($faq['question'])) {
                    $faqs[] = $faq;
                }
            }
        }
        $data['faqs'] = $faqs;

        if ($request->hasFile('image_file')) {
            $imageName = time().'.'.$request->image_file->extension();
            $request->image_file->move(public_path('assets/img/rooms'), $imageName);
            $data['image'] = 'assets/img/rooms/'.$imageName;
        }

        $galleryImages = is_array($room->gallery_images) ? $room->gallery_images : [];
        
        // Remove individual images
        if ($request->has('delete_gallery_images')) {
            $toDelete = $request->input('delete_gallery_images');
            $galleryImages = array_values(array_filter($galleryImages, function($img) use ($toDelete) {
                return !in_array($img, $toDelete);
            }));
        }

        // Clear all images
        if ($request->has('clear_gallery_images')) {
            $galleryImages = [];
        }

        // Add new images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('assets/img/rooms/gallery'), $name);
                $galleryImages[] = 'assets/img/rooms/gallery/' . $name;
            }
        }

        $data['gallery_images'] = $galleryImages;

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
