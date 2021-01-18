<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required|min:6'
            ]
        );

        $user = User::create(
            [
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'password' => bcrypt($request->post('password')),
            ]
        );

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'password' => 'required'
            ]
        );

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var User $user */
            $user = Auth::user();

            $token = $user->createToken($user->email . '-' . now());

            $token->token->expires_at = $request->remember_me ?
                Carbon::now()->addMonth() :
                Carbon::now()->addDay();

            $token->token->save();

            return response()->json(
                [
                    'token_type' => 'Bearer',
                    'token' => $token->accessToken,
                    'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
                    'profile' => $user,
                ]
            );
        }

        return null;
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(
            [
                'message' => 'You are successfully logged out',
            ]
        );
    }

    public function profile(Request $request)
    {
        $user = auth()->guard('api')->user();

        return response()->json(
            [
                'profile' => $user,
            ]
        );
    }
}
