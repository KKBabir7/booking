<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageSettingController extends Controller
{
    /**
     * Show edit form for a specific page.
     */
    public function edit(string $page)
    {
        $dbPage = $page === 'room' ? 'rooms' : $page;
        $settings = PageSetting::getPage($dbPage);
        
        $restaurants = [];
        if ($page === 'restaurant') {
            $restaurants = \App\Models\Restaurant::all();
        }
        
        $viewMap = [
            'home_restaurant' => 'admin.home.restaurant',
            'home_conference' => 'admin.home.conference',
            'about' => 'admin.page.about.index',
            'faq' => 'admin.page.faq.index',
            'privacy_policy' => 'admin.page.privacy.index',
            'terms_of_service' => 'admin.page.terms.index',
        ];
        
        $viewName = $viewMap[$page] ?? "admin.page.{$page}.index";
        
        return view($viewName, compact('settings', 'restaurants'));
    }

    /**
     * Save settings for a specific page.
     */
    public function update(Request $request, string $page)
    {
        $data = $request->except(['_token', '_method']);
        $dbPage = $page === 'room' ? 'rooms' : $page;

        // Handle generic dynamic image uploads (top-level)
        foreach ($request->allFiles() as $key => $file) {
            if ($file instanceof \Illuminate\Http\UploadedFile) {
                if ($file->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $file->extension();
                    $file->move(public_path('assets/img/page_banners'), $imageName);
                    $path = 'assets/img/page_banners/' . $imageName;
                    
                    $dbKey = str_ends_with($key, '_file') ? substr($key, 0, -5) : $key;
                    $data[$dbKey] = $path;
                }
            } elseif (is_array($file)) {
                // Handle nested file arrays generically
                // e.g., cuisines_file[0][image] -> data[cuisines][0][image]
                $baseKey = str_replace('_file', '', $key);
                foreach ($file as $idx => $fileData) {
                    if (is_array($fileData)) {
                        foreach ($fileData as $subKey => $uploadFile) {
                            if ($uploadFile instanceof \Illuminate\Http\UploadedFile && $uploadFile->isValid()) {
                                $folder = ($page === 'restaurant' || $page === 'conference') ? $page : 'page_banners';
                                $imageName = time() . '_' . uniqid() . '.' . $uploadFile->extension();
                                $uploadFile->move(public_path("assets/img/{$folder}"), $imageName);
                                $path = "assets/img/{$folder}/" . $imageName;
                                
                                if (!isset($data[$baseKey][$idx])) {
                                    $data[$baseKey][$idx] = [];
                                }
                                $data[$baseKey][$idx][$subKey] = $path;
                            }
                        }
                    }
                }
            }
        }

        // Final cleanup and persistence
        foreach ($data as $key => $value) {
            // Remove any remaining '_file' keys (they are for uploads only)
            if (str_ends_with($key, '_file')) {
                continue;
            }

            if (is_array($value)) {
                // Re-index to ensure sequential keys (prevents 'new card' overwrites in frontend)
                $value = array_values($value);
                $value = json_encode($value);
            }
            
            PageSetting::set($dbPage, $key, $value);
        }

        return redirect()->back()->with('success', 'Page settings saved successfully!');
    }
}
