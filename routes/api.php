<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\UserController;
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

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE , ANY');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization , accept');
header('Access-Control-Allow-Credentials: true');


Route::get("getdata", "API\UserController@getdata")->middleware('auth:api');

Route::get('/email_test2', 'API\UserController@email_test2');

Route::post("login", "API\UserController@login");
Route::post("register", "API\UserController@register");
Route::post('forgot', 'API\UserController@forgot');

Route::post('resend_code', 'API\UserController@resend_code');
Route::post('varify_code', 'API\UserController@varify_code');



Route::post('contact', 'API\UserController@contact');  // contact form
Route::get('privacy_policy', 'API\UserController@privace_policy');
Route::get('terms_of_use', 'API\UserController@terms_of_use');


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('profile', 'API\UserController@updateProfile'); // update
    Route::get('profile', 'API\UserController@getUser'); // get user based on user_id

    // CHAT BOT.
    Route::get('joined/tribes', 'API\ChatBotController@joinedTribes'); // get list of joined tribes by user_id
    Route::post('join/tribe', 'API\ChatBotController@joinTribe');  // join tribe.
    Route::post('unjoin/tribe', 'API\ChatBotController@unJoinTribe');  // unjoin tribe.
    Route::post('logout', 'API\UserController@logout'); // user logout

    Route::get('user/questions', 'API\ChatBotController@getuserQuestions'); // get list of user questions.
    Route::get('dashboard/stats', 'API\ChatBotController@dashboardStats');  // dashboard stats.

    Route::post('ask/question', 'API\ChatBotController@userAskQuestion');
    Route::post('tribe', 'API\ChatBotController@getTribesTopics'); // show list of topics.

    Route::get('total_available_tribes', 'API\ChatBotController@total_available_tribes');
    Route::get('total_joined_tribes', 'API\ChatBotController@total_available_tribes');


    // ahmad    
    // 
    Route::post('all_clues', 'API\ChatBotController@getAllClues');


    // Route::post('make_article', 'API\ChatBotController@make_article');
    // Route::get('get_articles/{tribe_id}', 'API\ChatBotController@get_articles');


    Route::post('make_article', 'API\ChatBotController@make_article');
    Route::post('get_article', 'API\ChatBotController@get_article');
    Route::get('get_articles', 'API\ChatBotController@get_articles');
    Route::post('get_articles_by_tribe_id', 'API\ChatBotController@get_articles_by_tribe_id');
    Route::post('edit_article', 'API\ChatBotController@edit_article');
    // add comment
    Route::post('get_comments', 'API\ChatBotController@get_comment');
    Route::post('delete_comment', 'API\ChatBotController@delete_comment');
    Route::get('get_points', 'API\ChatBotController@get_points');
    Route::post('get_points_topic_wise', 'API\ChatBotController@get_points_topic_wise');
    Route::get('get_topic_list_for_points', 'API\ChatBotController@get_topic_list_for_points');
    // level crossed
    Route::get('get_level_crossed', 'API\ChatBotController@get_level_crossed');
    Route::post('post_comment', 'API\ChatBotController@post_comment');

    // getclue
    Route::post('getClues', 'API\ChatBotController@getClue');
    // tribe leader section
    // get all tribes of leader
    Route::get('getLeaderTribes', 'API\ChatBotController@get_leader_tribes');
    // get users of tribe
    Route::post('get_users_of_tribe', 'API\ChatBotController@get_users_of_tribe');
    // remove user from tribe
    Route::post('remove_user_from_tribe', 'API\ChatBotController@remove_user_from_tribe');
    Route::post('add_user_in_tribe', 'API\ChatBotController@add_user_in_tribe');
    // get users of tribe
    Route::post('add_user_to_tribe', 'API\ChatBotController@add_user_to_tribe');
    Route::post('add_like', 'API\ChatBotController@add_like');
    Route::post('add_dislike', 'API\ChatBotController@add_dislike');
    Route::post('delete_article', 'API\ChatBotController@del_art');
    
    

    // CHAT BOT.
    Route::get('tribes', 'API\ChatBotController@tribes');  // get tribes.
    Route::get('tribes_unjoined', 'API\ChatBotController@un_joined_tribes');  // get tribes.
    Route::post('request_to_join_tribe', 'API\ChatBotController@request_to_join_tribe');  // request to join tribe.
    Route::post('join_requests', 'API\ChatBotController@join_requests');

    Route::post('decline_request', 'API\ChatBotController@decline_join_request');

    Route::post('get_request_status', 'API\ChatBotController@get_request_status');
    Route::post('remove_user_image', 'API\ChatBotController@remove_user_image');

    Route::post('tribe/get/media', 'API\ChatBotController@getTribeMedia'); // get media by tribeid
    Route::post('tribe_leader/get/tribes', 'API\ChatBotController@getLeaderTribes'); // get media by tribeid
    Route::post('tribe/add/media', 'API\ChatBotController@addTribeMEdia'); // get media by tribeid







    // Route::post('tribe_edit/for_leader', 'API\ChatBotController@edit_tribe_details');




    // Route::get('join_requests/{leader_id}', 'API\ChatBotController@join_requests');
    // Route::get('join_requests/{leader_id}', 'API\ChatBotController@join_requests');







    // dashboard status section

    // Route::get('total_joined_tribes/{user_id}', 'API\ChatBotController@total_available_tribes');
    // Route::get('total_available_tribes/{user_id}', 'API\ChatBotController@total_available_tribes');









});
