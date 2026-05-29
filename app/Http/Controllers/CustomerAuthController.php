<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class CustomerAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:customer_accounts,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $customer = CustomerAccount::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => null,
            'address' => null,
            'profile_photo' => null,
            'status' => true,
        ]);

        session([
            'customer_id' => $customer->id
        ]);

        return redirect('/')
            ->with('success', 'Account created successfully');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $customer = CustomerAccount::where(
            'email',
            $request->email
        )->first();

        if (
            !$customer ||
            !Hash::check(
                $request->password,
                $customer->password
            )
        ) {

            return back()
                ->withErrors([
                    'email' => 'Invalid email or password'
                ]);
        }

        session([
            'customer_id' => $customer->id
        ]);

        return redirect('/')
            ->with('success', 'Welcome back!');
    }

    public function logout()
    {
        session()->forget('customer_id');

        return redirect('/');
    }

    // public function sendResetLink(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email'
    //     ]);

    //     $customer = CustomerAccount::where(
    //         'email',
    //         $request->email
    //     )->first();

    //     if (!$customer) {

    //         return back()->withErrors([
    //             'email' => 'Email not found.'
    //         ]);
    //     }

    //     return back()->with(
    //         'status',
    //         'Password reset link sent successfully.'
    //     );
    // }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $customer = CustomerAccount::where(
            'email',
            $request->email
        )->first();

        if (!$customer) {

            return back()->withErrors([
                'email' => 'Email not found'
            ]);
        }

        $otp = rand(100000, 999999);

        $customer->update([

            'otp_code' => $otp,

            'otp_expires_at' => now()->addMinutes(10)

        ]);
        Mail::to($customer->email)
            ->send(new OtpMail($otp));

        session([
            'reset_email' => $request->email
        ]);

        return back()->with([
            'showOtpForm' => true
        ]);
    }

    public function verifyOtp(Request $request)
{
    $customer = CustomerAccount::where(
        'email',
        session('reset_email')
    )->first();

    if (!$customer) {

        return back()->withErrors([
            'email' => 'Email tidak ditemukan'
        ]);
    }

    if ($customer->otp_code != $request->otp) {

        return back()->withErrors([
            'otp' => 'OTP salah'
        ]);
    }

    if (now()->gt($customer->otp_expires_at)) {

        return back()->withErrors([
            'otp' => 'OTP expired'
        ]);
    }

    session([
        'showPasswordForm' => true
    ]);

    return back();
}

   public function resetPassword(Request $request)
{
    $request->validate([

        'password' => 'required|min:8|confirmed'

    ]);

    $customer = CustomerAccount::where(
        'email',
        session('reset_email')
    )->first();

    if (!$customer) {

        return back()->withErrors([
            'email' => 'Customer not found'
        ]);
    }

    $customer->update([

        'password' => Hash::make(
            $request->password
        ),

        'otp_code' => null,

        'otp_expires_at' => null

    ]);

    session()->forget([
        'showOtpForm',
        'showPasswordForm',
        'reset_email'
    ]);

    return redirect()
        ->route('customer.login')
        ->with(
            'success',
            'Password berhasil diubah, silakan login.'
        );
}
}
