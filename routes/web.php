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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

Route::get('/logout', function(){
	 // session()->put('key', 'value');
	session()->forget('ahmad');
Auth::logout();
  return redirect('/login');
    
});
Route::get('/info' , function(){
    // dd(phpinfo());
    // echo env('MAIL_FROM_ADDRESS').'---'.env('MAIL_PASSWORD');
});



Route::get('delete-extra' , function(){
    // DB::table('question_answers')->where('topic_id' , '!=' , 50)->delete();
    // return 'extra- questions deleted';

});



Route::get('/tests', 'ResourceController@tests');

Route::get('/tests2', 'HomeController@tests2');

Route::get('/email_test', 'ResourceController@email_test');


Route::group(['prefix'=>'2fa'], function(){
    Route::get('/','LoginSecurityController@show2faForm');
    Route::post('/generateSecret','LoginSecurityController@generate2faSecret')->name('generate2faSecret');
    Route::post('/enable2fa','LoginSecurityController@enable2fa')->name('enable2fa');
    Route::post('/disable2fa','LoginSecurityController@disable2fa')->name('disable2fa');

    // 2fa middleware
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify')->middleware('2fa');
});

Route::get('/2fa/enable', 'LoginSecurityController@enableTwoFactor');
Route::post('/2fa/validate', 'LoginSecurityController@enableTwoFactorvalidate')->name('validate');
Route::get('/2fa/disable', 'LoginSecurityController@remove2fa');
Route::get('/2fa/disable', 'LoginSecurityController@remove2fa');
Route::post('/2faVerify', function () {
        // return redirect(URL()->previous());
	// session(['ahmad' => 1]);
	    session()->put('ahmad', '1');
        // return redirect(URL()->previous());

	// return 'asdasd';
         // $user_id = auth()->user()->id;
         // $role = DB::table('role_user')->where('user_id' , $user_id)->pluck('role_id')->first();
         // if($role == 1){
         
             return redirect('admin');
      
         
    })->name('2faVerify')->middleware('2fa');
    
    
    Route::get('/test_middleware', function () {
    // return "2FA middleware work!";
})->middleware(['auth', '2fa']);


Auth::routes();


// test middleware
Route::get('/test_middleware', function () {
    return "2FA middleware work!";
})->middleware(['auth', '2fa']);

Auth::routes();

Route::get('/', 'HomeController@redirect');
Route::get('admin','DashboardController@index')->middleware(['auth','2fa']);
Route::get('/dashboard', 'DashboardController@index')->middleware(['auth','2fa']);
Route::get('/home', 'DashboardController@index')->middleware(['auth','2fa']);



// site admins
Route::get('/site_admin', 'UsersController@site_admin_index')->name('admin_index')->middleware(['auth','2fa']);
Route::get('/site_admin/edit/{id}', 'UsersController@site_admin_edit')->middleware(['auth','2fa']);
Route::post('/site_admin/update', 'UsersController@site_admin_update')->middleware(['auth','2fa']);
Route::get('/site_admin/add', 'UsersController@site_admin_create')->middleware(['auth','2fa']);
Route::post('/site_admin/store', 'UsersController@site_admin_store')->middleware(['auth','2fa']);

Route::post('/site_admin/normal_user/create_admin', 'UsersController@make_user_site_admin')->middleware(['auth','2fa']);


Route::get('/pages', 'UsersController@pages_create')->middleware(['auth','2fa']);
Route::post('/pages/update', 'UsersController@pages_update')->middleware(['auth','2fa']);


// Agents    [named as users]
Route::get('/users', 'UsersController@index')->name('home')->middleware(['auth','2fa']);
Route::get('/users/add', 'UsersController@create')->middleware(['auth','2fa']);
Route::get('/users/edit/{id}', 'UsersController@edit')->middleware(['auth','2fa']);
Route::get('/users/detail/{id}', 'UsersController@detail')->middleware(['auth','2fa']);
Route::post('/users/update', 'UsersController@update')->middleware(['auth','2fa']);
Route::post('/users/store', 'UsersController@store')->middleware(['auth','2fa']);
Route::post('/users/delete', 'UsersController@destroy')->middleware(['auth','2fa']);

Route::post('/tribes/delete', 'sucrai\admin\tribeController@destroy2')->middleware(['auth','2fa']);

Route::post('/users/change_status', 'UsersController@change_status')->middleware(['auth','2fa']);
Route::get('/user_points', 'UsersController@get_points')->middleware(['auth','2fa']);
// end of agents
// join requests

Route::get('/join_requests', 'sucrai\admin\tribeController@join_requests')->middleware(['auth','2fa']);



Route::post('/join_requests/reject', 'sucrai\admin\tribeController@reject_request')->middleware(['auth','2fa']);
Route::post('/join_requests/approve', 'sucrai\admin\tribeController@approve_request')->middleware(['auth','2fa']);

Route::get('/article_comments/{id}', 'sucrai\admin\tribeController@article_comments')->middleware(['auth','2fa']);
Route::post('/article_comments_update', 'sucrai\admin\tribeController@article_comments_update')->middleware(['auth','2fa']);

Route::get('/delete_comment/{id}', 'sucrai\admin\tribeController@delete_comment')->middleware(['auth','2fa']);


Route::post('/delete_comment_post', 'sucrai\admin\tribeController@delete_comment_post')->middleware(['auth','2fa']);



// TRIBES
Route::get('/discussions', 'sucrai\admin\tribeController@get_tribe_article_view')->name('get_tribe_article_view')->middleware(['auth','2fa']);


Route::get('/tribesleader', 'sucrai\admin\tribeController@tribesleader')->name('tribesleader')->middleware(['auth','2fa']);
Route::get('/tribemembers/{id}', 'sucrai\admin\tribeController@tribemembers')->name('tribemembers')->middleware(['auth','2fa']);



Route::get('/tribes', 'sucrai\admin\tribeController@index')->name('tribes')->middleware(['auth','2fa']);
Route::get('/tribes/edit/{id}', 'sucrai\admin\tribeController@edit_tribe')->name('tribes.edit')->middleware(['auth','2fa']);
Route::post('/tribe/update_data', 'sucrai\admin\tribeController@update_tribe_data')->name('tribes.update_data')->middleware(['auth','2fa']);
Route::post('/tribe/remove/user/from/tribe', 'sucrai\admin\tribeController@remove_user_from_tribe')->name('tribes.remove_user_tribe')->middleware(['auth','2fa']);

Route::post('tribe/get/articles', 'sucrai\admin\tribeController@get_tribe_article')->name('tribes.get_articles')->middleware(['auth','2fa']);

Route::post('tribe/article/comment/delete', 'sucrai\admin\tribeController@article_comment_delete')->name('tribes.article_comment_delete')->middleware(['auth','2fa']);



Route::get('tribe/article/details/{article_id}', 'sucrai\admin\tribeController@tribe_article_details')->name('tribe_article_details')->middleware(['auth','2fa']);

Route::get('/tribe/make_leader/{tribe_id}/{user_id}', 'sucrai\admin\tribeController@make_leader')->name('tribe-make-leader')->middleware(['auth','2fa']);
Route::get('/tribe/remove_leader/{tribe_id}', 'sucrai\admin\tribeController@remove_leader')->name('tribe-remove-leader')->middleware(['auth','2fa']);
Route::get('/tribe/remove_from_tribe/{tribe_id}/{user_id}', 'sucrai\admin\tribeController@remove_from_tribe')->name('remove-user-from-tribe')->middleware(['auth','2fa']);
Route::get('/tribe/user_detail/{tribe_id}', 'sucrai\admin\tribeController@joinedDetails')->name('tribe-joined-user-details')->middleware(['auth','2fa']);
Route::get('/tribe/adduser/{id}', 'sucrai\admin\tribeController@adduser')->name('tribe-add-user')->middleware(['auth','2fa']);
Route::post('/tribe/store/', 'sucrai\admin\tribeController@storeuser')->name('tribe-store-user')->middleware(['auth','2fa']);
Route::post('/tribe/store/delete', 'sucrai\admin\tribeController@destroy')->name('destroy.tribe')->middleware(['auth','2fa']);

Route::get('/tribes_add', 'sucrai\admin\tribeController@add')->middleware(['auth','2fa']);;
Route::post('/tribe_stores', 'sucrai\admin\tribeController@stores')->middleware(['auth','2fa']);;
Route::get('/tribe_add_topic/{id}', 'sucrai\admin\tribeController@add_topic')->middleware(['auth','2fa']);;
Route::post('/tribe_topic_store','sucrai\admin\tribeController@store_topic')->middleware(['auth','2fa']);;
Route::post('/tribe_user_store', 'sucrai\admin\tribeController@storeuser')->middleware(['auth','2fa']);;

//end of tribes
//tribe
Route::get('/tribeleader', 'sucrai\admin\tribeController@tribe_leader')->name('tribes.leader')->middleware(['auth','2fa']);;
//end of tribe

// SUCRAI 
Route::get('/socraileader', 'sucrai\admin\sucraiController@index')->name('sucrai.leader')->middleware(['auth','2fa']);
Route::get('/socraileader/remove/{id}', 'sucrai\admin\sucraiController@remove_sucrai')->name('sucrai-remove')->middleware(['auth','2fa']);
Route::get('/socraileader/create', 'sucrai\admin\sucraiController@createSucrai')->name('sucrai.create')->middleware(['auth','2fa']);
Route::get('/socraileader/make/{id}', 'sucrai\admin\sucraiController@make_sucrai')->name('sucrai-make')->middleware(['auth','2fa']);

// QUESTIONS AND ANSWERS
Route::get('/questions_answers', 'sucrai\admin\questions_answersController@index2')->name('questions_answers')->middleware(['auth','2fa']);
// test
Route::get('/questions_answers/fast', 'sucrai\admin\questions_answersController@index2')->name('questions_answers-fast')->middleware(['auth','2fa']);
Route::post('/questions-answer/fetch_data', 'sucrai\admin\questions_answersController@fetch_data')->name('questions_answers-fast-search')->middleware(['auth','2fa']);



Route::get('/questions_answers/add', 'sucrai\admin\questions_answersController@add')->name('add.question')->middleware(['auth','2fa']);
Route::post('/questions_answers/store', 'sucrai\admin\questions_answersController@store')->name('store.question')->middleware(['auth','2fa']);

Route::post('/questions_answers/storeCSV', 'sucrai\admin\questions_answersController@store_csv')->name('store.CSV')->middleware(['auth','2fa']);

Route::get('/questions_answers/edit/{id}', 'sucrai\admin\questions_answersController@edit')->name('edit.question')->middleware(['auth','2fa']);
Route::post('/questions_answers/update', 'sucrai\admin\questions_answersController@update')->name('update.question')->middleware(['auth','2fa']);
Route::post('/questions_answers/delete', 'sucrai\admin\questions_answersController@destroy')->name('destroy.question')->middleware(['auth','2fa']);

   // ahmad routes
   Route::get('/questions_answers/addToExercise/{id}', 'sucrai\admin\questions_answersController@addtoexercise')->middleware(['auth','2fa']);
   Route::post('/questions_answers/store/exercise_question', 'sucrai\admin\questions_answersController@storeExerciseQuestion')->name('store.exercise_question')->middleware(['auth','2fa']);

   Route::get('/questions_answers/removefromExercise/{id}', 'sucrai\admin\questions_answersController@removefromexercise')->middleware(['auth','2fa']);
   Route::get('/questions_answers/makeItExercise/{id}', 'sucrai\admin\questions_answersController@makeItExercise')->middleware(['auth','2fa']);




// TOPICS
Route::get('/topics', 'sucrai\admin\TopicController@index')->name('topics')->middleware(['auth','2fa']);
Route::get('/topics/add', 'sucrai\admin\TopicController@add')->name('add.topic')->middleware(['auth','2fa']);
Route::post('/sucrai\admin\TopicController/store', 'sucrai\admin\TopicController@store')->name('store.topic')->middleware(['auth','2fa']);
Route::post('/topics/delete', 'sucrai\admin\TopicController@destroy')->name('topic.delete')->middleware(['auth','2fa']);
Route::get('/topics/edit/{id}', 'sucrai\admin\TopicController@edit')->middleware(['auth','2fa']);
Route::post('/topics/update', 'sucrai\admin\TopicController@update')->middleware(['auth','2fa']);

// Users import
Route::get('/users/import', 'UsersController@getImport')->name('import')->middleware(['auth','2fa']);
Route::get('/users/csv/sample', function ()
{
     $file = public_path("template/import-template-users.xls");
     $headers = array('Content-Type: application/octet-stream');
     return Response::download($file, 'import-template-users.xls', $headers);
});

Route::post('import/users', 'UsersController@importUsers')->name('import_users')->middleware(['auth','2fa']);

// Question and Answers Import
Route::get('/questions_answers/import', '\App\Http\Controllers\sucrai\admin\questions_answersController@getImport')->middleware(['auth','2fa']);
Route::get('/questions_answers/csv/sample', function ()
{
     $file = public_path("template/import-template-qa.xls");
     $headers = array('Content-Type: application/octet-stream');
     return Response::download($file, 'import-template-qa.xls', $headers);
})->middleware(['auth','2fa']);



// add media to server
Route::get('/media/home', 'sucrai\admin\questions_answersController@media_index')->name('home.media')->middleware(['auth','2fa']);
Route::get('/questions_answers/add/media', 'sucrai\admin\questions_answersController@addMedia')->name('add.media')->middleware(['auth','2fa']);
Route::post('/questions_answers/store/media', 'sucrai\admin\questions_answersController@storeMedia')->name('store.media')->middleware(['auth','2fa']);
Route::post('/questions_answers/store/internal_media_type', 'sucrai\admin\questions_answersController@storeInternalMediaQuestions')->name('store.internal.media.questions')->middleware(['auth','2fa']);
Route::post('/media/delete', 'sucrai\admin\questions_answersController@destroy_media')->name('destroy.tribe')->middleware(['auth','2fa']);


// 

Route::post('import/questions_answers', '\App\Http\Controllers\sucrai\admin\questions_answersController@importQuestionsAnswers')->name('import_questionsanswers')->middleware(['auth','2fa']);


//by saad
//password

Route::get('/update-password/{id}', 'UsersController@update_password')->middleware(['auth','2fa']);
Route::post('/update-password-post', 'UsersController@update_password_post')->middleware(['auth','2fa']);


//profile update
Route::get('/update-profile/{id}', 'UsersController@update_profile')->middleware(['auth','2fa']);
Route::post('/update-profile-post', 'UsersController@update_profile_admin')->middleware(['auth','2fa']);