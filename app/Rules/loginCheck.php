<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class loginCheck implements ValidationRule
{

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $email = $this->request->input('email');
        $passwordInput = $this->request->input('password');
        $loginStatus = FALSE;

        $accountCheck = User::where('email', $email)->count();
        if ($accountCheck > 0) {
            $userPassword = User::where('email', $email)->value('password');

            if (Hash::check($passwordInput, $userPassword)) {
                $loginStatus = TRUE;
            }
        }

        if ($loginStatus) {
            $userData = User::where('email', $email)->first();

            Session::put('loginStatus', TRUE);
            Session::put('userData', $userData);
        } else {
            $fail('Email Atau Password Salah!');
        }
    }
}
