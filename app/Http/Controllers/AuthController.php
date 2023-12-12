<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SendPasswordResetEmailRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\UserToken;
use App\Services\AuthService;
use Carbon\Carbon;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $userData = [
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = $this->authService->register($userData);

        $response = [
            'data' => $user
        ];

        return response()->json($response, 200);
    }
    /**
     * Authenticate the user.
     *
     * @param  App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $userData = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt(['email' => $userData['email'], 'password' => $userData['password']])) {
            $user = $this->authService->checkEmail($userData);
            $user->tokens()->delete();
            $token = Auth::user()->createToken('AccessToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'ログインできませんでした'], 401);
        }
    }

    public function checkLogin(){
        return response()->json(['message' => 'Success'], Response::HTTP_OK);
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'ログアウトしました。'], 200);
    }

    public function sendPasswordResetEmail(SendPasswordResetEmailRequest $request)
    {
        $userData = ['email' => $request->email ];
        $user = $this->authService->checkEmail($userData);
        if (!$user) {
            return response()->json(['error' => '未登録のメールアドレスです'], 401);
        }

        $token = $this->authService->sendPasswordResetEmail($user);

        $user->sendPasswordResetNotification($token);

        return response()->json([
            'token' => $token,
            'mail_sent' => true,
        ]);
    }

    private function doVerifyTokenAndEmail($token, $email)
    {
        $dbToken = UserToken::where('token', $token)->first();
        if (!$dbToken) {
            return ['success' => false, 'message' => 'トークンが無効です'];
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return ['success' => false, 'message' => '未登録のメールアドレスです'];
        }

        $now = Carbon::now();
        $dbTokenExpire = Carbon::parse($dbToken->expire_at);
        if ($now->isAfter($dbTokenExpire)) {
            return ['success' => false, 'message' => 'トークンの有効期限が切れています'];
        }

        if ($dbToken->user_id != $user->id) {
            return ['success' => false, 'message' => 'トークンが無効です'];
        }

        return ['success' => true];
    }

    public function verifyTokenAndEmail(Request $request)
    {
        $result = $this->doVerifyTokenAndEmail($request->token, $request->email);
        if (!$result['success']) {
            return response()->json(['message' => $result['message']]);
        }

        return response()->json([
            'token' => $request->token,
            'verified' => true,
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $result = $this->doVerifyTokenAndEmail($request->token, $request->email);
        if (!$result['success']) {
            return response()->json(['message' => $result['message']]);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        UserToken::where('token', $request->token)->delete();

        return response()->json([
            'message' => 'Password updated.'
        ]);
    }
}
