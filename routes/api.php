<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


 Route::get('/getNews',[\App\Http\Controllers\NewsController:: class, 'index']);
 //  جلب الخبر مع التصنيف
 Route::get('/get_news_with_category',[\App\Http\Controllers\NewsController:: class,'get_news_with_category']);
 Route::get('/getNews/id',[\App\Http\Controllers\NewsController:: class, 'show']);
 Route::get('/getUser',[\App\Http\Controllers\UserController:: class, 'index']);
 Route::post('/login',[\App\Http\Controllers\UserController:: class, 'login']);
 Route::post('/addUser',[\App\Http\Controllers\UserController:: class, 'store']);
 Route::get('/news/filter',[NewsController::class,'filterNewsTitleAndType']);
 Route::get('/news/filterByTitle',[NewsController::class,'filterByTitle']);
 Route::get('/news/filterBydate',[NewsController::class,'filterBydate']);

Route :: group(['middleware'=>'auth:api'],function() {
    Route:: post('/addNews', [\App\Http\Controllers\NewsController:: class, 'addNews']);
    Route:: post('/addType', [\App\Http\Controllers\ClassificationsController:: class, 'store']);
    Route:: post('/updateNews/{id}', [NewsController:: class, 'update']);
    Route:: post('/deleteNews/{id}', [NewsController:: class, 'destroy']);
});
