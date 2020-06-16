<?php

use App\Http\Controllers\Frontend\Auth\ConfirmAccountController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\PasswordExpiredController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\Auth\SocialLoginController;
use App\Http\Controllers\Frontend\Auth\UpdatePasswordController;

/*
 * Frontend Access Controllers
 * All route names are prefixed with 'frontend.auth'.
 */
Route::group(
	array(
		'namespace' => 'Auth',
		'as'        => 'auth.',
	),
	function () {
		// These routes require the user to be logged in
		Route::group(
			array( 'middleware' => 'auth' ),
			function () {
				Route::get( 'logout', array( LoginController::class, 'logout' ) )->name( 'logout' );

				// These routes can not be hit if the password is expired
				Route::group(
					array( 'middleware' => 'password_expires' ),
					function () {
						// Change Password Routes
						Route::patch( 'password/update', array( UpdatePasswordController::class, 'update' ) )->name( 'password.update' );
					}
				);

				// Password expired routes
				Route::get( 'password/expired', array( PasswordExpiredController::class, 'expired' ) )->name( 'password.expired' );
				Route::patch( 'password/expired', array( PasswordExpiredController::class, 'update' ) )->name( 'password.expired.update' );
			}
		);

		// These routes require no user to be logged in
		Route::group(
			array( 'middleware' => 'guest' ),
			function () {
				// Authentication Routes
				Route::get( 'login', array( LoginController::class, 'showLoginForm' ) )->name( 'login' );
				Route::post( 'login', array( LoginController::class, 'login' ) )->name( 'login.post' );

				// Socialite Routes
				Route::get( 'login/{provider}', array( SocialLoginController::class, 'login' ) )->name( 'social.login' );
				Route::get( 'login/{provider}/callback', array( SocialLoginController::class, 'login' ) );

				// Registration Routes
				Route::get( 'register', array( RegisterController::class, 'showRegistrationForm' ) )->name( 'register' );
				Route::post( 'register', array( RegisterController::class, 'register' ) )->name( 'register.post' );

				// Confirm Account Routes
				Route::get( 'account/confirm/{token}', array( ConfirmAccountController::class, 'confirm' ) )->name( 'account.confirm' );
				Route::get( 'account/confirm/resend/{uuid}', array( ConfirmAccountController::class, 'sendConfirmationEmail' ) )->name( 'account.confirm.resend' );

				// Password Reset Routes
				Route::get( 'password/reset', array( ForgotPasswordController::class, 'showLinkRequestForm' ) )->name( 'password.email' );
				Route::post( 'password/email', array( ForgotPasswordController::class, 'sendResetLinkEmail' ) )->name( 'password.email.post' );

				Route::get( 'password/reset/{token}', array( ResetPasswordController::class, 'showResetForm' ) )->name( 'password.reset.form' );
				Route::post( 'password/reset', array( ResetPasswordController::class, 'reset' ) )->name( 'password.reset' );
			}
		);
	}
);
