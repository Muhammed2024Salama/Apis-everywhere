<?php
namespace App\Requests\User;

use App\Requests\BaseRequestFormApi;

class CreateUserValidator extends BaseRequestFormApi {

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
            'name'=>'required|max:50',
            'email'=>'required|min:5|max:50|email|unique:users,email',
            'password'=>'required|min:6|max:50|confirmed',
        ];
    }
}
