<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class RecaptchaRule implements Rule
{
    public function passes($attribute, $value)
    {
        $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);

        return $response->isSuccess();
    }

    public function message()
    {
        return 'The reCAPTCHA verification failed. Please try again.';
    }
}
