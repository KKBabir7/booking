<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    public function index()
    {
        $favicon = Setting::first();
        $seoMetas = SeoMeta::orderBy('page_name')->get();
        return view('admin.seo.index', compact('favicon', 'seoMetas'));
    }

    public function updateFavicon(Request $request)
    {
        $request->validate([
            'site_favicon' => 'required|image|mimes:ico,png,jpg,jpeg,svg|max:512',
        ]);

        $setting = Setting::first() ?: new Setting();

        if ($request->hasFile('site_favicon')) {
            // Delete old favicon if exists
            if ($setting->site_favicon && File::exists(public_path($setting->site_favicon))) {
                File::delete(public_path($setting->site_favicon));
            }

            $imageName = 'favicon-' . time() . '.' . $request->site_favicon->extension();
            $request->site_favicon->move(public_path('assets/img/logo'), $imageName);
            $setting->site_favicon = 'assets/img/logo/' . $imageName;
            $setting->save();
        }

        return redirect()->back()->with('success', 'Favicon updated successfully.');
    }

    public function deleteFavicon()
    {
        $setting = Setting::first();
        if ($setting && $setting->site_favicon) {
            if (File::exists(public_path($setting->site_favicon))) {
                File::delete(public_path($setting->site_favicon));
            }
            $setting->site_favicon = null;
            $setting->save();
        }
        return redirect()->back()->with('success', 'Favicon deleted successfully.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page_name' => 'required|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:seo_metas,slug',
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'robots_index' => 'required|in:index,noindex',
            'robots_follow' => 'required|in:follow,nofollow',
        ]);

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadImage($request->file('og_image'), 'og');
        }

        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $this->uploadImage($request->file('twitter_image'), 'twitter');
        }

        SeoMeta::create($data);

        return redirect()->back()->with('success', 'SEO record created successfully.');
    }

    public function update(Request $request, SeoMeta $seo_meta)
    {
        $data = $request->validate([
            'page_name' => 'required|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:seo_metas,slug,' . $seo_meta->id,
            'canonical_url' => 'nullable|url|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'robots_index' => 'required|in:index,noindex',
            'robots_follow' => 'required|in:follow,nofollow',
        ]);

        if ($request->hasFile('og_image')) {
            // Delete old image
            if ($seo_meta->og_image && File::exists(public_path($seo_meta->og_image))) {
                File::delete(public_path($seo_meta->og_image));
            }
            $data['og_image'] = $this->uploadImage($request->file('og_image'), 'og');
        }

        if ($request->hasFile('twitter_image')) {
            // Delete old image
            if ($seo_meta->twitter_image && File::exists(public_path($seo_meta->twitter_image))) {
                File::delete(public_path($seo_meta->twitter_image));
            }
            $data['twitter_image'] = $this->uploadImage($request->file('twitter_image'), 'twitter');
        }

        $seo_meta->update($data);

        return redirect()->back()->with('success', 'SEO record updated successfully.');
    }

    public function destroy(SeoMeta $seo_meta)
    {
        // Delete images
        if ($seo_meta->og_image && File::exists(public_path($seo_meta->og_image))) {
            File::delete(public_path($seo_meta->og_image));
        }
        if ($seo_meta->twitter_image && File::exists(public_path($seo_meta->twitter_image))) {
            File::delete(public_path($seo_meta->twitter_image));
        }

        $seo_meta->delete();

        return redirect()->back()->with('success', 'SEO record deleted successfully.');
    }

    private function uploadImage($file, $type)
    {
        $imageName = $type . '-' . time() . '-' . Str::random(10) . '.' . $file->extension();
        $file->move(public_path('assets/img/seo'), $imageName);
        return 'assets/img/seo/' . $imageName;
    }
}
