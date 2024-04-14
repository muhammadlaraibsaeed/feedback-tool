<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CommentController as BackendCommentController;
use App\Http\Controllers\Backend\FeedBackController as BackendFeedBackController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Backend\VoteController;
use App\Http\Controllers\Frontend\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Frontend\Admin\DashBoardController;
use App\Http\Controllers\Frontend\CommentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\FeedBackController;

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
})->name('welcome');

Auth::routes();

// that route is use to Separate admin and user side view
Route::get('/home',function(){
    if (Gate::allows('isAdmin')) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route("welcome");
    }
})->name('home');

// Frontend Routes
Route::middleware('auth')->group(function(){
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/profile', 'view')->name('user.view');
    });

    Route::controller(FeedBackController::class)->group(function () {
        Route::get('/feeback/form', 'feedForm')->name('feed.form');
        Route::get("feedback/list",'feedList')->name('feed.list');
    });

    Route::controller(CommentController::class)->group(function(){
        Route::get('show/comment','showComment')->name('show.comment');
    });
    // klaklk
    Route::controller(AdminCategoryController::class)->group(function(){
        Route::get('show/category',"showCategory")->name('show.category');
    });
});

// Backend Routes

Route::middleware('auth')->group(function(){
    Route::controller(BackendFeedBackController::class)->group(function(){
        Route::post('/feedstore','feedstore')->name('feed.store');
        Route::delete('/feed/delet','deleteFeed')->name('feed.delete');
        Route::post('update/feedback','updateFeedBack')->name('update.feed');
    });

    Route::controller(VoteController::class)->group(function(){
            Route::post('store/vote','storeVote')->name('store.vote');
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::post('store/category','storeCategory')->name('store.category');
        Route::patch('update/category','updateCategory')->name('update.category');
        Route::delete('delete/category','deleteCategory')->name('delete.category');
    });

    Route::controller(BackendCommentController::class)->group(function(){
        Route::post('store/comment','storeComment')->name('store.comment');
        Route::patch('update/comment','updateComment')->name('update.comment');
        Route::delete('delete/comment','deleteComment')->name('delete.comment');
    });

    Route::controller(BackendUserController::class)->group(function(){
        Route::post('user/profile/update','updateUser')->name('update.user');
    });
});


// admin  Dashboard
Route::middleware('admin')->group(function(){
    Route::controller(DashBoardController::class)->group(function(){
        Route::get('admin/dashboard','dashBoard')->name('admin.dashboard');
    });
});





