<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    
    /**
     * List all available users
     * @OA\Get (
     *      path="/api/users",
     *      tags={"Users"},
     *      @OA\Response (
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent (
     *              @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Marilie Jacobs"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="marilie_jacobs@example.org"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-10-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-10-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *          )
     *      )
     * )
     * 
     */
    public function index()
    {
        $users = User::all();
        
        return response()->json([
            'rows' => $users,
        ]);
    }
    
    /**
     * Insert a new user
     * @OA\Post (
     *      path="/api/users",
     *      tags={"Users"},
     *      @OA\RequestBody (
     *          @OA\MediaType (
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property (
     *                      type="object",
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Brad Champlin"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="brad_champlin@example.net"
     *                     ),
     *                     @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         example="D$5f_4fa.E"
     *                     )
     *                  ),
     *                 example={
     *                     "name": "Brad Champlin",
     *                     "email": "brad_champlin@example.net",
     *                     "password": "D$5f_4fa.E" 
     *                }
     *              )
     *          )
     *      ),
     *      @OA\Response (
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent (
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="name", type="string", example="Brad Champlin"),
     *              @OA\Property(property="email", type="string", example="brad_champlin@example.net"),
     *              @OA\Property(property="created_at", type="string", example="2023-10-23T00:09:16.000000Z"),
    *               @OA\Property(property="updated_at", type="string", example="2023-10-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The name field is required."),
     *              @OA\Property(property="errors", type="string", example="Error Object"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        
        return $user;
    }
    
    /**
     * Get by id the information for a specific user
     * @OA\Get (
     *      path="/api/users/{id}",
     *      tags={"Users"},
     *      @OA\Parameter (
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="number")
     *      ),
     *      @OA\Response (
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent (
     *              @OA\Property(
     *                  property="id",
     *                  type="number",
     *                  example="1"
     *              ),
     *               @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Marilie Jacobs"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   type="string",
     *                   example="marilie_jacobs@example.org"
     *               ),
     *              @OA\Property(
     *                   property="email_verified_at",
     *                   type="string",
     *                   example="2023-10-24T00:09:16.000000Z"
     *               ),
     *               @OA\Property(
     *                   property="created_at",
     *                   type="string",
     *                   example="2023-10-23T00:09:16.000000Z"
     *               ),
     *               @OA\Property(
     *                   property="updated_at",
     *                   type="string",
     *                   example="2023-10-23T12:33:45.000000Z"
     *               )
     *          )
     *      ),
     *      @OA\Response (
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent (
     *              @OA\Property(property="message", type="string", example="resource not found")
     *          )
     *      )
     * )
     * 
     */
    public function show($id)
    {
        $user = User::find($id);
        
        if(is_null($user)) {
           return  response()->json(['message' => 'resource not found'], 404);
        }
        
        return $user;
    }
}
