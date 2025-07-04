<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(StoreBannerRequest $request)
    {
        $validated = $request->validated();

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'image_path' => $imagePath,
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner baru berhasil diunggah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $validated = $request->validated();

        $imagePath = $banner->image_path;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image_path);

            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banner->update([
            'image_path' => $imagePath,
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image_path);

        $banner->delete();

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil dihapus.');
    }
}
