<?php

namespace Sprocketbox\Toolkit\Validators\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserPassword implements Rule
{
    /**
     * @var string|null
     */
    protected ?string $guard;

    public function __construct(?string $guard = null)
    {
        $this->guard = $guard;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $user = Auth::guard($this->guard)->user();

        if ($user !== null) {
            return Hash::check($value, $user->getAuthPassword());
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'validation.user_password';
    }
}