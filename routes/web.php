<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/index','TextController@index');
Route::get('/export','TextController@export');

Route::match(['get', 'post'],'/user','TestController@user');

Route::post('/user/profile', function () {
    // Validate the request...
     echo 'qq';
   // return back()->withInput();
});






////for online exam test case
Route::get('/exam','TestController@exam');
Route::post('/addexam','TestController@addExam');
Route::get('/edit-exam/{id}','TestController@editExam');
//Q&A 
Route::get('/qna','TestController@qna');
Route::post('/addqna','TestController@getqna');
Route::post('/import','TestController@import')->name('importQnA');
Route::get('/all-std','TestController@allstd');
Route::post('/add-std','TestController@addstd');



Route::get('/test',function(){
    $collection = collect(['name' => 'Desk', 'price' => 200]);
   // dd($collection->toArray());
    dd($collection->toJson());
});