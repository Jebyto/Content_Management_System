<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LDAP\Result;

class AuthController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     */

     /**
     * Login with email and password
     * @OA\Post (
     *     description="Creates a new token for authentication and authorizing some features",
     *     path="/api/login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "email":"example@email.com",
     *                     "password":"password"
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Authorized. Token: 3x4mpl3T0k3n"),
     *
     *         )
     *     ),
     *      @OA\Response(
     *          response=403,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Not Authorized"),
     *          )
     *      )
     * )
     */

    public function login(Request $request){

        if(Auth::attempt($request->only("email","password"))){

            $token = $request->user()->createToken($request->user()->name . '_token');

            return response("Authorized \nToken: $token->plainTextToken", 200);
        }

        return response('Not Authorized', 403);

    }


    /**
     * Display a listing of the resource.
     */

     /**
     * Logout
     * @OA\Post (
     *     description="Authentication token associated with this session is invalidated and access is revoked",
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     security={ {"bearerToken":{}} },

     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Token Revoked"),
     *
     *         )
     *     ),
     * )
     */

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();

        return response('Token Revoked', 200);
    }


    /**
     * Display a listing of the resource.
     */

     /**
     * Logged user
     * @OA\Get (
     *     description="Return the user authenticated",
     *     path="/api/me",
     *     tags={"Authentication"},
     *      security={ {"bearerToken":{}} },

     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Jhon Doe"),
     *              @OA\Property(property="email", type="string", example="example@email.com"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *         )
     *     ),
     * )
     */

    public function me(Request $request){
        return $request->user();
    }
}
