
## About TooGoodToGo

It is an application that allows us to create and manage users and recipes. All users will be able to search for all recipes, they will be able to create and update their own recipes, they will be able to add and delete favorite recipes and they will also be able to see other users recipes.

## Installation & Configuration ##

1. git clon [https://github.com/megabraker01/toogoodtogo](https://laravel.com/docs/routing).
2. **cd toogoodtogo**
3. **composer install**
4. Create the Data Base and name it **toogoodtogo**
5. Rename file __.env.example__ to __.env__ and edit the Data Base connection parameters
6. **php artisan key:generate**, to Generate APP_KEY
7. **php artisan migrate --seed**, to generate the migrations and execute the seeders
8. go to **app/Http/Controller/Controller.php** and change the anotation @OA\Server(url) to the value http://yourdomain_name (http://127.0.0.1:8000/)
9. **php artisan serve** to run the application
10. To try and test the application go to the route: [http://yourdomain_name/api/documentation](http://localhost/api/documentation)

## API Documentation

To generate the documentation i use [OpenAPI (swagger)](https://github.com/DarkaOnLine/L5-Swagger) in version 8.5.1, it is already correctly installed and configured in our project. To access we just have to go to: [http://yourdomain_name/api/documentation](http://localhost/api/documentation)

## Security Vulnerabilities

If you discover a security vulnerability within TooGoodToGo, please send an e-mail to Rafael Perez via [angel_rafael01@hotmail.com](mailto:angel_rafael01@hotmail.com). All security vulnerabilities will be promptly addressed.

## License

The TooGoodToGo app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
