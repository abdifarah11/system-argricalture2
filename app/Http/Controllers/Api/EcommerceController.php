<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CropType;
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
    public function index(Request $request)
{
    $regionId = $request->query('region_id');

    $categories = CropType::with([
        'crops' => function ($query) use ($regionId) {
            $query->with(['prices' => function ($q) use ($regionId) {
                if ($regionId) {
                    $q->where('region_id', $regionId);
                }
            }]);
        }
    ])->get(['id', 'name', 'description', 'image']);

    return response()->json([
        'success' => true,
        'categories' => $categories
    ]);
}

}
