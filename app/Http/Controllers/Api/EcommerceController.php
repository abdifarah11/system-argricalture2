<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CropType;
use App\Models\Region;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
//     //
//   public function index()
//     {
//         $categories = CropType::with([
//             'crops' => function ($query) {
//                 $query->select('id', 'name', 'description', 'image', 'crop_type_id')
//                     ->with(['prices' => function ($priceQuery) {
//                         $priceQuery->select('id', 'crop_id', 'region_id', 'price', 'unit', 'quantity', 'kg', 'litre');
//                     }]);
//             }
//         ])->get(['id', 'name', 'description', 'image']);

//         return response()->json([
//             'success' => true,
//             'categories' => $categories
//         ]);
//     }
//     public function index(Request $request)
// {
//     $regionId = $request->query('region_id');

//     $categories = CropType::with([
//         'crops' => function ($query) use ($regionId) {
//             $query->with(['prices' => function ($q) use ($regionId) {
//                 if ($regionId) {
//                     $q->where('region_id', $regionId);
//                 }
//             }]);
//         }
//     ])->get(['id', 'name', 'description', 'image']);

//     return response()->json([
//         'success' => true,
//         'categories' => $categories
//     ]);
// }
// public function index(Request $request)
// {
//     $cropTypeId = $request->query('crop_type'); // Get crop_type from query string

//     $query = CropType::with([
//         'crops' => function ($cropQuery) {
//             $cropQuery->select('id', 'name', 'description', 'image', 'crop_type_id')
//                 ->with(['prices' => function ($priceQuery) {
//                     $priceQuery->select('id', 'crop_id', 'region_id', 'price', 'unit', 'quantity', 'kg', 'litre');
//                 }]);
//         }
//     ])->select('id', 'name', 'description', 'image');

//     // Apply filter if crop_type ID is provided
//     if ($cropTypeId) {
//         $query->where('id', $cropTypeId);
//     }

//     $categories = $query->get();

//     return response()->json([
//         'success' => true,
//         'categories' => $categories
//     ]);
// }

public function index(Request $request)
{
    $cropTypeId = $request->query('crop_type'); // Optional
    $regionId = $request->query('region_id');   // Optional

    $query = CropType::with([
        'crops' => function ($cropQuery) use ($regionId) {
            $cropQuery->select('id', 'name', 'description', 'image', 'crop_type_id')
                ->with([
                    'prices' => function ($priceQuery) use ($regionId) {
                        $priceQuery->select('id', 'crop_id', 'region_id', 'price', 'unit', 'quantity', 'kg', 'litre')
                                   ->with('region:id,name');

                        // If region_id is provided and not 'all', filter it
                        if (!empty($regionId) && $regionId !== 'all') {
                            $priceQuery->where('region_id', $regionId);
                        }
                    }
                ]);
        }
    ])->select('id', 'name', 'description', 'image');

    // Filter by crop_type only if it's specified and not 'all'
    if (!empty($cropTypeId) && $cropTypeId !== 'all') {
        $query->where('id', $cropTypeId);
    }

    $categories = $query->get();

    // Always get all available regions for the frontend dropdown
    $regions = Region::select('id', 'name')->get();

    return response()->json([
        'success' => true,
        'categories' => $categories,
        'regions' => $regions
    ]);
}


}
