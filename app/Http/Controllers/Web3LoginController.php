<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Web3LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.web3login');
    }

    public function verifySignature(Request $request)
    {
        $address = $request->address;
        $signature = $request->signature;
        $message = $request->message;

        // Use web3 API in frontend to sign + verify the message
        // Backend just trusts the frontend's verified address for now (or later verify on backend)

        if (!$address || !$signature) {
            return response()->json(['error' => 'Invalid data'], 400);
        }

        // Store authenticated user session (example only, you should match with registered users)
        Session::put('web3_address', $address);

        return response()->json(['message' => 'Logged in successfully', 'address' => $address]);
    }

    public function logout()
    {
        Session::forget('web3_address');
        return redirect()->route('web3.login');
    }
}
