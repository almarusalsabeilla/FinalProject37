<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/', function () {
//     return view('layouts.master');
// });

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/questions/ask', 'QuestionController@index')->name('ask');
Route::post('/questions',  'QuestionController@store');
Route::get('/questions/{id}', 'QuestionController@show')->name('questions/{id}');
Route::post('/answers',  'AnswerController@store');
Route::get('/comments', 'CommentController@index')->name('comments');
Route::post('/comments', 'CommentController@store');
Route::get('/questions/{id}/edit', 'QuestionController@edit');
Route::put('/questions/{id}', 'QuestionController@update');
Route::post('/votes', 'VoteController@store');
Route::post('/home', 'HomeController@index');
Route::get('/index', function() {
    return view('layouts.master');
});

