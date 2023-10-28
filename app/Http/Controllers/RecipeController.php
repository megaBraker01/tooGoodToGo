<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *   schema="Recipe",
 *   title="Recipe",
 *   description="Recipe model",
 *   type="object",
 *   @OA\Property(property="id", type="number", example="1"),
 *   @OA\Property(property="name", type="string", example="pizza"),
 *   @OA\Property(property="user_id", type="number", example="5"),
 *   @OA\Property(property="created_at", type="string", example="2023-10-23T00:09:16.000000Z"),
 *   @OA\Property(property="updated_at", type="string", example="2023-10-23T12:33:45.000000Z"),
 *   example={"id": 25, "name": "Pizza", "user_id": "6", "created_at": "2023-10-23T00:09:16.000000Z", "updated_at": "2023-10-23T00:10:16.000000Z"}
 * )
 * 
 * @OA\Schema (
 *      schema="RecipeRequest",
 *      title="RecipeRequest",
 *      description="Recipe Request Model",
 *      type="object",
 *      @OA\Property(property="name", type="string", example="pizza"),
 *      @OA\Property(property="user_id", type="number", example="5"),
 *      example={"name": "Pizza", "user_id": "6"}
 * )
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
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                  @OA\Schema (
     *                      @OA\Property(
     *                          type="array",
     *                          property="data",
     *                          @OA\Items(ref="#/components/schemas/Recipe")
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
     *              @OA\Schema(ref="#/components/schemas/RecipeRequest")
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
     *                          type="object",
     *                          property="data",
     *                          ref="#/components/schemas/Recipe"
     *                     )
     *                  )
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent (
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
                'name' => 'required|unique:recipes',
                'user_id' => 'required|exists:users,id',
            ]);
            
            $recipe = new Recipe;
            $recipe->name = $request->name;
            $recipe->user_id = $request->user_id;
            
            /*
            if($request->hasFile('image')){
                $image = request('image');
                $filename = time() . $image->getClientOriginalName();
                $image->move(public_path() . 'recipe_img/',$filename);
                $recipe->image = $filename;
           }*/
            
            $recipe->save();
            
            return ApiResponse::success($recipe);
            
        } catch (ValidationException $ve) {
            
            $errors = $ve->validator->errors()->toArray();
            return ApiResponse::error($errors, $ve->getMessage(), 402);
            
        } catch (Exception $e) {
            return ApiResponse::error();
        }
    }

    /**
     * Get by id the information for a specific recipe, and also display the information of its ingredients.
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
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                  @OA\Schema (
     *                      @OA\Property(
     *                          type="object",
     *                          property="data",
     *                          ref="#/components/schemas/Recipe"
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
            $recipe = Recipe::with('ingredients')->find($id);
        
            if(is_null($recipe)) {
               return ApiResponse::error(null, 'not found', 404);
            }
            
            return ApiResponse::success($recipe);
            
        } catch (Exception $e) {
            return ApiResponse::error(null, $e->getMessage());
        }
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
     *             @OA\Schema(ref="#/components/schemas/RecipeRequest")
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponse"),
     *                  @OA\Schema (
     *                      @OA\Property(
     *                          type="object",
     *                          property="data",
     *                          ref="#/components/schemas/Recipe"
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
    public function update(Request $request, $id)
    {
        try {
            $recipe = Recipe::find($id);
            
            $request->validate([
                'name' => ['required', Rule::unique('recipes')->ignore($recipe)],
                'user_id' => 'required|exists:users,id',
            ]);
        
            if(is_null($recipe)) {
               return ApiResponse::error(null, 'not found', 404);
            }

            $recipe->name = $request->name;
            $recipe->user_id = $request->user_id;
            $recipe->update();
            
            return ApiResponse::success($recipe);
            
        } catch (ValidationException $ve) {
            
            $errors = $ve->validator->errors()->toArray();
            return ApiResponse::error($errors, $ve->getMessage(), 402);
            
        } catch (Exception $e) {
            return ApiResponse::error(null, 'unprocessable content', 422);
        }
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
     *              type="object",
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/ApiResponse"),
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
     */
    public function destroy($id)
    {
        try {
            $recipe = Recipe::find($id);
        
            if(is_null($recipe)) {
               return ApiResponse::error(null, 'not found', 404);
            }

            $recipe->delete();

            return ApiResponse::success(null, 'task executed successfully');
            
        } catch (Exception $e) {
            return ApiResponse::error();
        }
    }
    
    public function ingredients($id)
    {
        try {
            $recipe = Recipe::find($id);
        
            if(is_null($recipe)) {
               return ApiResponse::error(null, 'not found', 404);
            }
            
            $ingredients = $recipe->getIngredients();
            //dd($ingredients->getRelations()->toArray());
            
            return ApiResponse::success($ingredients);
            
        } catch (Exception $exc) {
            return ApiResponse::error();
        }
    }
}
