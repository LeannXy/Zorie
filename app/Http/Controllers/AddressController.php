<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CustomerAccount;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $customer = CustomerAccount::find(
            session('customer_id')
        );

        if (!$customer) {
            return redirect()
                ->route('customer.login');
        }

        $request->validate([
            'recipient_name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
            'google_maps_url' => 'nullable|url'
        ]);

        Address::create([
            'customer_id' => $customer->id,

            'recipient_name' =>
            $request->recipient_name,

            'phone' =>
            $request->phone,

            'province' =>
            $request->province,

            'city' =>
            $request->city,

            'district' =>
            $request->district,

            'postal_code' =>
            $request->postal_code,

            'address' =>
            $request->address,

            'google_maps_url' =>
            $request->google_maps_url,

            'is_default' =>
            Address::where(
                'customer_id',
                $customer->id
            )->count() == 0
        ]);

        return back()->with(
            'success',
            'Alamat berhasil ditambahkan'
        );
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return back()->with(
            'success',
            'Alamat berhasil dihapus'
        );
    }

    public function setDefault(Address $address)
    {
        Address::where(
            'customer_id',
            $address->customer_id
        )->update([
            'is_default' => false
        ]);

        $address->update([
            'is_default' => true
        ]);

        return back()->with(
            'success',
            'Alamat utama diperbarui'
        );
    }

    public function update(Request $request, Address $address)
    {
        $request->validate([

            'recipient_name' => 'required',

            'phone' => 'required',

            'province' => 'required',

            'city' => 'required',

            'district' => 'required',

            'postal_code' => 'required',

            'address' => 'required',

            'google_maps_url' => 'nullable|url'

        ]);

        $address->update([

            'recipient_name' => $request->recipient_name,

            'phone' => $request->phone,

            'province' => $request->province,

            'city' => $request->city,

            'district' => $request->district,

            'postal_code' => $request->postal_code,

            'address' => $request->address,

            'google_maps_url' => $request->google_maps_url

        ]);

        return back()->with(
            'success',
            'Alamat berhasil diperbarui'
        );
    }
}
