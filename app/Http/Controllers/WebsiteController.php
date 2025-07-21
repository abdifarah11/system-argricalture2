<?php  
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    // public function home()
    // {
    //     return view('website.home');
    // }
       public function home()
    {
        $crops = Crop::with(['cropType', 'user', 'region'])->latest()->take(12)->get();
        return view('website.home', compact('crops'));
    }
}
