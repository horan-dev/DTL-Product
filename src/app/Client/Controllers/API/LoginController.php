<?php

namespace App\Client\Controllers\API;

use Domain\Client\Data\LoginData;

use App\Client\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\APIController;
use Domain\Client\Actions\LoginEmailAction;

class LoginController extends APIController
{
    /**
    * Login By Email - password
    * @unauthenticated
    * @bodyParam email string required The email of the user. Example: admin@test.com
    * @bodyParam password string The password of the user. Example: password
    * @responseFile 200 responses/login.json
    * @response status=404 scenario="user not found" {"message": "User not found"}
    */
    public function login(LoginRequest $request): JsonResponse
    {

        $token=LoginEmailAction::run(LoginData::from($request));
        return $token ?
            $this->okResponse(['token'=>$token]) : $this->notFoundResponse("user not found");
    }
}
