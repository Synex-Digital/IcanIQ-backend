<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Photo;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::all();
        return view('backend.banner.index', [
            'banners' => $banner
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpeg,png,jpg,webp'
        ]);

        Photo::upload($request->banner, 'files/banner', 'BANNER', [851, 315]);

        $banner = new Banner();
        $banner->banner = Photo::$name;
        $banner->save();

        return back()->with('succ', 'uploaded');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if ($banner) {
            Photo::delete('files/banner', $banner->banner);
            Banner::find($banner->id)->delete();
        }
        return back()->with('succ', 'item deleted');
    }
}
