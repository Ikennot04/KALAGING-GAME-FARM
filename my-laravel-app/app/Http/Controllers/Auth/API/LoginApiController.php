<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Application\Admin\RegisterAdmin;
use App\Application\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkerModel;

class LoginApiController extends Controller
{
    private RegisterAdmin $registerAdmin;

    public function __construct(RegisterAdmin $registerAdmin)
    {
        $this->registerAdmin = $registerAdmin;
    }

   
    public function register(Request $request)
    {
        try {
            if ($request->input('role_id') == UserRole::ADMIN && 
                (!Auth::check() || Auth::user()->role_id !== UserRole::ADMIN)) {
                return response()->json(['error' => 'Unauthorized to create admin users'], 403);
            }

            $input = $request->all();
            $imageName = 'default-profile.jpg';

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $image->getClientOriginalName());
                Storage::disk('public')->putFileAs('images', $image, $imageName);
            }

            [$admin, $token] = $this->registerAdmin->create(
                $input['name'],
                $input['username'],
                $input['password'],
                $input['role_id'],
                $imageName
            );

            if ($input['role_id'] == UserRole::HANDLER) {
                $worker = new WorkerModel();
                $worker->setName($input['name']);
                $worker->setPosition('Handler');
                $worker->setImage($imageName);
                $worker->setUserId($admin->getId());
                $worker->save();
            }

            return response()->json([
                'message' => 'User successfully registered',
                'admin' => $admin->toArray(),
                'token' => $token,
                'token_type' => 'Bearer'
            ], 201);
        } catch (\Exception $e) {
            if (isset($imageName) && $imageName !== 'default-profile.jpg') {
                Storage::disk('public')->delete('images/' . $imageName);
            }
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            [$admin, $token] = $this->registerAdmin->login($request->username, $request->password);
            
            return response()->json([
                'status' => 'success',
                'token' => $token,
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
