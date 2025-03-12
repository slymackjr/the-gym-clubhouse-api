<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function allUsers(){
        $users = User::all();
        if($users){
            return response()->json([
                'success' => true,
                'message' => 'Users retrieved successfully',
                'data' => $users
            ], );

        }else{
            return response()->json([
                'success' => false,
                'message' => 'No users found'
            ], );
        }
    }

    public function user(int $id){
        $user = User::findOrFail($id);
        if($user){
            return response()->json([
                'success' => true,
                'message' => 'User retrieved successfully',
                'data' => $user
                ], );
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
                ], );
        }
    }

    public function addUser(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
            'phone_number' => 'required|string|unique:users'
            ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validate->errors()
                ], );
        }    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'password' => Hash::make("fitness")
        ]);

        if($user){
         
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
                ], );
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user'
                ], );
        }
    }

    public function updateUser(Request $request,int $id){
        $user = User::findOrFail($id);
        $validate = validator::make($request->all(),[
            'name' => "string|unique:users,name,$id", 
            'email' => "email|unique:users,email,$id",
            'role' => 'string',
            'phone_number' => "string|unique:users,phone_number,$id"
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validate->errors()
                ], );
        }

        $user->fill($request->only([
            'name',
            'email',
            'role',
            'phone_number'
        ]));

        $success = $user->save();

        if($success){
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
                ], );
        }else {
            return response()->json([
                'success' => false,
                'message' => 'updated failed'
            ],);    
        }
    }

    public function deleteUser(int $id){
        $user = User::findOrFail($id);
        $success = $user->delete();
        if($success){
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
                ], );
                }else {
                    return response()->json([
                        'success' => false,
                        'message' => 'delete failed'
                        ],);
                        }
    }

    public function login(Request $request){
        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Please fill your Email or Password',
                'errors' => $validate->errors(),
            ], );
        }

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials.',
        ], );
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials.',
        ], );
    }

    $token = $user->createToken('Authtoken', [$user->role])->plainTextToken;

    $user->makeHidden('password'); 

    return response()->json([
        'success' => true,
        'message' => 'Login successful.',
        'ability' => $user->role,
        'token' => $token,
        'user' => $user,
    ], );
    
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
        ], );
    }

    public function updatePassword(Request $request, int $id)
{
    $validate = Validator::make($request->all(), [
        'old_password' => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validate->errors(),
        ]);
    }

    $user = User::find($id);
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found',
        ]);
    }

    if (!Hash::check($request->old_password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Old password is incorrect',
        ]);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Password updated successfully',
    ]);
}

public function updateImage(Request $request, $id)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg',
    ]);

    $user = User::findOrFail($id);

    if ($user->image) {
        Storage::disk('public')->delete($user->image);
    }

    $path = $request->file('image')->store('profiles', 'public');
    $user->image = $path;
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Profile image updated successfully',
        'image_url' => Storage::url($path),
    ]);
}

public function getProfile($id)
{
    $user = User::findOrFail($id);
    return response()->json([
        'success' => true,
        'data' => [
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->profile_image ? asset("storage/$user->profile_image") : null,
        ],
    ]);
}

}
