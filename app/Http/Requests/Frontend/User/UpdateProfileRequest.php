<?php

namespace App\Http\Requests\Frontend\User;

use App\Helpers\Auth\SocialiteHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends FormRequest {

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
			'first_name'      => array( 'required' ),
			'last_name'       => array( 'required' ),
			'email'           => array( 'sometimes', 'required', 'email' ),
			'avatar_type'     => array( 'required', Rule::in( array_merge( array( 'gravatar', 'storage' ), ( new SocialiteHelper() )->getAcceptedProviders() ) ) ),
			'avatar_location' => array( 'sometimes', 'image' ),
		);
	}
}
