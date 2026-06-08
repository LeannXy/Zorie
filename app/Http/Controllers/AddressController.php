<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CustomerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');
        $customer = CustomerAccount::with('addresses')->find($customerId);
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $addresses = $customer->addresses;
        return view('pages.home.account.addresses', compact('customer', 'addresses'));
    }

    public function store(Request $request)
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return abort(401);
        }

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'postal_code' => 'required|string',
            'address' => 'required|string',
            'rajaongkir_city_id' => 'required',
        ]);

        // Jika ini alamat pertama, otomatis jadi default
        $isFirst = Address::where('customer_id', $customerId)->count() === 0;
        $isDefault = $isFirst || $request->has('is_default');

        if ($isDefault) {
            Address::where('customer_id', $customerId)->update(['is_default' => false]);
        }
//dd($request->all());
        Address::create([
            'customer_id' => $customerId,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'rajaongkir_city_id' => $request->rajaongkir_city_id,
            'is_default' => $isDefault,
        ]);

        return back()->with('success', 'Alamat berhasil ditambahkan');
    }

    public function update(Request $request, Address $address)
    {
        $customerId = session('customer_id');
        if (!$customerId || $address->customer_id != $customerId) {
            return abort(403);
        }

        $request->validate([
            'recipient_name' => 'required|string',
            'phone' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'postal_code' => 'required|string',
            'address' => 'required|string',
            'rajaongkir_city_id' => 'required',
        ]);

        $isDefault = $request->has('is_default');
        if ($isDefault) {
            Address::where('customer_id', $customerId)->update(['is_default' => false]);
        }

        $address->update(array_merge($request->all(), ['is_default' => $isDefault]));

        return back()->with('success', 'Alamat berhasil diperbarui');
    }

    public function setDefault(Address $address)
    {
        $customerId = session('customer_id');
        if (!$customerId || $address->customer_id != $customerId) {
            return abort(403);
        }

        Address::where('customer_id', $customerId)->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah');
    }

    public function destroy(Address $address)
    {
        $customerId = session('customer_id');
        if (!$customerId || $address->customer_id != $customerId) {
            return abort(403);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $next = Address::where('customer_id', $customerId)->first();
            if ($next) $next->update(['is_default' => true]);
        }

        return back()->with('success', 'Alamat berhasil dihapus');
    }


public function searchCity(Request $request)
{
    $search = $request->get('search', '');

    $response = Http::withHeaders([
        'key' => env('RAJAONGKIR_API_KEY')
    ])->get(
        'https://api.rajaongkir.com/starter/city',
        [
            'search' => $search,
        ]
    );

    return response()->json(
        $response->json()
    );
}



  
public function searchPostalCode(Request $request)
{
    $search = $request->get('postal_code', '');

    if (!$search) {
        return response()->json([
            'data' => []
        ]);
    }

    try {

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->get(
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination',
            [
                'search' => $search,
                'limit' => 20,
                'offset' => 0
            ]
        );

        $data = $response->json();

        return response()->json($data);

    } catch (\Exception $e) {

        return response()->json([
            'data' => [],
            'error' => $e->getMessage()
        ], 500);

    }
}


    }

