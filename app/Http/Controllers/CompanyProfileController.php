<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyProfileController extends Controller
{

    public function show()
{
    $profile = CompanyProfile::first();
    if ($profile) {
        if ($profile->logo) {
            $profile->logo = asset("storage/$profile->logo");
        }
        return response()->json([
            'success' => true,
            'message' => 'Company profile retrieved successfully',
            'data' => $profile,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No company profile found',
        ]);
    }
}

public function updateOrCreate(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            'company_name' => 'required|string',
            'company_email' => 'required|email',
            'tin' => 'nullable|string',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'website' => 'nullable|url',
            'founder' => 'nullable|string',
            'manager' => 'nullable|string',
            'account_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'logo' => 'nullable|image',
        ]);

        if($validatedData->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validatedData->errors()
                ], );
        }   

        $validatedData = $validatedData->validated();
        $profile = CompanyProfile::first();

        if ($request->hasFile('logo')) {
            if ($profile && $profile->logo && Storage::exists($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }

            $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $profile = $profile->fill($validatedData);
        $profile->save();

        if ($profile->logo) {
            $profile->logo = Storage::url($profile->logo);
        }

        return response()->json([
            'success' => true,
            'message' => 'Company profile updated successfully',
            'data' => $profile,
        ]);
    }


    public function deleteProfile()
    {
        $profile = CompanyProfile::first();

        if ($profile) {
            if ($profile->logo) {
                Storage::delete($profile->logo);
            }

            $success = $profile->delete();

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Company profile deleted successfully',
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete company profile',
        ]);
    }

    private function validateImage($image)
{
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $minWidth = 300;

    $imageMimeType = $image->getMimeType();
    $imageSize = getimagesize($image);

    if (!in_array($imageMimeType, $allowedMimeTypes)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid file type, Only JPEG, PNG, JPG, and GIF images are allowed.',
        ], );
    }

    if ($imageSize[0] > $minWidth) {
        return response()->json([
            'success' => false,
            'message' => "Invalid image dimensions, Image width must be greater {$minWidth} pixels.",
        ], );
    }

    return null; 
}

}
