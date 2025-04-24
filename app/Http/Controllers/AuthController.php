<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

/**
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Enter your API token as 'Bearer {token}'"
 * )
 */

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
/**
     * @OA\Post(
     *     path="/api/register",
     *     summary="User Registration",
     *     description="Register a new user and return a token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         ),
     *     ),
     *     @OA\Response(response=201, description="User registered successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     * )
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $userData = $request->all();


        $userData['password'] = Hash::make($userData['password']);


        $user = $this->userRepository->createUser($userData);
        $token = $user->createToken('Token')->accessToken;
        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token,]);
    }

/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="User Login",
 *     description="Authenticate user and return token",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         content={
 *             "multipart/form-data": @OA\MediaType(
 *                 mediaType="multipart/form-data",
 *                 @OA\Schema(
 *                     type="object",
 *                     required={"email", "password"},
 *                     @OA\Property(
 *                         property="email",
 *                         type="string",
 *                         format="email",
 *                         example="john@example.com"
 *                     ),
 *                     @OA\Property(
 *                         property="password",
 *                         type="string",
 *                         format="password",
 *                         example="secret123"
 *                     )
 *                 )
 *             )
 *         }
 *     ),
 *     @OA\Response(response=200, description="Login successful"),
 *     @OA\Response(response=401, description="Unauthorized"),
 * )
 */



    public function login(Request $request)
    {
        // $credentials = $request->only('email', 'password');

        // if (!Auth::attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // $user= Auth::User();
        $User = user::where('email', $request->email)->first();

        $token = $User->createToken('Token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $User,
            'token' => $token,
        ]);
    }


/**
 * @OA\Get(
 *     path="/api/profile",
 *     summary="Retrieve user profile",
 *     description="Fetches the authenticated user's profile information.",
 *     tags={"Authentication"},
 *     security={{"sanctum": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Profile information retrieved successfully.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Profile information"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
public function profile()
{
    $userData = auth::user();

    return response()->json([
        "status" => true,
        "message" => "Profile information",
        "data" => $userData
    ]);
}



    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="User Logout",
     *     description="Logs out the authenticated user",
     *     tags={"Authentication"},
     *     @OA\Response(response=200, description="User logged out successfully"),
     *     security={{"bearerAuth": {}}}
     * )
     */

     public function logout(Request $request)
     {
         // Revoke the user's current token
         $request->user()->currentAccessToken()->delete();
     
         return response()->json(['message' => 'User logged out successfully']);
     }


     
        /**
         * @OA\Post(
         *     path="/api/upload",
         *     summary="Upload a file",
         *     description="Handles the uploading of a file and stores its metadata.",
         *     operationId="uploadFile",
         *     tags={"Authentication"},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\MediaType(
         *             mediaType="multipart/form-data",
         *             @OA\Schema(
         *                 @OA\Property(
         *                     property="file",
         *                     type="string",
         *                     format="binary",
         *                     description="The file to be uploaded"
         *                 )
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="File uploaded successfully",
         *         @OA\JsonContent(
         *             @OA\Property(property="message", type="string", example="File uploaded successfully"),
         *             @OA\Property(
         *                 property="file",
         *                 type="object",
         *                 @OA\Property(property="id", type="integer", example=1),
         *                 @OA\Property(property="name", type="string", example="example.jpg"),
         *                 @OA\Property(property="path", type="string", example="uploads/example.jpg"),
         *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-02T04:49:06.000000Z"),
         *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-02T04:49:06.000000Z")
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=400,
         *         description="Bad request"
         *     ),
         *     @OA\Response(
         *         response=500,
         *         description="Server error"
         *     )
         * )
         */

     public function upload(Request $request)
    {
       
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        
        $path = $request->file('file')->store('uploads', 'public');
        $file = new File();
        $file->name = $request->file('file')->getClientOriginalName();
        $file->path = $path;
        $file->save();
        return response()->json([
            'message' => 'File uploaded successfully',
            'file' => $file
        ], 201);
    }

    // public function refresh()
    // {
    //     return response()->json(['token' => JWTAuth::refresh()]);
    // }


    /**
     * @OA\Post(
     *     path="/api/forgot-password",
     *     summary="Forgot Password",
     *     description="Send a password reset link to the user's email",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *         ),
     *     ),
     *     @OA\Response(response=200, description="Password reset link sent"),
     *     @OA\Response(response=404, description="User not found"),
     * )
     */

    // public function forgotPassword(Request $request)
    // {
    //     $request->validate(['email' => 'required|email|exists:users,email']);

    //     $token = \Illuminate\Support\Str::random(60);
    //     \DB::table('password_resets')->insert([
    //         'email' => $request->email,
    //         'token' => \Illuminate\Support\Facades\Hash::make($token),
    //         'created_at' => now(),
    //     ]);

    //     \Mail::to($request->email)->send(new \App\Mail\ResetPasswordMail($token));

    //     return response()->json(['message' => 'Password reset link sent']);
    // }
}
