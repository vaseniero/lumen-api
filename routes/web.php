<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*
$router->get('/', function () use ($router) {
    return $router->app->version();
});
*/

$router->app->middleware([
    App\Http\Middleware\Authenticate::class
 ]);

/***
 * The first parameter 'createuser' it is the url address
 * So to call this we will use the URL as BASE URL + createuser
 * 
 * The second parameter is UserController@create 
 * it means we are calling create function which is inside UserController
 * 
 * Using the same for all routes
 ***/

$router->post('createuser', 'UserController@create');
/*
$app->post('createquestion', 'QuestionController@create');
$app->post('submitanswer', 'AnswerController@submit');
$app->post('userlogin', 'UserController@login');
$app->post('createcategory', 'CategoryController@create');
$app->get('categories', 'CategoryController@get');
$app->get('getmyquestions/{user_id}', 'UserController@getQuestions');
$app->get('questions', 'QuestionController@getAll');
$app->get('questions/{category_id}', 'QuestionController@getByCategory');
*/