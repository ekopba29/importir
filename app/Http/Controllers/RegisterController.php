<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request, $role)
    {
        $currURI = $request->getUri();
        $admin = route('register', ['role' => 'admin']);
        $staff = route('register', ['role' => 'staff']);

        switch ($currURI) {
            case $staff:
                $role = "staff";
                break;

            case $admin:
                $role = "admin";
                break;
        }

        $rule = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ];

        $validation = Validator::make(
            $request->all(),
            $rule
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => $validation->errors()]
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $role,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'OK',
            'data' => ['admin' => $user]
        ]);
    }

    public function login(Request $request)
    {
        $rule = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        $validation = Validator::make(
            $request->all(),
            $rule
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => 'NOK',
                'errors' => ['validation' => $validation->errors()]
            ]);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'NOK',
                'errors' => [
                    'validation' => [
                        'password' => [
                            'Invalid credentials'
                        ]
                    ],
                ]
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => 'OK',
            'data' => [
                'access_token' => $authToken,
            ]
        ]);
    }
}
