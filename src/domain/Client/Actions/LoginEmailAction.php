<?php

namespace Domain\Client\Actions;

use Domain\Client\Models\User;
use Domain\Client\Data\LoginData;
use Lorisleiva\Actions\Concerns\AsAction;
use Hash;

class LoginEmailAction
{
    use AsAction;

    public function __construct(
        protected User $user
    ) {

    }
    /**
     * login by email
     */
    public function handle(LoginData $loginData): string|null
    {
        //check user email
        $user=$this->user->where('email', $loginData->email)->first();
        if(!$user) return null;

        //check user pass
        if (Hash::check($loginData->password, $user->password, [])) {

            //generate token
            return  $user->createToken(
                config('auth.defaults.token_name')
            )->accessToken;
        }

        return null;
    }
}
