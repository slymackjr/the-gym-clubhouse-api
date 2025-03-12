<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    /**
     * Display a listing of all discounts.
     */
    public function allDiscounts()
    {
        $discounts = Discount::all();
        return response()->json([
            'success' => true,
            'message' => 'Discounts retrieved successfully',
            'data' => $discounts
        ]);
    }
    public function allActiveDiscounts()
{
    $discounts = Discount::where('active', true)->get();
    return response()->json([
        'success' => true,
        'message' => 'Active discounts retrieved successfully',
        'data' => $discounts
    ]);
}

    /**
     * Display a specific discount by ID.
     */
    public function discount(int $id)
    {
        $discount = Discount::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Discount retrieved successfully',
            'data' => $discount
        ]);
    }

    /**
     * Store a new discount.
     */
    public function addDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:discounts',
            'percentage' => 'required|numeric|min:0|max:100',
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $discount = Discount::create($request->only('name', 'percentage','active'));

        return response()->json([
            'success' => true,
            'message' => 'Discount created successfully',
            'data' => $discount
        ]);
    }

    /**
     * Update an existing discount by ID.
     */
    public function updateDiscount(Request $request, int $id)
    {
        $discount = Discount::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'string|unique:discounts,name,' . $id,
            'percentage' => 'numeric|min:0|max:100',
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $discount->update($request->only('name', 'percentage', 'active'));

        return response()->json([
            'success' => true,
            'message' => 'Discount updated successfully',
            'data' => $discount
        ]);
    }

    /**
     * Delete a discount by ID.
     */
    public function deleteDiscount(int $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return response()->json([
            'success' => true,
            'message' => 'Discount deleted successfully'
        ]);
    }

    public function calculateDiscount(Request $request)
    {
        $packageId = $request->input('packageId');
        $discountId = $request->input('discountId');

        $package = Package::find($packageId);
        $discount = Discount::find($discountId);

        if (!$package) {
            return response()->json(['error' => 'Invalid package ID'], 404);
        }

        $priceUSD = $package->priceUSD;
        $priceTZS = $package->priceTZS;

        $discountPercentage = $discount ? $discount->percentage : 0;
        $discountFactor = 1 - $discountPercentage / 100;

        $totalPriceUSD = $priceUSD * $discountFactor;
        $totalPriceTZS = $priceTZS * $discountFactor;

        return response()->json([
            'totalPriceUSD' => $totalPriceUSD,
            'totalPriceTZS' => $totalPriceTZS,
        ]);
    }

    /**
 * Toggle the active status of a discount by ID.
 */
public function toggleActiveStatus(int $id)
{
    $discount = Discount::findOrFail($id);
    $discount->active = !$discount->active; 
    $discount->save();

    return response()->json([
        'success' => true,
        'message' => 'Discount status updated successfully',
        'data' => $discount
    ]);
}

}
