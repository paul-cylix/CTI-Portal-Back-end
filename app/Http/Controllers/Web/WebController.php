<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class WebController extends Controller
{
    public function resetPassword(Request $request){
        // Request Validate
        $request->validate([
            'email'=>'required'
        ]);

        // Check if user exist
        $result = User::where('email', $request->email)->exists();

        // If exist update the password to Letmein2022
        if (filter_var($result, FILTER_VALIDATE_BOOLEAN)) {
            User::where('email', $request->email)->update(['password' => Hash::make('Letmein2022')]);
        }

        return back()->with('response', $result);
    }
}
