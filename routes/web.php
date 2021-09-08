<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('home');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/detail/{slug}', 'HomeController@detail')->name('detail');

Route::prefix('/posts')->name('posts.')->group(function () {
    Route::get('/create', 'PostController@showCreateForm')->name('create');
    Route::post('/create', 'PostController@store')->name('store');

    Route::get('/edit/{slug}', 'PostController@showEditForm')->name('edit');
    Route::post('/update', 'PostController@update')->name('update');

    Route::get('/delete/{slug}', 'PostController@showDeleteForm')->name('delete');
    Route::post('/destroy', 'PostController@destroy')->name('destroy');
});

Auth::routes();
Route::prefix('/users')->name('users.')->group(function () {
    Route::get('/posts/{slug}', 'PostController@showPostsByUser')->name('posts');
    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::get('/edit', 'UserController@showEditForm')->name('edit');
    Route::post('/update', 'UserController@update')->name('update');
});

// Define Admin Routes
Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function () {
    // Main Routes
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/users', 'HomeController@showUsers')->name('users');
    Route::get('/posts', 'HomeController@showPosts')->name('posts');
    Route::get('/categories', 'HomeController@showCategories')->name('categories');
    // User Register by Admin
    Route::get('/users/register', 'UserController@showRegisterForm')->name('users.register');
    Route::post('/users/register', 'UserController@registerUser')->name('users.register');
    // User Edit
    Route::get('/users/edit/{id}', 'UserController@showEditForm')->name('users.edit');
    Route::post('/users/update', 'UserController@updateUser')->name('users.update');
    // User Delete
    Route::get('/users/delete/{id}', 'UserController@showDeleteForm')->name('users.delete');
    Route::post('/users/destroy', 'UserController@destroy')->name('users.destroy');

    // Post Edit
    Route::get('/posts/edit/{id}', 'PostController@showEditForm')->name('posts.edit');
    Route::post('/posts/update', 'PostController@updatePost')->name('posts.update');
    // Post Delete
    Route::get('/posts/delete/{id}', 'PostController@showDeleteForm')->name('posts.delete');
    Route::post('/posts/destroy', 'PostController@destroy')->name('posts.destroy');

    // Categories
    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('/create', 'CategoryController@showCreateForm')->name('create');
        Route::post('/create', 'CategoryController@store')->name('store');
        Route::get('/edit/{id}', 'CategoryController@showEditForm')->name('edit');
        Route::post('/update', 'CategoryController@update')->name('update');
        Route::get('/delete/{id}', 'CategoryController@showDeleteForm')->name('delete');
        Route::post('/destroy', 'CategoryController@destroy')->name('destroy');
    });

    Route::namespace('Auth')->group(function () {
        //Login Routes
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');

        //Forgot Password Routes
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');
    });
});
