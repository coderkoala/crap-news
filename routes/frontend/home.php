<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\ProfileController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get( '/', array( HomeController::class, 'index' ) )->name( 'index' );
Route::get( '/read/{slug}', array( HomeController::class, 'slug' ) )->name( 'slug' );
Route::get( '/browse', array( HomeController::class, 'category' ) )->name( 'category' );
Route::get( '/about', array( HomeController::class, 'about' ) )->name( 'about' );
Route::get( 'contact', array( ContactController::class, 'index' ) )->name( 'contact' );
Route::post( 'contact/send', array( ContactController::class, 'send' ) )->name( 'contact.send' );

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(
	array( 'middleware' => array( 'auth', 'password_expires' ) ),
	function () {
		Route::group(
			array(
				'namespace' => 'User',
				'as'        => 'user.',
			),
			function () {
				// User Dashboard Specific
				Route::get( 'dashboard', array( DashboardController::class, 'index' ) )->name( 'dashboard' );

				// User Account Specific
				Route::get( 'account', array( AccountController::class, 'index' ) )->name( 'account' );

				// User Profile Specific
				Route::patch( 'profile/update', array( ProfileController::class, 'update' ) )->name( 'profile.update' );

				// User Rating
				Route::post( 'rate', array( DashboardController::class, 'rate' ) )->name( 'rate' );
			}
		);
	}
);
