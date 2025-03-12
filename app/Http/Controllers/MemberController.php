<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function allMembers()
    {
        $members = Member::all();
        return response()->json([
            'success' => $members->isNotEmpty(),
            'message' => $members->isNotEmpty() ? 'Members retrieved successfully' : 'No members found',
            'data' => $members
        ]);
    }
    public function totalMembers()
{
    $members = Member::all();
    $total = $members->count();

    return response()->json([
        'success' => true,
        'message' => $total > 0 ? 'Members retrieved successfully' : 'No members found',
        'data' => $total,
    ]);
}

    public function member(int $id)
    {
        $member = Member::find($id);

        if ($member) {
            return response()->json([
                'success' => true,
                'message' => 'Member retrieved successfully',
                'data' => $member
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }
    }

    public function addMember(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:members',
            'role' => 'required|string',
            'phone_number' => 'required|string|max:15|unique:members',
            'email' => 'nullable|email|unique:members',
            'gender' => 'required|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'memo' => 'nullable|string|max:500'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validate->errors()
            ]);
        }

        $member = Member::create($request->only([
            'name', 'role', 'phone_number', 'email', 'gender', 'height', 'weight','memo'
        ]));
        return response()->json([
            'success' => true,
            'message' => 'Member created successfully',
            'data' => $member
        ]);
    }

    public function updateMember(Request $request, int $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }

        $validate = Validator::make($request->all(), [
            'name' => "string|max:255|unique:members,name,$id",
            'role' => 'string',
            'phone_number' => "string|max:15|unique:members,phone_number,$id", 
            'email' => "email|unique:members,email,$id",
            'gender' => 'string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'memo' => 'nullable|string'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validate->errors()
            ]);
        }

        $member->fill($request->only([
            'name', 'role', 'phone_number', 'email', 'gender', 'height', 'weight','memo'
        ]));
        $success = $member->save();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Member updated successfully' : 'Failed to update member',
            'data' => $member
        ]);
    }

    public function deleteMember(int $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }

        $success = $member->delete();

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Member deleted successfully' : 'Failed to delete member'
        ]);
    }
}
