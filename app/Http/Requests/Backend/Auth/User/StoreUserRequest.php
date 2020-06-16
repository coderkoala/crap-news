<?php

namespace App\Http\Requests\Backend\Auth\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * Class StoreUserRequest.
 */
class StoreUserRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->isAdmin();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return array(
			'first_name' => array( 'required' ),
			'last_name'  => array( 'required' ),
			'email'      => array( 'required', 'email', Rule::unique( 'users' ) ),
			'password'   => PasswordRules::register( $this->email ),
			'roles'      => array( 'required', 'array' ),
		);
	}
}
