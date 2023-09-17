<?php
namespace App\Requests\User;

use App\Requests\BaseRequestFormApi;

class LoginUserValidator extends BaseRequestFormApi {

    /**
     * @return bool
     */
    public function authorized(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email'=>'required|min:5|max:50|email',
            'password'=>'required|min:6|max:50',
        ];
    }
}
