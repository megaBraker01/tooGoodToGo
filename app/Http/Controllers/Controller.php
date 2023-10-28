<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
* @OA\Info(
*   title="Too Good To Go API", 
*   version="1.0",
*   description="It is an application that allows us to create and manage users and recipes. All users will be able to search for all recipes, they will be able to create and update their own recipes, they will be able to add and delete favorite recipes and they will also be able to see other users' recipes."
* )
*
* @OA\Server(url="http://toogoodtogo.test:8080")
*/
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
