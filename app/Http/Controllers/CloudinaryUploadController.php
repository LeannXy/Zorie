<?php

namespace App\Http\Controllers;

use App\Services\CloudinaryImageStorage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CloudinaryUploadController extends Controller
{
    public function signAdmin(Request $request, CloudinaryImageStorage $imageStorage)
    {
        $validated = $request->validate([
            'directory' => [
                'required',
                Rule::in(['products', 'categories', 'category-banners', 'profile-admin', 'profiles']),
            ],
        ]);

        return response()->json($imageStorage->signedUpload($validated['directory']));
    }

    public function signCustomer(CloudinaryImageStorage $imageStorage)
    {
        return response()->json($imageStorage->signedUpload('profiles'));
    }
}
