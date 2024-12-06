<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Application\Admin\RegisterAdmin;

class LoginApiController extends Controller
{
    private RegisterAdmin $registerAdmin;

    public function __construct(RegisterAdmin $registerAdmin)
    {
        $this->registerAdmin = $registerAdmin;
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try {
            $input = $request->all();
            $admin = $this->registerAdmin->create(
                $input['name'],
                $input['username'],
                $input['password']
            );

            return response()->json([
                'message' => 'Admin successfully registered',
                'admin' => $admin->toArray(),
                'token' => $admin->getApiToken(),
                'token_type' => 'Bearer'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $admin = $this->registerAdmin->login($request->username, $request->password);
            
            return response()->json([
                'status' => 'success',
                'token' => $admin->getApiToken(),
                'user' => $admin->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out from all devices successfully'
        ]);
    }
}
