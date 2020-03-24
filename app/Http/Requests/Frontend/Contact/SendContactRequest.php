<?php

namespace App\Http\Requests\Frontend\Contact;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SendContactRequest.
 */
class SendContactRequest extends FormRequest {

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
			'name'                 => array( 'required' ),
			'email'                => array( 'required', 'email' ),
			'message'              => array( 'required' ),
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
