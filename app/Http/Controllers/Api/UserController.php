<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Регистрация
     * @OA\Post(
     *     path="/api/auth/register",
     *     operationId="UserRegister",
     *     tags={"User"},
     *     summary="Регистрация нового юзера",
     *     @OA\Parameter(
     *           name="name",
     *           description="Имя юзера",
     *           required=true,
     *           in="query",
     *           @OA\Schema(
     *               type="string"
     *           )
     *     ),
     *     @OA\Parameter(
     *            name="email",
     *            description="Email юзера",
     *            required=true,
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *     ),
     *     @OA\Parameter(
     *            name="password",
     *            description="Password юзера",
     *            required=true,
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="token",
     *                  type="string",
     *              ),
     *         ),
     *     )
     * )
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created!',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ]);
    }

    /**
     * Логин
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="UserLogin",
     *     tags={"User"},
     *     summary="Login юзера",
     *     @OA\Parameter(
     *            name="email",
     *            description="Email юзера",
     *            required=true,
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *     ),
     *     @OA\Parameter(
     *            name="password",
     *            description="Password юзера",
     *            required=true,
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="token",
     *                  type="string",
     *              ),
     *         ),
     *     )
     * )
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status' => true,
            'message' => 'You are login!',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ]);
    }
}
