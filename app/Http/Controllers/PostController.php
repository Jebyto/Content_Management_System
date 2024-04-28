<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     /**
     * Get List of Posts
     * @OA\Get (
     *     path="/api/posts",
     *     tags={"Post"},
     *     description="Get a list of post",
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
     *                         property="title",
     *                         type="string",
     *                         example="Title"
     *                     ),
     *                     @OA\Property(
     *                         property="content",
     *                         type="string",
     *                         example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
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
     *                          property="tags",
     *                          type="array",
     *                          @OA\Items(ref="app\Models\Post")
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
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */

     /**
     * Store a newly created resource in storage.
     */

      /**
     * Create Post
     * @OA\Post (
     *     path="/api/posts",
     *     tags={"Post"},
     *     security={ {"bearerToken":{}} },
     *     description="Authenticated user create a new post",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="content",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="tags",
     *                          type="array",
     *                          @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="name",
     *                              type="string"
     *                          )
     *                     )
     * )
     *                 ),
     *                 example={
     *                     "title":"Title",
     *                     "content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut gravida nisi.",
     *                     "tags": {
     *                              {"name": "tag1"},
     *                              {"name": "tag2"}
     *                     }
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Post created")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Error, post not created"),
     *          )
     *      )
     * )
     */
    public function store(StoreUpdatePostRequest $request)
    {
        $request['user_id'] = $request->user()->id;

        $post = Post::create($request->all());

        if (!$post) {
            return response()->json(['message' => 'Error, post not created'], 500);
        }

        if(!$request['tags']){
            return response()->json(['message' => 'Post created without tags'], 201);
        }

        foreach ($request['tags'] as $tagData) {
            Tag::Create(['name' => $tagData['name'], 'post_id' => $post['id']]);
        }

        return response()->json(['message' => 'Post created'], 201);
    }


    /**
     * Display the specified resource.
     */

    /**
     * Get Post by id
     * @OA\Get (
     *     path="/api/posts/{id}",
     *     tags={"Post"},
     *     description="Get a post by id",
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
     *              @OA\Property(property="msg", type="string", example="Post not found"),
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="Title"),
     *              @OA\Property(property="content", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut gravida nisi."),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="tags", type="array", @OA\Items(ref="app\Models\Post")
     *         ),
     *         )
     *     )
     * )
     */
    public function show(string $post)
    {
        //
        $post = Post::find($post);
        if($post){
            return new PostResource($post);
        }

        return response()->json([ 'message' => 'Post not found.'], 404 );
    }

    /**
     * Get List of Posts with the tag name
     * @OA\Get (
     *     path="/api/posts/getByTag/{tagName}",
     *     tags={"Post"},
     *     description="Get a list of post with the same tag name",
     *     @OA\Parameter(
     *         in="path",
     *         name="tagName",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     * @OA\Response(
     *          response=404,
     *          description="Post not found.",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="Posts not found"),
     *          )
     *      ),
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
     *                         property="title",
     *                         type="string",
     *                         example="Title"
     *                     ),
     *                     @OA\Property(
     *                         property="content",
     *                         type="string",
     *                         example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
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
     *                          property="tags",
     *                          type="array",
     *                          @OA\Items(ref="app\Models\Post")
     *                     ),
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function showByTag(string $tagName)
    {
        //
        $post = Post::whereHas('tags', function($query) use ($tagName){
            $query->where('name', '=', $tagName );
        })->get()->load('tags');

        if($post->isNotEmpty()){
            return PostResource::collection($post);
        }

        return response()->json([ 'message' => 'Posts not found.'], 404 );
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update Post
     * @OA\Patch (
     *     path="/api/posts/{id}",
     *     tags={"Post"},
     *     security={ {"bearerToken":{}} },
     *     description="Authenticated user update a post",
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
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="content",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"Title changed",
     *                     "content":"New content"
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
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="tags", type="array", @OA\Items(ref="app\Models\Post"))
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Post not found."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbbiden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthorized. You are not the owner of this post."),
     *          )
     *      )
     * )
     */
    public function update(StoreUpdatePostRequest $request, string $post)
    {
        $post = Post::find($post);

        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized. You are not the owner of this post.'], 403);
        }

        $post->update($request->all());

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */

     /**
     * Remove the specified resource from storage.
     */

     /**
     * Delete Post
     * @OA\Delete (
     *     path="/api/posts/{id}",
     *     tags={"Post"},
     *     security={ {"bearerToken":{}} },
     *     description="Authenticated user delete a post",
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
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="tags", type="array", @OA\Items(ref="app\Models\Post"))
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
     *              @OA\Property(property="message", type="string", example="Unauthorized. You are not the owner of this post."),
     *          )
     *      )
     * )
     */
    public function destroy(Request $request ,string $post)
    {
        $post = Post::find($post);

        if (!$post) {
            return response()->json(['message' => 'Post not found.'], 404);
        }

        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized. You are not the owner of this post.'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.'], 200);
    }
}
