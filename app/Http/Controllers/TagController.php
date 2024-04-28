<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
     * Get List of Tags
     * @OA\Get (
     *     path="/api/tags",
     *     tags={"Tag"},
     *     description="Get a list of tags",
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
     *                         example="TagName"
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
     *                     ),
     *                     @OA\Property(
     *                          property="post",
     *                          type="object",
     *                          @OA\Schema(ref="app\Models\Post")
     *                     ),
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        //
        return TagResource::collection(Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     */

      /**
     * Create Tag
     * @OA\Post (
     *     path="/api/tags",
     *     tags={"Tag"},
     *     security={ {"bearerToken":{}} },
     *     description="Insert a tag on the user's post",
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
     *                          property="post_id",
     *                          type="number"
     *                      ),
     *                 ),
     *                 example={
     *                     "name":"Node",
     *                     "post_id":"0"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Tag registered with success!")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="An error occurred while registering the tag."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbbiden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Not authorized to create a tag on this post."),
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Post not found."),
     *          )
     *      )
     * )
     */
    public function store(StoreUpdateTagRequest $request)
    {
        //
        $post = Post::find($request->post_id);

        if(!$post){
            return response()->json([ 'message' => 'Post not found.'], 404 );
        }

        if($post->user->id != $request->user()->id){
            return response()->json([ 'message' => 'Not authorized to create a tag on this post.'], 403 );
        }

        if(Tag::create($request->all())){
            return response()->json([ 'message' => 'Tag registered with success!'], 201);
        }

        return response()->json([ 'message' => 'An error occurred while registering the tag.'], 400 );
    }

    /**
     * Display the specified resource.
     */

     /**
     * Get Tag by id
     * @OA\Get (
     *     path="/api/tags/{id}",
     *     tags={"Tag"},
     *     description="Get a tag by id",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *          response=404,
     *          description="Post not found.",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Tag not found"),
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Node"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="post", type="object", @OA\Schema(ref="app\Models\Post")
     *         ),
     *         )
     *     )
     * )
     */
    public function show(string $tag)
    {
        //
        $tag = Tag::find($tag);
        if($tag){
            return new TagResource($tag);
        }

        return response()->json([ 'message' => 'Tag not found.'], 404 );
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update Tag
     * @OA\Patch (
     *     path="/api/tags/{id}",
     *     tags={"Tag"},
     *     security={ {"bearerToken":{}} },
     *     description="Update a tag's post of the authenticated user",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
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
     *                      )
     *                 ),
     *                 example={
     *                     "name":"Node"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Node"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Tag not found."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbbiden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Not authorized to update this tag on another user's post"),
     *          )
     *      )
     * )
     */
    public function update(StoreUpdateTagRequest $request, string $tag)
    {
        //
        $tag = Tag::find($tag);

        if(!$tag){
            return response()->json([ 'message' => 'Tag not found.'], 404 );
        }

        $post = $tag->post;

        if($post->user->id != $request->user()->id){
            return response()->json([ 'message' => "Not authorized to update this tag on another user's post"], 403 );
        }

        $tag->update($request->all());
        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     */

     /**
     * Delete Tag
     * @OA\Delete (
     *     path="/api/tags/{id}",
     *     tags={"Tag"},
     *     security={ {"bearerToken":{}} },
     *     description="Delete a tag's post of the authenticated user",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Node"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Tag not found."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbbiden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Not authorized to delete this tag on another user's post"),
     *          )
     *      )
     * )
     */
    public function destroy(Request $request, string $tag)
    {
        //
        $tag = Tag::find($tag);

        if(!$tag){
            return response()->json([ 'message' => 'Tag not found.'], 404 );
        }

        $post = $tag->post;

        if($post->user->id != $request->user()->id){
            return response()->json([ 'message' => "Not authorized to delete this tag on another user's post"], 403 );
        }

        $tag->delete();
        return new TagResource($tag);
    }
}
