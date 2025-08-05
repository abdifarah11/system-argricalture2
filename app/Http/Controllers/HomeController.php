<?php

namespace App\Http\Controllers;

use App\Models\CropType;
use App\Models\Region;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $regionId = $request->query('region_id');

        // Load crop types with crops and optionally filter prices by region
        $categories = CropType::with(['crops.prices' => function ($query) use ($regionId) {
            if (!empty($regionId)) {
                $query->where('region_id', $regionId);
            }
        }])->get();

        $regions = Region::all();

        // Set a test session value (for debugging or testing purposes)
        session()->put('test', 'This is a test session value');

        return view('website.home', compact('categories', 'regions'));
    }
}
