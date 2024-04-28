<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */

     /**
     * Get List Users
     * @OA\Get (
     *     path="/api/users",
     *     tags={"User"},
     *     description="Get a list of users",
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Jhon Doe"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="example@email.com"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function index()
    {
        //
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */

      /**
     * Create User
     * @OA\Post (
     *     path="/api/users",
     *     tags={"User"},
     *     description="Name: required, email: valid email, password: min 8 characters",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="email"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="password"
     *                      ),
     *                 ),
     *                 example={
     *                     "name":"Jhon Doe",
     *                     "email":"example@email.com",
     *                     "password":"password"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User registered with success!")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="An error occurred while registering the user."),
     *          )
     *      )
     * )
     */

     public function store(StoreUpdateUserRequest $request)
     {
         $user = User::create($request->all());

         if ($user) {
             return response()->json(['message' => 'User registered with success!'], 201);
         } else {
             return response()->json(['message' => 'An error occurred while registering the user.'], 400);
         }
     }

    /**
     * Display the specified resource.
     */

     /**
     * Get User
     * @OA\Get (
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     description="Get the user with the given id",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
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
     *     )
     * )
     */
    public function show(string $user)
    {
        //
        $user = User::find($user);
        if($user){
            return new UserResource($user);
        }

        return response()->json([ 'message' => 'User not found.'], 404 );
    }

    /**
     * Update the specified resource in storage.
     */

     /**
     * Update User
     * @OA\Patch (
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     security={ {"bearerToken":{}} },
     *     description="Update authenticated user, passing the right id",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"Jhon Doe",
     *                     "email":"example@email.com"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="title"),
     *              @OA\Property(property="email", type="string", example="content"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User not found."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbbiden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Not authorized to update this user."),
     *          )
     *      )
     * )
     */
    public function update(StoreUpdateUserRequest $request, string $id)
    {
        //
        if($id != $request->user()->id){
            return response()->json(['message'=> 'Not authorized to update this user.'],403);
        }

        $user = User::find($request->user()->id);
        if($user){
            $user->update($request->all());
            return new UserResource($user);
        }

        return response()->json([ 'message' => 'User not found.'], 404 );
    }

    /**
     * Remove the specified resource from storage.
     */

     /**
     * Delete User
     * @OA\Delete (
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     security={ {"bearerToken":{}} },
     *     description="Delete authenticated user, passing the id",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="title"),
     *              @OA\Property(property="email", type="string", example="content"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User not found."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbbiden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Not authorized to delete this user."),
     *          )
     *      )
     * )
     */
    public function destroy(Request $request , string $id)
    {
        if($id != $request->user()->id){
            return response()->json(['message'=> 'Not authorized to delete this user.'],403);
        }

        $user = User::find($request->user()->id);
        if($user){
            $user->delete();
            return new UserResource($user);
        }

        return response()->json([ 'message' => 'User not found.'], 404 );
    }
}
