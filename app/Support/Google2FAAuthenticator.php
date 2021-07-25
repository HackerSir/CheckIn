<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request as IlluminateRequest;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAAuthenticator extends Authenticator
{
    /**
     * @var User
     */
    private $user;

    /**
     * Authenticator constructor.
     *
     * @param IlluminateRequest $request
     * @param User $user
     */
    public function __construct(IlluminateRequest $request, User $user)
    {
        parent::__construct($request);
        $this->user = $user;
    }

    /**
     * Get the current user.
     *
     * @return mixed
     */
    protected function getUser()
    {
        return $this->user ?: $this->getAuth()->user();
    }
}
