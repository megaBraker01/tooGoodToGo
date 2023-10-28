<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;

/**
* @OA\Info(
*   title="Too Good To Go API", 
*   version="1.0",
*   description="It is an application that allows us to create and manage users and recipes. All users will be able to search for all recipes, they will be able to create and update their own recipes, they will be able to add and delete favorite recipes and they will also be able to see other users' recipes."
* )
*
* @OA\Server(url="http://toogoodtogo.test:8080")
*/
class RecipeController extends Controller
{
    /**
     * List all available recipes
     * @OA\Get (
     *      path="/api/recipes",
     *      tags={"Recipes"},
     *      @OA\Response (
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent (
     *              @OA\Property (property="message", type="string", example="success"),
     *              @OA\Property (property="statusCode", type="number", example="200"),
     *              @OA\Property (property="error", type="boolean", example="false"),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="number", example="1"),
     *                     @OA\Property(property="name", type="string", example="pizza"),
     *                     @OA\Property(property="user_id", type="number", example="5"),
     *                     @OA\Property(property="created_at", type="string", example="2023-10-23T00:09:16.000000Z"),
    *                     @OA\Property(property="updated_at", type="string", example="2023-10-23T12:33:45.000000Z")
     *                 )
     *             )
     *          )
     *      )
     * )
     * 
     */
    public function index()
    {
        try {
            $recipes = Recipe::all();
            
            return ApiResponse::success($recipes);
        } catch (Exception $e) {
            return ApiResponse::error();
        }
    }

    /**
     * Insert a new recipe
     * @OA\Post (
     *      path="/api/recipes",
     *      tags={"Recipes"},
     *      @OA\RequestBody (
     *          @OA\MediaType (
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property (
     *                      type="object",
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="pizza"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="number",
     *                         example=5
     *                     )
     *                  ),
     *                 example={
     *                     "name": "Pizza",
     *                     "user_id": "1"
     *                }
     *              )
     *          )
     *      ),
     *      @OA\Response (
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent (
     *              @OA\Property (property="message", type="string", example="success"),
     *              @OA\Property (property="statusCode", type="number", example="200"),
     *              @OA\Property (property="error", type="boolean", example="false"),
     *              @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="number", example="1"),
     *                     @OA\Property(property="name", type="string", example="pizza"),
     *                     @OA\Property(property="user_id", type="number", example="5"),
     *                     @OA\Property(property="created_at", type="string", example="2023-10-23T00:09:16.000000Z"),
    *                     @OA\Property(property="updated_at", type="string", example="2023-10-23T12:33:45.000000Z")
     *                 )
     *             )
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
            'user_id' => 'required',
        ]);
        
        $recipe = new Recipe;
        $recipe->name = $request->name;
        $recipe->user_id = $request->user_id;
        $recipe->save();
        
        return $recipe;
    }

    /**
     * Get by id the information for a specific recipe
     * @OA\Get (
     *      path="/api/recipes/{id}",
     *      tags={"Recipes"},
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
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="name", type="string", example="pizza"),
     *              @OA\Property(property="user_id", type="number", example="5"),
     *              @OA\Property(property="created_at", type="string", example="2023-10-23T00:09:16.000000Z"),
    *               @OA\Property(property="updated_at", type="string", example="2023-10-23T12:33:45.000000Z")
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
        $recipe = Recipe::find($id);
        
        if(is_null($recipe)) {
           return  response()->json(['message' => 'resource not found'], 404);
        }
        
        return $recipe;
    }

    /**
     * Update recipe data
     * @OA\Put (
     *     path="/api/recipes/{id}",
     *      tags={"Recipes"},
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
     *                      ),
     *                      @OA\Property(
     *                          property="user_id",
     *                          type="number"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "Hawaiian Pizza",
     *                     "user_id": "1"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Hawaiian Pizza"),
     *              @OA\Property(property="user_id", type="number", example=1),
     *              @OA\Property(property="created_at", type="string", example="2023-10-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-10-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The apellidos field is required."),
     *              @OA\Property(property="errors", type="string", example="Objeto de errores"),
     *          )
     *      )
     * )
     */
    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'name' => 'required|string',
            'user_id' => 'required',
        ]);
        
        $recipe->name = $request->name;
        $recipe->user_id = $request->user_id;
        $recipe->update();
        
        return $recipe;
    }

    /**
     * Delete a recipe by id
     * @OA\Delete (
     *      path="/api/recipes/{id}",
     *      tags={"Recipes"},
     *      @OA\Parameter (
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response (
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent (
     *              @OA\Property(property="message", type="string", example="resource deleted successfully")
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
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        
        if(is_null($recipe)) {
           return  response()->json(['message' => 'resource not found'], 404);
        }
        
        $recipe->delete();
        
        return response()->json(['message' => 'task executed successfully']);
    }
}
