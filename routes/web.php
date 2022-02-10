<?php

use Illuminate\Support\Facades\Route;

Route::get( '/admin/show-login2303', 'Admin\AuthController@login' )->name( 'showLogin' );
Route::post( '/admin/show-login2303', 'Admin\AuthController@postLogin' )->name( 'postAdminLogin' );
Route::get( '/admin/show-register2303', 'Admin\AuthController@showRegister' )->name( 'admin.register' );
Route::post( '/admin/show-register2303', 'Admin\AuthController@postRegister' )->name( 'admin.postRegister' );

Route::group( array( 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin' ), function () {
    Route::get( '/dashboard', 'PageController@home' )->name( 'home' );

    Route::resource( '/category', 'CategoryController' );
    Route::get( '/category-search', 'CategoryController@search' )->name( 'category.search' );

    Route::resource( '/language', 'LanguageController' );
    Route::get( '/language-search', 'LanguageController@search' )->name( 'language.search' );

    Route::resource( '/article', 'ArticleController' );
    Route::get( '/article-search', 'ArticleController@search' )->name( 'article.search' );

    Route::resource( '/course', 'CourseController' );
    Route::get( '/course-search', 'CourseController@search' )->name( 'course.search' );
    Route::resource( '/course-video', 'CourseVideoController' );

    Route::resource( '/member', 'MemberController' );
    Route::get( '/member-search', 'MemberController@search' )->name( 'member.search' );

    Route::get( '/enroll', 'StudentEnrollController@index' )->name( 'enroll.index' );
    Route::get( '/enroll-search', 'StudentEnrollController@search' )->name( 'enroll.search' );
    Route::get( '/enroll-active/{id}', 'StudentEnrollController@enrollActive' )->name( 'enroll.active' );

    Route::get( 'logout', 'AuthController@logout' )->name( 'logout' );
} );

Route::group( array( 'namespace' => 'Customer' ), function () {
    Route::get( '/', 'PageController@index' )->name( 'index' );

    Route::get( '/course', 'CourseController@allCourse' )->name( 'course' );
    Route::get( '/course-list', 'CourseController@courseList' );
    Route::get( '/course-detail/{slug}', 'CourseController@courseDetail' )->name( 'courseDetail' );
    Route::get( '/course-video/{slug}', 'CourseController@courseVideo' )->name( 'courseVideo' );
    Route::get( '/course-like-count', 'CourseController@storeLikeCount' );

    Route::get( '/article', 'ArticleController@allArticle' )->name( 'article' );
    Route::get( '/article-list', 'ArticleController@articleList' );
    Route::get( '/article-detail/{slug}', 'ArticleController@articleDetail' )->name( 'articleDetail' );
    Route::get( '/article-like-count', 'ArticleController@storeLikeCount' );

    Route::get( '/plan', 'PlanController@showPlan' )->name( 'showPlan' );
    Route::get( '/plan-active/{slug}', 'PlanController@activePlan' )->name( 'activePlan' );
    Route::post( '/plan-active/{slug}', 'PlanController@storePlan' )->name( 'storePlan' );

    Route::get( '/history', 'HistoryController@history' )->name( 'history' );

    Route::group( array( 'middleware' => 'auth' ), function () {
        Route::post( '/course-comment', 'CourseController@storeComment' )->name( 'storeComment' );
        Route::post( '/article-comment', 'ArticleController@storeComment' )->name( 'article.storeComment' );
    } );

    Route::get( '/logout', 'AuthController@logout' )->name( 'customer.logout' );
} );

Route::get( '/login', 'Customer\AuthController@showLogin' )->name( 'login' );
Route::post( '/login', 'Customer\AuthController@postLogin' )->name( 'postLogin' );
Route::get( '/register', 'Customer\AuthController@showRegister' )->name( 'customer.register' );
Route::post( '/register', 'Customer\AuthController@postRegister' )->name( 'customer.postRegister' );
