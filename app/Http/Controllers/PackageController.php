<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function allPackages()
    {
        $packages = Package::all();
        if ($packages) {
            return response()->json([
                'success' => true,
                'message' => 'Packages retrieved successfully',
                'data' => $packages
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No packages found'
            ]);
        }
    }
    public function totalPackages()
{
    $packages = Package::all();
    $total = $packages->count();

    return response()->json([
        'success' => true,
        'message' => $total > 0 ? 'Packages retrieved successfully' : 'No Packages found',
        'data' => $total,
    ]);
}

    public function package(int $id)
    {
        $package = Package::findOrFail($id);

        if ($package) {
            return response()->json([
                'success' => true,
                'message' => 'Package retrieved successfully',
                'data' => $package
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ]);
        }
    }

    public function addPackage(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:packages',
            'priceUSD' => 'required|numeric',
            'priceTZS' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validatedData->errors()
            ]);
        }

        $package = Package::create($request->only('name', 'priceUSD','priceTZS','duration'));

        if ($package) {
            return response()->json([
                'success' => true,
                'message' => 'Package created successfully',
                'data' => $package
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create package'
            ]);
        }
    }

    public function updatePackage(Request $request, int $id)
    {
        $package = Package::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => "required|string|max:255|unique:packages,name,$id",
            'priceUSD' => 'required|numeric',
            'priceTZS' => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $package->update($request->only('name', 'priceUSD','priceTZS','duration'));

        if ($package) {
            return response()->json([
                'success' => true,
                'message' => 'Package updated successfully',
                'data' => $package
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update package'
            ]);
        }
    }

    public function deletePackage(int $id)
    {
        $package = Package::findOrFail($id);
        $success = $package->delete();

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Package deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete package'
            ]);
        }
    }
}
