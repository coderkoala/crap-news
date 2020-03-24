<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * Class RegisterRequest.
 */
class RegisterRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return array(
			'first_name'           => array( 'required', 'string' ),
			'last_name'            => array( 'required', 'string' ),
			'email'                => array( 'required', 'string', 'email', Rule::unique( 'users' ) ),
			'password'             => PasswordRules::register( $this->email ),
			'g-recaptcha-response' => array( 'required_if:captcha_status,true', 'captcha' ),
		);
	}

	/**
	 * @return array
	 */
	public function messages() {
		return array(
			'g-recaptcha-response.required_if' => __( 'validation.required', array( 'attribute' => 'captcha' ) ),
		);
	}
}
