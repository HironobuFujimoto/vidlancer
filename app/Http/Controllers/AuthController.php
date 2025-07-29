<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // ① バリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // ② ユーザーをメールで取得
        $user = User::where('email', $request->email)->first();

        // ③ ユーザーが存在しない、またはパスワードが一致しない場合
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => '認証失敗'], 401);
        }

        // ④ JWTのペイロードを作成
        $payload = [
            'iss' => "vidlancer",           // 発行者（任意）
            'sub' => $user->id,             // トークンの対象（ユーザーID）
            'iat' => time(),                // 発行時間
            'exp' => time() + 60*60         // 有効期限（1時間）
        ];

        // ⑤ トークンの生成
        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        // ⑥ レスポンスとしてトークンを返す
        return response()->json([
            'token' => $jwt,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name
            ]
        ]);
    }

    public function register(Request $request)
    {
        Log::info('This is a test log.');
        Log::info('JWT_SECRET = ' . env('JWT_SECRET'));
        // ① バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        // ② ユーザー作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // ③ JWTのペイロードを作成
        $payload = [
            'iss' => "vidlancer",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60*60
        ];

        // ④ トークンの生成
        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        // ⑤ トークンとユーザー情報を返す
        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name
            ]
        ], 201);
    }
}
