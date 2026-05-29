<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccount;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $customer = CustomerAccount::firstOrCreate(
            [
                'email' => $googleUser->email
            ],
            [
                'name' => $googleUser->name,
                'profile_photo' => $googleUser->avatar,
                'status' => true,
            ]
        );

        session([
            'customer_id' => $customer->id
        ]);

        return redirect('/');
    }
}