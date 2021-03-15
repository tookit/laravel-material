<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    use ValidatesRequests;

    const IDENTIFIERS = ['username','email','mobile'];

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {


        $token = $this->guard()->attempt($this->credentials($request));

        if (!$token) {
            return new JsonResponse(['errors' => ['Unauthorized']], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register a new user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        return $this->login($request);

    }




    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {

        $keys = array_keys($request->all());
        foreach(self::IDENTIFIERS as $identifier) {
            if(in_array($identifier, $keys)) {
                return $request->only($identifier, 'password');
            }
        }
        return $request->only('email', 'password');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Tymon\JWTAuth\JWTGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return new JsonResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
        ]);
    }
}
