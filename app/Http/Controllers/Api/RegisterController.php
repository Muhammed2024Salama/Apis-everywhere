<?php
namespace App\Http\Controllers\Api;

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
    public function __construct(UserService $userService){
        $this->userService=$userService;
    }

    /**
     * @param CreateUserValidator $createUserValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(CreateUserValidator $createUserValidator){
        if(!empty($createUserValidator->getErrors())){
            return response()->json($createUserValidator->getErrors(),406);
        }
        $user=$this->userService->createUser($createUserValidator->request()->all());
        $message['user']=$user;
        $message['token'] =  $user->createToken('MyApp')->plainTextToken;
        return $this->sendResponse($message);
    }

    /**
     * @param LoginUserValidator $loginUserValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserValidator $loginUserValidator){
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
