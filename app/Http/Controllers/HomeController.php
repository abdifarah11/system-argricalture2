<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    //
//     public function index(Request $request)
// {
//     $regionId = $request->query('region_id');

//     $categories = Http::get("http://127.0.0.1:8000/api/ecommerce/categories", [
//         'region_id' => $regionId
//     ])->json()['categories'];

//     $regions = Region::all();

//     return view('website.home', compact('categories', 'regions'));
// }
public function index(Request $request)
{
    $regionId = $request->query('region_id');

    $categories = \App\Models\CropType::with(['crops.prices' => function ($query) use ($regionId) {
        if ($regionId) {
            $query->where('region_id', $regionId);
        }
    }])->get();

    $regions = \App\Models\Region::all();

    session()->put('test', 'THis is test session value');

    return view('website.home', compact('categories', 'regions'));
}

}
