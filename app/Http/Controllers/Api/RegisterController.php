<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Requests\User\CreateUserValidator;
use App\Requests\User\LoginUserValidator;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    /**
     * @var UserService
     */
    public UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param CreateUserValidator $createUserValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(CreateUserValidator $createUserValidator)
    {
        if (!empty($createUserValidator->getErrors())) {
            return ResponseHelper::error('error', $createUserValidator->getErrors(), 406);
        }

        $user = $this->userService->createUser($createUserValidator->request()->all());

        $data = [
            'user' => $user,
            'token' => $user->createToken('MyApp')->plainTextToken
        ];

        return ResponseHelper::success('User registered successfully', 'success', $data);
    }

    /**
     * @param LoginUserValidator $loginUserValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserValidator $loginUserValidator)
    {
        if (!empty($loginUserValidator->getErrors())) {
            return ResponseHelper::error('error', $loginUserValidator->getErrors(), 406);
        }

        $request = $loginUserValidator->request();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $data = [
                'token' => $user->createToken('MyApp')->plainTextToken,
                'name' => $user->name,
            ];

            return ResponseHelper::success('Login successful', 'success', $data);
        }

        return ResponseHelper::error('fail', 'Unauthorized', 401);
    }
}
