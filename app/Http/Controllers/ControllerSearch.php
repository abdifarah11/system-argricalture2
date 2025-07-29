<?php    
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ControllerSearch extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return view('products.search_results', compact('products', 'query'));
    }
}
