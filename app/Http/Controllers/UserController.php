<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('read-create-update-delete-user');
        return User::all();
    }

    public function get_user(string $id)
    {
        $this->authorize('read-create-update-delete-user');

        if($user = User::find($id)) {
            return $user;
        } else {
            return response()->json([
                'message' => 'user not found',
            ]);
        }
    }

    public function register(Request $request)
    {
        $this->authorize('read-create-update-delete-user');
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'role_id' => 'required|string',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password'
        ]);

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
        ]);

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
            ], 201);

        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    public function update(Request $request, string $id)
    {
        $this->authorize('read-create-update-delete-user');
        $data = $request->validate([
            'name' => 'string',
            'username' => 'string',
            'role_id' => 'string',
        ]);

        $user = User::find($id);

        if($user) {
            $user->update($data);
            return response()->json([
                'message' => 'successfully updated',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }

    }

    public function soft_delete(string $id)
    {
        $this->authorize('read-create-update-delete-user');
        $user = User::find($id);
        if($user) {
            $user->delete();
            return response()->json([
                'message' => 'successfully soft deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }
    }

    public function delete(string $id)
    {
        $this->authorize('read-create-update-delete-user');
        $user = User::find($id);
        if($user) {
            $user->forceDelete();
            return response()->json([
                'message' => 'successfully deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }
    }

    public function check_user(string $id)
    {
        $this->authorize('read-create-update-delete-user');
        if(User::find($id)) {
            $message = 'user available';
        } else if(User::withTrashed()->find($id)) {
            $message = 'user in trash';
        } else {
            $message = 'user in not found';
        }

        return response()->json([
            'message' => $message
        ]);
    }
}
