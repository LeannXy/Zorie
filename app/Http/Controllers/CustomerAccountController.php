<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccount;
use App\Models\Order;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailOtpMail;
use App\Mail\OtpMail;

class CustomerAccountController extends Controller
{
    public function dashboard()
    {
        $customer = CustomerAccount::find(
            session('customer_id')
        );

        if (!$customer) {
            return redirect()
                ->route('customer.login');
        }

        $totalOrders = Order::where(
            'customer_id',
            $customer->id
        )->count();

        $totalReviews = Testimonial::where(
            'customer_id',
            $customer->id
        )->count();

        $orders = Order::where(
            'customer_id',
            $customer->id
        );

        $addresses = $customer
            ->addresses()
            ->latest()
            ->get();

        $profileCompletion = 0;

        if ($customer->name) $profileCompletion += 25;
        if ($customer->email_verified) $profileCompletion += 25;
        if ($customer->phone) $profileCompletion += 25;
        if ($addresses->count() > 0) $profileCompletion += 25;
        return view(
            'pages.home.customersAccount',
            compact(
                'customer',
                'totalOrders',
                'totalReviews',
                'orders',
                'addresses',
                'profileCompletion'
            )
        );
    }

    public function updateProfile(Request $request)
    {
        $customer = CustomerAccount::find(
            session('customer_id')
        );

        if (!$customer) {

            return redirect()
                ->route('customer.login');
        }

        $request->validate([

            'name' => 'required|max:255',

            'phone' => 'nullable|max:20',

            'address' => 'nullable',

            'gender' => 'nullable',

            'date_of_birth' => 'nullable|date',

            'profile_photo' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'

        ]);

        if ($request->hasFile('profile_photo')) {

            $path = $request
                ->file('profile_photo')
                ->store(
                    'profiles',
                    'public'
                );

            $customer->profile_photo = $path;
        }
        $customer->name = $request->name;

        $customer->phone = $request->phone;

        $customer->address = $request->address;

        $customer->gender = $request->gender;

        $customer->date_of_birth =
            $request->date_of_birth;

        $customer->save();

        return back()
            ->with(
                'success',
                'Profil berhasil diperbarui'
            )
            ->with(
                'active_tab',
                'profile'
            );
    }

    public function changePassword(Request $request)
    {
        $customer = CustomerAccount::find(
            session('customer_id')
        );

        if (!$customer) {
            return redirect()
                ->route('customer.login');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        if (
            !Hash::check(
                $request->current_password,
                $customer->password
            )
        ) {
            return back()
                ->withErrors([
                    'current_password' =>
                    'Password saat ini salah'
                ])
                ->with(
                    'active_tab',
                    'security'
                );
        }

        $customer->password =
            Hash::make(
                $request->new_password
            );

        $customer->save();

        session()->forget('customer_id');

        return redirect()
            ->route('customer.login')
            ->with(
                'success',
                'Password berhasil diubah. Silakan login kembali.'
            );
    }

    public function sendOldEmailOtp(Request $request)
    {
        $request->validate([
            'new_email' =>
            'required|email|unique:customer_accounts,email'
        ]);

        $customer = CustomerAccount::find(
            session('customer_id')
        );

        $otp = rand(100000, 999999);

        $customer->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        Mail::to($customer->email)
            ->send(
                new VerifyEmailOtpMail($otp)
            );

        session([
            'new_email' => $request->new_email,
            'change_email_step' => 1
        ]);

        return back();
    }

    public function verifyOldEmailOtp(Request $request)
    {
        $customer = CustomerAccount::find(
            session('customer_id')
        );

        if (!$customer) {
            return back();
        }

        if (
            $customer->otp_code != $request->otp
        ) {
            return back()->withErrors([
                'otp' => 'OTP salah'
            ]);
        }

        if (
            now()->gt(
                $customer->otp_expires_at
            )
        ) {
            return back()->withErrors([
                'otp' => 'OTP expired'
            ]);
        }

        session([
            'change_email_step' => 2
        ]);

        return back()->with(
            'success',
            'Email lama berhasil diverifikasi'
        );
    }

    public function sendNewEmailOtp()
    {
        $customer = CustomerAccount::find(
            session('customer_id')
        );

        $otp = rand(100000, 999999);

        $customer->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        Mail::to(
            session('new_email')
        )->send(
            new VerifyEmailOtpMail($otp)
        );

        session([
            'change_email_step' => 3
        ]);

        return back()->with(
            'success',
            'OTP dikirim ke email baru'
        );
    }

    public function verifyNewEmailOtp(Request $request)
    {
        $customer = CustomerAccount::find(
            session('customer_id')
        );

        if (
            $customer->otp_code != $request->otp
        ) {
            return back()->withErrors([
                'otp' => 'OTP salah'
            ]);
        }

        if (
            now()->gt(
                $customer->otp_expires_at
            )
        ) {
            return back()->withErrors([
                'otp' => 'OTP expired'
            ]);
        }

        $customer->update([

            'email' => session('new_email'),

            'email_verified' => true,

            'otp_code' => null,

            'otp_expires_at' => null

        ]);

        session()->forget([

            'new_email',

            'change_email_step'

        ]);

        return back()->with(
            'success',
            'Email berhasil diganti'
        );
    }
}
