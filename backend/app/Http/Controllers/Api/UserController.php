<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sale;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return User::all()->map(function($user) {
            $user->uid = Crypt::encryptString($user->id);
            return $user;
        });
    }

    public function store(UserRequest $request)
    {

        $user = $this->userService->createUser($request->all());

        return response()->json($user, 201);
    }

    public function show($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        
        $user = User::findOrFail($id);
        
        $user->uid = Crypt::encryptString($user->id);
        
        return response()->json($user);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $updatedUser = $this->userService->updateUser($user, $request->all());

        return response()->json($user, 200);
    }

    public function destroy($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        
        $user = User::findOrFail($id);
        
        $this->userService->deleteUser($user);

        return response()->json(null, 204);
    }

    public function getSalesByUser($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        
        $user = User::findOrFail($id);

        $sales = Sale::where('user_id', $user->id)->get();
        
        return response()->json($sales, 200);
    }

    public function getByEmail($email)
    {
        $user = User::where('email', $email)->first();
        
        if ($user) {
            $user->uid = Crypt::encryptString($user->id);
        }

        return response()->json($user, 200);
    }
}
