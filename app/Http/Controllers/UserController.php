<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;
use Exception;
use Illuminate\Validation\ValidationException;


/**
 * @OA\Schema(
 *   schema="User",
 *   title="User",
 *   description="User model",
 *   type="object",
 *   @OA\Property(property="id", type="number", example="1"),
 *   @OA\Property(property="name", type="string", example="Jhon Snow"),
 *   @OA\Property(property="email", type="string", example="jhon_snow@example.org"),
 *   @OA\Property(property="is_admin", type="number", example="1"),
 *   @OA\Property(property="created_at", type="string", example="2023-10-23T00:09:16.000000Z"),
 *   @OA\Property(property="updated_at", type="string", example="2023-10-23T12:33:45.000000Z"),
 *   example={"id": 25, "name": "Jhon Snow", "email": "jhon_snow@example.org", "id_admin":"0", "created_at": "2023-10-23T00:09:16.000000Z", "updated_at": "2023-10-23T00:10:16.000000Z"}
 * )
 * @OA\Schema(
 *   schema="UserRequest",
 *   title="UserRequest",
 *   description="UserRequest model",
 *   type="object",
 *   @OA\Property(property="name", type="string", example="Jhon Snow"),
 *   @OA\Property(property="email", type="string", example="jhon_snow@example.org"),
 *   @OA\Property(property="password", type="string", example="2_G0od.2-gO"),
 *   @OA\Property(property="is_admin", type="number", example="1"),
 *   example={"name": "Jhon Snow", "email": "jhon_snow@example.org", "password":"2_G0od.2-gO", "id_admin":"0"}
 * )
 */
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
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                  @OA\Schema (
     *                      @OA\Property(
     *                          type="array",
     *                          property="data",
     *                          @OA\Items(ref="#/components/schemas/User")
     *                     )
     *                  )
     *              }
     *          )
     *      )
     * )
     * 
     */
    public function index()
    {
        try {
            $users = User::all();
            
            return ApiResponse::success($users);
            
        } catch (Exception $e) {
            return ApiResponse::error();
        }
    }
    
    /**
     * Insert a new user
     * @OA\Post (
     *      path="/api/users",
     *      tags={"Users"},
     *      @OA\RequestBody (
     *          @OA\MediaType (
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UserRequest")
     *          )
     *      ),
     *      @OA\Response (
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent (
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                  @OA\Schema (
     *                      @OA\Property(
     *                          type="array",
     *                          property="data",
     *                          @OA\Items(ref="#/components/schemas/User")
     *                     )
     *                  )
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponseError"),
     *              }
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            
            /*
            if($request->hasFile('image')){
                $image = request('image');
                $filename = time() . $image->getClientOriginalName();
                $image->move(public_path() . 'user_img/',$filename);
                $user->image = $filename;
           }*/
            
            $user->save();
            
            return ApiResponse::success($user);
            
        } catch (ValidationException $ve) {
            
            $errors = $ve->validator->errors()->toArray();
            return ApiResponse::error($errors, $ve->getMessage(), 402);
            
        } catch (Exception $e) {
            return ApiResponse::error();
        }

        
    }
    
    /**
     * Get by id the information for a specific user,  and also display the information of their recipes.
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
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                  @OA\Schema (
     *                      @OA\Property(
     *                          type="array",
     *                          property="data",
     *                          @OA\Items(ref="#/components/schemas/User")
     *                     )
     *                  )
     *              }
     *          )
     *      ),
     *      @OA\Response (
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent (
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponseError"),
     *              }
     *          )
     *      )
     * )
     * 
     */
    public function show($id)
    {
        try {
            $user = User::with('recipes')->find($id);
        
            if(is_null($user)) {
               return ApiResponse::error(null, 'not found', 404);
            }
            
            return ApiResponse::success($user);
            
        } catch (Exception $e) {
            return ApiResponse::error();
        }
    }
    
    public function favorite_recipes($id)
    {
        
    }
}
