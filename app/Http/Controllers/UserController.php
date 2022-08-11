<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function updateUser(Request $request)
    {
        $userAuth = auth('api')->user();
        if ($userAuth) {
            $user = User::find($userAuth->id);

            $user->update($request->all());

            return response()->json([
                'message' => 'User successfully Updated',
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized',
            ], 401);
        }
    }

    public function changePassword(request $request)
    {
        $userAuth = auth('api')->user();
        if ($userAuth) {
            $validator = Validator::make($request->all(), [
                'oldPassword' => 'required', 'newPassword' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $user = User::find($userAuth->id);
            $oldPassword = $request->oldPassword;

            $newPassword = $request->newPassword;
            if (!Hash::check($oldPassword, $user->password)) {
                return response()->json([
                    'message' => 'Old password is incorrect'
                ], 422);
            } else {
                if ($user) {
                    $user->update(['password' => bcrypt($newPassword)]);

                    return response()->json([
                        'message' => 'Password successfully Updated',
                        'user' => $user
                    ], 201);
                }
            }
        } else {
            return response()->json([
                'message' => 'unauthorized',
            ], 401);
        }
    }


    public function deleteUser(User $user)
    {
        //
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 1) {
            $user->delete();

            return response()->json([
                'message' => 'user deleted',
                'status_code' => 200,
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }

    public function getAllUserByRole(Request $request)
    {
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 1) {

            $users = User::paginate(10)->where("role", "=", $request->get('role'));
            if ($request->role == 1) {
                $type = "Admin";
            } else {
                if ($request->role == 2) {
                    $type = "Customer";
                } else {
                    $type = "Provider";
                }
            }
            return response()->json([
                'type' => $type,
                'users' => $users,

            ], 200);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }

    public function status(Request $request, User $user)
    {
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 1) {
            $user->update(array_merge(['enabled' => $request->get('enable')]));
            return response()->json([
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }
}
