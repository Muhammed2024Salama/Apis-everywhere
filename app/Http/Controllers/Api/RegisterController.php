<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Requests\Users\CreateUserValidator;
use App\Requests\Users\LoginUserValidator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * @var UserService
     */
    public $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService){
        $this->userService=$userService;
    }

    /**
     * @param CreateUserValidator $createUserValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(CreateUserValidator $createUserValidator)
    {
        if(!empty($createUserValidator->getErrors())){
            return response()->json($createUserValidator->getErrors(),406);
        }
        $user=$this->userService->createUser($createUserValidator->request()->all());
        $message['user']=$user;
        $message['token'] =  $user->createToken('MyApp')->plainTextToken;
        return $this->sendResponse($message);('MyApp')->plainTextToken;
        return $this->sendResponse($message);
    }

    /**
     * @param LoginUserValidator $loginUserValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserValidator $loginUserValidator)
    {
        if(!empty($loginUserValidator->getErrors())){
            return response()->json($loginUserValidator->getErrors(),406);
        }
        $request=$loginUserValidator->request();
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success);
        }
        else{
            return $this->sendResponse('Unauthorised', 'fail',401);
        }
    }
}
