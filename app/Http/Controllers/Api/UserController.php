<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UserController extends Controller
{
    // Registration endpoint
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Bouncer::assign('viewer')->to($user);

        $token = $user->createToken('api')->plainTextToken;

        return (new UserResource($user))->additional(['token' => $token]);
    }

    // Login endpoint
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if($request->email == 'admin@example.com'){
            $user = User::where('email', $data['email'])->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        }else{
            if (!Auth::attempt($data)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            $user = Auth::user();
        }

        $token = $user->createToken('api')->plainTextToken;

        return (new UserResource($user))->additional(['token' => $token]);
    }

    // List users (admin only)
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return UserResource::collection(User::paginate());
    }

    // Show details for one user
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    // Update user (admin or self)
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validatedData = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'string', 'min:8'],
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return new UserResource($user);
    }

    // Delete user (admin only)
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->noContent();
    }
}
